<?php

namespace App\Models\Consultation;

use App\Models\Client\ClientConsultation;
use App\Models\Service\ServiceUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consultation_reply extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'client_consultation_replies';

    protected $fillable = [
        'user_id', 'reply', 'consultation_id', 'from', 'created_at', 'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(ServiceUser::class, 'user_id', 'id');
    }

    public function course()
    {
        return $this->belongsTo(ClientConsultation::class, 'consultation_id', 'id');
    }
}
