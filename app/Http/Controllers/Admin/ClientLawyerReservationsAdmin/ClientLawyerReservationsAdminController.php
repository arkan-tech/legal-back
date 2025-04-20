<?php

namespace App\Http\Controllers\Admin\ClientLawyerReservationsAdmin;

use App\Http\Controllers\Controller;
use App\Models\Client\ClientLawyerReservations;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class ClientLawyerReservationsAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $items = ClientLawyerReservations::with('service', 'client', 'lawyer', 'importance', 'date', 'time', 'time')->get();
            return DataTables::of($items)
                ->addColumn('client', function ($row) {
                    return $row->client->myname;
                })
                ->addColumn('lawyer', function ($row) {
                    return $row->lawyer->name;
                })
                ->addColumn('service', function ($row) {
                    return $row->service->title;
                })
                ->addColumn('importance', function ($row) {
                    return $row->importance->title;
                })
                ->addColumn('date', function ($row) {
                    return $row->date->day_name;
                })
                ->addColumn('time', function ($row) {
                    return $row->time->time_from . ' : ' . $row->time->time_to;
                })
                ->addColumn('transaction_complete', function ($row) {
                    return $row->transaction_complete == 1 ? 'مدفوع' : ' غير مدفوع';
                })
                ->addColumn('status', function ($row) {
                    $status = $row->complete_status;
                    switch ($status) {
                        case 0:
                            return 'انتظار';
                            break;
                        case 1:
                            return 'مكتمل ';
                            break;
                        case 2:
                            return 'ملغي ';
                            break;
                        case 3:
                            return 'خطأ في الدفع ';
                            break;
                    }
                })
                ->addColumn('action', function ($row) {
                    $actions = '<a class="btn-delete-lawyer-reservation m-1"  id="btn_delete_lawyer_reservation_' . $row->id . '"  href="' . route('admin.clients.lawyer-reservation.delete', $row->id) . '" data-id="' . $row->id . '" title="حذف ">
                                      <i class="fa fa-trash"></i>
                                  </a>
                                  <a class="m-1 "  href="' . route('admin.clients.lawyer-reservation.show', $row->id) . '" data-id="' . $row->id . '" title="تعديل ">
                                     <i class="fa-solid fa-eye"></i>
                                  </a>';
                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.client_reservations.lawyers.index');
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
        $item = ClientLawyerReservations::with('service', 'client', 'lawyer.nationality_rel', 'importance', 'date', 'time', 'time')->findOrFail($id);

        return view('admin.client_reservations.lawyers.show', compact('item'));
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
        $item = ClientLawyerReservations::findOrFail($id);
        $item->delete();
        return  \response()->json([
           'status'=>true
        ]);
    }
}
