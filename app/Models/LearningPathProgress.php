<?php
namespace App\Models;

use App\Models\Account;
use App\Models\LearningPathItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LearningPathProgress extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'learning_path_items',
        'type',
        'account_id',
    ];

    public function learningPathItem()
    {
        return $this->belongsTo(LearningPathItem::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

}
