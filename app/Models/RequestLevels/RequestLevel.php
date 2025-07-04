<?php

namespace App\Models\RequestLevels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestLevel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'client_reservations_importance';
    protected $guarded = [];

}
