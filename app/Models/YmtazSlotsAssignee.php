<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class YmtazSlotsAssignee extends Model
{
    use HasFactory;
    protected $table = 'ymtaz_slots_assignees';
    protected $fillable = [
        'slot_id',
        'assignee_id',
    ];

    public function slot()
    {
        return $this->belongsTo(YmtazSlots::class, 'slot_id', 'id');
    }

    public function assignee()
    {
        return $this->belongsTo(Account::class, 'assignee_id', 'id');
    }
}
