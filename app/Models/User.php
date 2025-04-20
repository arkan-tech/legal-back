<?php

namespace App\Models;

use OwenIt\Auditing\Auditable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class User extends Authenticatable implements AuditableContract
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles, Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'avatar',
        'email_verified_at',
        'remember_token',
        'settings',
        'created_at',
        'updated_at',
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAvatarAttribute()
    {
        return !empty($this->attributes['avatar']) ? app_url('uploads/' . $this->attributes['avatar']) : asset('admin/app-assets/images/portrait/small/avatar-s-11.jpeg');

    }

    public function getUserTypeAttribute()
    {
        return 'admin';
    }

    public function auditableEvents()
    {
        return [
            'created',
            'updated',
            'deleted',
        ];
    }
    public function transformAudit(array $data): array
    {
        $data['user_type'] = $this->user_type;
        return $data;
    }
}
