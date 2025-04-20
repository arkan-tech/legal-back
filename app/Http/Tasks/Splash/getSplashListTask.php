<?php

namespace App\Http\Tasks\Splash;

use App\Http\Resources\API\Splash\SplashResource;
use App\Http\Tasks\BaseTask;
use App\Models\API\Splash\Splash;

class getSplashListTask extends BaseTask
{

    public function run()
    {
        $splash = SplashResource::collection(Splash::where('status', 1)->orderBy('created_at','desc')->get());

        return $this->sendResponse(true, 'الشاشات الرئيسية الاولى', compact('splash'), 200);
    }
}
