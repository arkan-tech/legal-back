<?php

namespace App\Models\Organizations;

use App\Models\AdvisoryCommittee\AdvisoryCommittee;
use App\Models\Lawyer\Lawyer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganizationsRequest extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'lawyer_id','description','priority','status', 'description', 'organization_id','price', 'file','payment_status', 'created_at', 'updated_at'
    ];
    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class, 'lawyer_id', 'id')->withTrashed();
    }
    public function organization()
    {
        return $this->belongsTo(AdvisoryCommittee::class, 'organization_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(AdvisoryCommittee::class, 'organization_id', 'id');
    }

    public function getFileAttribute(){
        return !empty($this->attributes['file']) || !is_null($this->attributes['file']) ? asset('uploads/lawyers/OrganizationsRequest/' . str_replace('\\', '/', $this->attributes['file'])) : null;

    }
}
