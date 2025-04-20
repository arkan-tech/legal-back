<?php

namespace App\Models;

use App\Models\Account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\AdvisoryServices\AdvisoryServices;
use App\Models\AdvisoryServices\AdvisoryServicesTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ClientReservations\ClientReservationsImportance;
use App\Models\AdvisoryServices\AdvisoryServicesSubCategoryPrice;

class AdvisoryServicesReservations extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'sub_category_price_id',
        'description',
        'price',
        'payment_status',
        'accept_rules',
        'accept_date',
        'reservation_status',
        'replay_status',
        'replay_subject',
        'replay_content',
        'transaction_id',
        'transaction_complete',
        'replay_time',
        'replay_date',
        'call_id',
        'from',
        'to',
        'day',
        'transferTime',
        'for_admin',
        'advisory_id',
        'request_status',
        'account_id',
        'reserved_from_lawyer_id',
        'elite_service_request_id'
    ];
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id')->withTrashed();
    }

    // public function service()
    // {
    //     return $this->belongsTo(AdvisoryServices::class, 'advisory_services_id', 'id')->withTrashed();
    // }

    // public function type()
    // {
    //     return $this->belongsTo(AdvisoryServicesTypes::class, 'type_id', 'id')->withTrashed();
    // }

    // public function importanceRel()
    // {
    //     return $this->belongsTo(ClientReservationsImportance::class, 'importance_id', 'id')->withTrashed();
    // }
    public function files()
    {
        return $this->hasMany(AdvisoryServicesReservationFiles::class, 'reservation_id');
    }
    public function subCategoryPrice()
    {
        return $this->belongsTo(AdvisoryServicesSubCategoryPrice::class, 'sub_category_price_id', 'id')->withTrashed();
    }
    public function lawyer()
    {
        return $this->belongsTo(Account::class, 'reserved_from_lawyer_id', 'id')->withTrashed();
    }

    public function ReservationStatus()
    {
        $ReservationStatus = $this->attributes['reservation_status'];
        $status = "";
        switch ($ReservationStatus) {
            case 1:
                $status = 'مقبول';
                break;
            case 2:
                $status = 'تمت الاحالة الى مستشار';
                break;
            case 3:
                $status = 'تم القبول من المحامي';
                break;
            case 4:
                $status = 'قيد الدراسة';
                break;
            case 5:
                $status = 'تم الانتهاء';
                break;
            case 6:
                $status = 'مرفوض من الادارة';
                break;
            case 7:
                $status = 'ملغي من العميل';
                break;
        }
        return $status;
    }

    public function paymentStatus()
    {
        $paymentStatus = $this->attributes['transaction_complete'];
        $status = "";
        switch ($paymentStatus) {
            case 0:
                $status = 'غير مدفوع';
                break;
            case 1:
                $status = 'مدفوع';
                break;
            case 2:
                $status = 'الغاء الدفع';
                break;
            case 3:
                $status = 'عملية دفع فاشلة';
                break;
            case 4:
                $status = 'عملية دفع فاشلة';
                break;

        }
        return $status;
    }

    public function replayStatus()
    {
        $replayStatus = $this->attributes['replay_status'];
        $status = "";
        switch ($replayStatus) {
            case 0:
                $status = 'انتظار الرد';
                break;
            case 1:
                $status = 'تم الرد';
                break;
        }
        return $status;
    }
}
