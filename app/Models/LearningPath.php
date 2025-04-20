<?php

namespace App\Models;

use App\Models\Account;
use App\Models\LearningPathItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LearningPath extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'order',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function items()
    {
        return $this->hasMany(LearningPathItem::class);
    }
}
