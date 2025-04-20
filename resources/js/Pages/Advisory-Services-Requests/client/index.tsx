import React from "react";

import MainSettingsTable from "../../../components/Tables/Settings/AdvisoryServices/MainSettingsTable";
import Breadcrumb from "../../../components/Breadcrumbs/Breadcrumb";
import DefaultLayout from "../../../layout/DefaultLayout";
import {
    GetArabicDate,
    GetArabicDateTime,
} from "../../../helpers/DateFunctions";
import ServicesRequestsTable from "../../../components/Tables/Services-Requests/ServicesRequestsTable";
import AdvisoryServicesRequestsTable from "../../../components/Tables/Advisory-Services-Requests/AdvisoryServicesRequestsTable";
export interface Request {
    id;
    clientName;
    deleted;
    serviceName;
    lawyerName;
    replyStatus;
    reservationStatus;
    transactionStatus;
    createdAt;
    subCategoryName;
    generalCategoryName;
    transferTime;
    importance;
    requestStatus;
    requestStatusText;
}
const ClientAdvisoryServicesRequests = ({ requests }) => {
    console.log(requests);
    const headers = [
        "#",
        "العميل",
        "وسيلة الأستشارة",
        "نوع الاستشارة العام",
        "نوع الاستشارة الدقيق",
        "مقدم الخدمة المحال اليه",
        "حالة التذكرة",
        "حالة الرد",
        "حالة الدفع",
        "تاريخ الطلب",
        "وقت الطلب",
        "تاريخ ووفت الأحالة",
        "العمليات",
    ];

    let mappedRequests: Request[] = requests.map((request) => {
        let reservationStatus;
        switch (request.reservation_status) {
            case 1:
                reservationStatus = "مقبول";
                break;
            case 2:
                reservationStatus = "تمت الاحالة إلى مستشار";
                break;
            case 3:
                reservationStatus = "تم القبول من المحامي";
                break;
            case 4:
                reservationStatus = "قيد الدراسة";
                break;
            case 5:
                reservationStatus = "تم الانتهاء";
                break;
            case 6:
                reservationStatus = "مرفوض من الادارة";
                break;
            case 7:
                reservationStatus = "ملغي من العميل";
                break;
        }
        let requestStatusText;
        switch (request.request_status) {
            case "1":
                requestStatusText = "جديد";
                break;
            case "2":
                requestStatusText = "انتظار";
                break;
            case "3":
                requestStatusText = "متأخر";
                break;
            case "4":
                requestStatusText = "غير منجز";
                break;
            case "5":
                requestStatusText = "منجز";
                break;
        }
        let transactionStatus;
        switch (request.transaction_complete) {
            case 0:
                transactionStatus = "غير مدفوع";
                break;
            case 1:
                transactionStatus = "مدفوع";
                break;
            case 2:
                transactionStatus = "الغاء الدفع";
                break;
            case 3:
                transactionStatus = " عملية دفع فاشلة";
                break;
            case 4:
                transactionStatus = "مجاناً";
                break;
        }
        return {
            id: request.id,
            clientName: request.account.name,
            deleted:
                request.account != null
                    ? request.account.deleted_at != null
                        ? true
                        : false
                    : true,
            serviceName:
                request.sub_category_price.sub_category.general_category
                    .payment_category_type.name,
            lawyerName: request.lawyer?.name || "-",

            generalCategoryName:
                request.sub_category_price.sub_category.general_category.name,
            subCategoryName: request.sub_category_price.sub_category.name,
            replyStatus: request.reply_status == 1 ? "تم الرد" : "انتظار",
            reservationStatus,
            transactionStatus,
            requestStatusText,
            requestStatus: request.request_status,
            transferTime: GetArabicDateTime(request.transferTime),
            createdAt: GetArabicDateTime(request.created_at),
        };
    });
    return (
        <DefaultLayout>
            <Breadcrumb pageName="وارد استشارات العملاء" />
            <AdvisoryServicesRequestsTable
                headers={headers}
                data={mappedRequests}
            />
        </DefaultLayout>
    );
};

export default ClientAdvisoryServicesRequests;
