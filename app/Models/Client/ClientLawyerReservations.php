<?php

namespace App\Models\Client;

use App\Models\ClientReservations\ClientReservationsImportance;
use App\Models\Lawyer\Lawyer;
use App\Models\Lawyer\LawyerWorkDays;
use App\Models\Lawyer\LawyerWorkDayTimes;
use App\Models\Service\Service;
use App\Models\Service\ServiceUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientLawyerReservations extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'client_lawyer_reservations';
    protected $guarded = [];

    //Start Relations

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(ServiceUser::class, 'client_id', 'id');
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
        return !empty($this->attributes['file']) ? asset('uploads/client/reservations/lawyers/' . $this->attributes['file']) : null;
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
