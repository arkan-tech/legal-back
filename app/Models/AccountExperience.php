<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountExperience extends Model
{
    use HasFactory;

    protected $fillable = ['account_id', 'title', 'company', 'from', 'to'];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
