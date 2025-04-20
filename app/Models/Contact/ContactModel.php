<?php

namespace App\Models\Contact;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactModel extends Model
{
    use HasFactory, SoftDeletes;
    public $timestamps = false;
    protected $table = 'contacts';
    protected $guarded = [];
}
