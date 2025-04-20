<?php

namespace App\Models;

use App\Models\Account;
use App\Models\LearningPathItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FavouriteLearningPathItem extends Model
{
    use HasFactory;

    protected $table = 'favourite_learning_path_items';
    protected $fillable = ['account_id', 'learning_path_item_id'];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function learningPathItem()
    {
        return $this->belongsTo(LearningPathItem::class, 'learning_path_item_id', 'id');
    }
}
