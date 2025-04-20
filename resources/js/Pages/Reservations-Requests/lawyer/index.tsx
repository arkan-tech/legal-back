import React from "react";

import Breadcrumb from "../../../components/Breadcrumbs/Breadcrumb";
import DefaultLayout from "../../../layout/DefaultLayout";
import {
    GetArabicDate,
    GetArabicDateTime,
    GetArabicTime,
} from "../../../helpers/DateFunctions";
import AdvisoryServicesRequestsTable from "../../../components/Tables/Advisory-Services-Requests/AdvisoryServicesRequestsTable";
import { Request } from "../client";
import ReservatationRequestsTable from "../../../components/Tables/ReservatationRequestsTable";

const LawyerAdvisoryServicesRequests = ({ requests }) => {
    const headers = [
        "#",
        "العميل",
        "نوع الموعد",
        "نوع الأهمية",
        "مقدم الخدمة المحال اليه",
        "حالة التذكرة",
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
            reservationImportance: request.importance.name,
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
            <Breadcrumb pageName="وارد مواعيد مقدمي الخدمة" />
            <ReservatationRequestsTable
                headers={headers}
                data={mappedRequests}
                reserverType={"lawyer"}
            />
        </DefaultLayout>
    );
};

export default LawyerAdvisoryServicesRequests;
