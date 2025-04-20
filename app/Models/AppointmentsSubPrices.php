<?php

namespace App\Models;

use App\Models\Account;
use App\Models\AppointmentsSubCategory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AppointmentsMainCategory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ClientReservations\ClientReservationsImportance;

class AppointmentsSubPrices extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'appointments_sub_prices';

    protected $fillable = [
        'main_category_id',
        'price',
        'account_id',
        'importance_id',
        'is_hidden',
    ];

    public function mainCategory()
    {
        return $this->belongsTo(AppointmentsMainCategory::class, 'main_category_id');
    }
    public function importance()
    {
        return $this->belongsTo(ClientReservationsImportance::class, 'importance_id');
    }
    public function lawyer()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}
