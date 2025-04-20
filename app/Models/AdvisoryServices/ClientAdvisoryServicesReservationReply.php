<?php

namespace App\Models\AdvisoryServices;

use App\Models\Service\ServiceUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservations;

class ClientAdvisoryServicesReservationReply extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'client_advisory_services_reservations_replies';

	protected $guarded = [];

    public function client()
    {
        return $this->belongsTo(ServiceUser::class, 'client_id', 'id');
    }

	public function client_advisory_services_reservation(){
		return $this->belongsTo(ClientAdvisoryServicesReservations::class, 'client_reservation_id', 'id');
	}
    public function getAttachmentAttribute(){
        return !empty($this->attributes['attachment']) || !is_null($this->attributes['attachment']) ? asset('uploads/lawyers/OrganizationsRequest/Replays' . str_replace('\\', '/', $this->attributes['attachment'])) : null;

    }
}
