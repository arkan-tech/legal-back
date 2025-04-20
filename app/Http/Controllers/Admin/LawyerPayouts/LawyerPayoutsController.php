<?php

namespace App\Http\Controllers\Admin\LawyerPayouts;

use App\Models\Invoice;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\LawyerPayoutRequests;
use App\Models\Specialty\AccurateSpecialty;
use App\Models\FunctionalCases\FunctionalCases;
use Carbon\Carbon;


class LawyerPayoutsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index()
    {
        // dd('index');
        $lawyerPayouts = LawyerPayoutRequests::with(['payments', 'lawyer'])->orderBy('created_at', 'desc')->get();
        $lawyerPayouts = $lawyerPayouts->each(function ($payoutRequest) {
            $payoutRequest->payments->each(function ($payment) {
                $payment->setRelation('product', $payment->product);
            });
        });

        dd($lawyerPayouts);
        // return Inertia::render('LawyerPayouts/index', get_defined_vars());
    }
    public function edit($id)
    {
        $lawyerPayout = LawyerPayoutRequests::with(['payments', 'lawyer'])->orderBy('created_at', 'desc')->findOrFail($id);
        $lawyerPayout->payments->each(function ($payment) {
            $payment->setRelation('product', $payment->product);
        });
        return Inertia::render('LawyerPayouts/Edit/index', get_defined_vars());
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
            '*' => 'required'
        ], [
            '*.required' => 'الحقل مطلوب'
        ]);
        $lawyerPayout = LawyerPayoutRequests::with(['payments', 'lawyer'])->orderBy('created_at', 'desc')->findOrFail($request->id);
        $lawyerPayout->update([
            'comment' => $request->comment,
            'status' => $request->status
        ]);
        if ($request->status == 2) {
            $lawyerPayout->payments->each(function ($payment) {
                $payment->update([
                    'paid' => 1,
                ]);
            });
        }
        $lawyerPayout->payments->each(function ($payment) {
            $payment->setRelation('product', $payment->product);
        });
        return response()->json([
            'status' => true,
            "data" => $lawyerPayout
        ]);
    }


    public function invoices()
    {
        $invoices = Invoice::orderBy('created_at', 'desc')->get();

        $invoices = $invoices->map(function ($invoice) {

            $createdAt = $invoice->created_at;

            $months = [
                'يناير' => '01',
                'فبراير' => '02',
                'مارس' => '03',
                'أبريل' => '04',
                'مايو' => '05',
                'يونيو' => '06',
                'يوليو' => '07',
                'أغسطس' => '08',
                'سبتمبر' => '09',
                'أكتوبر' => '10',
                'نوفمبر' => '11',
                'ديسمبر' => '12',
            ];

            foreach ($months as $arabicMonth => $numericMonth) {
                if (strpos($createdAt, $arabicMonth) !== false) {
                    $createdAt = str_replace($arabicMonth, $numericMonth, $createdAt);
                    break;
                }
            }
            $invoice->user_name = $invoice->account->name ?? $invoice->serviceUser->name ?? 'غير معروف';

            $invoice->created_at = Carbon::createFromFormat('d m Y H:i', $createdAt)->toIso8601String();
            // dd($invoice);
            return $invoice;
        });



        return Inertia::render('Invoices/index', [
            'invoices' => $invoices
        ]);
    }



}