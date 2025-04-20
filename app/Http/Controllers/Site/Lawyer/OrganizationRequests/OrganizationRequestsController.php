<?php

namespace App\Http\Controllers\Site\Lawyer\OrganizationRequests;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\Lawyer\OrganizationRequests\OrganizationRequestsRequest;
use App\Models\Lawyer\Lawyer;
use App\Models\Organizations\OrganizationsRequest;
use App\Models\Organizations\OrganizationsRequest_reply;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use function auth;

class OrganizationRequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $lawyer = auth()->guard('lawyer')->user();
        $organizations_request = OrganizationsRequest::where('lawyer_id', $lawyer->id)->get();
        return view('site.lawyers.organization-requests.index', compact('organizations_request', 'lawyer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $lawyer = auth()->guard('lawyer')->user();
        return view('site.lawyers.organization-requests.create', compact('lawyer'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(OrganizationRequestsRequest $request)
    {
        $lawyer = auth()->guard('lawyer')->user();
        $service_request = new OrganizationsRequest;
        $service_request->organization_id = $request->type;
        $service_request->priority = $request->priority;
        $service_request->description = $request->description;
        $service_request->lawyer_id = $lawyer->id;
        $service_request->status = 0;
        $service_request->price = 500;
        $service_request->save();
        if ($request->has('file')) {
            $service_request->file = saveImage($request->file('file'), 'uploads/lawyers/OrganizationsRequest/');
            $service_request->save();
        }
        return response()->json(['success' => 1, 'requestID' => $service_request->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(Request $request)
    {
        $consultation = OrganizationsRequest::findOrFail($request->id);
        $replies = OrganizationsRequest_reply::where('request_id', $request->id)->get();
        $lawyer = auth()->guard('lawyer')->user();

        return view('site.lawyers.organization-requests.organizationrequestreplies', compact('consultation', 'replies', 'lawyer'));
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
    public function update(Request $request, $id)
    {
        //
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

    public function saveOrganizationRequestReply(Request $request)
    {
        $consultation = OrganizationsRequest::findOrFail($request->mainConsultation);

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

        return response()->json(['chats' => view('site.lawyers.organization-requests.vieworganizationrequestreplies', compact('replies', 'consultation'))->render()]);

    }
}
