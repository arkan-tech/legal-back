import React, { useState } from "react";

import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import DefaultLayout from "../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import PaymentCategoriesSettingsForm from "../../../../components/Forms/Settings/AdvisoryServices/PaymentCategoriesSettingsForm";
import MainSettingsForm from "../../../../components/Forms/Settings/AdvisoryServices/MainSettingsFrom";
import JudicialGuideSettingsForm from "../../../../components/Forms/Settings/JudicialGuide/JudicialGuideSettingsForm";
import BooksSettingsForm from "../../../../components/Forms/Settings/Books/BooksSettingsForm";
import BannersForm from "../../../../components/Forms/Settings/BannersForm";

function BannersCreate() {
    const [errors, setErrors] = useState({});
    const [expiresAt, setExpiresAt] = useState("");
    const [file, setFile] = useState(null);
    const [progress, setProgress] = useState(0);
    async function saveData() {
        const formData = new FormData();
        if (file) {
            formData.append("image", file);
        }
        formData.append("expires_at", expiresAt);

        try {
            const res = await axios.post(
                "/newAdmin/settings/banners/create",
                formData,
                {
                    onUploadProgress: (event) => {
                        const percent = Math.floor(
                            (event.loaded * 100) / event.total!
                        );
                        setProgress(percent);
                    },
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                }
            );
            if (res.status == 200) {
                toast.success("تم انشاء الملف بنجاح");
                router.get(`/newAdmin/settings/banners/${res.data.item.id}`);
            }
        } catch (err) {
            setErrors(err.response.data.errors);
        }
    }
    return (
        <DefaultLayout>
            <Breadcrumb pageName="اضافة بانر" />
            <BannersForm
                errors={errors}
                saveData={saveData}
                expiresAt={expiresAt}
                setExpiresAt={setExpiresAt}
                setFile={setFile}
                file={file}
                progress={progress}
            />
        </DefaultLayout>
    );
}

export default BannersCreate;
