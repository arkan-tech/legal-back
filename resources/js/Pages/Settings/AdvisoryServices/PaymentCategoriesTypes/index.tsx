import React, { useState } from "react";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import DefaultLayout from "../../../../layout/DefaultLayout";
import ServicesCategoriesSettingsTable from "../../../../components/Tables/Services/ServicesCategoriesSettingsTable";
import BaseTableSettings from "../../../../components/Tables/Settings/AdvisoryServices/BaseTableSettings";
import DeleteModal from "../../../../components/Modals/DeleteModal";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import PaymentCategoriesTypesTable from "../../../../components/Tables/Settings/AdvisoryServices/PaymentCategoriesTypesTable";

const Services = ({ paymentCategoriesTypes }) => {
    const headers = ["#", "الاسم", "تحتاج لموعد", "العمليات"];

    return (
        <>
            <DefaultLayout>
                <Breadcrumb pageName="اعدادات انواع الوسائل" />
                <PaymentCategoriesTypesTable
                    headers={headers}
                    data={paymentCategoriesTypes}
                />
            </DefaultLayout>
        </>
    );
};

export default Services;
