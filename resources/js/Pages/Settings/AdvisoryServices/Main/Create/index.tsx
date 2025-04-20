import React, { useState } from "react";

import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import BaseSettingsForm from "../../../../../components/Forms/Settings/AdvisoryServices/BaseSettingsForm";
import AdvisoryServicesMainSettingsForm from "../../../../../components/Forms/Settings/AdvisoryServices/AdvisoryServicesMainSettingsForm";

function AdvisoryServicesMainSettingsCreate({ paymentCategoryTypes }) {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState("");
    const [description, setDescription] = useState("");
    const [paymentCategoryType, setPaymentCategoryType] = useState("");

    async function saveData() {
        router.post(
            "/newAdmin/settings/advisory-services/general-categories/store",
            {
                name,
                description,
                payment_category_type_id: paymentCategoryType,
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
            <Breadcrumb pageName="اضافة تخصص عام للأستشارات" />
            <AdvisoryServicesMainSettingsForm
                errors={errors}
                saveData={saveData}
                name={name}
                setName={setName}
                description={description}
                setDescription={setDescription}
                paymentCategoryType={paymentCategoryType}
                setPaymentCategoryType={setPaymentCategoryType}
                paymentCategoryTypes={paymentCategoryTypes}
            />
        </DefaultLayout>
    );
}

export default AdvisoryServicesMainSettingsCreate;
