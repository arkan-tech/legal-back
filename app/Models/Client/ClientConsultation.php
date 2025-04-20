<?php

namespace App\Models\Client;

use App\Models\Service\ServiceUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientConsultation extends Model
{
    use HasFactory, SoftDeletes;

    public function client()
    {
        return $this->belongsTo(ServiceUser::class, 'client_id', 'id');
    }
}
