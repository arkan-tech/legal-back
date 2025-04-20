<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountBankInfo extends Model
{
    use HasFactory;

    protected $table = 'account_bank_info';

    protected $fillable = ['account_id', 'bank_name', 'account_number'];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
