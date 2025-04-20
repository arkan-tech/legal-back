<?php

namespace App\Models;

use App\Models\Lawyer\Lawyer;
use App\Models\Service\ServiceUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Level extends Model
{
    use SoftDeletes;
    protected $fillable = ['level_number', 'required_experience'];

    public function clients()
    {
        return $this->hasMany(ServiceUser::class, 'client_id');
    }

    public function lawyers()
    {
        return $this->hasMany(Lawyer::class, 'lawyer_id');
    }
}
