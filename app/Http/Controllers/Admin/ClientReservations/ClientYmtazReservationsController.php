<?php

namespace App\Http\Controllers\Admin\ClientReservations;

use App\Http\Controllers\Controller;
use App\Models\ClientReservations\ClientReservationsTypes;
use App\Models\YmtazReservations\YmtazReservations;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class ClientYmtazReservationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $items = YmtazReservations::with('client', 'service', 'importance', 'ymtaz_date', 'ymtaz_time')->orderBy('created_at', 'desc')->get();
            return DataTables::of($items)
                ->addColumn('client', function ($row) {
                    return $row->client->myname;
                })
                ->addColumn('service', function ($row) {
                    return $row->service->title;
                })
                ->addColumn('importance', function ($row) {
                    return $row->importance->title;
                })
                ->addColumn('date', function ($row) {
                    return $row->ymtaz_date->date;
                })
                ->addColumn('time', function ($row) {
                    return $row->ymtaz_time->time_from . ' ' . ':' . ' ' . $row->ymtaz_time->time_to;
                })
                ->addColumn('transaction_complete', function ($row) {
                    $status = $row->transaction_complete;
                    if ($status == 0) {
                        return 'غير مدفوع';
                    }
                    if ($status == 1) {
                        return 'مدفوع';
                    } elseif ($status == 2) {
                        return 'ملغي';
                    } else {
                        return 'مرفوض';
                    }
                })
                ->addColumn('status', function ($row) {
                    $status = $row->status;
                    if ($status == 0) {
                        return ' انتظار';
                    }
                    if ($status == 1) {
                        return 'قيد الدراسة';
                    } elseif ($status == 2) {
                        return 'مكتمل';
                    } elseif ($status == 3) {
                        return 'ملغي';
                    }
                })
                ->addColumn('action', function ($row) {
                    $actions = '
                                  <a class="m-1  "  href="' . route('admin.client_ymtaz_reservations.edit', $row->id) . '" data-id="' . $row->id . '" title="تعديل">
                                     <i class="fa-solid fa-user-edit"></i>
                                  </a>';
                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.client_reservations.ymtaz.index');

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

//        $request->validate([
//            '*' => 'required',
//        ], [
//            '*.required' => 'الحقل مطلوب'
//        ]);
//
//        $item = ClientReservationsTypes::create([
//            'title' => $request->name,
//        ]);
//        return \response()->json([
//            'status' => true
//        ]);
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
        $item = YmtazReservations::with('client', 'service', 'importance', 'ymtaz_date', 'ymtaz_time')->findOrFail($id);
        return view('admin.client_reservations.ymtaz.edit', get_defined_vars());
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
        $item = YmtazReservations::findOrFail($request->id);
        if ($item->transaction_complete == 0) {
            return redirect()->route('admin.client_ymtaz_reservations.edit', $item->id)->with('success', '  لا يمكن الرد , الموعد غير مدفوع');

        }
        if ($item->status != 2) {

            $request->validate([
                'replay' => 'required',
            ], [
                'replay.required' => ' حقل  محتوى الرد مطلوب'
            ]);

            $item->update([
                'replay' => $request->replay,
                'status' => 2,
                'replay_time' => date('h:i'),
                'replay_date' => date('Y-m-d'),
            ]);
            if ($request->has('replay_file')) {
                $item->update([
                    'replay_file' => saveImage($request->replay_file, 'uploads/ymtaz_reservations/replay_file/'),
                ]);
            }
            return redirect()->route('admin.client_ymtaz_reservations.edit', $item->id)->with('success', 'تم الرد بنجاح');

        } else {
            return redirect()->route('admin.client_ymtaz_reservations.edit', $item->id)->with('success', 'تم الرد مسبقاً ');

        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $item = ClientReservationsTypes::findOrFail($id);
        $item->update([
            'status' => 0
        ]);
        return \response()->json([
            'status' => true,
        ]);
    }
}
