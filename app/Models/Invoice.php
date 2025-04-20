<?php

namespace App\Models;

use App\Models\Service\ServiceUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $table = 'invoices';
    protected $fillable = [
        'user_id',
        'transaction_id',
        'status',
        'amount',
        'fees',
        'description',
        'ip_address',
        'service',
        'serviceCate',
        'requester_type',
        'order_number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->locale('ar')->translatedFormat('d F Y H:i');
    }
    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->locale('ar')->translatedFormat('d F Y H:i');
    }
    public function getFeesAttribute($value)
    {
        return number_format($value, 2);
    }
    public function getAmountAttribute($value)
    {
        return number_format($value, 2);
    }
    public function getTransactionIdAttribute($value)
    {
        return $value;
    }
    public function setTransactionIdAttribute($value)
    {
        $this->attributes['transaction_id'] = $value;
    }

    public function account()
{
    return $this->belongsTo(Account::class, 'user_id', 'id');
}
    public function serviceUser()
    {
        return $this->belongsTo(ServiceUser::class, 'user_id', 'id');
    }
}