<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Psr\Log\LogLevel;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;
use Illuminate\Auth\AuthenticationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<Throwable>, LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    public function render($request, Throwable $exception)
    {
        if ($request->expectsJson()) {
            if ($exception instanceof AuthenticationException) {
                return response()->json(['status' => false, 'code' => 401, 'message' => 'Unauthenticated', 'data' => null])->setStatusCode(401);
            }
            if ($exception instanceof UnauthorizedHttpException) {
                return response()->json(['status' => false, 'code' => 401, 'message' => 'Unauthenticated', 'data' => null])->setStatusCode(401);
            }
            if ($exception instanceof NotFoundHttpException) {
                return response()->json(['status' => false, 'code' => 404, 'message' => '404 Not Found', 'data' => null])->setStatusCode(404);
            }
            if ($exception instanceof ModelNotFoundException) {
                return response()->json(['status' => false, 'code' => 404, 'message' => $exception->getMessage(), 'data' => null])->setStatusCode(404);
            }
        }

        return parent::render($request, $exception);
    }
    protected function unauthenticated($request, AuthenticationException $exception)
    {

        $guard = data_get($exception->guards(), 0);
        switch ($guard) {
            case 'lawyer':
                $login = 'site.login';
                $route = redirect()->route($login);
                break;
            case 'client':
                $login = 'site.login';
                $route = redirect()->route($login);
                break;
            case 'lawyer_electronic_office':
                $login = 'site.lawyer.electronic-office.login.form';
                $path = $request->path();
                $path = explode('/', $path);
                $id = $path[count($path) - 1];
                $route = redirect()->route($login, $id);
                break;
            default:
                if ($request->is('admin', 'admin/*')) {
                    $login = 'login';
                    $route = redirect()->route($login);
                } else {
                    $login = 'login';
                    $route = redirect()->route($login);
                }
                break;
        }
        return $route;

    }

}
