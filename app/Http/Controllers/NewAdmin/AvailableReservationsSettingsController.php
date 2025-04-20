<?php

namespace App\Http\Controllers\NewAdmin;

use Inertia\Inertia;
use App\Models\Visitor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Reservations\Reservation;
use Illuminate\Validation\ValidationException;
use App\Models\Reservations\AvailableReservation;
use App\Models\Reservations\AvailableReservationDateTime;




class AvailableReservationsSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $availableReservations = AvailableReservation::with(['reservationTypeImportance.reservationType', 'reservationTypeImportance.reservationImportance', 'reservationTypeImportance', 'availableDateTime'])->where('isYmtaz', 1)->get();
        return Inertia::render('Settings/Reservations/AvailableReservations/index', get_defined_vars());
    }

    public function createForm()
    {
        // $reservationTypes
        return Inertia::render('Settings/Reservations/AvailableReservations/Create/index', get_defined_vars());
    }
    public function edit($id)
    {
        // $visitor = Visitor::findOrFail($id);
        return Inertia::render('Settings/Reservations/AvailableReservations/Edit/index', get_defined_vars());
    }
    public function create(Request $request)
    {
        $request->validate([
            'reservation_type_importance_id' => 'required',
            'day' => 'required',
            'from' => 'required',
            'to' => 'required',
        ], [
            '*' => 'الحقل مطلوب'
        ]);

        $availableReservation = AvailableReservation::where(['availableDateTime.day' => $request->day, 'availableDateTime.from' => $request->from, 'availableDateTime.to' => $request->to, 'isYmtaz' => 1])->get();
        if (count($availableReservation) > 0) {
            throw ValidationException::withMessages(['date' => 'يوجد يوم و معاد في نفس الموعد المختار']);
        }

        $availableReservation = AvailableReservation::create([
            'reservation_type_importance_id' => $availableReservation->reservation_type_importance_id,
            'isYmtaz' => 1,
        ]);

        AvailableReservationDateTime::create([
            'reservation_id' => $availableReservation->id,
            'day' => $request->day,
            'from' => $request->from,
            'to' => $request->to
        ]);

        return to_route('newAdmin.settings.reservations.availableReservations.edit', ['id' => $availableReservation->id]);

    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'status' => 'required'
        ]);

        $visitor = Visitor::findOrFail($request->id);
        $visitor->name = $request->name;
        $visitor->email = $request->email;
        $visitor->status = $request->status;
        $visitor->save();
        return response()->json([
            'status' => true,
        ]);
    }

    public function destroy($id)
    {
        $visitor = Visitor::findOrFail(request('id'));
        $visitor->delete();
        return to_route('newAdmin.visitors.index');
    }

}
