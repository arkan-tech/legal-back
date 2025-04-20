import React, { useState } from "react";

import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import BaseSettingsForm from "../../../../../components/Forms/Settings/AdvisoryServices/BaseSettingsForm";
import PaymentCategoriesSettingsForm from "../../../../../components/Forms/Settings/AdvisoryServices/PaymentCategoriesSettingsForm";

function BaseSettingsCreate({ base }) {
    const [errors, setErrors] = useState({});
    const [paymentCategoryName, setPaymentCategoryName] = useState("");
    const [selectedBase, setSelectedBase] = useState("");
    const [paymentMethod, setPaymentMethod] = useState("");

    async function saveData() {
        console.log(selectedBase);
        router.post(
            "/admin/advisory-services/payment-categories/store",
            {
                name: paymentCategoryName,
                advisory_services_base_id: selectedBase,
                payment_method: paymentMethod,
            },
            {
                onError: (err) => {
                    setErrors(err);
                },
            }
        );
    }
    return (
        <DefaultLayout>
            <Breadcrumb pageName="اضافة باقة استشارة" />
            <PaymentCategoriesSettingsForm
                errors={errors}
                saveData={saveData}
                paymentCategoryName={paymentCategoryName}
                setPaymentCategoryName={setPaymentCategoryName}
                selectedBase={selectedBase}
                setSelectedBase={setSelectedBase}
                paymentMethod={paymentMethod}
                setPaymentMethod={setPaymentMethod}
                base={base}
            />
        </DefaultLayout>
    );
}

export default BaseSettingsCreate;
