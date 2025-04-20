import React from "react";
import DefaultLayout from "../../layout/DefaultLayout";
import Breadcrumb from "../../components/Breadcrumbs/Breadcrumb";
import LawyerPayoutsTable from "../../components/Tables/LawyerPayoutsTable";
import { GetArabicDate } from "../../helpers/DateFunctions";

const Page = ({ lawyerPayouts }) => {
    const headers = [
        "#",
        "اسم مقدم الخدمة",
        "عدد المنتجات",
        "سعر المنتجات",
        "حالة الطلب",
        "تاريخ الطلب",
        "توقيت الطلب",
        "العمليات",
    ];
    lawyerPayouts = lawyerPayouts.map((lawyerPayout) => {
        return {
            id: lawyerPayout.id,
            lawyer: lawyerPayout.lawyer,
            lawyerName: lawyerPayout.lawyer.name,
            productsCount: lawyerPayout.payments.length,
            productsPrice: lawyerPayout.payments.reduce(
                (acc, payment) => acc + payment.product.price * 0.75,
                0
            ),

            status: lawyerPayout.status,
            statusText:
                lawyerPayout.status == "1"
                    ? "انتظار"
                    : lawyerPayout.status == "2"
                    ? "مدفوع"
                    : "مرفوض",
            createdAt: GetArabicDate(lawyerPayout.created_at),
        };
    });
    return (
        <>
            <DefaultLayout>
                <Breadcrumb pageName="طلبات تحويل الرصيد" />
                <LawyerPayoutsTable headers={headers} data={lawyerPayouts} />
            </DefaultLayout>
        </>
    );
};

export default Page;
