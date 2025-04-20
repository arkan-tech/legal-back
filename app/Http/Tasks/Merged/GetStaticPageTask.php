<?php

namespace App\Http\Tasks\Merged;

use App\Models\StaticPage;
use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\Lawyer\Lawyer;
use App\Models\Service\ServiceUser;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Lawyer\LawyerShortDataResource;

class GetStaticPageTask extends BaseTask
{
    public function run(Request $request, $key)
    {

        $page = StaticPage::where('key', $key)->first();

        if (!$page) {
            return $this->sendResponse(false, 'Not found', null, 404);
        }

        return $this->sendResponse(true, '', json_decode($page->content), $code = 200);

    }
}
