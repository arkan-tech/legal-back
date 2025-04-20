import React, { useRef, useState } from "react";
import ServicesCategoriesSettingsForm from "../../../../../components/Forms/Settings/Services/Categories/ServicesCategoriesSettingsForm";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import ErrorNotification from "../../../../../components/ErrorNotification";
import SuccessNotification from "../../../../../components/SuccessNotification";

function ServicesCategoriesSettingsEdit({ category }) {
    const [errors, setErrors] = useState({});
    const [categoryName, setCategoryName] = useState(category?.name || "");
    const contentRef = useRef<HTMLDivElement>(null);

    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);

    async function saveData() {
        try {
            const res = await axios.post(`/admin/services/categories/update`, {
                id: category.id,
                name: categoryName,
            });
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
    return (
        <DefaultLayout>
            {" "}
            <div ref={contentRef}>
                <Breadcrumb pageName="تعديل قسم الخدمة" />{" "}
                {isSuccess && <SuccessNotification classNames="my-2" />}
                {isError && <ErrorNotification classNames="my-2" />}
                <ServicesCategoriesSettingsForm
                    category={category}
                    errors={errors}
                    saveData={saveData}
                    categoryName={categoryName}
                    setCategoryName={setCategoryName}
                />{" "}
            </div>
        </DefaultLayout>
    );
}

export default ServicesCategoriesSettingsEdit;
