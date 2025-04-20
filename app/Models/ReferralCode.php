<?php

namespace App\Models;

use App\Models\Lawyer\Lawyer;
use App\Models\Service\ServiceUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReferralCode extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "referral_codes";
    protected $fillable = [
        'referral_code',
        'account_id',
    ];
    public function user()
    {
        return $this->belongsTo(Account::class);
    }

}
