import React, { useRef, useState } from "react";
import ServicesCategoriesSettingsForm from "../../../../../components/Forms/Settings/Services/Categories/ServicesCategoriesSettingsForm";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import BaseSettingsForm from "../../../../../components/Forms/Settings/AdvisoryServices/BaseSettingsForm";
import SuccessNotification from "../../../../../components/SuccessNotification";
import ErrorNotification from "../../../../../components/ErrorNotification";

function BaseSettingsEdit({ base }) {
    const [errors, setErrors] = useState({});
    const [baseName, setBaseName] = useState(base?.title || "");
    const contentRef = useRef<HTMLDivElement>(null);

    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);

    async function saveData() {
        try {
            const res = await axios.post(
                `/admin/advisory-services-base/update`,
                {
                    id: base.id,
                    name: baseName,
                }
            );
            if (res.status == 200) {
                toast.success("done");
                setIsSuccess(true);
                contentRef.current?.scrollIntoView({ behavior: "smooth" });
            }
        } catch (err) {
            setIsError(true);
            contentRef.current?.scrollIntoView({ behavior: "smooth" });
            return setErrors(err.response.data.errors);
        }
    }
    return (
        <DefaultLayout>
            <div ref={contentRef}>
                <Breadcrumb pageName="تعديل فئة استشارة" />
                {isSuccess && <SuccessNotification classNames="my-2" />}
                {isError && <ErrorNotification classNames="my-2" />}
                <BaseSettingsForm
                    errors={errors}
                    saveData={saveData}
                    baseName={baseName}
                    setBaseName={setBaseName}
                />
            </div>
        </DefaultLayout>
    );
}

export default BaseSettingsEdit;
