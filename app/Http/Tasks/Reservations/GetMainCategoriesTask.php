<?php

namespace App\Http\Tasks\Reservations;

use App\Http\Tasks\BaseTask;
use App\Models\AppointmentsMainCategory;
use App\Http\Resources\AppointmentsMainCategoryResource;

class GetMainCategoriesTask extends BaseTask
{
    public function run()
    {
        $categories = AppointmentsMainCategoryResource::collection(AppointmentsMainCategory::where('is_hidden', 0)->with([
            'prices' => function ($query) {
                $query->whereNull('account_id');
            }
        ])->get());
        return [
            'status' => true,
            'message' => 'Main categories fetched successfully.',
            'data' => compact('categories'),
            'code' => 200
        ];
    }
}
