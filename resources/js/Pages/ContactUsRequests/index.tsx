import React from "react";
import { GetArabicDate } from "../../helpers/DateFunctions";
import DefaultLayout from "../../layout/DefaultLayout";
import Breadcrumb from "../../components/Breadcrumbs/Breadcrumb";
import ContactUsRequestsTable from "../../components/Tables/ContactUsRequests/ContactUsRequestsTable";

const ContactUsRequests = ({ requests, types }) => {
    const headers = [
        "#",
        "اسم مقدم الشكوى",
        "نوع الحساب",
        "موضوع الشكوى",
        "نوع الشكوى",
        "حالة الرد",
        "تاريخ الطلب",
        "توقيت الطلب",
        "العمليات",
    ];
    console.log("requests", requests);
    requests = requests.map((request) => {
        return {
            id: request.id,
            name: request.account?.name || request.name,
            type:
                request.account?.account_type == "lawyer"
                    ? "مقدم خدمة"
                    : request.account?.account_type == "client"
                    ? "عميل"
                    : "زائر",
            subject: request.subject,
            requestType: types.find((type) => type.id == request.type).name,
            requestTypeId: request.type,
            status: request.reply_subject ? "تم الرد" : "لم يتم الرد بعد",
            createdAt: GetArabicDate(request.created_at),
        };
    });
    return (
        <DefaultLayout>
            <Breadcrumb pageName="وارد تواصل معنا" />
            <ContactUsRequestsTable
                headers={headers}
                data={requests}
                requestTypes={types}
            />
        </DefaultLayout>
    );
};

export default ContactUsRequests;
