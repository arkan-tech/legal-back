<?php

namespace App\Http\Controllers\Admin\OrganizationRequests;

use App\Http\Controllers\Controller;
use App\Models\Organizations\OrganizationsRequest;
use App\Models\Organizations\OrganizationsRequest_reply;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use function GuzzleHttp\Promise\all;

class OrganizationRequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $clients = OrganizationsRequest::with('lawyer', 'organization')->orderBy('created_at', 'desc')->get();
            return DataTables::of($clients)
                ->addColumn('lawyer', function ($row) {
                    return '<a  href="' . route('admin.digital-guide.edit', $row->lawyer->id) . '" target="_blank">
                                   ' . $row->lawyer->name . '
                                  </a>';

                })
                ->addColumn('organization', function ($row) {
                    return $row->organization->title;
                })
                ->addColumn('priority', function ($row) {
                    $priority = $row->priority;
                    switch ($priority) {
                        case 1:
                            return 'عاجل جدا';
                            break;
                        case 2:
                            return 'مرتبط بموعد';
                            break;
                        case null:
                            return 'غير محدد';
                            break;
                    }
                })
                ->addColumn('status', function ($row) {
                    $status = $row->status;
                    switch ($status) {
                        case 0:
                            return ' جديد';
                            break;
                        case 1:
                            return ' مقبول';
                            break;
                        case 2:
                            return ' مرفوض';
                            break;
                    }
                })
                ->addColumn('price', function ($row) {
                    $price = $row->price;
                    !is_null($row->price) ? $price = $row->price : $price = ' -';
                    return $price;
                })
                ->addColumn('payment_status', function ($row) {
                    $payment_status = $row->payment_status;
                    switch ($payment_status) {
                        case 1:
                            return ' مكتمل';
                            break;
                        case 2:
                            return ' ملغي';
                            break;
                        case 3:
                            return ' مرفوض';
                            break;
                        case null:
                            return ' -';
                            break;
                    }
                })
                ->addColumn('action', function ($row) {
                    $actions = '<a class="btn-delete-organization-requests m-1"  id="btn_delete_organization_requests_' . $row->id . '"  href="' . route('admin.organization-requests.delete', $row->id) . '" data-id="' . $row->id . '" title="حذف ">
                                      <i class="fa fa-trash"></i>
                                  </a>
                                  <a class="m-1"    href="' . route('admin.organization-requests.edit', $row->id) . '" data-id="' . $row->id . '" title="تعديل ">
                                     <i class="fa-solid fa-user-pen"></i>
                                  </a>
                                  <a class="m-1 btn-replay-organization-requests"    href="' . route('admin.organization-requests.get.data', $row->id) . '" data-id="' . $row->id . '" title="رد على الاستشارة ">
                                     <i class="fa fa-reply"></i>
                                  </a>';
                    return $actions;
                })
                ->rawColumns(['action', 'lawyer'])
                ->make(true);

        }
        return view('admin.organization_requests.index');
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
        $request = OrganizationsRequest::with('lawyer', 'organization')->findorFail($id);
        return view('admin.organization_requests.edit', get_defined_vars());

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
        $request->validate([
            'status' => 'required',
            'price' => 'required_if:status,1',
        ], [
            'status.required' => 'حقل الحالة مطلوب',
            'price.required_if' => ' تحديد سعر الإستشارة مطلوب عند قبول حالة الطلب',
        ]);
        $request_org = OrganizationsRequest::findorFail($request->id);
        $request_org->update([
            'status' => $request->status,
            'price' => $request->price,
        ]);
        return redirect()->back()->with('success', 'تم تحديث حالة الطلب بنجاح');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $request = OrganizationsRequest::findOrFail($id);
        $request->delete();
        return response()->json([
            'status' => true
        ]);
    }

    public function getOrganizationRequestData($id)
    {
        $item = OrganizationsRequest::with('lawyer', 'organization')->findOrFail($id);
        return response()->json([
            'status' => true,
            'item' => $item
        ]);
    }

    public function replay(Request $request)
    {
        $request->validate([
            'message' => 'required',
        ], [
            'message.required' => 'يجب ترك رسالة للرد على الاستشارة'
        ]);

       $replay =  OrganizationsRequest_reply::create([
           'request_id'=>$request->request_id,
           'lawyer_id'=>$request->request_id,
           'reply'=>$request->message,
           'from'=>2,
        ]);

       if ($request->has('attachment')){
           $replay->attachment= saveImage($request->attachment,'uploads/lawyers/OrganizationsRequest/Replays');
           $replay->save();
       }
        return response()->json([
            'status' => true
        ]);
    }
}
