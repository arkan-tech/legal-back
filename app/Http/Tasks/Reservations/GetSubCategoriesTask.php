<?php

namespace App\Http\Tasks\Reservations;

use App\Models\AppointmentsSubCategory;

class GetSubCategoriesTask
{
    public function run()
    {
        $subCategories = AppointmentsSubCategory::all();
        return [
            'status' => true,
            'message' => 'Sub categories fetched successfully.',
            'data' => $subCategories,
            'code' => 200
        ];
    }
}
