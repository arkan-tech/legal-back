<?php

namespace App\Models\Complaint;

use App\Models\Lawyer\Lawyer;
use App\Models\Service\ServiceUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Complaint extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'complaints';
    protected $fillable = [
        'client_id', 'lawyer_id', 'complaint_body', 'created_at', 'updated_at',
    ];

    public function client()
    {
        return $this->belongsTo(ServiceUser::class, 'client_id', 'id');
    }

    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class, 'lawyer_id', 'id');
    }
}
