import React, { useRef, useState } from "react";

import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import BaseSettingsForm from "../../../../../components/Forms/Settings/AdvisoryServices/BaseSettingsForm";
import MainSettingsForm from "../../../../../components/Forms/Settings/JudicialGuide/MainSettingsForm";
import SuccessNotification from "../../../../../components/SuccessNotification";
import ErrorNotification from "../../../../../components/ErrorNotification";

function MainSettingsEdit({ mainCategory, countries }) {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState(mainCategory.name || "");
    const contentRef = useRef<HTMLDivElement>(null);
    const [selectedCountry, setSelectedCountry] = useState(
        mainCategory?.country_id
    );
    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);
    async function saveData() {
        try {
            const res = await axios.post(
                `/newAdmin/settings/judicial-guide/main/${mainCategory.id}`,
                {
                    name: name,
                    country_id: selectedCountry,
                }
            );
            if (res.status == 200) {
                setIsSuccess(true);
                contentRef.current?.scroll({ top: 0 });
            }
        } catch (err) {
            setErrors(err.response.data.errors);
            setIsError(true);
            contentRef.current?.scroll({ top: 0 });
        }
    }
    return (
        <DefaultLayout ref={contentRef}>
            <Breadcrumb pageName="تعديل نوع محكمة" />{" "}
            {isSuccess && <SuccessNotification classNames="my-2" />}
            {isError && <ErrorNotification classNames="my-2" />}
            <MainSettingsForm
                errors={errors}
                saveData={saveData}
                name={name}
                setName={setName}
                selectedCountry={selectedCountry}
                setSelectedCountry={setSelectedCountry}
                countries={countries}
            />
        </DefaultLayout>
    );
}

export default MainSettingsEdit;
