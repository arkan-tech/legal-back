import React, { useRef, useState } from "react";

import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import DefaultLayout from "../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import PaymentCategoriesSettingsForm from "../../../../components/Forms/Settings/AdvisoryServices/PaymentCategoriesSettingsForm";
import MainSettingsForm from "../../../../components/Forms/Settings/AdvisoryServices/MainSettingsFrom";
import JudicialGuideSettingsForm from "../../../../components/Forms/Settings/JudicialGuide/JudicialGuideSettingsForm";
import ErrorNotification from "../../../../components/ErrorNotification";
import SuccessNotification from "../../../../components/SuccessNotification";
import BooksSettingsForm from "../../../../components/Forms/Settings/Books/BooksSettingsForm";
import BannersForm from "../../../../components/Forms/Settings/BannersForm";

function BannersEdit({ banner }) {
    const [errors, setErrors] = useState({});

    const contentRef = useRef<HTMLDivElement>(null);
    const [file, setFile] = useState(banner.image || null);
    const [expiresAt, setExpiresAt] = useState(banner.expires_at || null);
    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);
    const [progress, setProgress] = useState(0);

    async function saveData() {
        const formData = new FormData();
        if (file && typeof file != "string") {
            formData.append("image", file);
        }

        formData.append("expires_at", expiresAt);
        console.log(formData);
        try {
            const res = await axios.post(
                `/newAdmin/settings/banners/${banner.id}`,
                formData,
                {
                    onUploadProgress: (event) => {
                        const percent = Math.floor(
                            (event.loaded * 100) / event.total!
                        );
                        setProgress(percent);
                    },
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
            <div ref={contentRef}>
                <Breadcrumb pageName="تعديل الكتاب " />
                {isSuccess && <SuccessNotification classNames="my-2" />}
                {isError && <ErrorNotification classNames="my-2" />}
                <BannersForm
                    errors={errors}
                    saveData={saveData}
                    file={file}
                    setFile={setFile}
                    expiresAt={expiresAt}
                    setExpiresAt={setExpiresAt}
                    progress={progress}
                />
            </div>
        </DefaultLayout>
    );
}

export default BannersEdit;
