<?php

namespace App\Models\Reservations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Reservations\ReservationTypeImportance;
use App\Models\Reservations\ReservationCategory;

class ReservationType extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected static function booted()
    {
        static::deleting(function ($reservationType) {
            $typesImportance = $reservationType->typesImportance();
            foreach ($typesImportance as $typeImportnace) {
                $typeImportnace->delete();
            }
        });
    }
    public function typesImportance()
    {
        return $this->hasMany(ReservationTypeImportance::class, 'reservation_types_id');
    }

    // Category relationship removed as it doesn't exist
}
