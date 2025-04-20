<?php

namespace App\Http\Controllers\Site\Lawyer\ElectronicOffice\Dashboard\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($id)
    {
        $lawyer = CheckElectronicOfficeLawyer($id);
        return view('site.lawyers.electronic_office.dashboard.settings.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request)
    {
        $lawyer = CheckElectronicOfficeLawyer($request->electronic_id_code);
        $request->validate([
            '*' => 'required',
            'password' => 'sometimes',
            'email' => ['sometimes', 'email', Rule::unique('lawyers')->ignore($lawyer->id)]
            ], [
                '*.required' => 'الحقل مطلوب'
            ]);
        $day = strlen($request->day) == 1 ? '0' . $request->day : $request->day;
        $birthday = $request->year . '-' . $request->month . '-' . $day;
        $lawyer->day = $day;
        $lawyer->month = $request->month;
        $lawyer->year = $request->year;
        $lawyer->birthday = $birthday;
        $lawyer->name = $request->name;
        $lawyer->username = $request->name;
        $lawyer->about = $request->about;
        $lawyer->gender = $request->gender;
        $lawyer->phone = $request->phone;
        $lawyer->email = $request->email;
        if (!is_null($request['password'])) {
            $lawyer->password = bcrypt($request->password);
            $lawyer->update();
        }
        if ($request->has('personal_image')) {
            $personal_image = saveImage($request->file('personal_image'), 'uploads/lawyers/personal_image/');
            $lawyer->personal_image = $personal_image;
            $lawyer->photo = $personal_image;
            $lawyer->update();
        }
        return redirect()->route('site.lawyer.electronic-office.dashboard.settings.index',$request->electronic_id_code)->with('success','تم تحديث الملف الشخصي');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
