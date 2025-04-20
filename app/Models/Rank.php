<?php

namespace App\Models;

use App\Models\Lawyer\Lawyer;
use App\Models\Service\ServiceUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rank extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'min_level', 'border_color', 'image'];

    public function clients()
    {
        return $this->hasMany(ServiceUser::class, 'client_id');
    }

    public function lawyers()
    {
        return $this->hasMany(Lawyer::class, 'lawyer_id');
    }

    public function getImageAttribute()
    {
        return !empty($this->attributes['image']) || !is_null($this->attributes['image']) ? asset('uploads/ranks/' . $this->attributes['image']) : null;

    }
}
