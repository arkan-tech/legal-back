import React from "react";
import {
    GetArabicDate,
    GetArabicDateTime,
} from "../../../../helpers/DateFunctions";
import DefaultLayout from "../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import ServiceRequestsTable from "../../../../components/Tables/Services-Requests/ServicesRequestsTable";
import { Request } from "../../client";
const ForLawyerClientServicesRequests = ({
    requests,
    advisories,
    all_lawyers,
}) => {
    const headers = [
        "#",
        "العميل",
        "الخدمة",
        "مقدم الخدمة",
        "حالة الطلب",
        "مستوى الطلب",
        "حالة الرد",
        "حالة الدفع",
        "تاريخ الطلب",
        "وقت الطلب",
        "تاريخ ووفت الأحالة",
        "العمليات",
    ];
    let referralStatus;
    let mappedRequests: Request[] = requests.map((request) => {
        switch (request.referral_status) {
            case 0:
                referralStatus = "غير محال";
                break;
            case 1:
                referralStatus = "محال";
                break;
            case 2:
                referralStatus = "دراسة الطلب";
                break;
            case 3:
                referralStatus = "انهاء الطلب";
                break;
            case 4:
                referralStatus = "مرفوض من المستشار";
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
                transactionStatus = "ملغي";
                break;
            default:
                transactionStatus = "مرفوض";
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
        return {
            id: request.id,
            clientName: request.account.name,
            deleted:
                request.account != null
                    ? request.account.deleted_at != null
                        ? true
                        : false
                    : true,
            serviceName: request.type.title,
            lawyerName: request.lawyer?.name || "-",
            requestStatus: request.request_status,
            requestStatusText,
            replyStatus: request.replay_status == 1 ? "تم الرد" : "انتظار",
            referralStatus,
            transactionStatus,
            transferTime: GetArabicDate(request.transferTime),
            importance: request.priority_rel.title,
            createdAt: GetArabicDateTime(request.created_at),
        };
    });
    return (
        <DefaultLayout>
            <Breadcrumb pageName="وارد خدمات العملاء" />
            <ServiceRequestsTable headers={headers} data={mappedRequests} />
        </DefaultLayout>
    );
};

export default ForLawyerClientServicesRequests;
