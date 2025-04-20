<?php

namespace App\Models\ElectronicOffice\Services;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Services extends Model
{
    use HasFactory , SoftDeletes;
    protected $table = 'ec_services';
    protected $guarded = [];

    public function getImageAttribute(){
        return !empty($this->attributes['image']) || !is_null($this->attributes['image']) ? asset('uploads/lawyers/electronic_office/' . str_replace('\\', '/', $this->attributes['image'])) : asset('uploads/person.png');

    }
}
