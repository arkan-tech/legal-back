<?php

namespace App\Models\Lawyer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LawyersContact extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'lawyer_id', 'details', 'file', 'type', 'subject', 'ymtaz_reply_subject', 'reply', 'created_at', 'updated_at',
    ];

    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class, 'lawyer_id', 'id');
    }

    public function getFileAttribute()
    {
        return !empty($this->attributes['file']) || !is_null($this->attributes['file']) ? asset('uploads/lawyers/contacts_ymtaz/' . str_replace('\\', '/', $this->attributes['file'])) : null;

    }

    public function type()
    {
        if ($this->type == 1) {
            return "طلب خدمة";
        } elseif ($this->type == 2) {
            return "شكوى أو بلاغ";
        } elseif ($this->priority == 3) {
            return "أخرى";
        }
    }
}
