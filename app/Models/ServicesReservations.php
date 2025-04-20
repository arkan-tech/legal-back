<?php

namespace App\Models;

use App\Models\Account;
use App\Models\Service\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ServicesRequestsAndReservationsFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ClientReservations\ClientReservationsImportance;

class ServicesReservations extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'services_reservations';
    protected $fillable = [
        'type_id',
        'description',
        'priority',
        'file',
        'payment_status',
        'price',
        'replay',
        'replay_file',
        'replay_from_admin',
        'replay_from_lawyer_id',
        'replay_status',
        'replay_date',
        'replay_time',
        'status', // e.g., 'pending', 'accepted', 'declined'
        'for_admin',
        'advisory_id',
        'request_status',
        'accept_rules',
        'referral_status',
        'transaction_complete',
        'transaction_id',
        'transferTime',
        'day',
        'from',
        'to',
        'account_id',
        'reserved_from_lawyer_id',
        'elite_service_request_id'
    ];
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id')->withTrashed();
    }

    public function type()
    {
        return $this->belongsTo(Service::class, 'type_id', 'id')->withTrashed();
    }

    public function priorityRel()
    {
        return $this->belongsTo(ClientReservationsImportance::class, 'priority', 'id')->withTrashed();
    }

    public function lawyer()
    {
        return $this->belongsTo(Account::class, 'reserved_from_lawyer_id', 'id')->withTrashed();
    }

    public function getFileAttribute()
    {
        return !empty($this->attributes['file']) ? asset('uploads/services-reservations/' . str_replace('\\', '/', $this->attributes['file'])) : null;
    }

    public function getReplayFileAttribute()
    {
        return !empty($this->attributes['replay_file']) ? asset('uploads/lawyer/service_request/replay_file/' . str_replace('\\', '/', $this->attributes['replay_file'])) : null;
    }

    public function forAdmin()
    {
        $for_admin = $this->attributes['for_admin'];
        $status = "";
        switch ($for_admin) {
            case 1:
                $status = 'الادمن';
                break;

            case 3:
                $status = 'هيئة استشارية';
                break;

            case 2:
                $status = 'مستشار';
                break;
        }
        return $status;
    }

    public function offers()
    {
        return $this->hasMany(ServiceRequestOffer::class, 'service_request_id', 'id');
    }

    public function files()
    {
        return $this->hasMany(ServicesRequestsAndReservationsFile::class, 'reservation_id');
    }
}
