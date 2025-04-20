<?php

namespace App\Models\Organizations;

use App\Models\Lawyer\Lawyer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganizationsRequest_reply extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'organization_requests_replies';

    protected $fillable = [
        'request_id', 'reply', 'lawyer_id', 'from', 'attachment', 'created_at', 'updated_at',
    ];

    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class, 'lawyer_id', 'id');
    }

    public function getAttachmentAttribute(){
        return !empty($this->attributes['file']) || !is_null($this->attributes['file']) ? asset('uploads/lawyers/OrganizationsRequest/Replays' . str_replace('\\', '/', $this->attributes['file'])) : null;

    }
}
