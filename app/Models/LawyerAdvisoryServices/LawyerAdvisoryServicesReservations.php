<?php

namespace App\Models\LawyerAdvisoryServices;

use App\Models\AdvisoryServices\AdvisoryServices;
use App\Models\AdvisoryServices\AdvisoryServicesTypes;
use App\Models\ClientReservations\ClientReservationsImportance;
use App\Models\Lawyer\Lawyer;
use App\Models\Service\ServiceUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LawyerAdvisoryServicesReservations extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lawyer_advisory_services_reservations';
    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo(Lawyer::class, 'reserved_lawyer_id', 'id')->withTrashed();
    }

    public function service()
    {
        return $this->belongsTo(AdvisoryServices::class, 'advisory_services_id', 'id')->withTrashed();
    }

    public function type()
    {
        return $this->belongsTo(AdvisoryServicesTypes::class, 'type_id', 'id')->withTrashed();
    }

    public function importanceRel()
    {
        return $this->belongsTo(ClientReservationsImportance::class, 'importance_id', 'id')->withTrashed();
    }

    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class, 'lawyer_id', 'id')->withTrashed();
    }

    public function appointment()
    {
        return $this->belongsTo(LawyerAdvisoryServicesAppointment::class, 'id', 'lawyer_id')->withTrashed();
    }

    public function getFileAttribute()
    {
        return !empty($this->attributes['file']) ? asset('uploads/advisory_services/reservations/' . str_replace('\\', '/', $this->attributes['file'])) : null;

    }

    public function getReplayFileAttribute()
    {
        return !empty($this->attributes['replay_file']) ? asset('uploads/advisory_services/replay_file/reservations/' . str_replace('\\', '/', $this->attributes['replay_file'])) : null;

    }

    public function ReservationStatus()
    {
        $ReservationStatus = $this->attributes['reservation_status'];
        switch ($ReservationStatus) {
            case 1:
                return '  مقبول';
                break;
            case 2:
                return 'تمت الاحالة الى مستشار';
                break;
            case 3:
                return ' تم القبول من المحامي ';
                break;
            case 4:
                return '  قيد الدراسة ';
                break;
            case 5:
                return 'تم الانتهاء';
                break;
            case 6:
                return 'مرفوض من الادارة';
                break;
            case 7:
                return 'ملغي من العميل';
                break;
        }
    }

    public function paymentStatus()
    {
        $paymentStatus = $this->attributes['transaction_complete'];
        switch ($paymentStatus) {
            case 0:
                return ' غير مدفوع';
                break;
            case 1:
                return 'مدفوع';
                break;
            case 2:
                return 'الغاء الدفع';
                break;
            case 3:
                return ' عملية دفع فاشلة';
                break;
            case 4:
                return ' عملية دفع فاشلة';
                break;

        }
    }

    public function replayStatus()
    {
        $replayStatus = $this->attributes['replay_status'];
        switch ($replayStatus) {
            case 0:
                return 'انتظار الرد';
                break;
            case 1:
                return 'تم الرد';
                break;

        }
    }
}
