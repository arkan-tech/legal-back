<?php

namespace App\Models\Client;

use App\Models\Service\ServiceUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientDeleteAccountRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'client_delete_accounts_requests';
    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo(ServiceUser::class, 'client_id', 'id');
    }
}
