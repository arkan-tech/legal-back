import React from "react";
import DefaultLayout from "../../layout/DefaultLayout";
import Breadcrumb from "../../components/Breadcrumbs/Breadcrumb";
import { Link } from "@inertiajs/react";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faEye } from "@fortawesome/free-solid-svg-icons";

interface EliteServiceRequest {
    id: number;
    requester: {
        name: string;
        deleted_at: string | null;
    };
    eliteServiceCategory: {
        name: string;
    };
    description: string;
    transaction_complete: number;
    status: string;
    pricer: {
        id: number;
        name: string;
    } | null;
    created_at: string;
}

const EliteServiceRequests = ({
    requests = [],
}: {
    requests: EliteServiceRequest[];
}) => {
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

    return (
        <DefaultLayout>
            <Breadcrumb pageName="طلبات النخبة" />
            <div className="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
                <div className="max-w-full overflow-x-auto">
                    <table
                        className="w-full table-auto"
                        style={{ direction: "rtl" }}
                    >
                        <thead>
                            <tr className="bg-gray-2 text-right dark:bg-meta-4">
                                <th className="py-4 px-4 font-medium text-black dark:text-white">
                                    #
                                </th>
                                <th className="py-4 px-4 font-medium text-black dark:text-white">
                                    العميل
                                </th>
                                <th className="py-4 px-4 font-medium text-black dark:text-white">
                                    نوع الخدمة
                                </th>
                                <th className="py-4 px-4 font-medium text-black dark:text-white">
                                    عضو لجنة التسعير
                                </th>
                                <th className="py-4 px-4 font-medium text-black dark:text-white">
                                    حالة الطلب
                                </th>
                                <th className="py-4 px-4 font-medium text-black dark:text-white">
                                    حالة الدفع
                                </th>
                                <th className="py-4 px-4 font-medium text-black dark:text-white">
                                    تاريخ الطلب
                                </th>
                                <th className="py-4 px-4 font-medium text-black dark:text-white">
                                    العمليات
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            {requests.map((request) => (
                                <tr key={request.id}>
                                    <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                        <p className="text-black dark:text-white">
                                            {request.id}
                                        </p>
                                    </td>
                                    <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                        {request.requester?.deleted_at ? (
                                            <del className="text-red-500">
                                                {request.requester?.name}
                                            </del>
                                        ) : (
                                            <p className="text-black dark:text-white">
                                                {request.requester?.name}
                                            </p>
                                        )}
                                    </td>
                                    <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                        <p className="text-black dark:text-white">
                                            {request.eliteServiceCategory?.name}
                                        </p>
                                    </td>
                                    <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                        <p className="text-black dark:text-white">
                                            {request.pricer?.name ||
                                                "لم يتم التعيين"}
                                        </p>
                                    </td>
                                    <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                        <span
                                            className={`inline-block rounded px-2.5 py-0.5 text-sm font-medium ${
                                                getRequestStatus(request.status)
                                                    .color
                                            }`}
                                        >
                                            {
                                                getRequestStatus(request.status)
                                                    .text
                                            }
                                        </span>
                                    </td>
                                    <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                        <p className="text-black dark:text-white">
                                            {getTransactionStatus(
                                                request.transaction_complete
                                            )}
                                        </p>
                                    </td>
                                    <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                        <p className="text-black dark:text-white">
                                            {request.created_at}
                                        </p>
                                    </td>
                                    <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                        <div className="flex items-center gap-3">
                                            <Link
                                                href={`/newAdmin/elite-service-requests/${request.id}`}
                                                className="hover:text-primary"
                                            >
                                                <FontAwesomeIcon icon={faEye} />
                                            </Link>
                                        </div>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>
        </DefaultLayout>
    );
};

export default EliteServiceRequests;
