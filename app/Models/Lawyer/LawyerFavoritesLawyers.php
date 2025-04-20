<?php

namespace App\Models\Lawyer;

use App\Models\Lawyer\Lawyer;
use App\Models\Service\ServiceUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LawyerFavoritesLawyers extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lawyer_favorite_lawyers';
    protected $guarded = [];

    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class, 'fav_lawyer_id', 'id');
    }

}
