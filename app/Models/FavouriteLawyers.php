<?php

namespace App\Models;

use App\Models\Lawyer\Lawyer;
use App\Models\Service\ServiceUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FavouriteLawyers extends Model
{
    use HasFactory;

    protected $table = 'favourite_lawyers';
    protected $fillable = ['service_user_id', 'userType', 'lawyer_id', 'fav_lawyer_id'];

    public function favLawyer()
    {
        return $this->belongsTo(Lawyer::class, 'fav_lawyer_id', 'id');
    }
    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class, 'lawyer_id', 'id');
    }
    public function client()
    {
        return $this->belongsTo(ServiceUser::class, 'service_user_id', 'id');
    }

}
