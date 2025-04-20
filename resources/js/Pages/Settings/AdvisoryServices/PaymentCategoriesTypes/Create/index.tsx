import React, { useState } from "react";

import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import BaseSettingsForm from "../../../../../components/Forms/Settings/AdvisoryServices/BaseSettingsForm";
import PaymentCategoriesTypesForm from "../../../../../components/Forms/Settings/AdvisoryServices/PaymentCategoriesTypesForm";

function BaseSettingsCreate() {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState("");
    const [description, setDescription] = useState("");
    const [requiresAppointment, setRequiresAppointment] = useState(false);
    async function saveData() {
        router.post(
            "/newAdmin/settings/advisory-services/payment-categories-types/create",
            {
                name,
                description,
                requires_appointment: requiresAppointment,
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
            <Breadcrumb pageName="اضافة نوع وسيلة" />
            <PaymentCategoriesTypesForm
                errors={errors}
                saveData={saveData}
                name={name}
                setName={setName}
                description={description}
                setDescription={setDescription}
                requiresAppointment={requiresAppointment}
                setRequiresAppointment={setRequiresAppointment}
            />
        </DefaultLayout>
    );
}

export default BaseSettingsCreate;
