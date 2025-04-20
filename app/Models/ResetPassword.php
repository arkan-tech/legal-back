<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResetPassword extends Model
{
    use HasFactory;
    protected $table = 'reset_passwords';
    protected $fillable = [
        'email',
        'token',
        'used',
        'expires_at',
    ];
    protected $casts = [
        'used' => 'boolean',
        'expires_at' => 'datetime',
    ];
    public function isExpired(): bool
    {
        return $this->expires_at < Carbon::now();
    }
}
