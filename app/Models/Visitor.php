<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Visitor extends Authenticatable implements JWTSubject
{
    use HasFactory, SoftDeletes;
    protected $table = "visitors";
    protected $guarded = [];
    public function injectToken($token)
    {
        $this->token = $token;
    }
    //End General Functions


    //Start JWT Functions

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    //End JWT Functions
}
