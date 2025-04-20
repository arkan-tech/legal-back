<?php

namespace App\Models\Lawyer;

use App\Models\ClientReservations\ClientReservationsImportance;
use App\Models\Service\Service;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LawyerReservationsLawyer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lawyer_reservations_lawyer';
    protected $guarded = [];

    //Start Relations

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(Lawyer::class, 'reserved_lawyer_id', 'id');
    }

    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class, 'lawyer_id', 'id');
    }

    public function importance()
    {
        return $this->belongsTo(ClientReservationsImportance::class, 'importance_id', 'id');
    }

    public function date()
    {
        return $this->belongsTo(LawyerWorkDays::class, 'date_id', 'id');
    }

    public function time()
    {
        return $this->belongsTo(LawyerWorkDayTimes::class, 'time_id', 'id');
    }

    //End Relations


    //Start Mutators
    public function getFileAttribute()
    {
        return !empty($this->attributes['file']) ? asset('uploads/lawyer/reservations/lawyers/' . $this->attributes['file']) : null;
    }
    //End Mutators

    //Start General Functions
    public function CompleteStatus()
    {
        $status = $this->attributes['complete_status'];
        switch ($status) {
            case 0:
                return 'انتظار ';
                break;
            case 1:
                return 'مكتمل ';
                break;
            case 2:
                return 'ملغي ';
                break;
            case 3:
                return 'مرفوض ';
                break;

        }
    }
    //End General Functions


}
