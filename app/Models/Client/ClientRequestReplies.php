<?php

namespace App\Models\Client;

use App\Models\Lawyer\Lawyer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientRequestReplies extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'client_requests_replies';
    protected $fillable  =['client_requests_id','replay','from_admin','from','id','file','replay_laywer_id'];

    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class, 'replay_laywer_id', 'id');
    }

    public function getFileAttribute()
    {
        return !empty($this->attributes['file']) ? asset('uploads/client/service_request/' . str_replace('\\', '/', $this->attributes['file'])) : null;

    }
}
