<?php

namespace App\Models\Client;

use App\Models\Lawyer\Lawyer;
use App\Models\Service\Service;
use App\Models\Service\ServiceUser;
use App\Models\Service\ServicesType;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client\ClientRequestReplies;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ClientReservations\ClientReservationsImportance;

class ClientRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'status',
        'description',
        'replay_status',
        'type_id',
        'file',
        'priority',
        'created_at',
        'updated_at',
        'payment_status',
        'price',
        'for_admin',
        'referral_status',
        'advisory_id',
        'lawyer_id',
        'replay',
        'replay_file',
        'replay_from_admin',
        'replay_from_lawyer_id',
        'accept_rules',
        'request_status',
        'transaction_complete',
        'transaction_id',
        'replay_date',
        'replay_time'
    ];

    public function client()
    {
        return $this->belongsTo(ServiceUser::class, 'client_id', 'id')->withTrashed();
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
        return !empty($this->attributes['file']) ? asset('uploads/client/service_request/' . str_replace('\\', '/', $this->attributes['file'])) : null;
    }

    public function getReplayFileAttribute()
    {
        return !empty($this->attributes['replay_file']) ? asset('uploads/client/service_request/replay_file/' . str_replace('\\', '/', $this->attributes['replay_file'])) : null;
    }

    public function replies()
    {
        return $this->hasMany(ClientRequestReplies::class, 'client_requests_id', 'id')->withTrashed();
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
