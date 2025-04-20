<?php

namespace App\Models\LawyerServicesRequest;

use App\Models\ClientReservations\ClientReservationsImportance;
use App\Models\Lawyer\Lawyer;
use App\Models\Service\Service;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LawyerServicesRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lawyer_services_requests';
    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo(Lawyer::class, 'request_lawyer_id', 'id')->withTrashed();
    }

    public function type()
    {
        return $this->belongsTo(Service::class, 'type_id', 'id')->withTrashed();
    }

    public function priorityRel()
    {
        return $this->belongsTo(ClientReservationsImportance::class, 'priority', 'id')->withTrashed();
    }

    public function Lawyer()
    {
        return $this->belongsTo(Lawyer::class, 'lawyer_id', 'id')->withTrashed();
    }

    public function getFileAttribute()
    {
        return !empty($this->attributes['file']) ? asset('uploads/lawyer/service_request/' . str_replace('\\', '/', $this->attributes['file'])) : null;
    }

    public function getReplayFileAttribute()
    {
        return !empty($this->attributes['replay_file']) ? asset('uploads/lawyer/service_request/replay_file/' . str_replace('\\', '/', $this->attributes['replay_file'])) : null;
    }
    public function requesterLawyer()
    {
        return $this->belongsTo(Lawyer::class, 'request_lawyer_id', 'id')->withTrashed();

    }
    public function forAdmin()
    {
        $for_admin = $this->attributes['for_admin'];
        switch ($for_admin) {
            case 1:
                return 'الادمن';
            case 3:
                return 'هيئة استشارية';
            case 2:
                return 'مستشار';
        }
    }


}
