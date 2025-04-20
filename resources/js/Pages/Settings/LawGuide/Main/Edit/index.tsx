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
import LawGuideMainCategoryForm from "../../../../../components/Forms/Settings/LawGuideMainCategoryForm";

function MainSettingsEdit({ mainCategory }) {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState(mainCategory.name || "");
    const contentRef = useRef<HTMLDivElement>(null);
    const [nameEn, setNameEn] = useState("");

    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);
    async function saveData() {
        try {
            const res = await axios.post(
                `/newAdmin/settings/law-guide/main/${mainCategory.id}`,
                {
                    name: name,
                    name_en: nameEn,
                }
            );
            if (res.status == 200) {
                setIsSuccess(true);
                contentRef.current?.scrollIntoView({ behavior: "smooth" });
            }
        } catch (err) {
            setErrors(err.response.data.errors);
            setIsError(true);
            contentRef.current?.scrollIntoView({ behavior: "smooth" });
        }
    }
    return (
        <DefaultLayout>
            {" "}
            <div ref={contentRef}>
                <Breadcrumb pageName="تعديل قسم رئيسي" />{" "}
                {isSuccess && <SuccessNotification classNames="my-2" />}
                {isError && <ErrorNotification classNames="my-2" />}
                <LawGuideMainCategoryForm
                    errors={errors}
                    saveData={saveData}
                    name={name}
                    setName={setName}
                    route="law-guide"
                    nameEn={nameEn}
                    setNameEn={setNameEn}
                />{" "}
            </div>
        </DefaultLayout>
    );
}

export default MainSettingsEdit;
