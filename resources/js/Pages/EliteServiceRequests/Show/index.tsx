import React, { useState } from "react";
import DefaultLayout from "../../../layout/DefaultLayout";
import Breadcrumb from "../../../components/Breadcrumbs/Breadcrumb";
import { router, Link } from "@inertiajs/react";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faArrowLeft } from "@fortawesome/free-solid-svg-icons";
import toast from "react-hot-toast";

interface File {
    id: number;
    file: string;
    is_voice: boolean;
    is_reply: boolean;
}

interface PricingCommitteeMember {
    id: number;
    name: string;
}

interface PaymentCategoryType {
    id: number;
    name: string;
}

interface GeneralCategory {
    id: number;
    name: string;
    paymentCategoryType?: PaymentCategoryType;
}

interface Category {
    id: number;
    name: string;
}

interface AdvisoryService {
    id: number;
    name: string;
    generalCategory?: GeneralCategory;
}

interface Service {
    id: number;
    name: string;
    category?: Category;
}

interface ReservationType {
    id: number;
    name: string;
}

interface PricingOffer {
    id: number;
    elite_service_request_id: number;

    // Advisory Services
    advisory_service_sub_id: number | null;
    advisory_service_sub_price: number | null;
    advisory_service_sub_price_counter: number | null;
    advisory_service_date: string | null;
    advisory_service_date_counter: string | null;
    advisory_service_from_time: string | null;
    advisory_service_from_time_counter: string | null;
    advisory_service_to_time: string | null;
    advisory_service_to_time_counter: string | null;

    // Services
    service_sub_id: number | null;
    service_sub_price: number | null;
    service_sub_price_counter: number | null;

    // Reservations
    reservation_type_id: number | null;
    reservation_price: number | null;
    reservation_price_counter: number | null;
    reservation_date: string | null;
    reservation_date_counter: string | null;
    reservation_from_time: string | null;
    reservation_from_time_counter: string | null;
    reservation_to_time: string | null;
    reservation_to_time_counter: string | null;
    reservation_latitude: string | null;
    reservation_longitude: string | null;

    created_at: string;
    updated_at: string;

    // Relationships
    advisoryServiceSub?: AdvisoryService;
    serviceSub?: Service;
    reservationType?: ReservationType;
}

interface EliteServiceRequest {
    id: number;
    requester: {
        id: number;
        name: string;
        deleted_at: string | null;
    };
    eliteServiceCategory: {
        id: number;
        name: string;
    };
    description: string;
    transaction_complete: number;
    status: string;
    pricer: {
        id: number;
        name: string;
    } | null;
    files: File[];
    created_at: string;
    offers: PricingOffer | null;
}

const EliteServiceRequestShow = ({
    request,
    pricingCommittee,
}: {
    request: EliteServiceRequest;
    pricingCommittee: PricingCommitteeMember[];
}) => {
    const [selectedPricer, setSelectedPricer] = useState(
        request.pricer?.id?.toString() || ""
    );
    console.log(request.offers);
    const getTransactionStatus = (status: number) => {
        switch (status) {
            case 0:
                return "غير مدفوع";
            case 1:
                return "مدفوع";
            case 2:
                return "الغاء الدفع";
            case 3:
                return "عملية دفع فاشلة";
            case 4:
                return "مجاناً";
            default:
                return "غير معروف";
        }
    };

    const getRequestStatus = (status: string) => {
        switch (status) {
            case "pending-pricing":
                return {
                    text: "في انتظار التسعير",
                    color: "bg-warning text-white",
                };
            case "pending-pricing-approval":
                return {
                    text: "في انتظار موافقة التسعير",
                    color: "bg-warning text-white",
                };
            case "pending-pricing-change":
                return {
                    text: "في انتظار تعديل التسعير",
                    color: "bg-warning text-white",
                };
            case "rejected-pricing":
                return {
                    text: "تم رفض التسعير",
                    color: "bg-danger text-white",
                };
            case "pending-payment":
                return {
                    text: "في انتظار الدفع",
                    color: "bg-meta-6 text-white",
                };
            case "approved":
                return { text: "تمت الموافقة", color: "bg-success text-white" };
            case "rejected-pricing-change":
                return {
                    text: "تم رفض تعديل التسعير",
                    color: "bg-danger text-white",
                };
            case "pending-meeting":
                return {
                    text: "في انتظار الاجتماع",
                    color: "bg-info text-white",
                };
            case "pending-review":
                return { text: "قيد المراجعة", color: "bg-meta-5 text-white" };
            case "pending-voting":
                return { text: "قيد التصويت", color: "bg-primary text-white" };
            case "completed":
                return { text: "مكتمل", color: "bg-success text-white" };
            default:
                return {
                    text: "في انتظار التسعير",
                    color: "bg-warning text-white",
                };
        }
    };

    const assignPricer = () => {
        if (!selectedPricer) {
            toast.error("الرجاء اختيار عضو لجنة التسعير");
            return;
        }

        router.post(
            `/newAdmin/elite-service-requests/${request.id}/assign-pricer`,
            {
                pricer_account_id: selectedPricer,
            }
        );
    };

    const formatDateTime = (date: string | null, time: string | null) => {
        if (!date) return "غير محدد";
        return time ? `${date} ${time}` : date;
    };

    return (
        <DefaultLayout>
            <Breadcrumb pageName="تفاصيل طلب النخبة" />

            <div className="mb-4">
                <Link
                    href="/newAdmin/elite-service-requests"
                    className="inline-flex items-center gap-2 rounded-md bg-primary py-2 px-4 text-white hover:bg-opacity-90"
                >
                    <FontAwesomeIcon icon={faArrowLeft} />
                    العودة للقائمة
                </Link>
            </div>

            <div className="space-y-6" style={{ direction: "rtl" }}>
                {/* Request Details Card */}
                <div className="rounded-sm border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
                    <h2 className="mb-6 text-xl font-semibold text-black dark:text-white">
                        بيانات الطلب
                    </h2>
                    <div className="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div className="mb-4">
                            <label className="mb-2 block text-black dark:text-white">
                                رقم الطلب:
                            </label>
                            <div className="rounded border border-stroke bg-gray px-4 py-2 dark:border-strokedark dark:bg-meta-4">
                                {request.id || "غير متوفر"}
                            </div>
                        </div>
                        <div className="mb-4">
                            <label className="mb-2 block text-black dark:text-white">
                                العميل:
                            </label>
                            <div className="rounded border border-stroke bg-gray px-4 py-2 dark:border-strokedark dark:bg-meta-4">
                                {request.requester?.name || "غير متوفر"}
                            </div>
                        </div>
                        <div className="mb-4">
                            <label className="mb-2 block text-black dark:text-white">
                                نوع الخدمة:
                            </label>
                            <div className="rounded border border-stroke bg-gray px-4 py-2 dark:border-strokedark dark:bg-meta-4">
                                {request.eliteServiceCategory?.name ||
                                    "غير متوفر"}
                            </div>
                        </div>
                        <div className="mb-4">
                            <label className="mb-2 block text-black dark:text-white">
                                تاريخ الطلب:
                            </label>
                            <div className="rounded border border-stroke bg-gray px-4 py-2 dark:border-strokedark dark:bg-meta-4">
                                {request.created_at || "غير متوفر"}
                            </div>
                        </div>
                        <div className="mb-4">
                            <label className="mb-2 block text-black dark:text-white">
                                حالة الطلب:
                            </label>
                            <div className="rounded border border-stroke bg-gray px-4 py-2 dark:border-strokedark dark:bg-meta-4">
                                <span
                                    className={`inline-block rounded px-2.5 py-0.5 text-sm font-medium ${
                                        getRequestStatus(request.status || "")
                                            .color
                                    }`}
                                >
                                    {
                                        getRequestStatus(request.status || "")
                                            .text
                                    }
                                </span>
                            </div>
                        </div>
                        <div className="mb-4">
                            <label className="mb-2 block text-black dark:text-white">
                                حالة الدفع:
                            </label>
                            <div className="rounded border border-stroke bg-gray px-4 py-2 dark:border-strokedark dark:bg-meta-4">
                                {getTransactionStatus(
                                    request.transaction_complete
                                )}
                            </div>
                        </div>
                    </div>
                    <div className="mb-4">
                        <label className="mb-2 block text-black dark:text-white">
                            الوصف:
                        </label>
                        <div className="rounded border border-stroke bg-gray px-4 py-3 dark:border-strokedark dark:bg-meta-4 min-h-[100px]">
                            {request.description || "لا يوجد وصف"}
                        </div>
                    </div>
                </div>

                {/* Files Section */}
                {request.files && request.files.length > 0 && (
                    <div className="rounded-sm border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
                        <h2 className="mb-6 text-xl font-semibold text-black dark:text-white">
                            الملفات المرفقة
                        </h2>
                        <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            {request.files.map((file, index) => (
                                <a
                                    key={index}
                                    href={file.file}
                                    target="_blank"
                                    className="group rounded-sm border border-stroke bg-gray-50 p-4 hover:bg-gray-100 hover:border-primary transition-all dark:border-strokedark dark:bg-meta-4 dark:hover:bg-meta-5"
                                >
                                    <div className="flex flex-col items-center text-center">
                                        <div className="mb-2 w-12 h-12 flex items-center justify-center rounded-full bg-primary/10 text-primary">
                                            {file.is_voice ? (
                                                // Voice file icon
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    className="h-6 w-6"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                >
                                                    <path
                                                        strokeLinecap="round"
                                                        strokeLinejoin="round"
                                                        strokeWidth={2}
                                                        d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"
                                                    />
                                                </svg>
                                            ) : (
                                                // Document file icon
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    className="h-6 w-6"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                >
                                                    <path
                                                        strokeLinecap="round"
                                                        strokeLinejoin="round"
                                                        strokeWidth={2}
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                                    />
                                                </svg>
                                            )}
                                        </div>
                                        <span className="text-primary group-hover:underline font-medium">
                                            {file.is_voice
                                                ? `ملف صوتي ${index + 1}`
                                                : `ملف مرفق ${index + 1}`}
                                        </span>
                                    </div>
                                </a>
                            ))}
                        </div>
                    </div>
                )}

                {/* Committee Assignment Card */}
                <div className="rounded-sm border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
                    <h2 className="mb-6 text-xl font-semibold text-black dark:text-white">
                        إدارة لجنة تسعير النخبة
                    </h2>
                    <div className="mb-4">
                        <label className="mb-2 block text-black dark:text-white">
                            عضو لجنة التسعير الحالي:
                        </label>
                        <div className="rounded border border-stroke bg-gray px-4 py-2 dark:border-strokedark dark:bg-meta-4">
                            {request.pricer?.name || "لم يتم التعيين"}
                        </div>
                    </div>
                    <div className="mb-4">
                        <label className="mb-2 block text-black dark:text-white">
                            تعيين عضو لجنة التسعير:
                        </label>
                        <select
                            value={selectedPricer}
                            onChange={(e) => setSelectedPricer(e.target.value)}
                            className="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input"
                        >
                            <option value="">اختر عضو لجنة التسعير</option>
                            {pricingCommittee.map((member) => (
                                <option key={member.id} value={member.id}>
                                    {member.name}
                                </option>
                            ))}
                        </select>
                    </div>
                    <button
                        onClick={assignPricer}
                        className="inline-flex items-center justify-center rounded-md bg-primary py-3 px-10 text-center font-medium text-white hover:bg-opacity-90 lg:px-8 xl:px-10"
                    >
                        تعيين
                    </button>
                </div>

                {/* Pricing Offer Section */}
                {request.offers ? (
                    <div className="rounded-sm border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
                        <h2 className="mb-6 text-xl font-semibold text-black dark:text-white">
                            عرض تسعير النخبة
                        </h2>

                        <div className="space-y-6">
                            {/* Advisory Service Offer */}
                            {request.offers.advisory_service_sub_id && (
                                <div className="rounded-sm border border-stroke bg-gray-50 p-5 shadow-sm dark:border-strokedark dark:bg-meta-4">
                                    <h3 className="mb-4 text-lg font-semibold text-black dark:text-white flex items-center gap-2">
                                        <span className="inline-block w-4 h-4 rounded-full bg-primary"></span>
                                        خدمة استشارية
                                    </h3>
                                    <div className="grid grid-cols-1 gap-4 md:grid-cols-2">
                                        <div className="mb-4 col-span-2">
                                            <label className="mb-2 block text-black dark:text-white font-medium">
                                                معلومات الخدمة الاستشارية:
                                            </label>
                                            <div className="flex flex-col gap-3">
                                                {request.offers
                                                    .advisory_service_sub
                                                    ?.general_category
                                                    ?.payment_category_type
                                                    ?.name && (
                                                    <div>
                                                        <label className="mb-1 block text-sm text-meta-5">
                                                            وسيلة الاستشارة:
                                                        </label>
                                                        <div className="rounded border border-stroke bg-white px-4 py-2 dark:border-strokedark dark:bg-boxdark">
                                                            {
                                                                request.offers
                                                                    .advisory_service_sub
                                                                    .general_category
                                                                    .payment_category_type
                                                                    .name
                                                            }
                                                        </div>
                                                    </div>
                                                )}

                                                {request.offers
                                                    .advisory_service_sub
                                                    ?.general_category
                                                    ?.name && (
                                                    <div>
                                                        <label className="mb-1 block text-sm text-meta-5">
                                                            التصنيف العام:
                                                        </label>
                                                        <div className="rounded border border-stroke bg-white px-4 py-2 dark:border-strokedark dark:bg-boxdark">
                                                            {
                                                                request.offers
                                                                    .advisory_service_sub
                                                                    .general_category
                                                                    .name
                                                            }
                                                        </div>
                                                    </div>
                                                )}

                                                {request.offers
                                                    .advisory_service_sub
                                                    ?.name && (
                                                    <div>
                                                        <label className="mb-1 block text-sm text-meta-5">
                                                            نوع الخدمة:
                                                        </label>
                                                        <div className="rounded border border-stroke bg-white px-4 py-2 dark:border-strokedark dark:bg-boxdark">
                                                            {
                                                                request.offers
                                                                    .advisory_service_sub
                                                                    .name
                                                            }
                                                        </div>
                                                    </div>
                                                )}
                                            </div>
                                        </div>
                                        <div className="mb-4">
                                            <label className="mb-2 block text-black dark:text-white font-medium">
                                                السعر المقترح:
                                            </label>
                                            <div className="rounded border border-stroke bg-white px-4 py-2 dark:border-strokedark dark:bg-boxdark">
                                                {
                                                    request.offers
                                                        .advisory_service_sub_price
                                                }{" "}
                                                ريال
                                                {request.offers
                                                    .advisory_service_sub_price_counter && (
                                                    <span className="mr-2 text-primary">
                                                        (تعديل العميل:{" "}
                                                        {
                                                            request.offers
                                                                .advisory_service_sub_price_counter
                                                        }{" "}
                                                        ريال)
                                                    </span>
                                                )}
                                            </div>
                                        </div>
                                        {request.offers
                                            .advisory_service_date && (
                                            <>
                                                <div className="mb-4">
                                                    <label className="mb-2 block text-black dark:text-white font-medium">
                                                        تاريخ الموعد:
                                                    </label>
                                                    <div className="rounded border border-stroke bg-white px-4 py-2 dark:border-strokedark dark:bg-boxdark">
                                                        {
                                                            request.offers
                                                                .advisory_service_date
                                                        }
                                                        {request.offers
                                                            .advisory_service_date_counter && (
                                                            <span className="mr-2 text-primary">
                                                                (تعديل العميل:{" "}
                                                                {
                                                                    request
                                                                        .offers
                                                                        .advisory_service_date_counter
                                                                }
                                                                )
                                                            </span>
                                                        )}
                                                    </div>
                                                </div>
                                                <div className="mb-4">
                                                    <label className="mb-2 block text-black dark:text-white font-medium">
                                                        وقت الموعد:
                                                    </label>
                                                    <div className="rounded border border-stroke bg-white px-4 py-2 dark:border-strokedark dark:bg-boxdark">
                                                        من{" "}
                                                        {
                                                            request.offers
                                                                .advisory_service_from_time
                                                        }{" "}
                                                        إلى{" "}
                                                        {
                                                            request.offers
                                                                .advisory_service_to_time
                                                        }
                                                        {(request.offers
                                                            .advisory_service_from_time_counter ||
                                                            request.offers
                                                                .advisory_service_to_time_counter) && (
                                                            <span className="mr-2 text-primary">
                                                                (تعديل العميل:
                                                                من{" "}
                                                                {
                                                                    request
                                                                        .offers
                                                                        .advisory_service_from_time_counter
                                                                }{" "}
                                                                إلى{" "}
                                                                {
                                                                    request
                                                                        .offers
                                                                        .advisory_service_to_time_counter
                                                                }
                                                                )
                                                            </span>
                                                        )}
                                                    </div>
                                                </div>
                                            </>
                                        )}
                                    </div>
                                </div>
                            )}

                            {/* Service Offer */}
                            {request.offers.service_sub_id && (
                                <div className="rounded-sm border border-stroke bg-gray-50 p-5 shadow-sm dark:border-strokedark dark:bg-meta-4">
                                    <h3 className="mb-4 text-lg font-semibold text-black dark:text-white flex items-center gap-2">
                                        <span className="inline-block w-4 h-4 rounded-full bg-success"></span>
                                        خدمة
                                    </h3>
                                    <div className="grid grid-cols-1 gap-4 md:grid-cols-2">
                                        <div className="mb-4 col-span-2">
                                            <label className="mb-2 block text-black dark:text-white font-medium">
                                                معلومات الخدمة:
                                            </label>
                                            <div className="flex flex-col gap-3">
                                                {request.offers.service_sub
                                                    ?.category?.name && (
                                                    <div>
                                                        <label className="mb-1 block text-sm text-meta-5">
                                                            التصنيف:
                                                        </label>
                                                        <div className="rounded border border-stroke bg-white px-4 py-2 dark:border-strokedark dark:bg-boxdark">
                                                            {
                                                                request.offers
                                                                    .service_sub
                                                                    .category
                                                                    .name
                                                            }
                                                        </div>
                                                    </div>
                                                )}

                                                {request.offers.service_sub
                                                    ?.title && (
                                                    <div>
                                                        <label className="mb-1 block text-sm text-meta-5">
                                                            نوع الخدمة:
                                                        </label>
                                                        <div className="rounded border border-stroke bg-white px-4 py-2 dark:border-strokedark dark:bg-boxdark">
                                                            {
                                                                request.offers
                                                                    .service_sub
                                                                    .title
                                                            }
                                                        </div>
                                                    </div>
                                                )}
                                            </div>
                                        </div>
                                        <div className="mb-4">
                                            <label className="mb-2 block text-black dark:text-white font-medium">
                                                السعر المقترح:
                                            </label>
                                            <div className="rounded border border-stroke bg-white px-4 py-2 dark:border-strokedark dark:bg-boxdark">
                                                {
                                                    request.offers
                                                        .service_sub_price
                                                }{" "}
                                                ريال
                                                {request.offers
                                                    .service_sub_price_counter && (
                                                    <span className="mr-2 text-primary">
                                                        (تعديل العميل:{" "}
                                                        {
                                                            request.offers
                                                                .service_sub_price_counter
                                                        }{" "}
                                                        ريال)
                                                    </span>
                                                )}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            )}

                            {/* Reservation Offer */}
                            {request.offers.reservation_type_id && (
                                <div className="rounded-sm border border-stroke bg-gray-50 p-5 shadow-sm dark:border-strokedark dark:bg-meta-4">
                                    <h3 className="mb-4 text-lg font-semibold text-black dark:text-white flex items-center gap-2">
                                        <span className="inline-block w-4 h-4 rounded-full bg-info"></span>
                                        حجز موعد
                                    </h3>
                                    <div className="grid grid-cols-1 gap-4 md:grid-cols-2">
                                        <div className="mb-4 col-span-2">
                                            <label className="mb-2 block text-black dark:text-white font-medium">
                                                معلومات الحجز:
                                            </label>
                                            <div className="flex flex-col gap-3">
                                                {request.offers.reservation_type
                                                    ?.name && (
                                                    <div>
                                                        <label className="mb-1 block text-sm text-meta-5">
                                                            نوع الحجز:
                                                        </label>
                                                        <div className="rounded border border-stroke bg-white px-4 py-2 dark:border-strokedark dark:bg-boxdark">
                                                            {
                                                                request.offers
                                                                    .reservation_type
                                                                    .name
                                                            }
                                                        </div>
                                                    </div>
                                                )}
                                            </div>
                                        </div>
                                        <div className="mb-4">
                                            <label className="mb-2 block text-black dark:text-white font-medium">
                                                السعر المقترح:
                                            </label>
                                            <div className="rounded border border-stroke bg-white px-4 py-2 dark:border-strokedark dark:bg-boxdark">
                                                {
                                                    request.offers
                                                        .reservation_price
                                                }{" "}
                                                ريال
                                                {request.offers
                                                    .reservation_price_counter && (
                                                    <span className="mr-2 text-primary">
                                                        (تعديل العميل:{" "}
                                                        {
                                                            request.offers
                                                                .reservation_price_counter
                                                        }{" "}
                                                        ريال)
                                                    </span>
                                                )}
                                            </div>
                                        </div>
                                        <div className="mb-4">
                                            <label className="mb-2 block text-black dark:text-white font-medium">
                                                تاريخ الموعد:
                                            </label>
                                            <div className="rounded border border-stroke bg-white px-4 py-2 dark:border-strokedark dark:bg-boxdark">
                                                {
                                                    request.offers
                                                        .reservation_date
                                                }
                                                {request.offers
                                                    .reservation_date_counter && (
                                                    <span className="mr-2 text-primary">
                                                        (تعديل العميل:{" "}
                                                        {
                                                            request.offers
                                                                .reservation_date_counter
                                                        }
                                                        )
                                                    </span>
                                                )}
                                            </div>
                                        </div>
                                        <div className="mb-4">
                                            <label className="mb-2 block text-black dark:text-white font-medium">
                                                وقت الموعد:
                                            </label>
                                            <div className="rounded border border-stroke bg-white px-4 py-2 dark:border-strokedark dark:bg-boxdark">
                                                من{" "}
                                                {
                                                    request.offers
                                                        .reservation_from_time
                                                }
                                                إلى{" "}
                                                {
                                                    request.offers
                                                        .reservation_to_time
                                                }
                                                {(request.offers
                                                    .reservation_from_time_counter ||
                                                    request.offers
                                                        .reservation_to_time_counter) && (
                                                    <span className="mr-2 text-primary">
                                                        (تعديل العميل: من{" "}
                                                        {
                                                            request.offers
                                                                .reservation_from_time_counter
                                                        }
                                                        إلى{" "}
                                                        {
                                                            request.offers
                                                                .reservation_to_time_counter
                                                        }
                                                        )
                                                    </span>
                                                )}
                                            </div>
                                        </div>
                                        {request.offers.reservation_latitude &&
                                            request.offers
                                                .reservation_longitude && (
                                                <div className="mb-4 col-span-2">
                                                    <label className="mb-2 block text-black dark:text-white font-medium">
                                                        الموقع:
                                                    </label>
                                                    <div className="rounded border border-stroke bg-white px-4 py-2 dark:border-strokedark dark:bg-boxdark">
                                                        <a
                                                            href={`https://maps.google.com/?q=${request.offers.reservation_latitude},${request.offers.reservation_longitude}`}
                                                            target="_blank"
                                                            className="text-primary hover:underline"
                                                        >
                                                            عرض الموقع على
                                                            الخريطة
                                                        </a>
                                                    </div>
                                                </div>
                                            )}
                                    </div>
                                </div>
                            )}
                        </div>

                        <div className="mt-6">
                            <label className="mb-2 block text-black dark:text-white">
                                تاريخ تقديم العرض:
                            </label>
                            <div className="rounded border border-stroke bg-gray px-4 py-2 dark:border-strokedark dark:bg-meta-4">
                                {request.offers.created_at || "غير متوفر"}
                            </div>
                        </div>
                    </div>
                ) : (
                    <div className="rounded-sm border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
                        <h2 className="mb-6 text-xl font-semibold text-black dark:text-white">
                            عرض تسعير النخبة
                        </h2>
                        <div className="text-center py-10 text-gray-500">
                            لم يتم تقديم عرض تسعير بعد
                        </div>
                    </div>
                )}
            </div>
        </DefaultLayout>
    );
};

export default EliteServiceRequestShow;
