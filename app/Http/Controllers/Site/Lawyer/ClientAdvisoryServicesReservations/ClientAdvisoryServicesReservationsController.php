<?php

namespace App\Http\Controllers\Site\Lawyer\ClientAdvisoryServicesReservations;

use App\Http\Controllers\Controller;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservations;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ClientAdvisoryServicesReservationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $lawyer = auth()->guard('lawyer')->user();
        $reservations = ClientAdvisoryServicesReservations::with('client', 'service', 'type', 'importanceRel', 'lawyer')
            ->where('lawyer_id', $lawyer->id)
            ->orderBy('created_at','desc')->get();
        return view('site.lawyers.client-advisory-services-reservations.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function SendFinalReplay(Request $request)
    {
        $request->validate([
            'replay_subject' => 'required',
            'replay_content' => 'required',
        ], [
            'replay_subject.required' => 'الحقل مطلوب ',
            'replay_content.required' => 'الحقل مطلوب ',
        ]);
        $reservation = ClientAdvisoryServicesReservations::findOrFail($request->id);
        $reservation->update([
            'replay_status' => 1,
            'replay_subject' => $request->replay_subject,
            'replay_content' => $request->replay_content,
            'reservation_status' => 5,

            'replay_time' =>  date("h:i:s"),
            'replay_date' => date("Y-m-d"),
        ]);
        if ($request->has('replay_file')) {
            $reservation->update([
                'replay_file' => saveImage($request->replay_file, 'uploads/advisory_services/replay_file/reservations/')
            ]);
        }
        return \response()->json([
            'status' => true
        ]);
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
}
