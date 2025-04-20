<?php

namespace App\Models\Service;

use App\Models\Lawyer\Lawyer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicesRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'lawyer_id',
        'description',
        'type_id',
        'file',
        'payment_status',
        'created_at',
        'updated_at',
    ];

    public function client()
    {
        return $this->belongsTo(ServiceUser::class, 'client_id', 'id')->withTrashed();
    }

    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class, 'lawyer_id', 'id')->withTrashed();
    }

    public function payment()
    {
        if ($this->payment_status == 1) {
            return "تم الدفع بنجاح";
        } elseif ($this->payment_status == 2) {
            return "تم الغاء الدفع من العميل";
        } elseif ($this->payment_status == 3) {
            return "تم رفض عملية الدفع";
        }
    }

    public function type()
    {
        return $this->belongsTo(ServicesType::class, 'type_id', 'id')->withTrashed();
    }
}
