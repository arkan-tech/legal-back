<?php

namespace App\Models;

use App\Models\Account;
use App\Models\Service\ServiceUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactYmtaz extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "contact_ymtaz";
    protected $guarded = [];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');

    }
    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class, 'lawyer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'reply_user_id');
    }

    public function getFileAttribute()
    {
        return !empty($this->attributes['file']) ? asset('uploads/contact_ymtaz/' . str_replace('\\', '/', $this->attributes['file'])) : null;
    }
}
