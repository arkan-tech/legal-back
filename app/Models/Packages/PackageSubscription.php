<?php

namespace App\Models\Packages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Account;
use App\Models\Package;

class PackageSubscription extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'package_id',
        'account_id',
        'transaction_id',
        'transaction_complete',
        'consumed_services',
        'consumed_advisory_services',
        'consumed_reservations',
        'start_date',
        'end_date'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
