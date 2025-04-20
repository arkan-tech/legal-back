<?php

namespace App\Models\LawyerYmtazContact;

use App\Models\Lawyer\Lawyer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LawyerYmtazContact extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lawyer_ymtaz_contacts';
    protected $fillable = [
        'lawyer_id', 'reply', 'details', 'subject', 'file', 'type', 'created_at', 'updated_at', 'ymtaz_reply_subject',
        'reply',
    ];

    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class, 'lawyer_id', 'id');
    }

    public function getFileAttribute()
    {
        return !empty($this->attributes['file']) ? asset('uploads/client/contacts_ymtaz/' . str_replace('\\', '/', $this->attributes['file'])) : null;

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
