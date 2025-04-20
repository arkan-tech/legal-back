<?php

namespace App\Models;

use App\Models\Account;
use App\Models\Lawyer\Lawyer;
use App\Models\Service\ServiceUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExperienceLog extends Model
{
    protected $fillable = ['account_id', 'experience', 'reason'];

    // Define relationships
    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
