import React, { useState } from "react";
import ServicesCategoriesSettingsForm from "../../../../../components/Forms/Settings/Services/Categories/ServicesCategoriesSettingsForm";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";

function ServicesCategoriesSettingsEdit() {
    const [errors, setErrors] = useState({});
    const [categoryName, setCategoryName] = useState("");

    async function saveData() {
        router.post(
            "/admin/services/categories/store",
            {
                name: categoryName,
            },
            {
                onError: (err) => {
                    setErrors(err);
                },
            }
        );
    }
    return (
        <DefaultLayout>
            <Breadcrumb pageName="اضافة قسم الخدمة" />
            <ServicesCategoriesSettingsForm
                errors={errors}
                saveData={saveData}
                categoryName={categoryName}
                setCategoryName={setCategoryName}
            />
        </DefaultLayout>
    );
}

export default ServicesCategoriesSettingsEdit;
