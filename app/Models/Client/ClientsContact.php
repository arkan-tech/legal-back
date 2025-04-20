<?php

namespace App\Models\Client;

use App\Models\Service\ServiceUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientsContact extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id', 'reply', 'details', 'subject', 'file', 'type', 'created_at', 'updated_at','ymtaz_reply_subject',
        'reply',
    ];

    public function client()
    {
        return $this->belongsTo(ServiceUser::class, 'client_id', 'id');
    }
    public function getFileAttribute()
    {
        return !empty($this->attributes['file'])? asset('uploads/client/contacts_ymtaz/' . str_replace('\\', '/', $this->attributes['file'])) : null;

    }
    public function type()
    {
        if ($this->type == 1) {
            return "طلب خدمة";
        } elseif ($this->type == 2) {
            return "شكوى أو بلاغ";
        } elseif ($this->type == 3) {
            return "أخرى";
        }
    }
}
