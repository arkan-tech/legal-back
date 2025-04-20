import React, { useState } from "react";

import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import MainSettingsForm from "../../../../../components/Forms/Settings/JudicialGuide/MainSettingsForm";

function MainSettingsCreate() {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState("");

    async function saveData() {
        try {
            const res = await axios.post(
                "/newAdmin/settings/books/main/create",
                {
                    name: name,
                }
            );
            if (res.status == 200) {
                toast.success("تم انشاء الملف بنجاح");
                router.get(`/newAdmin/settings/books/main/${res.data.item.id}`);
            }
        } catch (err) {
            setErrors(err.response.data.errors);
        }
    }
    return (
        <DefaultLayout>
            <Breadcrumb pageName="اضافة قسم رئيسي" />
            <MainSettingsForm
                errors={errors}
                saveData={saveData}
                name={name}
                setName={setName}
                route="books/main"
            />
        </DefaultLayout>
    );
}

export default MainSettingsCreate;
