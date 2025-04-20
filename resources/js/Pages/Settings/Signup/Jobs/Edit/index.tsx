import React, { useState } from "react";
import ServicesCategoriesSettingsForm from "../../../../../components/Forms/Settings/Services/Categories/ServicesCategoriesSettingsForm";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import JobsSettingsForm from "../../../../../components/Forms/Settings/Signup/JobsSettingsForm";

function JobsSettingsEdit({ job }) {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState(job?.title || "");
    const [needLicense, setNeedLicense] = useState(job?.need_license);

    async function saveData() {
        try {
            const res = await axios.post(
                `/admin/digital-guide/sections/update`,
                {
                    id: job.id,
                    name: name,
                    need_license: needLicense,
                }
            );
            if (res.status == 200) {
                toast.success("done");
            }
        } catch (err) {
            return setErrors(err.response.data.errors);
        }
    }
    return (
        <DefaultLayout>
            <Breadcrumb pageName="تعديل المهنة" />
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

export default JobsSettingsEdit;
