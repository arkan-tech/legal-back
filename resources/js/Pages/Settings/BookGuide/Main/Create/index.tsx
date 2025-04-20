import React, { useState } from "react";

import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import MainSettingsForm from "../../../../../components/Forms/Settings/JudicialGuide/MainSettingsForm";
import LawGuideMainCategoryForm from "../../../../../components/Forms/Settings/LawGuideMainCategoryForm";

function MainSettingsCreate() {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState("");
    const [nameEn, setNameEn] = useState("");

    async function saveData() {
        try {
            const res = await axios.post(
                "/newAdmin/settings/book-guide/main/create",
                {
                    name_ar: name,
                    name_en: nameEn,
                }
            );
            if (res.status == 200) {
                toast.success("تم انشاء الملف بنجاح");
                router.get(
                    `/newAdmin/settings/book-guide/main/${res.data.item.id}`
                );
            }
        } catch (err) {
            setErrors(err.response.data.errors);
        }
    }
    return (
        <DefaultLayout>
            <Breadcrumb pageName="اضافة قسم رئيسي" />
            <LawGuideMainCategoryForm
                errors={errors}
                saveData={saveData}
                name={name}
                setName={setName}
                route="book-guide"
                nameEn={nameEn}
                setNameEn={setNameEn}
            />
        </DefaultLayout>
    );
}

export default MainSettingsCreate;
