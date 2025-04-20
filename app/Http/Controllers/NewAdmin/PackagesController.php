<?php

namespace App\Http\Controllers\NewAdmin;

use Inertia\Inertia;
use App\Models\Books;
use App\Models\Package;
use App\Models\Activity;
use App\Models\City\City;
use Illuminate\Http\Request;
use App\Models\Degree\Degree;
use App\Models\Country\Country;
use App\Models\Regions\Regions;
use App\Models\Service\Service;
use App\Models\LawyerPermission;
use App\Models\BooksSubCategories;
use App\Models\BooksMainCategories;
use App\Http\Controllers\Controller;
use App\Rules\ArrayAtLeastOneRequired;
use App\Models\Reservations\ReservationType;
use App\Models\DigitalGuide\DigitalGuideCategories;
use App\Models\AdvisoryServices\AdvisoryServicesTypes;
use Google\Service\AndroidEnterprise\GoogleAuthenticationSettings;

class PackagesController extends Controller
{
    public function index()
    {
        $packages = Package::get();
        $types = $this->getTypes();
        return Inertia::render('Settings/Packages/index', get_defined_vars());
    }

    public function create()
    {
        $types = $this->getTypes();
        $services = Service::with('category', 'ymtaz_levels_prices.level')->orderBy('created_at', 'desc')->get();
        $advisoryServicesTypes = AdvisoryServicesTypes::orderBy('created_at', 'desc')->with(['advisoryService', 'advisoryService.payment_category', 'advisoryService.payment_category_type', 'advisoryService.payment_category.advisory_services_base', 'advisory_services_prices.importance'])->get();
        $reservationTypes = ReservationType::with([
            'typesImportance' => function ($query) {
                $query->where('isYmtaz', 1)->with(['reservationType', 'reservationImportance']);
            }
        ])->get();
        $sections = DigitalGuideCategories::where('status', 1)->get();

        $permissions = LawyerPermission::orderBy('created_at', 'desc')->get();
        return Inertia::render('Settings/Packages/Create/index', compact('types', 'services', 'advisoryServicesTypes', 'reservationTypes', 'permissions', 'sections'));

    }
    public function getTypes()
    {
        $types = [
            (object) ['id' => 0, 'name' => 'الكل'],
            (object) ['id' => 1, 'name' => 'فرد'],
            (object) ['id' => 2, 'name' => 'مؤسَّسة'],
            (object) ['id' => 3, 'name' => 'شركة'],
            (object) ['id' => 4, 'name' => 'جهة حكومية'],
            (object) ['id' => 5, 'name' => 'اخرى'],
        ];

        return $types;
    }

    public function edit($id)
    {
        $item = Package::with('services', 'advisoryServices', 'reservations', 'permissions', 'sections')->findOrFail($id);
        $types = $this->getTypes();
        $services = Service::with('category', 'ymtaz_levels_prices.level')->orderBy('created_at', 'desc')->get();
        $advisoryServicesTypes = AdvisoryServicesTypes::orderBy('created_at', 'desc')->with(['advisoryService', 'advisoryService.payment_category', 'advisoryService.payment_category_type', 'advisoryService.payment_category.advisory_services_base', 'advisory_services_prices.importance'])->get();
        $reservationTypes = ReservationType::with([
            'typesImportance' => function ($query) {
                $query->where('isYmtaz', 1)->with(['reservationType', 'reservationImportance']);
            }
        ])->get();
        $permissions = LawyerPermission::orderBy('created_at', 'desc')->get();
        $sections = DigitalGuideCategories::where('status', 1)->get();

        return Inertia::render('Settings/Packages/Edit/index', compact('item', 'types', 'services', 'advisoryServicesTypes', 'reservationTypes', 'permissions', 'sections'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'packageName' => 'required|string|max:255',
            'duration' => 'required|integer',
            'targetedType' => 'required|integer|in:0,1,2,3,4,5',
            'packageType' => 'required|integer|in:0,1,2',
            'priceBeforeDiscount' => 'required|numeric',
            'priceAfterDiscount' => 'required|numeric',
            'instructions' => 'sometimes|nullable|string',
            'selectedServices' => 'required_if:packageType,1|array',
            'selectedAdvisoryServicesTypes' => 'required_if:packageType,1|array',
            'selectedReservationTypes' => 'required_if:packageType,1|array',
            'selectedServices.*.number_of_bookings' => 'required|integer|min:1',
            'selectedAdvisoryServicesTypes.*.number_of_bookings' => 'required|integer|min:1',
            'selectedReservationTypes.*.number_of_bookings' => 'required|integer|min:1',
            'number_of_services' => 'required_if:packageType,1|integer',
            'number_of_advisory_services' => 'required_if:packageType,1|integer',
            'number_of_reservations' => 'required_if:packageType,1|integer',
            'durationType' => 'required|integer|in:1,2,3,4',
            'taxes' => 'required|numeric',
            'selectedLawyerPermissions' => 'required_if:packageType,2|array',
            'sections' => 'required_if:packageType,2|array',
        ], [
            '*.required' => 'الحقل مطلوب',
            'packageName.max' => 'اسم الحزمة يجب ألا يتجاوز 255 حرفًا',
            'instructions.string' => 'التعليمات يجب أن تكون نصًا',
            'selectedServices.min' => 'يجب اختيار خدمة واحدة على الأقل',
            'selectedAdvisoryServicesTypes.min' => 'يجب اختيار نوع خدمة استشارية واحدة على الأقل',
            'selectedReservationTypes.min' => 'يجب اختيار نوع حجز واحد على الأقل',
            'selectedLawyerPermissions.min' => 'يجب اختيار نوع مزية واحد على الأقل',
            'selectedServices.*.number_of_bookings.required' => 'عدد الحجوزات مطلوب لكل خدمة',
            'selectedAdvisoryServicesTypes.*.number_of_bookings.required' => 'عدد الحجوزات مطلوب لكل استشارة',
            'selectedReservationTypes.*.number_of_bookings.required' => 'عدد الحجوزات مطلوب لكل موعد',
        ]);

        if ($request->packageType == 1) {
            $totalServicesBookings = collect($request->selectedServices)->sum('number_of_bookings');
            $totalAdvisoryServicesBookings = collect($request->selectedAdvisoryServicesTypes)->sum('number_of_bookings');
            $totalReservationsBookings = collect($request->selectedReservationTypes)->sum('number_of_bookings');

            $errors = [];

            if ($totalServicesBookings !== $request->number_of_services) {
                $errors['servicesSelected'] = "عدد الحجوزات يجب أن يتوافق مع إجمالي عدد الخدمات المحدد.";
            }

            if ($totalAdvisoryServicesBookings !== $request->number_of_advisory_services) {
                $errors['advisoryServicesSelected'] = "عدد الحجوزات يجب أن يتوافق مع إجمالي عدد الاستشارات المحدد.";
            }

            if ($totalReservationsBookings !== $request->number_of_reservations) {
                $errors['reservationsSelected'] = "عدد الحجوزات يجب أن يتوافق مع إجمالي عدد المواعيد المحدد.";
            }

            if (!empty($errors)) {
                return response()->json([
                    "status" => false,
                    "errors" => $errors
                ], 422);
            }
        }

        $package = Package::create([
            'name' => $request->packageName,
            'duration' => $request->duration,
            'targetedType' => $request->targetedType,
            'priceBeforeDiscount' => $request->priceBeforeDiscount,
            'priceAfterDiscount' => $request->priceAfterDiscount,
            'instructions' => $request->instructions,
            'package_type' => $request->packageType,
            'number_of_services' => $request->number_of_services,
            'number_of_advisory_services' => $request->number_of_advisory_services,
            'number_of_reservations' => $request->number_of_reservations,
            'duration_type' => $request->durationType,
            'taxes' => $request->taxes,
        ]);

        if ($request->packageType == 1) {
            $package->services()->sync(collect($request->selectedServices)->mapWithKeys(function ($item) {
                return [$item['id'] => ['number_of_bookings' => $item['number_of_bookings']]];
            }));
            $package->advisoryServices()->sync(collect($request->selectedAdvisoryServicesTypes)->mapWithKeys(function ($item) {
                return [$item['id'] => ['number_of_bookings' => $item['number_of_bookings']]];
            }));
            $package->reservations()->sync(collect($request->selectedReservationTypes)->mapWithKeys(function ($item) {
                return [$item['id'] => ['number_of_bookings' => $item['number_of_bookings']]];
            }));
        }
        if ($request->packageType == 2) {

            $package->sections()->sync($request->sections);

            $package->permissions()->sync($request->selectedLawyerPermissions);

        }

        return response()->json([
            "status" => true,
            'item' => $package
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'packageName' => 'required|string|max:255',
            'duration' => 'required|integer',
            'targetedType' => 'required|integer|in:0,1,2,3,4,5',
            'priceBeforeDiscount' => 'required|numeric',
            'priceAfterDiscount' => 'required|numeric',
            'instructions' => 'sometimes|nullable|string',
            'selectedServices' => 'required_if:packageType,1|array',
            'selectedAdvisoryServicesTypes' => 'required_if:packageType,1|array',
            'selectedReservationTypes' => 'required_if:packageType,1|array',
            'selectedServices.*.number_of_bookings' => 'required|integer|min:1',
            'selectedAdvisoryServicesTypes.*.number_of_bookings' => 'required|integer|min:1',
            'selectedReservationTypes.*.number_of_bookings' => 'required|integer|min:1',
            'packageType' => 'required|integer|in:0,1,2',
            'number_of_services' => 'required_if:packageType,1|integer',
            'number_of_advisory_services' => 'required_if:packageType,1|integer',
            'number_of_reservations' => 'required_if:packageType,1|integer',
            'durationType' => 'required|integer|in:1,2,3,4',
            'taxes' => 'required|numeric',
            'selectedLawyerPermissions' => 'required_if:packageType,2|array',
            'sections' => 'required_if:packageType,2|array',
        ], [
            '*.required' => 'الحقل مطلوب',
            'packageName.max' => 'اسم الحزمة يجب ألا يتجاوز 255 حرفًا',
            'instructions.string' => 'التعليمات يجب أن تكون نصًا',
            'selectedServices.min' => 'يجب اختيار خدمة واحدة على الأقل',
            'selectedAdvisoryServicesTypes.min' => 'يجب اختيار نوع خدمة استشارية واحدة على الأقل',
            'selectedReservationTypes.min' => 'يجب اختيار نوع حجز واحد على الأقل',
            'selectedLawyerPermissions.min' => 'يجب اختيار نوع مزية واحد على الأقل',
            'selectedServices.*.number_of_bookings.required' => 'عدد الحجوزات مطلوب لكل خدمة',
            'selectedAdvisoryServicesTypes.*.number_of_bookings.required' => 'عدد الحجوزات مطلوب لكل استشارة',
            'selectedReservationTypes.*.number_of_bookings.required' => 'عدد الحجوزات مطلوب لكل موعد',
        ]);

        $totalServicesBookings = collect($request->selectedServices)->sum('number_of_bookings');
        $totalAdvisoryServicesBookings = collect($request->selectedAdvisoryServicesTypes)->sum('number_of_bookings');
        $totalReservationsBookings = collect($request->selectedReservationTypes)->sum('number_of_bookings');

        if ($request->packageType == 1) {
            $totalServicesBookings = collect($request->selectedServices)->sum('number_of_bookings');
            $totalAdvisoryServicesBookings = collect($request->selectedAdvisoryServicesTypes)->sum('number_of_bookings');
            $totalReservationsBookings = collect($request->selectedReservationTypes)->sum('number_of_bookings');

            $errors = [];

            if ($totalServicesBookings !== $request->number_of_services) {
                $errors['servicesSelected'] = "عدد الحجوزات يجب أن يتوافق مع إجمالي عدد الخدمات المحدد.";
            }

            if ($totalAdvisoryServicesBookings !== $request->number_of_advisory_services) {
                $errors['advisoryServicesSelected'] = "عدد الحجوزات يجب أن يتوافق مع إجمالي عدد الاستشارات المحدد.";
            }

            if ($totalReservationsBookings !== $request->number_of_reservations) {
                $errors['reservationsSelected'] = "عدد الحجوزات يجب أن يتوافق مع إجمالي عدد المواعيد المحدد.";
            }

            if (!empty($errors)) {
                return response()->json([
                    "status" => false,
                    "errors" => $errors
                ], 422);
            }
        }
        $package = Package::findOrFail($id);
        $package->update([
            'name' => $request->packageName,
            'duration' => $request->duration,
            'targetedType' => $request->targetedType,
            'priceBeforeDiscount' => $request->priceBeforeDiscount,
            'priceAfterDiscount' => $request->priceAfterDiscount,
            'instructions' => $request->instructions,
            'package_type' => $request->packageType,
            'number_of_services' => $request->number_of_services,
            'number_of_advisory_services' => $request->number_of_advisory_services,
            'number_of_reservations' => $request->number_of_reservations,
            'duration_type' => $request->durationType,
            'taxes' => $request->taxes,
        ]);

        if ($request->packageType == 1) {

            $package->services()->sync(collect($request->selectedServices)->mapWithKeys(function ($item) {
                return [$item['id'] => ['number_of_bookings' => $item['number_of_bookings']]];
            }));
            $package->advisoryServices()->sync(collect($request->selectedAdvisoryServicesTypes)->mapWithKeys(function ($item) {
                return [$item['id'] => ['number_of_bookings' => $item['number_of_bookings']]];
            }));
            $package->reservations()->sync(collect($request->selectedReservationTypes)->mapWithKeys(function ($item) {
                return [$item['id'] => ['number_of_bookings' => $item['number_of_bookings']]];
            }));
        }
        if ($request->packageType == 2) {
            $package->sections()->sync($request->sections);
            $package->permissions()->sync($request->selectedLawyerPermissions);

        }

        return response()->json([
            "status" => true,
            'item' => $package
        ]);
    }

    public function destroy($id)
    {
        $package = Package::findOrFail($id);
        $package->delete();

        return response()->json([
            "status" => true
        ]);
    }
}
