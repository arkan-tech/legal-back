<?php

namespace App\Http\Controllers\Admin\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.home.index');
    }
    public function profile()
    {
        return view('admin.profile.index');
    }
    public function UpdateProfile(Request $request)
    {
        $admin = auth()->user();
        $admin->update([
                'name'=>$request->name,
                'email'=>$request->email,
        ]);
        if ($request->has('password') && !is_null($request->password)){
            $admin->update([
                'password'=>bcrypt($request->password)
            ]);
        }

        return redirect()->back()->with('success','تم تحديث البيانات بجاح');
    }
}
