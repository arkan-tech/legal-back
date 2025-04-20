import React, { useState } from "react";

import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import BaseSettingsForm from "../../../../../components/Forms/Settings/AdvisoryServices/BaseSettingsForm";
import LanguageSettingsForm from "../../../../../components/Forms/Settings/LanguageSettingsForm";

function BaseSettingsCreate() {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState("");

    async function saveData() {
        router.post(
            "/newAdmin/settings/signup/languages/create",
            {
                name,
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
            <Breadcrumb pageName="اضافة لغة" />
            <LanguageSettingsForm
                errors={errors}
                saveData={saveData}
                name={name}
                setName={setName}
            />
        </DefaultLayout>
    );
}

export default BaseSettingsCreate;
