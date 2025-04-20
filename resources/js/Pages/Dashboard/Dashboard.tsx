import React from "react";
import CardDataStats from "../../components/CardDataStats";
import ChartOne from "../../components/Charts/ChartOne";
import ChartThree from "../../components/Charts/ChartThree";
import ChartTwo from "../../components/Charts/ChartTwo";
import ChatCard from "../../components/Chat/ChatCard";
import MapOne from "../../components/Maps/MapOne";
import TableOne from "../../components/Tables/TableOne";
import DefaultLayout from "../../layout/DefaultLayout";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import {
    faClock,
    faComment,
    faFile,
    faGavel,
    faUser,
    faUserAltSlash,
    faUserCheck,
    faUserPlus,
    faUsers,
    faUserSlash,
    faChartLine,
    faChartPie,
    faChartBar,
    faChartArea,
    faUserGraduate,
    faUserTie,
    faUserShield,
    faUserCog,
    faUserMd,
    faUserSecret,
    faUserNinja,
    faUserAstronaut,
    faUserFriends,
    faUserEdit,
    faUserLock,
    faUserTimes,
    faUserTag,
    faUserClock,
    faUserAlt,
    faUserCircle,
    faCheckCircle,
    faPlusCircle,
    faTimesCircle,
    faExclamationCircle,
    faTimes,
} from "@fortawesome/free-solid-svg-icons";
import { usePage } from "@inertiajs/react";
import { PageProps } from "../../components/Sidebar";

interface SearchConsoleAnalytics {
    total_clicks: number;
    total_impressions: number;
    average_ctr: number;
    average_position: number;
    top_queries: Array<{
        query: string;
        clicks: number;
        impressions: number;
        ctr: number;
        position: number;
    }>;
    devices: {
        DESKTOP: { clicks: number; impressions: number; ctr: number };
        MOBILE: { clicks: number; impressions: number; ctr: number };
        TABLET: { clicks: number; impressions: number; ctr: number };
    };
    countries: {
        [key: string]: {
            clicks: number;
            impressions: number;
            ctr: number;
        };
    };
    top_pages: {
        [key: string]: {
            clicks: number;
            impressions: number;
            ctr: number;
        };
    };
}

interface WebsiteAnalytics {
    [platform: string]: {
        active_users: number;
        page_views: number;
        sessions: number;
        avg_session_duration: number;
        bounce_rate: number;
    };
}

interface MobileAnalytics {
    android: {
        active_users: number;
        page_views: number;
        sessions: number;
    };
    ios: {
        active_users: number;
        page_views: number;
        sessions: number;
    };
}

interface DashboardProps {
    websiteAnalytics: WebsiteAnalytics;
    mobileAnalytics: MobileAnalytics;
    searchConsoleAnalytics: SearchConsoleAnalytics;
    totalClientsFirstTime: number;
    totalClientsFirstTimeWIthInvitation: number;
    totalOldClients: number;
    totalUpdatedClients: number;
    totalClientsApproved: number;
    totalClientsNew: number;
    totalClientsBlocked: number;
    totalClientsPending: number;
    totalClientsCompletedProfile: number;
    totalClientsNotCompletedProfile: number;
    totalLawyersFirstTime: number;
    totalLawyersFirstTimeWIthInvitation: number;
    totalOldLawyers: number;
    totalUpdatedLawyers: number;
    totalLawyersApproved: number;
    totalLawyersNew: number;
    totalLawyersBlocked: number;
    totalLawyersPending: number;
    totalLawyersCompletedProfile: number;
    totalLawyersNotCompletedProfile: number;
    doneServices: number;
    newServices: number;
    waitingServices: number;
    notDoneServices: number;
    lateServices: number;
    doneAdvisoryServices: number;
    newAdvisoryServices: number;
    waitingAdvisoryServices: number;
    notDoneAdvisoryServices: number;
    lateAdvisoryServices: number;
    doneReservations: number;
    newReservations: number;
    waitingReservations: number;
    notDoneReservations: number;
    lateReservations: number;
    advisoryServicesPaymentCategoryTypes: number;
    servicesCategories: number;
    reservationsTypes: number;
    advisoryServicesGeneralCategories: number;
    advisoryServicesSubCategories: number;
    servicesSubCategories: number;
    uniqueLawyers: number;
    uniqueClients: number;
    // Elite Service Requests analytics
    totalEliteRequests: number;
    pendingPricingRequests: number;
    pendingPricingApprovalRequests: number;
    pendingPricingChangeRequests: number;
    rejectedPricingRequests: number;
    pendingPaymentRequests: number;
    approvedRequests: number;
    rejectedPricingChangeRequests: number;
    pendingMeetingRequests: number;
    pendingReviewRequests: number;
    pendingVotingRequests: number;
    completedRequests: number;
    requestsWithAdvisoryServices: number;
    requestsWithServices: number;
    requestsWithReservations: number;
    elitePaidRequests: number;
    eliteUnpaidRequests: number;
    eliteCancelledPaymentRequests: number;
    eliteFailedPaymentRequests: number;
    eliteFreeRequests: number;
}

const Dashboard = ({
    websiteAnalytics,
    mobileAnalytics,
    searchConsoleAnalytics,
    totalClientsFirstTime,
    totalClientsFirstTimeWIthInvitation,
    totalOldClients,
    totalUpdatedClients,
    totalClientsApproved,
    totalClientsNew,
    totalClientsBlocked,
    totalClientsPending,
    totalClientsCompletedProfile,
    totalClientsNotCompletedProfile,
    totalLawyersFirstTime,
    totalLawyersFirstTimeWIthInvitation,
    totalOldLawyers,
    totalUpdatedLawyers,
    totalLawyersApproved,
    totalLawyersNew,
    totalLawyersBlocked,
    totalLawyersPending,
    totalLawyersCompletedProfile,
    totalLawyersNotCompletedProfile,
    doneServices,
    newServices,
    waitingServices,
    notDoneServices,
    lateServices,
    doneAdvisoryServices,
    newAdvisoryServices,
    waitingAdvisoryServices,
    notDoneAdvisoryServices,
    lateAdvisoryServices,
    doneReservations,
    newReservations,
    waitingReservations,
    notDoneReservations,
    lateReservations,
    advisoryServicesPaymentCategoryTypes,
    servicesCategories,
    reservationsTypes,
    advisoryServicesGeneralCategories,
    advisoryServicesSubCategories,
    servicesSubCategories,
    uniqueLawyers,
    uniqueClients,
    // Elite Service Requests analytics
    totalEliteRequests,
    pendingPricingRequests,
    pendingPricingApprovalRequests,
    pendingPricingChangeRequests,
    rejectedPricingRequests,
    pendingPaymentRequests,
    approvedRequests,
    rejectedPricingChangeRequests,
    pendingMeetingRequests,
    pendingReviewRequests,
    pendingVotingRequests,
    completedRequests,
    requestsWithAdvisoryServices,
    requestsWithServices,
    requestsWithReservations,
    elitePaidRequests,
    eliteUnpaidRequests,
    eliteCancelledPaymentRequests,
    eliteFailedPaymentRequests,
    eliteFreeRequests,
}: DashboardProps) => {
    const { props } = usePage<PageProps>();

    return (
        <DefaultLayout>
            {props.user.roles.includes("super-admin") && (
                <>
                    <div
                        style={{ direction: "rtl" }}
                        className="my-4 grid grid-cols-12 gap-4 md:gap-6 2xl:gap-7.5 justify-end "
                    >
                        <label className="col-span-12 md:col-span-4 text-2xl text-primary dark:text-white ">
                            احصائيات استخدام الموقع
                        </label>
                    </div>
                    <div
                        style={{ direction: "rtl" }}
                        className="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5"
                    >
                        <CardDataStats
                            title="المستخدمين النشطين"
                            total={Object.values(websiteAnalytics)
                                .reduce(
                                    (sum, platform) =>
                                        sum + platform.active_users,
                                    0
                                )
                                .toString()}
                        >
                            <FontAwesomeIcon
                                icon={faUsers}
                                className="text-primary dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="عدد مشاهدات الصفحات"
                            total={Object.values(websiteAnalytics)
                                .reduce(
                                    (sum, platform) =>
                                        sum + platform.page_views,
                                    0
                                )
                                .toString()}
                        >
                            <FontAwesomeIcon
                                icon={faFile}
                                className="text-primary dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="عدد الجلسات"
                            total={Object.values(websiteAnalytics)
                                .reduce(
                                    (sum, platform) => sum + platform.sessions,
                                    0
                                )
                                .toString()}
                        >
                            <FontAwesomeIcon
                                icon={faClock}
                                className="text-primary dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="معدل الارتداد"
                            total={
                                Object.values(websiteAnalytics).reduce(
                                    (sum, platform) =>
                                        sum + platform.bounce_rate,
                                    0
                                ) /
                                    Object.keys(websiteAnalytics).length +
                                "%"
                            }
                        >
                            <FontAwesomeIcon
                                icon={faChartLine}
                                className="text-primary dark:text-white"
                            />
                        </CardDataStats>
                    </div>

                    <div
                        style={{ direction: "rtl" }}
                        className="my-4 grid grid-cols-12 gap-4 md:gap-6 2xl:gap-7.5 justify-end "
                    >
                        <label className="col-span-12 md:col-span-4 text-2xl text-primary dark:text-white ">
                            احصائيات محرك البحث جوجل
                        </label>
                    </div>
                    <div
                        style={{ direction: "rtl" }}
                        className="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5"
                    >
                        <CardDataStats
                            title="عدد النقرات"
                            total={
                                searchConsoleAnalytics?.total_clicks?.toString() ||
                                "0"
                            }
                            bgColor={"bg-blue-500"}
                            iconBgColor={"bg-blue-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faChartLine}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="عدد الظهور"
                            total={
                                searchConsoleAnalytics?.total_impressions?.toString() ||
                                "0"
                            }
                            bgColor={"bg-green-500"}
                            iconBgColor={"bg-green-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faChartBar}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="معدل النقر للظهور"
                            total={`${
                                searchConsoleAnalytics?.average_ctr?.toString() ||
                                "0"
                            }%`}
                            bgColor={"bg-purple-500"}
                            iconBgColor={"bg-purple-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faChartPie}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="متوسط الترتيب"
                            total={
                                searchConsoleAnalytics?.average_position?.toString() ||
                                "0"
                            }
                            bgColor={"bg-orange-500"}
                            iconBgColor={"bg-orange-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faChartArea}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>
                    </div>

                    <div
                        style={{ direction: "rtl" }}
                        className="my-4 grid grid-cols-12 gap-4 md:gap-6 2xl:gap-7.5"
                    >
                        <div className="col-span-12 xl:col-span-6">
                            <div className="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
                                <h4 className="mb-6 text-xl font-semibold text-black dark:text-white">
                                    أعلى عمليات البحث
                                </h4>
                                <div className="flex flex-col">
                                    <div className="grid grid-cols-4 rounded-sm bg-gray-2 dark:bg-meta-4 sm:grid-cols-4">
                                        <div className="p-2.5 text-center xl:p-5">
                                            <h5 className="text-sm font-medium uppercase xsm:text-base">
                                                الكلمة المفتاحية
                                            </h5>
                                        </div>
                                        <div className="p-2.5 text-center xl:p-5">
                                            <h5 className="text-sm font-medium uppercase xsm:text-base">
                                                النقرات
                                            </h5>
                                        </div>
                                        <div className="p-2.5 text-center xl:p-5">
                                            <h5 className="text-sm font-medium uppercase xsm:text-base">
                                                الظهور
                                            </h5>
                                        </div>
                                        <div className="p-2.5 text-center xl:p-5">
                                            <h5 className="text-sm font-medium uppercase xsm:text-base">
                                                معدل النقر
                                            </h5>
                                        </div>
                                    </div>

                                    {searchConsoleAnalytics?.top_queries ? (
                                        searchConsoleAnalytics.top_queries.map(
                                            (query, index) => (
                                                <div
                                                    className={`grid grid-cols-4 sm:grid-cols-4 ${
                                                        index ===
                                                        searchConsoleAnalytics
                                                            .top_queries
                                                            .length -
                                                            1
                                                            ? ""
                                                            : "border-b border-stroke dark:border-strokedark"
                                                    }`}
                                                    key={index}
                                                >
                                                    <div className="flex items-center justify-center p-2.5 xl:p-5">
                                                        <p className="text-black dark:text-white">
                                                            {query.query}
                                                        </p>
                                                    </div>
                                                    <div className="flex items-center justify-center p-2.5 xl:p-5">
                                                        <p className="text-meta-3">
                                                            {query.clicks}
                                                        </p>
                                                    </div>
                                                    <div className="flex items-center justify-center p-2.5 xl:p-5">
                                                        <p className="text-meta-3">
                                                            {query.impressions}
                                                        </p>
                                                    </div>
                                                    <div className="flex items-center justify-center p-2.5 xl:p-5">
                                                        <p className="text-meta-3">
                                                            {query.ctr}%
                                                        </p>
                                                    </div>
                                                </div>
                                            )
                                        )
                                    ) : (
                                        <div className="flex items-center justify-center p-4">
                                            <p className="text-meta-1">
                                                لا توجد بيانات متاحة
                                            </p>
                                        </div>
                                    )}
                                </div>
                            </div>
                        </div>

                        <div className="col-span-12 xl:col-span-6">
                            <div className="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
                                <h4 className="mb-6 text-xl font-semibold text-black dark:text-white">
                                    احصائيات حسب نوع الجهاز
                                </h4>
                                <div className="flex flex-col">
                                    <div className="grid grid-cols-3 rounded-sm bg-gray-2 dark:bg-meta-4">
                                        <div className="p-2.5 text-center xl:p-5">
                                            <h5 className="text-sm font-medium uppercase xsm:text-base">
                                                نوع الجهاز
                                            </h5>
                                        </div>
                                        <div className="p-2.5 text-center xl:p-5">
                                            <h5 className="text-sm font-medium uppercase xsm:text-base">
                                                النقرات
                                            </h5>
                                        </div>
                                        <div className="p-2.5 text-center xl:p-5">
                                            <h5 className="text-sm font-medium uppercase xsm:text-base">
                                                معدل النقر
                                            </h5>
                                        </div>
                                    </div>

                                    {searchConsoleAnalytics?.devices ? (
                                        Object.entries(
                                            searchConsoleAnalytics.devices
                                        ).map(([device, stats], index) => (
                                            <div
                                                className={`grid grid-cols-3 ${
                                                    index ===
                                                    Object.entries(
                                                        searchConsoleAnalytics.devices
                                                    ).length -
                                                        1
                                                        ? ""
                                                        : "border-b border-stroke dark:border-strokedark"
                                                }`}
                                                key={device}
                                            >
                                                <div className="flex items-center justify-center p-2.5 xl:p-5">
                                                    <p className="text-black dark:text-white">
                                                        {device === "DESKTOP"
                                                            ? "كمبيوتر"
                                                            : device ===
                                                              "MOBILE"
                                                            ? "جوال"
                                                            : "تابلت"}
                                                    </p>
                                                </div>
                                                <div className="flex items-center justify-center p-2.5 xl:p-5">
                                                    <p className="text-meta-3">
                                                        {stats.clicks}
                                                    </p>
                                                </div>
                                                <div className="flex items-center justify-center p-2.5 xl:p-5">
                                                    <p className="text-meta-3">
                                                        {stats.ctr}%
                                                    </p>
                                                </div>
                                            </div>
                                        ))
                                    ) : (
                                        <div className="flex items-center justify-center p-4">
                                            <p className="text-meta-1">
                                                لا توجد بيانات متاحة
                                            </p>
                                        </div>
                                    )}
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr className="my-4" />

                    <div
                        style={{ direction: "rtl" }}
                        className="my-4 grid grid-cols-12 gap-4 md:gap-6 2xl:gap-7.5 justify-end "
                    >
                        <label className="col-span-12 md:col-span-4 text-2xl text-primary dark:text-white ">
                            احصائيات تطبيق الجوال
                        </label>
                    </div>
                    <div
                        style={{ direction: "rtl" }}
                        className="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5"
                    >
                        <CardDataStats
                            title="مستخدمي Android النشطين"
                            total={mobileAnalytics.android.active_users.toString()}
                            bgColor={"bg-green-500"}
                            iconBgColor={"bg-green-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faUserCheck}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="مستخدمي iOS النشطين"
                            total={mobileAnalytics.ios.active_users.toString()}
                            bgColor={"bg-blue-500"}
                            iconBgColor={"bg-blue-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faUserCheck}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="مشاهدات Android"
                            total={mobileAnalytics.android.page_views.toString()}
                            bgColor={"bg-green-500"}
                            iconBgColor={"bg-green-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faFile}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="مشاهدات iOS"
                            total={mobileAnalytics.ios.page_views.toString()}
                            bgColor={"bg-blue-500"}
                            iconBgColor={"bg-blue-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faFile}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>
                    </div>

                    <hr className="my-4" />

                    <div
                        style={{ direction: "rtl" }}
                        className="my-4 grid grid-cols-12 gap-4 md:gap-6 2xl:gap-7.5 justify-end "
                    >
                        <label className="col-span-12 text-2xl text-primary dark:text-white ">
                            احصائيات طالبي الخدمة
                        </label>
                    </div>
                    <div
                        style={{ direction: "rtl" }}
                        className="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5"
                    >
                        <CardDataStats
                            title="عدد العملاء الجدد اول مرة"
                            total={totalClientsFirstTime}
                        >
                            <FontAwesomeIcon
                                icon={faUserPlus}
                                className="text-primary dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="عدد العملاء الجدد برمز دعوة"
                            total={totalClientsFirstTimeWIthInvitation}
                        >
                            <FontAwesomeIcon
                                icon={faUserTag}
                                className="text-primary dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="عدد العملاء القدامى"
                            total={totalOldClients}
                        >
                            <FontAwesomeIcon
                                icon={faUserFriends}
                                className="text-primary dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="عدد العملاء المحدثون"
                            total={totalUpdatedClients}
                        >
                            <FontAwesomeIcon
                                icon={faUserEdit}
                                className="text-primary dark:text-white"
                            />
                        </CardDataStats>
                        <div className="grid grid-cols-3 col-span-4 gap-4">
                            <div className="col-span-1">
                                <CardDataStats
                                    title="اجمالي عدد العملاء"
                                    total={(
                                        parseInt(
                                            totalClientsCompletedProfile.toString()
                                        ) +
                                        parseInt(
                                            totalClientsNotCompletedProfile.toString()
                                        )
                                    ).toString()}
                                >
                                    <FontAwesomeIcon
                                        icon={faUserCheck}
                                        className="text-primary dark:text-white"
                                    />
                                </CardDataStats>
                            </div>
                            <div className="col-span-1">
                                <CardDataStats
                                    title="عدد العملاء المستكملين حسابهم"
                                    total={totalClientsCompletedProfile}
                                >
                                    <FontAwesomeIcon
                                        icon={faUserCheck}
                                        className="text-primary dark:text-white"
                                    />
                                </CardDataStats>
                            </div>
                            <div className="col-span-1">
                                <CardDataStats
                                    title="عدد العملاء الغير مستكملين حسابهم"
                                    total={totalClientsNotCompletedProfile}
                                >
                                    <FontAwesomeIcon
                                        icon={faUserTimes}
                                        className="text-primary dark:text-white"
                                    />
                                </CardDataStats>
                            </div>
                        </div>

                        <CardDataStats
                            title="عدد العملاء المقبولين"
                            total={totalClientsApproved}
                            bgColor={"bg-green-500"}
                            iconBgColor={"bg-green-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faUserCheck}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>

                        <CardDataStats
                            title="عدد العملاء الجدد"
                            total={totalClientsNew}
                            bgColor={"bg-purple-500"}
                            iconBgColor={"bg-purple-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faUserPlus}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>

                        <CardDataStats
                            title="عدد العملاء المعلقين"
                            total={totalClientsPending}
                            bgColor={"bg-yellow-500"}
                            iconBgColor={"bg-yellow-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faUserClock}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="عدد العملاء المحظورين"
                            total={totalClientsBlocked}
                            bgColor={"bg-red-500"}
                            iconBgColor={"bg-red-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faUserLock}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>
                    </div>

                    <hr className="my-4" />

                    <div
                        style={{ direction: "rtl" }}
                        className="my-4 grid grid-cols-12 gap-4 md:gap-6 2xl:gap-7.5 justify-end "
                    >
                        <label className="col-span-12 text-2xl text-primary dark:text-white ">
                            احصائيات مقدمي الخدمة
                        </label>
                    </div>
                    <div
                        style={{ direction: "rtl" }}
                        className="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5"
                    >
                        <CardDataStats
                            title="عدد مقدمي الخدمة الجدد اول مرة"
                            total={totalLawyersFirstTime}
                        >
                            <FontAwesomeIcon
                                icon={faUserPlus}
                                className="text-primary dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="عدد مقدمي الخدمة الجدد برمز دعوة"
                            total={totalLawyersFirstTimeWIthInvitation}
                        >
                            <FontAwesomeIcon
                                icon={faUserTag}
                                className="text-primary dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="عدد مقدمي الخدمة القدامى"
                            total={totalOldLawyers}
                        >
                            <FontAwesomeIcon
                                icon={faUserFriends}
                                className="text-primary dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="عدد مقدمي الخدمة المحدثون"
                            total={totalUpdatedLawyers}
                        >
                            <FontAwesomeIcon
                                icon={faUserEdit}
                                className="text-primary dark:text-white"
                            />
                        </CardDataStats>
                        <div className="grid grid-cols-3 col-span-4 gap-4">
                            <div className="col-span-1">
                                <CardDataStats
                                    title="اجمالي عدد العملاء"
                                    total={(
                                        parseInt(
                                            totalLawyersCompletedProfile.toString()
                                        ) +
                                        parseInt(
                                            totalLawyersNotCompletedProfile.toString()
                                        )
                                    ).toString()}
                                >
                                    <FontAwesomeIcon
                                        icon={faUserCheck}
                                        className="text-primary dark:text-white"
                                    />
                                </CardDataStats>
                            </div>
                            <div className="col-span-1">
                                <CardDataStats
                                    title="عدد مقدمي الخدمة المستكملين حسابهم"
                                    total={totalLawyersCompletedProfile}
                                >
                                    <FontAwesomeIcon
                                        icon={faUserCheck}
                                        className="text-primary dark:text-white"
                                    />
                                </CardDataStats>
                            </div>
                            <div className="col-span-1">
                                <CardDataStats
                                    title="عدد مقدمي الخدمة الغير مستكملين حسابهم"
                                    total={totalLawyersNotCompletedProfile}
                                >
                                    <FontAwesomeIcon
                                        icon={faUserTimes}
                                        className="text-primary dark:text-white"
                                    />
                                </CardDataStats>
                            </div>
                        </div>
                        <CardDataStats
                            title="عدد مقدمي الخدمة المقبولين"
                            total={totalLawyersApproved}
                            bgColor={"bg-green-500"}
                            iconBgColor={"bg-green-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faUserCheck}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="عدد مقدمي الخدمة الجدد"
                            total={totalLawyersNew}
                            bgColor={"bg-purple-500"}
                            iconBgColor={"bg-purple-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faUserPlus}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="عدد مقدمي الخدمة المعلقين"
                            total={totalLawyersPending}
                            bgColor={"bg-yellow-500"}
                            iconBgColor={"bg-yellow-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faUserClock}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="عدد مقدمي الخدمة المحظورين"
                            total={totalLawyersBlocked}
                            bgColor={"bg-red-500"}
                            iconBgColor={"bg-red-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faUserLock}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>
                    </div>
                    <hr className="my-4" />

                    <div
                        style={{ direction: "rtl" }}
                        className="my-4 grid grid-cols-12 gap-4 md:gap-6 2xl:gap-7.5 justify-end "
                    >
                        <label className="col-span-12 text-2xl text-primary dark:text-white ">
                            احصائيات المنتجات العامة
                        </label>
                    </div>
                    <div
                        style={{ direction: "rtl" }}
                        className="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5"
                    >
                        <CardDataStats
                            title="اجمالي المنتجات"
                            total={
                                advisoryServicesPaymentCategoryTypes +
                                servicesCategories +
                                reservationsTypes
                            }
                        >
                            <FontAwesomeIcon
                                icon={faChartPie}
                                className="text-primary dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="اجمالي منتجات الأستشارات"
                            total={advisoryServicesPaymentCategoryTypes}
                        >
                            <FontAwesomeIcon
                                icon={faComment}
                                className="text-primary dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="اجمالي منتجات الخدمات"
                            total={servicesCategories}
                        >
                            <FontAwesomeIcon
                                icon={faFile}
                                className="text-primary dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="اجمالي منتجات المواعيد"
                            total={reservationsTypes}
                        >
                            <FontAwesomeIcon
                                icon={faClock}
                                className="text-primary dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="اجمالي المنتجات العامة للأستشارات"
                            total={advisoryServicesGeneralCategories}
                        >
                            <FontAwesomeIcon
                                icon={faComment}
                                className="text-primary dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="اجمالي المنتجات الخاصة للأستشارات"
                            total={advisoryServicesSubCategories}
                        >
                            <FontAwesomeIcon
                                icon={faComment}
                                className="text-primary dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="اجمالي مسميات منتجات الخدمات"
                            total={servicesSubCategories}
                        >
                            <FontAwesomeIcon
                                icon={faFile}
                                className="text-primary dark:text-white"
                            />
                        </CardDataStats>
                    </div>
                    <hr className="my-4" />

                    <div
                        style={{ direction: "rtl" }}
                        className="my-4 grid grid-cols-12 gap-4 md:gap-6 2xl:gap-7.5 justify-end "
                    >
                        <label className="col-span-12 text-2xl text-primary dark:text-white ">
                            احصائيات وارد المنتجات العامة
                        </label>
                    </div>
                    <div
                        style={{ direction: "rtl" }}
                        className="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5"
                    >
                        <CardDataStats
                            title="اجمالي وارد المنتجات"
                            total={
                                doneAdvisoryServices +
                                newAdvisoryServices +
                                waitingAdvisoryServices +
                                notDoneAdvisoryServices +
                                lateAdvisoryServices +
                                doneServices +
                                newServices +
                                waitingServices +
                                notDoneServices +
                                lateServices +
                                doneReservations +
                                newReservations +
                                waitingReservations +
                                notDoneReservations +
                                lateReservations
                            }
                        >
                            <FontAwesomeIcon
                                icon={faChartPie}
                                className="text-primary dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="اجمالي متلقي الطلبات"
                            total={uniqueLawyers}
                        >
                            <FontAwesomeIcon
                                icon={faUserMd}
                                className="text-primary dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="اجمالي طالبي الطلبات"
                            total={uniqueClients}
                        >
                            <FontAwesomeIcon
                                icon={faUserAlt}
                                className="text-primary dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="اجمالي الطلبات الغير مكتملة"
                            total={
                                newAdvisoryServices +
                                waitingAdvisoryServices +
                                notDoneAdvisoryServices +
                                lateAdvisoryServices +
                                newServices +
                                waitingServices +
                                notDoneServices +
                                lateServices +
                                newReservations +
                                waitingReservations +
                                notDoneReservations +
                                lateReservations
                            }
                        >
                            <FontAwesomeIcon
                                icon={faTimes}
                                className="text-primary dark:text-white"
                            />
                        </CardDataStats>
                    </div>
                    <hr className="my-4" />

                    <div
                        style={{ direction: "rtl" }}
                        className="my-4 grid grid-cols-12 gap-4 md:gap-6 2xl:gap-7.5 justify-end "
                    >
                        <label className="col-span-12 text-2xl text-primary dark:text-white ">
                            احصائيات وارد الأستشارات
                        </label>
                    </div>
                    <div
                        style={{ direction: "rtl" }}
                        className="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5"
                    >
                        <CardDataStats
                            title="اجمالي وارد الأستشارات"
                            total={
                                doneAdvisoryServices +
                                newAdvisoryServices +
                                waitingAdvisoryServices +
                                notDoneAdvisoryServices +
                                lateAdvisoryServices
                            }
                            small={true}
                        >
                            <FontAwesomeIcon
                                icon={faComment}
                                className="text-primary dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="مجموع الأستشارات المنجزة"
                            total={doneAdvisoryServices}
                            bgColor={"bg-green-500"}
                            iconBgColor={"bg-green-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faCheckCircle}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="مجموع الأستشارات الجديدة"
                            total={newAdvisoryServices}
                            bgColor={"bg-purple-500"}
                            iconBgColor={"bg-purple-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faPlusCircle}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="مجموع الأستشارات المنتظرة"
                            total={waitingAdvisoryServices}
                            bgColor={"bg-yellow-500"}
                            iconBgColor={"bg-yellow-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faClock}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="مجموع الأستشارات الغير منجزة"
                            total={notDoneAdvisoryServices}
                            bgColor={"bg-orange-500"}
                            iconBgColor={"bg-orange-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faTimesCircle}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="مجموع الأستشارات المتأخرة"
                            total={lateAdvisoryServices}
                            bgColor={"bg-red-500"}
                            iconBgColor={"bg-red-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faExclamationCircle}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>
                    </div>

                    <hr className="my-4" />

                    <div
                        style={{ direction: "rtl" }}
                        className="my-4 grid grid-cols-12 gap-4 md:gap-6 2xl:gap-7.5 justify-end "
                    >
                        <label className="col-span-12 text-2xl text-primary dark:text-white ">
                            احصائيات وارد الخدمات
                        </label>
                    </div>
                    <div
                        style={{ direction: "rtl" }}
                        className="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5"
                    >
                        <CardDataStats
                            title="اجمالي وارد الخدمات"
                            total={
                                doneServices +
                                newServices +
                                waitingServices +
                                notDoneServices +
                                lateServices
                            }
                        >
                            <FontAwesomeIcon
                                icon={faFile}
                                className="text-primary dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="مجموع الخدمات المنجزة"
                            total={doneServices}
                            bgColor={"bg-green-500"}
                            iconBgColor={"bg-green-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faCheckCircle}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="مجموع الخدمات الجديدة"
                            total={newServices}
                            bgColor={"bg-purple-500"}
                            iconBgColor={"bg-purple-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faPlusCircle}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="مجموع الخدمات المنتظرة"
                            total={waitingServices}
                            bgColor={"bg-yellow-500"}
                            iconBgColor={"bg-yellow-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faClock}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="مجموع الخدمات الغير منجزة"
                            total={notDoneServices}
                            bgColor={"bg-orange-500"}
                            iconBgColor={"bg-orange-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faTimesCircle}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="مجموع الخدمات المتأخرة"
                            total={lateServices}
                            bgColor={"bg-red-500"}
                            iconBgColor={"bg-red-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faExclamationCircle}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>
                    </div>

                    <hr className="my-4" />

                    <div
                        style={{ direction: "rtl" }}
                        className="my-4 grid grid-cols-12 gap-4 md:gap-6 2xl:gap-7.5 justify-end "
                    >
                        <label className="col-span-12 text-2xl text-primary dark:text-white ">
                            احصائيات وارد المواعيد
                        </label>
                    </div>
                    <div
                        style={{ direction: "rtl" }}
                        className="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5"
                    >
                        <CardDataStats
                            title="اجمالي وارد المواعيد"
                            total={
                                doneReservations +
                                newReservations +
                                waitingReservations +
                                notDoneReservations +
                                lateReservations
                            }
                        >
                            <FontAwesomeIcon
                                icon={faClock}
                                className="text-primary dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="مجموع المواعيد المنجزة"
                            total={doneReservations}
                            bgColor={"bg-green-500"}
                            iconBgColor={"bg-green-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faCheckCircle}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="مجموع المواعيد الجديدة"
                            total={newReservations}
                            bgColor={"bg-purple-500"}
                            iconBgColor={"bg-purple-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faPlusCircle}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="مجموع المواعيد المنتظرة"
                            total={waitingReservations}
                            bgColor={"bg-yellow-500"}
                            iconBgColor={"bg-yellow-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faClock}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="مجموع المواعيد الغير منجزة"
                            total={notDoneReservations}
                            bgColor={"bg-orange-500"}
                            iconBgColor={"bg-orange-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faTimesCircle}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>
                        <CardDataStats
                            title="مجموع المواعيد المتأخرة"
                            total={lateReservations}
                            bgColor={"bg-red-500"}
                            iconBgColor={"bg-red-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faExclamationCircle}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>
                    </div>

                    <hr className="my-4" />

                    <div
                        style={{ direction: "rtl" }}
                        className="my-4 grid grid-cols-12 gap-4 md:gap-6 2xl:gap-7.5 justify-end "
                    >
                        <label className="col-span-12 text-2xl text-primary dark:text-white ">
                            احصائيات طلبات النخبة
                        </label>
                    </div>
                    <div
                        style={{ direction: "rtl" }}
                        className="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5"
                    >
                        <CardDataStats
                            title="اجمالي طلبات النخبة"
                            total={totalEliteRequests}
                        >
                            <FontAwesomeIcon
                                icon={faChartPie}
                                className="text-primary dark:text-white"
                            />
                        </CardDataStats>

                        <CardDataStats
                            title="الطلبات قيد التسعير"
                            total={pendingPricingRequests}
                            bgColor={"bg-blue-500"}
                            iconBgColor={"bg-blue-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faClock}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>

                        <CardDataStats
                            title="الطلبات قيد الموافقة على التسعير"
                            total={pendingPricingApprovalRequests}
                            bgColor={"bg-indigo-500"}
                            iconBgColor={"bg-indigo-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faUserCheck}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>

                        <CardDataStats
                            title="الطلبات قيد التغيير على التسعير"
                            total={pendingPricingChangeRequests}
                            bgColor={"bg-purple-500"}
                            iconBgColor={"bg-purple-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faUserEdit}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>

                        <CardDataStats
                            title="الطلبات المرفوضة"
                            total={rejectedPricingRequests}
                            bgColor={"bg-red-500"}
                            iconBgColor={"bg-red-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faTimesCircle}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>

                        <CardDataStats
                            title="الطلبات قيد الدفع"
                            total={pendingPaymentRequests}
                            bgColor={"bg-yellow-500"}
                            iconBgColor={"bg-yellow-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faFile}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>

                        <CardDataStats
                            title="الطلبات المقبولة"
                            total={approvedRequests}
                            bgColor={"bg-green-500"}
                            iconBgColor={"bg-green-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faCheckCircle}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>

                        <CardDataStats
                            title="الطلبات قيد الاجتماع"
                            total={pendingMeetingRequests}
                            bgColor={"bg-orange-500"}
                            iconBgColor={"bg-orange-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faUsers}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>

                        <CardDataStats
                            title="الطلبات قيد المراجعة"
                            total={pendingReviewRequests}
                            bgColor={"bg-pink-500"}
                            iconBgColor={"bg-pink-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faUserCheck}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>

                        <CardDataStats
                            title="الطلبات قيد التصويت"
                            total={pendingVotingRequests}
                            bgColor={"bg-teal-500"}
                            iconBgColor={"bg-teal-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faUserFriends}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>

                        <CardDataStats
                            title="الطلبات المكتملة"
                            total={completedRequests}
                            bgColor={"bg-green-700"}
                            iconBgColor={"bg-green-500"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faCheckCircle}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>
                    </div>

                    <hr className="my-4" />

                    <div
                        style={{ direction: "rtl" }}
                        className="my-4 grid grid-cols-12 gap-4 md:gap-6 2xl:gap-7.5 justify-end "
                    >
                        <label className="col-span-12 text-2xl text-primary dark:text-white ">
                            احصائيات أنواع خدمات النخبة
                        </label>
                    </div>
                    <div
                        style={{ direction: "rtl" }}
                        className="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5"
                    >
                        <CardDataStats
                            title="طلبات الخدمات الاستشارية"
                            total={requestsWithAdvisoryServices}
                            bgColor={"bg-blue-500"}
                            iconBgColor={"bg-blue-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faComment}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>

                        <CardDataStats
                            title="طلبات الخدمات"
                            total={requestsWithServices}
                            bgColor={"bg-green-500"}
                            iconBgColor={"bg-green-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faFile}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>

                        <CardDataStats
                            title="طلبات الحجوزات"
                            total={requestsWithReservations}
                            bgColor={"bg-purple-500"}
                            iconBgColor={"bg-purple-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faClock}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>
                    </div>

                    <hr className="my-4" />

                    <div
                        style={{ direction: "rtl" }}
                        className="my-4 grid grid-cols-12 gap-4 md:gap-6 2xl:gap-7.5 justify-end "
                    >
                        <label className="col-span-12 text-2xl text-primary dark:text-white ">
                            احصائيات حالات الدفع لطلبات النخبة
                        </label>
                    </div>
                    <div
                        style={{ direction: "rtl" }}
                        className="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5"
                    >
                        <CardDataStats
                            title="الطلبات المدفوعة"
                            total={elitePaidRequests}
                            bgColor={"bg-green-500"}
                            iconBgColor={"bg-green-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faCheckCircle}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>

                        <CardDataStats
                            title="الطلبات الغير مدفوعة"
                            total={eliteUnpaidRequests}
                            bgColor={"bg-yellow-500"}
                            iconBgColor={"bg-yellow-300"}
                            textColor={"text-white dark:text-white"}
                        >
                            <FontAwesomeIcon
                                icon={faClock}
                                className="text-white dark:text-white"
                            />
                        </CardDataStats>
                    </div>
                </>
            )}
        </DefaultLayout>
    );
};

export default Dashboard;
