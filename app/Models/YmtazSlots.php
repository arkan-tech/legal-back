<?php

namespace App\Models;

use App\Models\YmtazSlotsAssignee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class YmtazSlots extends Model
{
    use HasFactory;

    protected $table = 'ymtaz_slots';

    protected $fillable = [
        'day',
        'leader_id',
    ];

    protected $with = ['leader'];

    public function leader()
    {
        return $this->belongsTo(Account::class, 'leader_id', 'id');
    }

    public function assignees()
    {
        return $this->hasMany(YmtazSlotsAssignee::class, 'slot_id', 'id');
    }

}
