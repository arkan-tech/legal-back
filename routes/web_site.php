<?php

use App\Http\Controllers\Site\Advisory\AdvisorySiteController;
use App\Http\Controllers\Site\Client\Password\ResetPasswordController;
use App\Http\Controllers\Site\Contact\ContactController;
use App\Http\Controllers\Site\DigitalGuide\DigitalGuideController;
use App\Http\Controllers\Site\Home\HomeSiteController;
use App\Http\Controllers\Site\Justiceguide\JusticeguideController;
use App\Http\Controllers\Site\Lawyer\Auth\LawyerAuthController;
use App\Http\Controllers\Site\Lawyer\Auth\RegisterLawyerController;
use App\Http\Controllers\Site\Lawyer\LawyerSiteController;
use App\Http\Controllers\Site\Library\LibraryController;
use App\Http\Controllers\Site\Services\ServicesSiteController;
use App\Http\Controllers\Site\Training\TrainingSiteController;
use App\Http\Controllers\Site\video\VideoController;
use Illuminate\Support\Facades\Route;

// Route::get('/{any}', function () {
//     return redirect('/newAdmin/dashboard');
// })->where('any', '.*');

//Route::view('/em/email','emails.new');
Route::group(['prefix' => '', 'as' => 'site.'], function () {
    Route::get('/', function () {
        return redirect('/newAdmin/dashboard');
    })->name('index');
});




