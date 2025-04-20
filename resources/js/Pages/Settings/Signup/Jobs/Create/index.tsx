import React, { useState } from "react";
import ServicesCategoriesSettingsForm from "../../../../../components/Forms/Settings/Services/Categories/ServicesCategoriesSettingsForm";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import JobsSettingsForm from "../../../../../components/Forms/Settings/Signup/JobsSettingsForm";

function JobsSettingsCreate() {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState("");
    const [needLicense, setNeedLicense] = useState(false);
    async function saveData() {
        router.post(
            "/admin/digital-guide/sections/store",
            {
                name: name,
                need_license: needLicense,
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
            <Breadcrumb pageName="اضافة مهنة" />
            <JobsSettingsForm
                errors={errors}
                saveData={saveData}
                name={name}
                setName={setName}
                needLicense={needLicense}
                setNeedLicense={setNeedLicense}
            />
        </DefaultLayout>
    );
}

export default JobsSettingsCreate;
