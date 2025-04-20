<?php

namespace App\Http\Tasks\Client\AdvisoryServices;

use App\Models\AdvisoryServices\AdvisoryServicesSubCategoryPrice;

class ClientGetLawyersByAdvisoryServiceGeneralSubIdTask
{
    public function run($id, $g_id, $s_id)
    {
        $lawyers = AdvisoryServicesSubCategoryPrice::where('sub_category_id', $s_id)->whereNotNull('lawyer_id')->with('lawyer')->get();

        return [
            'status' => true,
            'message' => 'Lawyers fetched successfully',
            'data' => $lawyers,
            'code' => 200
        ];
    }
}
