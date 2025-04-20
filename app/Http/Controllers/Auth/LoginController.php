<?php

namespace App\Http\Controllers\Auth;

use Google\Client;
use Google_Client;
use Inertia\Inertia;
use Firebase\JWT\JWK;
use Firebase\JWT\JWT;
use App\Models\Visitor;
use App\Models\Newsletter;
use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use Google\Service\PeopleService;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        // return view('admin.auth.login');
        return Inertia::render('Authentication/SignIn');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function redirectToApple()
    {
        return Socialite::driver('apple')->redirect();
    }

    public function handleGoogleCallback(Request $request, $token)
    {
        $base = new BaseTask();

        try {
            $client = new Google_Client(['client_id' => config('services.google.client_id')]);
            $payload = $client->verifyIdToken($token);

            if (!$payload) {
                return $base->sendResponse(false, "Invalid Token", null, 401);
            }

            // Extract user info from verified payload
            $userId = $payload['sub'];
            $email = $payload['email'];
            $name = $payload['name'];
            $avatarUrl = $payload['picture'];

            $visitor = Visitor::where('google_id', $userId)->first();
            if (is_null($visitor)) {
                $visitor = Visitor::create([
                    "name" => $name,
                    "email" => $email,
                    "image" => $avatarUrl,
                    "google_id" => $userId,
                    "status" => 1
                ]);

                $newsletter = Newsletter::where('email', $email)->first();
                if (is_null($newsletter)) {
                    Newsletter::create([
                        "email" => $email
                    ]);
                }
            }

            if ($visitor->status == 0) {
                return $base->sendResponse(false, 'Unauthorized', "هذا الحساب موقوف", 403);
            }

            $token = JWTAuth::fromUser($visitor);
            $visitor->injectToken($token);
            return $base->sendResponse(true, "Visitor Logged in successfully", compact('visitor'), 200);

        } catch (\Exception $e) {
            \Log::error('Google token verification error: ' . $e->getMessage());
            return $base->sendResponse(false, "Invalid Token", null, 401);
        }
    }

    public function handleAppleCallback(Request $request)
    {
        $base = new BaseTask();

        try {
            $appleUser = json_decode($request->getContent(), true);

            if (!isset($appleUser['identity_token'])) {
                return $base->sendResponse(false, "Identity token is required", null, 400);
            }

            // Verify the Apple identity token
            try {
                // Fetch Apple's public keys
                $publicKeys = json_decode(file_get_contents('https://appleid.apple.com/auth/keys'), true);

                // Parse the JWT to get the key ID (kid) from header
                $tokenParts = explode('.', $appleUser['identity_token']);
                $header = json_decode(base64_decode($tokenParts[0]), true);

                // Find the matching public key
                $publicKey = null;
                foreach ($publicKeys['keys'] as $key) {
                    if ($key['kid'] === $header['kid']) {
                        $publicKey = JWK::parseKey($key);
                        break;
                    }
                }

                if (!$publicKey) {
                    throw new \Exception('No matching public key found');
                }

                // Verify and decode the token
                $decodedToken = JWT::decode($appleUser['identity_token'], $publicKey, ['RS256']);

                // Verify the issuer and audience
                if (
                    $decodedToken->iss !== 'https://appleid.apple.com' ||
                    $decodedToken->aud !== env('APPLE_CLIENT_ID')
                ) {
                    throw new \Exception('Invalid token issuer or audience');
                }

                // Verify token expiration
                if ($decodedToken->exp < time()) {
                    throw new \Exception('Token has expired');
                }

                // Get user info from the decoded token
                $appleId = $decodedToken->sub;
                $email = $request->email ?? null;
                $name = $request->name ?? null;
                $image = $request->image ?? null;

            } catch (\Exception $e) {
                \Log::error('Apple token verification failed: ' . $e->getMessage());
                return $base->sendResponse(false, "Invalid Apple identity token", null, 401);
            }

            $visitor = Visitor::where('apple_id', $appleId)->first();

            if (is_null($visitor)) {
                $visitor = Visitor::create([
                    "name" => $name,
                    "email" => $email,
                    "image" => $image,
                    "apple_id" => $appleId,
                    "status" => 1
                ]);

                if ($email) {
                    $newsletter = Newsletter::where('email', $email)->first();
                    if (is_null($newsletter)) {
                        Newsletter::create([
                            "email" => $email
                        ]);
                    }
                }
            }

            if ($visitor->status == 0) {
                return $base->sendResponse(false, 'Unauthorized', "هذا الحساب موقوف", 403);
            }

            $token = JWTAuth::fromUser($visitor);
            $visitor->injectToken($token);

            return $base->sendResponse(true, "Visitor Logged in successfully", compact('visitor'), 200);

        } catch (\Exception $e) {
            \Log::error('Apple authentication failed: ' . $e->getMessage());
            return $base->sendResponse(false, "Authentication failed: " . $e->getMessage(), null, 401);
        }
    }
}
