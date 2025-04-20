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
import LanguageSettingsForm from "../../../../../components/Forms/Settings/LanguageSettingsForm";

function BaseSettingsEdit({ language }) {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState(language?.title || "");
    const contentRef = useRef<HTMLDivElement>(null);

    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);

    async function saveData() {
        try {
            const res = await axios.post(
                `/newAdmin/settings/signup/languages/${language.id}`,
                {
                    name,
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
                <Breadcrumb pageName="تعديل اللغة" />
                {isSuccess && <SuccessNotification classNames="my-2" />}
                {isError && <ErrorNotification classNames="my-2" />}
                <LanguageSettingsForm
                    errors={errors}
                    saveData={saveData}
                    name={name}
                    setName={setName}
                />
            </div>
        </DefaultLayout>
    );
}

export default BaseSettingsEdit;
