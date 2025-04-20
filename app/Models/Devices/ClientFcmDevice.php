<?php

namespace App\Models\Devices;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientFcmDevice extends Model
{
    use HasFactory , SoftDeletes;
    protected $table = 'client_fcm_devices';

    protected $guarded = [];

}
