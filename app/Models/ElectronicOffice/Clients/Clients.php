<?php

namespace App\Models\ElectronicOffice\Clients;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clients extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ec_clients';
    protected $guarded = [];

    public function getImageAttribute()
    {
        return !empty($this->attributes['image']) || !is_null($this->attributes['image']) ? asset('uploads/lawyers/electronic_office/clients/' . str_replace('\\', '/', $this->attributes['image'])) : asset('uploads/person.png');

    }
}
