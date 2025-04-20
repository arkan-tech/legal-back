<?php

namespace App\Models\Reservations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReservationImportance extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $table = "reservation_importance";

    protected static function booted()
    {
        static::deleting(function ($reservationImportance) {
            $reservationTypeImportances = $reservationImportance->reservationTypeImportances();
            foreach ($reservationTypeImportances as $reservationTypeImportance) {
                $reservationTypeImportance->delete();
            }
        });
    }

    public function reservationTypeImportances()
    {
        return $this->hasMany(ReservationTypeImportance::class, 'reservation_importance_id', 'id');
    }
}
