<?php

namespace App\Http\Controllers\NewAdmin;

use App\Models\Reservations\ReservationImportance;
use App\Models\Reservations\ReservationTypeImportance;
use Inertia\Inertia;
use App\Models\Visitor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Reservations\ReservationType;




class ReservationsTypesSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $reservationTypes = ReservationType::with([
            'typesImportance' => function ($query) {
                $query->where('isYmtaz', 1)->with(['reservationType', 'reservationImportance']);
            }
        ])->get();
        return Inertia::render('Settings/Reservations/Types/index', get_defined_vars());
    }

    public function edit($id)
    {
        $reservationType = ReservationType::with([
            'typesImportance' => function ($query) {
                $query->where('isYmtaz', 1)->with(['reservationType', 'reservationImportance']);
            }
        ])->findOrFail($id);
        $reservationImportances = ReservationImportance::get();
        return Inertia::render('Settings/Reservations/Types/Edit/index', get_defined_vars());
    }
    public function createForm()
    {
        $reservationImportances = ReservationImportance::get();
        return Inertia::render('Settings/Reservations/Types/Create/index', get_defined_vars());
    }

    public function create(Request $request)
    {
        $request->validate([
            '*' => 'required',
            'name' => 'required',
            'minPrice' => 'required|lt:maxPrice',
            'maxPrice' => 'required|gt:minPrice',
            'prices.*.price' => 'gte:minPrice|lte:minPrice'
        ], [
            '*.required' => 'الحقل مطلوب',
            'minPrice.lt' => "الحد الأدنى يجب ان يكون اقل من الحد الأقصى",
            'maxPrice.gt' => "الحد الأقصى يجب ان يكون اكبر من الحد الأدنى",
            "prices.*.price.gte" => "يجب ان يكون سعر المستوى بين الحد الأدنى و الأقصى",
            "prices.*.price.lte" => "يجب ان يكون سعر المستوى بين الحد الأدنى و الأقصى",
        ]);
        $reservationType = ReservationType::create([
            'name' => $request->name,
            'minPrice' => $request->minPrice,
            'maxPrice' => $request->maxPrice,
        ]);
        foreach ($request->prices as $level) {
            if (!is_null($level['id'])) {
                ReservationTypeImportance::create([
                    'reservation_types_id' => $reservationType->id,
                    'reservation_importance_id' => $level['id'],
                    'price' => $level['price'],
                    'isYmtaz' => 1
                ]);
            }
        }
        return to_route('newAdmin.settings.reservations.types.edit', ['id' => $reservationType->id]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            '*' => 'required',
        ], [
            '*.required' => 'الحقل مطلوب',
        ]);
        $reservationType = ReservationType::findOrFail($id);

        $reservationType->update([
            'name' => $request->name,
            'minPrice' => $request->minPrice,
            'maxPrice' => $request->maxPrice,
        ]);
        $prices = ReservationTypeImportance::where('reservation_types_id', $reservationType->id)->delete();
        foreach ($request->prices as $level) {
            if (!is_null($level['id'])) {
                ReservationTypeImportance::create([
                    'reservation_types_id' => $reservationType->id,
                    'reservation_importance_id' => $level['id'],
                    'price' => $level['price'],
                    'isYmtaz' => 1
                ]);
            }
        }
        return response()->json([
            'success' => true,
        ]);
    }

    public function toggle(Request $request, $id)
    {
        $reservationType = ReservationType::findOrFail($id);
        $reservationType->isHidden = !$request->enabled;
        $reservationType->save();

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $reservationType = ReservationType::findOrFail(request('id'));
        $reservationType->delete();
        return to_route('newAdmin.settings.reservations.types.index');
    }

}
