<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LawyerPermission extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description'];

    // Define the many-to-many relationship with Package
    public function packages()
    {
        return $this->belongsToMany(Package::class, 'package_assigned_permissions', 'lawyer_permission_id', 'package_id');
    }
}
