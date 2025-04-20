<?php

namespace App\Models\Client;

use App\Models\Lawyer\Lawyer;
use App\Models\Service\ServiceUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientsFavoritesLawyers extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'client_favorite_lawyers';
    protected $guarded = [];

    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class, 'lawyer_id', 'id');
    }

}
