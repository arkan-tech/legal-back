<?php

namespace App\Http\Controllers\NewAdmin;

use App\Models\AdvisoryServices\AdvisoryServicesGeneralCategory;
use App\Models\AdvisoryServices\AdvisoryServicesSubCategory;
use App\Models\Service\ServiceCategory;
use App\Models\Service\ServiceSubCategory;
use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Account;
use App\Models\City\City;
use App\Models\LawyerOld;
use Illuminate\Http\Request;
use App\Models\Lawyer\Lawyer;
use Illuminate\Http\Response;
use App\Models\ServiceUserOld;
use App\Models\Country\Country;
use App\Models\Regions\Regions;
use App\Models\Service\Service;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Exports\ExportServiceUsers;
use App\Models\Country\Nationality;
use App\Models\PaymentCategoryType;
use App\Models\Service\ServiceUser;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Client\ClientRequest;
use App\Models\ServicesReservations;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;
use App\Models\Service\ServicesRequest;
use App\Models\Reservations\Reservation;
use App\Http\Tasks\Merged\GetMostBoughtTask;
use App\Models\AdvisoryServicesReservations;
use App\Models\Reservations\ReservationType;
use App\Models\AdvisoryServices\AdvisoryServices;
use App\Models\AdvisoryCommittee\AdvisoryCommittee;
use App\Http\Resources\API\Services\ServicesResource;
use App\Models\AdvisoryServices\AdvisoryServicesTypes;
use App\Models\Reservations\ReservationTypeImportance;
use App\Http\Controllers\API\Merged\ReservationsController;
use App\Models\LawyerServicesRequest\LawyerServicesRequest;
use App\Http\Resources\API\Reservations\ReservationTypeResource;
use App\Models\AdvisoryServices\AdvisoryServicesPaymentCategory;
use App\Http\Requests\Admin\Client\ClientAdminUpdateProfileRequest;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservations;
use App\Models\LawyerAdvisoryServices\LawyerAdvisoryServicesAppointment;
use App\Models\LawyerAdvisoryServices\LawyerAdvisoryServicesReservations;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesTypesResource;

class NewAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function showAnalytics()
    {
        try {
            // Cache the results to reduce database queries
            $cacheDuration = 60; // Cache duration in minutes

            $analyticsService = new \App\Services\GoogleAnalyticsService();

            // Get Google Analytics data with 1-hour cache
            $websiteAnalytics = Cache::remember('google_analytics_website', 60, function () use ($analyticsService) {
                return $analyticsService->getWebsiteAnalytics();
            });

            $mobileAnalytics = Cache::remember('google_analytics_mobile', 60, function () use ($analyticsService) {
                return $analyticsService->getMobileAnalytics();
            });

            $searchConsoleAnalytics = Cache::remember('google_search_console', 60, function () use ($analyticsService) {
                return $analyticsService->getSearchConsoleAnalytics();
            });

            $oldClientsEmails = Cache::remember("oldClientsEmails", $cacheDuration, function () {
                return ServiceUserOld::pluck('email')->toArray();
            });

            $oldLawyersEmails = Cache::remember("oldLawyersEmails", $cacheDuration, function () {
                return LawyerOld::pluck('email')->toArray();
            });

            $accounts = Cache::remember('accounts', $cacheDuration, function () {
                return Account::all();
            });

            // Clients
            $totalClientsFirstTime = Cache::remember('totalClientsFirstTime', $cacheDuration, function () use ($oldClientsEmails, $accounts) {
                return $accounts->where('account_type', 'client')->whereNotIn('email', $oldClientsEmails)->count();
            });

            $totalClientsFirstTimeWIthInvitation = Cache::remember('totalClientsFirstTimeWithInvitation', $cacheDuration, function () use ($accounts) {
                return $accounts->where('account_type', 'client')->whereNotNull('referred_by')->count();
            });

            $totalOldClients = Cache::remember('totalOldClients', $cacheDuration, function () use ($oldClientsEmails) {
                return count($oldClientsEmails);
            });

            $totalUpdatedClients = Cache::remember('totalUpdatedClients', $cacheDuration, function () use ($oldClientsEmails, $accounts) {
                return $accounts->where('account_type', 'client')->whereIn('email', $oldClientsEmails)->count();
            });

            $totalClientsApproved = Cache::remember('totalClientsApproved', $cacheDuration, function () use ($accounts) {
                return $accounts->where('account_type', 'client')->where('status', 2)->count();
            });

            $totalClientsNew = Cache::remember('totalClientsNew', $cacheDuration, function () use ($accounts) {
                return $accounts->where('account_type', 'client')->where('status', 1)->count();
            });

            $totalClientsBlocked = Cache::remember('totalClientsBlocked', $cacheDuration, function () use ($accounts) {
                return $accounts->where('account_type', 'client')->where('status', 4)->count();
            });

            $totalClientsPending = Cache::remember('totalClientsPending', $cacheDuration, function () use ($accounts) {
                return $accounts->where('account_type', 'client')->where('status', 3)->count();
            });

            $totalClientsCompletedProfile = Cache::remember('totalClientsCompletedProfile', $cacheDuration, function () use ($accounts) {
                return $accounts->where('account_type', 'client')->where('profile_complete', true)->count();
            });

            $totalClientsNotCompletedProfile = Cache::remember('totalClientsNotCompletedProfile', $cacheDuration, function () use ($accounts) {
                return $accounts->where('account_type', 'client')->where('profile_complete', false)->count();
            });
            // Lawyers
            $totalLawyersFirstTime = Cache::remember('totalLawyersFirstTime', $cacheDuration, function () use ($oldLawyersEmails, $accounts) {
                return $accounts->where('account_type', 'lawyer')->whereNotIn('email', $oldLawyersEmails)->count();
            });

            $totalLawyersFirstTimeWIthInvitation = Cache::remember('totalLawyersFirstTimeWithInvitation', $cacheDuration, function () use ($accounts) {
                return $accounts->where('account_type', 'lawyer')->whereNotNull('referred_by')->count();
            });

            $totalOldLawyers = Cache::remember('totalOldLawyers', $cacheDuration, function () use ($oldLawyersEmails) {
                return count($oldLawyersEmails);
            });

            $totalUpdatedLawyers = Cache::remember('totalUpdatedLawyers', $cacheDuration, function () use ($oldLawyersEmails, $accounts) {
                return $accounts->where('account_type', 'lawyer')->whereIn('email', $oldLawyersEmails)->count();
            });

            $totalLawyersApproved = Cache::remember('totalLawyersApproved', $cacheDuration, function () use ($accounts) {
                return $accounts->where('account_type', 'lawyer')->where('status', 2)->count();
            });

            $totalLawyersNew = Cache::remember('totalLawyersNew', $cacheDuration, function () use ($accounts) {
                return $accounts->where('account_type', 'lawyer')->where('status', 1)->count();
            });

            $totalLawyersBlocked = Cache::remember('totalLawyersBlocked', $cacheDuration, function () use ($accounts) {
                return $accounts->where('account_type', 'lawyer')->where('status', 4)->count();
            });

            $totalLawyersPending = Cache::remember('totalLawyersPending', $cacheDuration, function () use ($accounts) {
                return $accounts->where('account_type', 'lawyer')->where('status', 3)->count();
            });

            $totalLawyersCompletedProfile = Cache::remember('totalLawyersCompletedProfile', $cacheDuration, function () use ($accounts) {
                return $accounts->where('account_type', 'lawyer')->where('profile_complete', true)->count();
            });

            $totalLawyersNotCompletedProfile = Cache::remember('totalLawyersNotCompletedProfile', $cacheDuration, function () use ($accounts) {
                return $accounts->where('account_type', 'lawyer')->where('profile_complete', false)->count();
            });

            $ServiceRequests = Cache::remember('ServiceRequests', $cacheDuration, function () {
                return ServicesReservations::where('transaction_complete', 1)->get();
            });


            $doneServices = $ServiceRequests->where('request_status', 5)->count();
            $newServices = $ServiceRequests->where('request_status', 1)->count();
            $waitingServices = $ServiceRequests->where('request_status', 2)->count();
            $notDoneServices = $ServiceRequests->where('request_status', 4)->count();
            $lateServices = $ServiceRequests->where('request_status', 3)->count();

            $advisoryServiceRequests = Cache::remember('advisoryServiceRequests', $cacheDuration, function () {
                return AdvisoryServicesReservations::where('transaction_complete', 1)->get();
            });


            $doneAdvisoryServices = $advisoryServiceRequests->where('request_status', 5)->count();
            $newAdvisoryServices = $advisoryServiceRequests->where('request_status', 1)->count();
            $waitingAdvisoryServices = $advisoryServiceRequests->where('request_status', 2)->count();
            $notDoneAdvisoryServices = $advisoryServiceRequests->where('request_status', 4)->count();
            $lateAdvisoryServices = $advisoryServiceRequests->where('request_status', 3)->count();

            $reservationRequests = Cache::remember('reservationRequests', $cacheDuration, function () {
                return Reservation::where('transaction_complete', 1)->get();
            });
            $doneReservations = $reservationRequests->where('request_status', 5)->count();
            $newReservations = $reservationRequests->where('request_status', 1)->count();
            $waitingReservations = $reservationRequests->where('request_status', 2)->count();
            $notDoneReservations = $reservationRequests->where('request_status', 4)->count();
            $lateReservations = $reservationRequests->where('request_status', 3)->count();

            $advisoryServicesPaymentCategoryTypes = Cache::remember('advisoryServicesPaymentCategoryTypes', $cacheDuration, function () {
                return PaymentCategoryType::count();
            });
            $servicesCategories = Cache::remember('serviceCategories', $cacheDuration, function () {
                return ServiceCategory::count();
            });
            $reservationsTypes = Cache::remember('reservationTypes', $cacheDuration, function () {
                return ReservationType::count();
            });
  
            $advisoryServicesGeneralCategories = Cache::remember('advisoryServicesGeneralCategories', $cacheDuration, function () {
                return AdvisoryServicesGeneralCategory::count();
            });
            $advisoryServicesSubCategories = Cache::remember('advisoryServicesSubCategories', $cacheDuration, function () {
                return AdvisoryServicesSubCategory::count();
            });
            $servicesSubCategories = Cache::remember('serviceCategories', $cacheDuration, function () {
                return ServiceSubCategory::count();
            });

            $uniqueLawyers = Cache::remember('uniqueLawyers', $cacheDuration, function () use ($advisoryServiceRequests, $reservationRequests, $ServiceRequests) {
                $advisoryServicesLawyers = $advisoryServiceRequests->pluck('reserved_from_lawyer_id')->toArray();
                $servicesLawyers = $ServiceRequests->pluck('reserved_from_lawyer_id')->toArray();
                $reservationsLawyers = $reservationRequests->pluck('reserved_from_lawyer_id')->toArray();
                $allLawyers = array_merge($advisoryServicesLawyers, $servicesLawyers, $reservationsLawyers);
                return count(array_unique($allLawyers));
            });

            $uniqueClients = Cache::remember('uniqueClients', $cacheDuration, function () use ($advisoryServiceRequests, $reservationRequests, $ServiceRequests) {
                $advisoryServicesClients = $advisoryServiceRequests->pluck('account_id')->toArray();
                $servicesClients = $ServiceRequests->pluck('account_id')->toArray();
                $reservationsClients = $reservationRequests->pluck('account_id')->toArray();
                $allClients = array_merge($advisoryServicesClients, $servicesClients, $reservationsClients);
                return count(array_unique($allClients));
            });

            // Elite Service Requests analytics
            $eliteServiceRequests = Cache::remember('eliteServiceRequests', $cacheDuration, function () {
                return \App\Models\EliteServiceRequest::with('offers')->get();
            });

            $totalEliteRequests = $eliteServiceRequests->count();

            // Status counts
            $pendingPricingRequests = $eliteServiceRequests->where('status', 'pending-pricing')->count();
            $pendingPricingApprovalRequests = $eliteServiceRequests->where('status', 'pending-pricing-approval')->count();
            $pendingPricingChangeRequests = $eliteServiceRequests->where('status', 'pending-pricing-change')->count();
            $rejectedPricingRequests = $eliteServiceRequests->where('status', 'rejected-pricing')->count();
            $pendingPaymentRequests = $eliteServiceRequests->where('status', 'pending-payment')->count();
            $approvedRequests = $eliteServiceRequests->where('status', 'approved')->count();
            $rejectedPricingChangeRequests = $eliteServiceRequests->where('status', 'rejected-pricing-change')->count();
            $pendingMeetingRequests = $eliteServiceRequests->where('status', 'pending-meeting')->count();
            $pendingReviewRequests = $eliteServiceRequests->where('status', 'pending-review')->count();
            $pendingVotingRequests = $eliteServiceRequests->where('status', 'pending-voting')->count();
            $completedRequests = $eliteServiceRequests->where('status', 'completed')->count();

            // Product type counts in offers
            $requestsWithAdvisoryServices = $eliteServiceRequests->filter(function ($request) {
                return $request->offers && $request->offers->advisory_service_sub_id;
            })->count();

            $requestsWithServices = $eliteServiceRequests->filter(function ($request) {
                return $request->offers && $request->offers->service_sub_id;
            })->count();

            $requestsWithReservations = $eliteServiceRequests->filter(function ($request) {
                return $request->offers && $request->offers->reservation_type_id;
            })->count();

            // Transaction status counts
            $elitePaidRequests = $eliteServiceRequests->where('transaction_complete', 1)->count();
            $eliteUnpaidRequests = $eliteServiceRequests->where('transaction_complete', 0)->count();
            $eliteCancelledPaymentRequests = $eliteServiceRequests->where('transaction_complete', 2)->count();
            $eliteFailedPaymentRequests = $eliteServiceRequests->where('transaction_complete', 3)->count();
            $eliteFreeRequests = $eliteServiceRequests->where('transaction_complete', 4)->count();

            return Inertia::render('Dashboard/Dashboard', [
                'websiteAnalytics' => $websiteAnalytics,
                'mobileAnalytics' => $mobileAnalytics,
                'searchConsoleAnalytics' => $searchConsoleAnalytics,
                'totalClientsFirstTime' => $totalClientsFirstTime,
                'totalClientsFirstTimeWIthInvitation' => $totalClientsFirstTimeWIthInvitation,
                'totalOldClients' => $totalOldClients,
                'totalUpdatedClients' => $totalUpdatedClients,
                'totalClientsApproved' => $totalClientsApproved,
                'totalClientsNew' => $totalClientsNew,
                'totalClientsBlocked' => $totalClientsBlocked,
                'totalClientsPending' => $totalClientsPending,
                'totalClientsCompletedProfile' => $totalClientsCompletedProfile,
                'totalClientsNotCompletedProfile' => $totalClientsNotCompletedProfile,
                'totalLawyersFirstTime' => $totalLawyersFirstTime,
                'totalLawyersFirstTimeWIthInvitation' => $totalLawyersFirstTimeWIthInvitation,
                'totalOldLawyers' => $totalOldLawyers,
                'totalUpdatedLawyers' => $totalUpdatedLawyers,
                'totalLawyersApproved' => $totalLawyersApproved,
                'totalLawyersNew' => $totalLawyersNew,
                'totalLawyersBlocked' => $totalLawyersBlocked,
                'totalLawyersPending' => $totalLawyersPending,
                'totalLawyersCompletedProfile' => $totalLawyersCompletedProfile,
                'totalLawyersNotCompletedProfile' => $totalLawyersNotCompletedProfile,
                'doneServices' => $doneServices,
                'newServices' => $newServices,
                'waitingServices' => $waitingServices,
                'notDoneServices' => $notDoneServices,
                'lateServices' => $lateServices,
                'doneAdvisoryServices' => $doneAdvisoryServices,
                'newAdvisoryServices' => $newAdvisoryServices,
                'waitingAdvisoryServices' => $waitingAdvisoryServices,
                'notDoneAdvisoryServices' => $notDoneAdvisoryServices,
                'lateAdvisoryServices' => $lateAdvisoryServices,
                'doneReservations' => $doneReservations,
                'newReservations' => $newReservations,
                'waitingReservations' => $waitingReservations,
                'notDoneReservations' => $notDoneReservations,
                'lateReservations' => $lateReservations,
                'advisoryServicesPaymentCategoryTypes' => $advisoryServicesPaymentCategoryTypes,
                'servicesCategories' => $servicesCategories,
                'reservationsTypes' => $reservationsTypes,
                'advisoryServicesGeneralCategories' => $advisoryServicesGeneralCategories,
                'advisoryServicesSubCategories' => $advisoryServicesSubCategories,
                'servicesSubCategories' => $servicesSubCategories,
                'uniqueLawyers' => $uniqueLawyers,
                'uniqueClients' => $uniqueClients,
                // Elite Service Requests analytics
                'totalEliteRequests' => $totalEliteRequests,
                'pendingPricingRequests' => $pendingPricingRequests,
                'pendingPricingApprovalRequests' => $pendingPricingApprovalRequests,
                'pendingPricingChangeRequests' => $pendingPricingChangeRequests,
                'rejectedPricingRequests' => $rejectedPricingRequests,
                'pendingPaymentRequests' => $pendingPaymentRequests,
                'approvedRequests' => $approvedRequests,
                'rejectedPricingChangeRequests' => $rejectedPricingChangeRequests,
                'pendingMeetingRequests' => $pendingMeetingRequests,
                'pendingReviewRequests' => $pendingReviewRequests,
                'pendingVotingRequests' => $pendingVotingRequests,
                'completedRequests' => $completedRequests,
                'requestsWithAdvisoryServices' => $requestsWithAdvisoryServices,
                'requestsWithServices' => $requestsWithServices,
                'requestsWithReservations' => $requestsWithReservations,
                'elitePaidRequests' => $elitePaidRequests,
                'eliteUnpaidRequests' => $eliteUnpaidRequests,
                'eliteCancelledPaymentRequests' => $eliteCancelledPaymentRequests,
                'eliteFailedPaymentRequests' => $eliteFailedPaymentRequests,
                'eliteFreeRequests' => $eliteFreeRequests,
            ]);
        } catch (\Exception $e) {
            Log::error('Error in showAnalytics: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}