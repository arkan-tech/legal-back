<?php

namespace App\Models\Lawyer;

use App\Models\Service\ServiceUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LawyerDeleteAccountRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lawyer_delete_accounts_requests';
    protected $guarded = [];

    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class, 'lawyer_id', 'id');
    }
}
