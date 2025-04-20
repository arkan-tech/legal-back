<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MailerAccounts extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'mailer';

    protected $fillable = [
        'email',
        'is_subscribed'
    ];



    public function subscribe()
    {
        $this->is_subscribed = true;
        $this->save();
    }

    public function unsubscribe()
    {
        $this->is_subscribed = false;
        $this->save();
    }
}
