import React from "react";
import DefaultLayout from "../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import AdvisoryServicesRequestsTable from "../../../../components/Tables/Advisory-Services-Requests/AdvisoryServicesRequestsTable";
import {
    GetArabicDate,
    GetArabicDateTime,
    GetArabicTime,
} from "../../../../helpers/DateFunctions";
import { Request } from "../../client";
import ReservatationRequestsTable from "../../../../components/Tables/ReservatationRequestsTable";

const ClientAdvisoryServicesRequests = ({ requests }) => {
    console.log("r", requests);
    const headers = [
        "#",
        "العميل",
        "نوع الموعد",
        "مقدم الخدمة المحال اليه",
        "حالة الطلب",
        "مستوى الطلب",
        "حالة الحضور",
        "حالة الدفع",
        "سعر الموعد",
        "يوم الموعد",
        "من",
        "الى",
        "تاريخ الطلب",
        "وقت الطلب",
        // "تاريخ ووفت الأحالة",
        "العمليات",
    ];

    let mappedRequests: Request[] = requests.map((request) => {
        let requestStatusText;
        switch (request.request_status) {
            case 1:
                requestStatusText = "قادم";
                break;
            case 2:
                requestStatusText = "قيد الأجتماع";
                break;
            case 3:
                requestStatusText = "منجز";
                break;
            case 4:
                requestStatusText = "غير منجز";
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
            reservationType: request.reservation_type.name,
            reservationImportance: request.importance.title,
            lawyerName: request.lawyer?.name || "-",
            requestStatusText,
            requestStatus: request.request_status,
            reservationAttended:
                request.reservationEnded == 1 ? "تم الحضور" : "انتظار",
            transactionStatus,
            price: request.price,
            date: GetArabicDate(request.day),
            from: GetArabicTime(request.from.split(" ")[1]),
            to: GetArabicTime(request.to.split(" ")[1]),
            // transferTime: GetArabicDateTime(request.transferTime),
            createdAt: GetArabicDateTime(request.created_at),
        };
    });
    return (
        <DefaultLayout>
            <Breadcrumb pageName="وارد مواعيد العملاء" />
            <ReservatationRequestsTable
                headers={headers}
                data={mappedRequests}
            />
        </DefaultLayout>
    );
};

export default ClientAdvisoryServicesRequests;
