<?php
namespace App\Models;

use App\Models\LawGuideLaw;
use App\Models\BookGuideSection;
use App\Models\LearningPathProgress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LearningPathItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'learning_path_id',
        'item_type',
        'item_id',
        'order',
        'mandatory',
    ];

    protected $appends = [
        'item',
        'locked'
    ];

    public function learningPath()
    {
        return $this->belongsTo(LearningPath::class);
    }

    public function getItemAttribute()
    {
        switch ($this->item_type) {
            case 'law-guide':
                return $this->lawGuideLaw;
            case 'book-guide':
                return $this->bookGuideSection;
            default:
                return null;
        }
    }

    public function progress()
    {
        return $this->hasOne(LearningPathProgress::class, 'learning_path_items');
    }

    public function getLawGuideGroupAttribute()
    {
        if ($this->item_type == 'law-guide') {
            return $this->lawGuideLaw?->lawGuide;
        }
        return null;
    }

    public function getBookGuideGroupAttribute()
    {
        if ($this->item_type == 'book-guide') {
            return $this->bookGuideSection?->bookGuide;
        }
        return null;
    }

    public function lawGuideLaw()
    {
        return $this->belongsTo(LawGuideLaw::class, 'item_id');
    }

    public function bookGuideSection()
    {
        return $this->belongsTo(BookGuideSection::class, 'item_id');
    }
    public function getLockedAttribute()
    {
        if ($this->mandatory) {
            $previousItem = $this->learningPath->items()->where('item_type', $this->item_type)->where('order', '<', $this->order)->orderBy('order', 'desc')->first();
            if ($previousItem && !$previousItem->progress) {
                return true;
            }
        }
        return false;
    }
}
