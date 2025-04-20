<?php

namespace App\Http\Controllers\NewAdmin;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Country\Country;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Rules\ArrayAtLeastOneRequired;
use Spatie\Permission\Models\Permission;
use App\Models\JudicialGuide\JudicialGuide;
use App\Models\JudicialGuide\JudicialGuideEmails;
use App\Models\JudicialGuide\JudicialGuideNumbers;
use App\Models\JudicialGuide\JudicialGuideSubCategory;
use App\Models\JudicialGuide\JudicialGuideMainCategory;
use Google\Service\AndroidEnterprise\GoogleAuthenticationSettings;


class DashboardUsersController extends Controller
{


    public function index()
    {
        $users = User::with('roles', 'permissions')->get();
        $roles = Role::with('permissions')->get();
        $permissions = Permission::get();
        return Inertia::render('Settings/Dashboard/Users/index', get_defined_vars());

    }


    public function indexCreate()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::get();
        return Inertia::render('Settings/Dashboard/Users/Create/index', get_defined_vars());

    }


    public function indexEdit($id)
    {
        $userData = User::with('roles', 'permissions')->findOrFail($id);
        $roles = Role::with('permissions')->get();
        $permissions = Permission::get();
        return Inertia::render('Settings/Dashboard/Users/Edit/index', get_defined_vars());

    }



    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            "email" => "required|unique:users,email",
            "roles" => "required|array|min:1",
            "permissions" => "sometimes|array"
        ], [
            '*' => "الحقل مطلوب"
        ]);

        $randomPassword = bin2hex(random_bytes(8));
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'avatar' => "uploads/person.png",
            'password' => bcrypt($randomPassword)
        ]);


        foreach ($request->roles as $role) {
            $role = Role::findOrFail($role);
            $user->roles()->attach($role);
        }
        if ($request->permissions) {
            foreach ($request->permissions as $permission) {
                $permission = Permission::findOrFail($permission);
                $user->permissions()->attach($permission);
            }
        }

        $em_data = [
            'name' => $user->name,
            'email' => $user->email,
            'subject' => "انشاءحساب على لوحة التحكم",
            'bodyMessage' => "مرحباً بك في تطبيق يمتاز , تم انشاء حساب لكم على لوحة التحكم و يمكنكم زيارتها على https://ymtaz.sa/newAdmin",
            'bodyMessage1' => 'كلمة المرور الخاصة بكم هي: ' . $randomPassword,
            'bodyMessage2' => "",
            'bodyMessage3' => "",
            'platformLink' => env('REACT_WEB_LINK'),

        ];
        Mail::send(
            'email',
            $em_data,
            function ($message) use ($em_data) {
                $message->from('ymtaz@ymtaz.sa');
                $message->to($em_data['email'], $em_data['name'])->subject($em_data['subject']);
            }
        );
        return response()->json([
            "status" => true,
            "item" => $user
        ]);
    }


    public function edit(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            "email" => "required|unique:users,email," . $id,
            "roles" => "required|array|min:1",
            "permissions" => "sometimes|array"
        ], [
            '*' => "الحقل مطلوب"
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $rolesToSync = [];
        foreach ($request->roles as $role) {
            $role = Role::findOrFail($role);
            array_push($rolesToSync, $role->name);
        }
        $user->syncRoles($rolesToSync);
        if ($request->permissions) {
            $permissionsToSync = [];
            foreach ($request->permissions as $permission) {
                $permission = Permission::findOrFail($permission);
                array_push($permissionsToSync, $permission->name);
            }
            $user->syncPermissions($permissionsToSync);
        }
        return response()->json([
            "status" => true,
            "item" => $user
        ]);
    }


    public function delete($id)
    {
        $item = User::findOrFail($id);
        $item->delete();

        return response()->json([
            "stauts" => true
        ]);
    }
}
