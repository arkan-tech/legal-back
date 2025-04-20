<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FavouriteBookGuide extends Model
{
    use HasFactory;

    protected $table = 'favourite_book_guides';
    protected $fillable = ['account_id', 'section_id'];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function section()
    {
        return $this->belongsTo(BookGuideSection::class, 'section_id', 'id');
    }
}
