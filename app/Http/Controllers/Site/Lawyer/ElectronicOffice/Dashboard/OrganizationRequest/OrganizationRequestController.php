<?php

namespace App\Http\Controllers\Site\Lawyer\ElectronicOffice\Dashboard\OrganizationRequest;

use App\Http\Controllers\Controller;
use App\Models\Organizations\OrganizationsRequest;
use App\Models\Organizations\OrganizationsRequest_reply;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class OrganizationRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($id)
    {
        $lawyer = CheckElectronicOfficeLawyer($id);
        $organizations_request = OrganizationsRequest::where('lawyer_id', $lawyer->id)->orderBy('created_at', 'DESC')->get();
        return view('site.lawyers.electronic_office.dashboard.organization-requests.index', get_defined_vars());

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($id)
    {
        $lawyer = CheckElectronicOfficeLawyer($id);
        return view('site.lawyers.electronic_office.dashboard.organization-requests.create', get_defined_vars());

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            '*' => 'required',
            'file' => 'sometimes',
        ], [
            '*.required' => 'الحقل مطلوب',
        ]);
        $lawyer = CheckElectronicOfficeLawyer($request->electronic_id_code);
        $service_request = OrganizationsRequest::create([
            'organization_id'=>$request->type,
            'priority'=>$request->priority,
            'description'=>$request->description,
            'lawyer_id'=>$lawyer->id,
            'status'=>0,
            'price'=>500,
        ]);
        if ($request->has('file')) {
            $service_request->file = saveImage($request->file('file'), 'uploads/lawyers/OrganizationsRequest/');
            $service_request->save();
        }
        return redirect()->route('site.lawyer.electronic-office.dashboard.organization-request.index',$request->electronic_id_code)->with('success', 'تم ارسال طلبك بنجاح , في انتظار الرد ');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($request_id, $id)
    {
        $lawyer = CheckElectronicOfficeLawyer($id);
        $consultation = OrganizationsRequest::findOrFail($request_id);
        $replies = OrganizationsRequest_reply::where('request_id', $request_id)->get();

        return view('site.lawyers.electronic_office.dashboard.organization-requests.organizationrequestreplies', compact('id','consultation','replies','lawyer'));

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
    public function saveOrganizationRequestReply(Request $request)
    {
        $lawyer = CheckElectronicOfficeLawyer($request->electronic_id_code);
        $consultation = OrganizationsRequest::where('id', $request->mainConsultation)->first();

        $validator = Validator::make($request->all(), [
            'reply' => 'required',
        ],
            [
                'reply.required' => 'من فضلك قم بادخال نص الرسالة اولا .',
            ]);
        $reply = new OrganizationsRequest_reply;
        $reply->request_id = $consultation->id;
        $reply->lawyer_id = $consultation->lawyer_id;
        $reply->reply = $request->reply;
        $reply->from = 1;
        $reply->save();

        $replies = OrganizationsRequest_reply::where('request_id', $request->mainConsultation)->orderBy('id', 'ASC')->get();

        return response()->json(['chats' => view('site.lawyers.electronic_office.dashboard.organization-requests.vieworganizationrequestreplies', compact('replies', 'consultation'))->render()]);

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
