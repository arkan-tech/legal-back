<?php

namespace App\Models;

use App\Models\Service\Service;
use App\Models\LawyerPermission;
use Illuminate\Database\Eloquent\Model;
use App\Models\Reservations\Reservation;
use App\Models\Reservations\ReservationType;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\DigitalGuide\DigitalGuideCategories;
use App\Models\AdvisoryServices\AdvisoryServicesTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Package extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "packages";
    protected $guarded = [];

    public function services()
    {
        return $this->belongsToMany(Service::class, 'packages_services', 'package_id', 'service_id')->withPivot('number_of_bookings');
    }
    public function reservations()
    {
        return $this->belongsToMany(ReservationType::class, 'packages_reservations', 'package_id', 'reservation_type_id')->withPivot('number_of_bookings');
    }

    // Define the many-to-many relationship with AdvisoryService
    public function advisoryServices()
    {
        return $this->belongsToMany(AdvisoryServicesTypes::class, 'packages_advisory_services', 'package_id', 'advisory_services_type_id')->withPivot('number_of_bookings');
    }

    // Define the many-to-many relationship with LawyerPermission
    public function permissions()
    {
        return $this->belongsToMany(LawyerPermission::class, 'package_assigned_permissions', 'package_id', 'lawyer_permission_id');
    }

    public function sections()
    {
        return $this->belongsToMany(DigitalGuideCategories::class, 'packages_sections', 'package_id', 'section_id');
    }

    public function hasSectionsForLawyer($lawyerId, $sectionIds)
    {
        if (auth()->user()->account_type !== 'lawyer') {
            return false;
        }

        $lawyer = LawyerAdditionalInfo::where('account_id', $lawyerId)->first();
        if (!$lawyer) {
            return false;
        }

        $lawyerSectionIds = $lawyer->sectionsRel->pluck('id')->toArray();
        return !array_diff($sectionIds, $lawyerSectionIds);
    }
}
