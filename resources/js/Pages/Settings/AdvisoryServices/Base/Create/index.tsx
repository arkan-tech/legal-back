import React, { useState } from "react";

import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import BaseSettingsForm from "../../../../../components/Forms/Settings/AdvisoryServices/BaseSettingsForm";

function BaseSettingsCreate() {
    const [errors, setErrors] = useState({});
    const [baseName, setBaseName] = useState("");

    async function saveData() {
        router.post(
            "/admin/advisory-services-base/store",
            {
                name: baseName,
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
            <Breadcrumb pageName="اضافة فئة استشارة" />
            <BaseSettingsForm
                errors={errors}
                saveData={saveData}
                baseName={baseName}
                setBaseName={setBaseName}
            />
        </DefaultLayout>
    );
}

export default BaseSettingsCreate;
