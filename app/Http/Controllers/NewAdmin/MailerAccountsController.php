<?php

namespace App\Http\Controllers\NewAdmin;

use App\Models\MailerAccounts;
use Inertia\Inertia;
use App\Models\Visitor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MailerAccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $mailer = MailerAccounts::get();
        return Inertia::render('MailerAccounts/index', get_defined_vars());
    }

    public function edit($id)
    {
        $mailer = MailerAccounts::findOrFail($id);
        return Inertia::render('MailerAccounts/Edit/index', get_defined_vars());
    }

    public function update(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:mailer,email,NULL,id,deleted_at,NULL',
            'status' => 'required'
        ]);

        $mailerAccount = MailerAccounts::findOrFail($request->id);
        $mailerAccount->email = $request->email;
        $mailerAccount->is_subscribed = $request->status;
        $mailerAccount->save();
        return response()->json([
            'status' => true,
        ]);
    }

    public function destroy($id)
    {
        $mailerAccount = MailerAccounts::findOrFail(request('id'));
        $mailerAccount->delete();
        return to_route('newAdmin.mailer-accounts.index');
    }

}
