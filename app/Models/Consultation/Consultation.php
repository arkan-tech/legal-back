<?php

namespace App\Models\Consultation;

use App\Models\Lawyer;
use App\Models\Service\ServiceUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consultation extends Model
{
    use HasFactory, SoftDeletes;

    public function client()
    {
        return $this->belongsTo(ServiceUser::class, 'client_id', 'id');
    }

    public function lawyer()
    {
        return $this->belongsTo(Lawyer\Lawyer::class, 'lawyer_id', 'id');
    }

}
