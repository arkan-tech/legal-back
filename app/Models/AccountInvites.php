<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountInvites extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "invites";
    protected $fillable = [
        'account_id',
        'email',
        'phone',
        'phone_code',
        'status'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }
}
