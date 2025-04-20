import React, { useRef, useState } from "react";
import ServicesCategoriesSettingsForm from "../../../../../components/Forms/Settings/Services/Categories/ServicesCategoriesSettingsForm";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import JobsSettingsForm from "../../../../../components/Forms/Settings/Signup/JobsSettingsForm";
import DegreesSettingsForm from "../../../../../components/Forms/Settings/Signup/DegreesSettingsForm";
import SuccessNotification from "../../../../../components/SuccessNotification";
import ErrorNotification from "../../../../../components/ErrorNotification";

function JobsSettingsEdit({ degree }) {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState(degree?.title || "");
    const [isSpecial, setIsSpecial] = useState(degree?.isSpecial);
    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);

    async function saveData() {
        try {
            const res = await axios.post(
                `/newAdmin/settings/signup/degrees/${degree.id}`,
                {
                    name: name,
                    isSpecial,
                }
            );
            if (res.status == 200) {
                setIsSuccess(true);
                contentRef.current?.scrollIntoView({ behavior: "smooth" });
            }
        } catch (err) {
            setIsError(true);
            contentRef.current?.scrollIntoView({ behavior: "smooth" });

            return setErrors(err.response.data.errors);
        }
    }
    const contentRef = useRef<HTMLDivElement>(null);

    return (
        <DefaultLayout>
            <div ref={contentRef}>
                {isSuccess && <SuccessNotification />}
                {isError && <ErrorNotification />}

                <Breadcrumb pageName="تعديل درجة علمية" />
                <DegreesSettingsForm
                    errors={errors}
                    saveData={saveData}
                    name={name}
                    setName={setName}
                    isSpecial={isSpecial}
                    setIsSpecial={setIsSpecial}
                />
            </div>
        </DefaultLayout>
    );
}

export default JobsSettingsEdit;
