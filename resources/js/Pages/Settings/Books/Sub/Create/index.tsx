import React, { useState } from "react";

import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import BaseSettingsForm from "../../../../../components/Forms/Settings/AdvisoryServices/BaseSettingsForm";
import PaymentCategoriesSettingsForm from "../../../../../components/Forms/Settings/AdvisoryServices/PaymentCategoriesSettingsForm";
import SubSettingsForm from "../../../../../components/Forms/Settings/Books/SubSettingsForm";

function BaseSettingsCreate({ mainCategories, countries, cities, regions }) {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState("");
    const [selectedMainCategory, setSelectedMainCategory] = useState("");

    async function saveData() {
        try {
            const res = await axios.post(
                "/newAdmin/settings/books/sub/create",
                {
                    name: name,
                    mainCategoryId: selectedMainCategory,
                }
            );
            if (res.status == 200) {
                toast.success("تم انشاء الملف بنجاح");
                router.get(`/newAdmin/settings/books/sub/${res.data.item.id}`);
            }
        } catch (err) {
            setErrors(err.response.data.errors);
        }
    }
    return (
        <DefaultLayout>
            <Breadcrumb pageName="اضافة قسم فرعي" />
            <SubSettingsForm
                errors={errors}
                saveData={saveData}
                name={name}
                setName={setName}
                selectedMainCategory={selectedMainCategory}
                setSelectedMainCategory={setSelectedMainCategory}
                mainCategories={mainCategories}
            />
        </DefaultLayout>
    );
}

export default BaseSettingsCreate;
