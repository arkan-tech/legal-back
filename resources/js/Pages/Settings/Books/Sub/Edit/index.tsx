import React, { useRef, useState } from "react";
import ServicesCategoriesSettingsForm from "../../../../../components/Forms/Settings/Services/Categories/ServicesCategoriesSettingsForm";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import BaseSettingsForm from "../../../../../components/Forms/Settings/AdvisoryServices/BaseSettingsForm";
import PaymentCategoriesSettingsForm from "../../../../../components/Forms/Settings/AdvisoryServices/PaymentCategoriesSettingsForm";
import SuccessNotification from "../../../../../components/SuccessNotification";
import ErrorNotification from "../../../../../components/ErrorNotification";
import SubSettingsForm from "../../../../../components/Forms/Settings/Books/SubSettingsForm";

function SubSettingsEdit({ mainCategories, subCategory }) {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState(subCategory?.name || "");
    const [selectedMainCategory, setSelectedMainCategory] = useState(
        subCategory?.main_category.id || ""
    );
    const contentRef = useRef<HTMLDivElement>(null);

    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);
    async function saveData() {
        setIsSuccess(false);
        setIsError(false);
        try {
            const res = await axios.post(
                `/newAdmin/settings/books/sub/${subCategory.id}`,
                {
                    name: name,
                    mainCategoryId: selectedMainCategory,
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
                <Breadcrumb pageName="تعديل قسم فرعي" />
                {isSuccess && <SuccessNotification classNames="my-2" />}
                {isError && <ErrorNotification classNames="my-2" />}
                <SubSettingsForm
                    errors={errors}
                    saveData={saveData}
                    name={name}
                    setName={setName}
                    selectedMainCategory={selectedMainCategory}
                    setSelectedMainCategory={setSelectedMainCategory}
                    mainCategories={mainCategories}
                />
            </div>
        </DefaultLayout>
    );
}

export default SubSettingsEdit;
