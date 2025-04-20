<?php

namespace App\Http\Controllers\Admin\ClientReservations;

use App\Http\Controllers\Controller;
use App\Models\ClientReservations\ClientReservations;
use App\Models\ClientReservations\ClientReservationsTypes;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class ClientReservationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $items = ClientReservations::with('client', 'typeRel', 'importanceRel')->where('reservation_with_ymtaz', 0)->orderBy('created_at', 'desc')->get();
            return DataTables::of($items)
                ->addColumn('client',function ($row){
                    return $row->client->myname;
                })
                ->addColumn('type',function ($row){
                    return $row->typeRel->title;
                })
                ->addColumn('importance',function ($row){
                    return $row->importanceRel->title;
                })
                ->addColumn('action', function ($row) {
                    $actions = '
                                  <a class="m-1  btn_show_client_reservations"  href="' . route('admin.client_reservations.show', $row->id) . '" data-id="' . $row->id . '" title="عرض ">
                                     <i class="fa-solid fa-eye"></i>
                                  </a>';
                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.client_reservations.index');

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

        $request->validate([
            '*' => 'required',
        ], [
            '*.required' => 'الحقل مطلوب'
        ]);

        $item = ClientReservationsTypes::create([
            'title' => $request->name,
        ]);
        return \response()->json([
            'status' => true
        ]);
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
        $item = ClientReservations::with('client','typeRel','importanceRel')->findOrFail($id);
        return \response()->json([
            'status' => true,
            'item' => $item
        ]);
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
            '*' => 'required',
        ], [
            '*.required' => 'الحقل مطلوب'
        ]);
        $item = ClientReservationsTypes::findOrFail($request->id);
        $item->update([
            'title' => $request->name,
        ]);
        return \response()->json([
            'status' => true,
        ]);

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
