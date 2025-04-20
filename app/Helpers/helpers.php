<?php


use App\Models\Account;
use App\Models\Lawyer\Lawyer;
use App\Models\Settings\Setting;
use Illuminate\Support\Facades\DB;
use App\Models\LawyerAdditionalInfo;
use App\Models\Lawyer\LawyerSections;
use Illuminate\Support\Facades\Cache;
use App\Models\Lawyer\LawyersAdvisorys;
use Illuminate\Support\Facades\Session;
use App\Models\Client\ClientRequestRates;
use App\Models\EliteServicePricingCommittee;

if (version_compare(phpversion(), '7.1', '>=')) {
    ini_set('precision', 14);
    ini_set('serialize_precision', -1);
}

function saveImage($image, $folder)
{
    //save photo in folder
    $file_extension = $image->getClientOriginalExtension();
    $file_name = md5(uniqid() . time()) . '.' . $file_extension;
    $path = public_path($folder);
    $image->move($path, $file_name);
    return $file_name;
}


function app_url($url)
{
    return request()->server('HTTP_X_FORWARDED_PROTO') == 'https' ? secure_url($url) : url($url);
}

function AllSettings()
{
    $Settings = DB::table('Settings')->first();
    return $Settings;
}

function checkFavorite($employee_id, $book_id)
{
    $favorite_status = DB::connection('mysql2')->table('library_favorites')->where('admin_id', $employee_id)->where('book_id', $book_id)->first();

    if ($favorite_status) {
        return true;
    } else {
        return false;
    }
}

function getClientReceivedEmailsCount()
{
    $client_received_emails = DB::table('client_lawyers_messages')
        ->where([['sender_type', 2], ['status', 0], ['client_id', Session::get('loggedInClientID')]])->get();

    return $client_received_emails->count();
}

function getLawyerReceivedEmailsCount()
{
    $client_received_emails = DB::table('client_lawyers_messages')
        ->where([['sender_type', 1], ['status', 0], ['lawyer_id', Session::get('loggedInUserID')]])->get();

    return $client_received_emails->count();
}

function getMainMessageOtherMessages($main_id)
{
    $client_received_emails = DB::table('client_lawyers_messages')
        ->where([['status', 0], ['message_id', $main_id]])->get();

    return $client_received_emails->count();
}

function GetLatestPosts()
{
    $posts = DB::table('courses')->take(3)->orderBy('id', 'DESC')->get();

    return $posts;
}

function GetCaseTypes()
{
    $types = DB::table('case_types')->orderBy('id', 'DESC')->get();

    return $types;
}

function GetSectionCount($SectionId)
{

    $sections_lawyers_ids = LawyerSections::where('section_id', $SectionId)->pluck('lawyer_id')->toArray();
    $SectionCount = Lawyer::whereIN('id', $sections_lawyers_ids)->where('accepted', 2)->where('show_at_digital_guide', 1)->get();
    $SectionCount = $SectionCount->count();
    return $SectionCount;
}

function GetLibCount($SectionId)
{

    $SectionCount = DB::table('librarycats')->where('Parent', $SectionId)->get();
    $SectionCount = $SectionCount->count();
    return $SectionCount;
}

function GetBooksSubCat($SectionId)
{
    $SectionCount = DB::table('librarycats')->where('Parent', $SectionId)->get();
    return $SectionCount;
}

function GetPmAmArabic($time)
{
    $arabic_date = null;
    if (is_null($time)) {
        $arabic_date = null;
    } else {
        $find = array("AM", "PM");
        $replace = array("صباحا", "مساءا");

        $standard = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
        $eastern_arabic_symbols = array("٠", "١", "٢", "٣", "٤", "٥", "٦", "٧", "٨", "٩");

        $ar_day = str_replace($find, $replace, $time);

        $arabic_date = str_replace($standard, $eastern_arabic_symbols, $ar_day);

    }
    return $arabic_date;
}

function setting($key, $default = null)
{
    $setting = Setting::where('key', $key)->first();
    return $setting->value;


}

//function setting($key, $default = null)
//{
//    $setting_cache = null;
//
//    $globalCache = config('voyager.settings.cache', false);
//
//    if ($globalCache && Cache::tags('settings')->has($key)) {
//        return Cache::tags('settings')->get($key);
//    }
//
//    if ($setting_cache === null) {
//        if ($globalCache) {
//            // A key is requested that is not in the cache
//            // this is a good opportunity to update all keys
//            // albeit not strictly necessary
//            Cache::tags('settings')->flush();
//        }
//
//        foreach (DB::table('settings')->orderBy('order')->get() as $setting) {
//            $keys = explode('.', $setting->key);
//            $setting_cache[$keys[0]][$keys[1]] = $setting->value;
//
//            if ($globalCache) {
//                Cache::tags('settings')->forever($setting->key, $setting->value);
//            }
//        }
//    }
//
//    $parts = explode('.', $key);
//
//    if (count($parts) == 2) {
//        return $setting_cache[$parts[0]][$parts[1]] ?: $default;
//    } else {
//        return $setting_cache[$parts[0]] ?: $default;
//    }
//
//}

function GetArabicDate($date)
{

    $months = array("Jan" => "يناير", "Feb" => "فبراير", "Mar" => "مارس", "Apr" => "أبريل", "May" => "مايو", "Jun" => "يونيو", "Jul" => "يوليو", "Aug" => "أغسطس", "Sep" => "سبتمبر", "Oct" => "أكتوبر", "Nov" => "نوفمبر", "Dec" => "ديسمبر");

    $en_month = date("M", strtotime($date));

    foreach ($months as $en => $ar) {
        if ($en == $en_month) {
            $ar_month = $ar;
        }
    }

    $find = array("Sat", "Sun", "Mon", "Tue", "Wed", "Thu", "Fri");
    $replace = array("السبت", "الأحد", "الإثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة");
    $ar_day_format = date('D'); // The Current Day
    $ar_day = str_replace($find, $replace, $ar_day_format);

    header('Content-Type: text/html; charset=utf-8');
    $standard = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
    $eastern_arabic_symbols = array("٠", "١", "٢", "٣", "٤", "٥", "٦", "٧", "٨", "٩");

    $current_date = $ar_day . ' ' . date("d", strtotime($date)) . ' ' . $ar_month . ' ' . date("Y", strtotime($date));
    $arabic_date = str_replace($standard, $eastern_arabic_symbols, $current_date);

    return $arabic_date;
}

function GetArabicDate2($date)
{

    $arabic_date = null;
    if (is_null($date)) {
        $arabic_date = null;
    } else {
        $months = array("Jan" => "يناير", "Feb" => "فبراير", "Mar" => "مارس", "Apr" => "أبريل", "May" => "مايو", "Jun" => "يونيو", "Jul" => "يوليو", "Aug" => "أغسطس", "Sep" => "سبتمبر", "Oct" => "أكتوبر", "Nov" => "نوفمبر", "Dec" => "ديسمبر");

        $en_month = date("M", strtotime($date));

        foreach ($months as $en => $ar) {
            if ($en == $en_month) {
                $ar_month = $ar;
            }
        }

        $find = array("Sat", "Sun", "Mon", "Tue", "Wed", "Thu", "Fri");
        $replace = array("السبت", "الأحد", "الإثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة");
        $ar_day_format = date('D'); // The Current Day
        $ar_day = str_replace($find, $replace, $ar_day_format);

        header('Content-Type: text/html; charset=utf-8');
        $standard = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
        $eastern_arabic_symbols = array("٠", "١", "٢", "٣", "٤", "٥", "٦", "٧", "٨", "٩");

        $current_date = date("d", strtotime($date)) . ' ' . $ar_month . ' ' . date("Y", strtotime($date));
        $arabic_date = str_replace($standard, $eastern_arabic_symbols, $current_date);

    }
    return $arabic_date;

}

function GetArabicDateTime($date)
{
    $arabic_date = null;
    if (is_null($date)) {
        $arabic_date = null;
    } else {
        $months = array(
            "Jan" => "يناير",
            "Feb" => "فبراير",
            "Mar" => "مارس",
            "Apr" => "أبريل",
            "May" => "مايو",
            "Jun" => "يونيو",
            "Jul" => "يوليو",
            "Aug" => "أغسطس",
            "Sep" => "سبتمبر",
            "Oct" => "أكتوبر",
            "Nov" => "نوفمبر",
            "Dec" => "ديسمبر"
        );

        $en_month = date("M", strtotime($date));
        $ar_month = $months[$en_month] ?? '';

        $days = array(
            "Sat" => "السبت",
            "Sun" => "الأحد",
            "Mon" => "الإثنين",
            "Tue" => "الثلاثاء",
            "Wed" => "الأربعاء",
            "Thu" => "الخميس",
            "Fri" => "الجمعة"
        );

        $en_day = date("D", strtotime($date));
        $ar_day = $days[$en_day] ?? '';

        header('Content-Type: text/html; charset=utf-8');
        $standard = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
        $eastern_arabic_symbols = array("٠", "١", "٢", "٣", "٤", "٥", "٦", "٧", "٨", "٩");

        $formatted_date = date("d", strtotime($date)) . ' ' . $ar_month . ' ' . date("Y", strtotime($date));
        $formatted_time = date("H:i", strtotime($date));
        $arabic_date = str_replace($standard, $eastern_arabic_symbols, $formatted_date) . ' ' . str_replace($standard, $eastern_arabic_symbols, $formatted_time);

    }
    return $arabic_date;
}

function GetArabicTime($date)
{
    $arabic_time = null;
    if (is_null($date)) {
        $arabic_time = null;
    } else {
        $months = array(
            "Jan" => "يناير",
            "Feb" => "فبراير",
            "Mar" => "مارس",
            "Apr" => "أبريل",
            "May" => "مايو",
            "Jun" => "يونيو",
            "Jul" => "يوليو",
            "Aug" => "أغسطس",
            "Sep" => "سبتمبر",
            "Oct" => "أكتوبر",
            "Nov" => "نوفمبر",
            "Dec" => "ديسمبر"
        );

        header('Content-Type: text/html; charset=utf-8');
        $standard = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
        $eastern_arabic_symbols = array("٠", "١", "٢", "٣", "٤", "٥", "٦", "٧", "٨", "٩");

        $formatted_time = date("H:i", strtotime($date));
        $arabic_time = str_replace($standard, $eastern_arabic_symbols, $formatted_time);

    }
    return $arabic_time;
}
function GetName($table, $returnfiled, $filed, $equal)
{
    $Section = DB::table($table)->select($returnfiled)->where($filed, $equal)->first();

    return $Section->$returnfiled;

}

function aboutdetails()
{
    $ad = DB::table('contents')->where('section', 1)->first();
    return $ad;

}

function GetVideoSubCat($SectionId)
{
    $SectionCount = DB::table('videos')->where('AlbumID', "$SectionId")->get();
    return $SectionCount;
}

function getSections()
{
    $sections = DB::table('digital_guide_sections')->get();
    return $sections;
}

function videothum($pageVideUrl)
{

    $link = $pageVideUrl;
    $video_id = explode("?v=", $link);
    if (!isset($video_id[1])) {
        $video_id = explode("youtu.be/", $link);
    }
    $youtubeID = $video_id[1];
    if (empty($video_id[1])) {
        $video_id = explode("/v/", $link);
    }

    $video_id = explode("&", $video_id[1]);
    $youtubeVideoID = $video_id[0];
    if ($youtubeVideoID) {
        $st = $youtubeVideoID;

        $thumbURL = 'https://img.youtube.com/vi/' . $st . '/mqdefault.jpg';
        return $thumbURL;

    } else {
        return false;
    }
}

function videotref($pageVideUrl)
{

    $link = $pageVideUrl;
    $video_id = explode("?v=", $link);
    if (!isset($video_id[1])) {
        $video_id = explode("youtu.be/", $link);
    }
    $youtubeID = $video_id[1];
    if (empty($video_id[1])) {
        $video_id = explode("/v/", $link);
    }

    $video_id = explode("&", $video_id[1]);
    $youtubeVideoID = $video_id[0];
    if ($youtubeVideoID) {
        $st = $youtubeVideoID;

        // $thumbURL = 'https://img.youtube.com/vi/' . $st . '/mqdefault.jpg';
        return $st;

    } else {
        return false;
    }
}

function GetSelectItem($tbl, $filed, $selected = '', $wh = '', $eq = '')
{
    if ($wh) {
        $Cats = DB::table($tbl)->select('id', $filed)->where("$wh", "$eq")->get();
    } else {
        $Cats = DB::table($tbl)->select('id', $filed)->get();
    }

    foreach ($Cats as $SingleCart) {
        if ($selected == $SingleCart->id) {
            echo '<option value=' . $SingleCart->id . ' selected>' . $SingleCart->$filed . ' </option>';

        } else {
            echo '<option value=' . $SingleCart->id . '>' . $SingleCart->$filed . '</option>';

        }
    }
}

function GenerateRegistrationRandomCode($length = 6)
{
    $chars = range(0, 6); // Simplified, no need for array_merge
    shuffle($chars);
    $code = implode('', array_slice($chars, 0, $length));

    // Ensure the code has the desired length by padding with leading zeros if necessary
    $code = str_pad($code, $length, '0', STR_PAD_LEFT);

    return $code;
}

function GenerateReferralCode($length = 8)
{
    // Define the characters to be used in the referral code
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $referralCode = '';

    // Generate a random code
    for ($i = 0; $i < $length; $i++) {
        $referralCode .= $characters[rand(0, $charactersLength - 1)];
    }

    return $referralCode;
}

function GenerateRandomKey($length = 10)
{

    $chars = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
    shuffle($chars);
    $password = implode(array_slice($chars, 0, $length));

    return $password;
}

function hashPassword($value)
{
    return simple_encrypt($value);
}

function simple_encrypt($text, $cipher = "aes-128-gcm")
{
    $encryptionMethod = "AES-256-CBC";
    $secretHash = "encryptionhash";
    $iv = '0123456789abcdef';

    $encryptedText = trim(openssl_encrypt($text, $encryptionMethod, $secretHash, 0, $iv));
    return $encryptedText;
}

function simple_decrypt($text, $cipher = "aes-128-gcm")
{
    $encryptionMethod = "AES-256-CBC";
    $secretHash = "encryptionhash";
    $iv = '0123456789abcdef';
    $decryptedText = trim(openssl_decrypt($text, $encryptionMethod, $secretHash, 0, $iv));

    return $decryptedText;
}


function CheckIfAnyChaneINLawyerAccepted($new_accept, $lawyer)
{
    $lawyer_old_status = $lawyer->accepted;
    if ($new_accept != $lawyer_old_status) {
        return [
            'status' => 'change',
            'new_status' => $new_accept,
        ];
    } else {
        return [
            'status' => 'no_change',
            'new_status' => null,
        ];
    }
}


function CheckIfAnyChaneINClientAccepted($new_accept, $client)
{
    $client_old_status = $client->accepted;
    if ($new_accept != $client_old_status) {
        return [
            'status' => 'change',
            'new_status' => $new_accept,
        ];
    } else {
        return [
            'status' => 'no_change',
            'new_status' => null,
        ];
    }
}


function getFileExtention($file)
{
    $path_info = pathinfo($file);

    return $path_info['extension']; // "bill"
}


function getAdvisorCatLawyersCount($advisor_cat_id)
{

    $lawyers = LawyerAdditionalInfo::whereHas('lawyer', function ($query) {
        $query->where('status', 2);
    })->where('is_advisor', 1)->pluck('id')->toArray();
    $advisor = LawyersAdvisorys::whereIN('account_details_id', $lawyers)->where('advisory_id', $advisor_cat_id)->count();
    return $advisor;
}

function in_range($number, $min, $max, $inclusive = FALSE)
{
    $max = intval($max);
    $min = intval($min);

    if (in_array($number, range($min, $max))) {
        return true;
    }
    return FALSE;
}

function CheckElectronicOfficeLawyer($uuid)
{
    $lawyer = Lawyer::where('electronic_id_code', $uuid)->first();
    if (!$lawyer) {
        return abort(404);
    } else {
        return $lawyer;
    }
}


function GetClientRequestRates($request_id)
{
    $rate = ClientRequestRates::where('client_service_request_id', $request_id)->first();
    return $rate;
}


function CalculateRateAvg($array)
{
    $avg = count($array) != 0 ? array_sum($array) / count($array) : null;
    if ($avg == null) {
        $avg = null;
    } else {
        $avg = $avg >= 5 ? 4 : $avg;
        $avg = intval($avg);
    }

    return $avg;
}


function getClientType($type)
{
    switch ($type) {
        case 1:
            return 'فرد';
            break;
        case 2:
            return 'مؤسسة';
            break;
        case 3:
            return 'شركة';
            break;
        case 4:
            return 'جهة حكومية';
            break;
        case 5:
            return 'هيئة';
            break;
    }
}

function getNextPricingCommitteeMember()
{
    $members = EliteServicePricingCommittee::all();
    $lastAssignedMember = Cache::get('last_assigned_pricing_member', -1);
    $nextMemberIndex = ($lastAssignedMember + 1) % $members->count();
    Cache::put('last_assigned_pricing_member', $nextMemberIndex);
    return $members[$nextMemberIndex];
}
