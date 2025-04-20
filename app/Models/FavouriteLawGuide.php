<?php

namespace App\Models;

use App\Models\LawGuideLaw;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FavouriteLawGuide extends Model
{
    use HasFactory;

    protected $table = 'favourite_law_guides';
    protected $fillable = ['account_id', 'law_id'];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function law()
    {
        return $this->belongsTo(LawGuideLaw::class, 'law_id', 'id');
    }
}
