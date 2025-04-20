<?php

namespace App\Models\Lawyer;

use App\Models\Lawyer;
use App\Models\Package\Package;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LawyerPackage extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'lawyer_packages';

    public function lawyer()
    {
        return $this->belongsTo(Lawyer\Lawyer::class, 'lawyer_id', 'id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }
}
