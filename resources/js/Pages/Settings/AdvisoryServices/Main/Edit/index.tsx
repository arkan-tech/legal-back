import React, { useRef, useState } from "react";
import ServicesCategoriesSettingsForm from "../../../../../components/Forms/Settings/Services/Categories/ServicesCategoriesSettingsForm";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import BaseSettingsForm from "../../../../../components/Forms/Settings/AdvisoryServices/BaseSettingsForm";
import SuccessNotification from "../../../../../components/SuccessNotification";
import ErrorNotification from "../../../../../components/ErrorNotification";
import AdvisoryServicesMainSettingsForm from "../../../../../components/Forms/Settings/AdvisoryServices/AdvisoryServicesMainSettingsForm";

function AdvisoryServicesMainSettingsEdit({
    generalCategory,
    paymentCategoryTypes,
}) {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState(generalCategory.name || "");
    const [description, setDescription] = useState(
        generalCategory.description || ""
    );
    const [paymentCategoryType, setPaymentCategoryType] = useState(
        generalCategory.payment_category_type_id || ""
    );
    const contentRef = useRef<HTMLDivElement>(null);

    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);

    async function saveData() {
        try {
            const res = await axios.post(
                `/newAdmin/settings/advisory-services/general-categories/${generalCategory.id}/update`,
                {
                    name,
                    description,
                    payment_category_type_id: paymentCategoryType,
                }
            );
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
        <DefaultLayout ref={contentRef}>
            <Breadcrumb pageName="تعديل تخصص عام للأستشارات" />
            {isSuccess && <SuccessNotification classNames="my-2" />}
            {isError && <ErrorNotification classNames="my-2" />}
            <AdvisoryServicesMainSettingsForm
                errors={errors}
                saveData={saveData}
                name={name}
                setName={setName}
                description={description}
                setDescription={setDescription}
                paymentCategoryType={paymentCategoryType}
                setPaymentCategoryType={setPaymentCategoryType}
                paymentCategoryTypes={paymentCategoryTypes}
            />
        </DefaultLayout>
    );
}

export default AdvisoryServicesMainSettingsEdit;
