<?php

namespace App\Models\YmtazReservations;

use App\Models\ClientReservations\ClientReservationsImportance;
use App\Models\Service\Service;
use App\Models\Service\ServiceUser;
use App\Models\YmtazSettings\YmtazWorkDays;
use App\Models\YmtazSettings\YmtazWorkDayTimes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class YmtazReservations extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ymtaz_clients_reservations';
    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo(ServiceUser::class, 'client_id', 'id');
    }

    public function importance()
    {
        return $this->belongsTo(ClientReservationsImportance::class, 'importance_id', 'id');
    }

    public function ymtaz_date()
    {
        return $this->belongsTo(YmtazWorkDays::class, 'ymtaz_date_id', 'id');
    }

    public function ymtaz_time()
    {
        return $this->belongsTo(YmtazWorkDayTimes::class, 'ymtaz_time_id', 'id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    public function getFileAttribute()
    {
        return !empty($this->attributes['file']) ? asset('uploads/ymtaz_reservations/' . str_replace('\\', '/', $this->attributes['file'])) : null;
    }

    public function getReplayFileAttribute()
    {
        return !empty($this->attributes['replay_file']) ? asset('uploads/ymtaz_reservations/replay_file/' . str_replace('\\', '/', $this->attributes['replay_file'])) : null;
    }
}
