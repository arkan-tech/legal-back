import React, { useRef, useState } from "react";
import ServicesCategoriesSettingsForm from "../../../../../components/Forms/Settings/Services/Categories/ServicesCategoriesSettingsForm";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import BaseSettingsForm from "../../../../../components/Forms/Settings/AdvisoryServices/BaseSettingsForm";
import PaymentCategoriesSettingsForm from "../../../../../components/Forms/Settings/AdvisoryServices/PaymentCategoriesSettingsForm";
import ErrorNotification from "../../../../../components/ErrorNotification";
import SuccessNotification from "../../../../../components/SuccessNotification";

function PaymentCategoriesSettingsEdit({ paymentCategory, base }) {
    console.log(paymentCategory);
    const [errors, setErrors] = useState({});
    const [paymentCategoryName, setPaymentCategoryName] = useState(
        paymentCategory?.name || ""
    );
    const [selectedBase, setSelectedBase] = useState(
        paymentCategory?.advisory_service_base_id || ""
    );
    const [paymentMethod, setPaymentMethod] = useState(
        paymentCategory?.payment_method || ""
    );
    const contentRef = useRef<HTMLDivElement>(null);

    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);
    async function saveData() {
        try {
            const res = await axios.post(
                `/admin/advisory-services/payment-categories/update`,
                {
                    id: paymentCategory.id,
                    name: paymentCategoryName,
                    payment_method: paymentMethod,
                    advisory_service_base_id: selectedBase,
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
        <DefaultLayout>
            <div ref={contentRef}>
                <Breadcrumb pageName="تعديل باقة الأستشارة" />
                {isSuccess && <SuccessNotification classNames="my-2" />}
                {isError && <ErrorNotification classNames="my-2" />}
                <PaymentCategoriesSettingsForm
                    errors={errors}
                    saveData={saveData}
                    paymentCategoryName={paymentCategoryName}
                    setPaymentCategoryName={setPaymentCategoryName}
                    selectedBase={selectedBase}
                    setSelectedBase={setSelectedBase}
                    paymentMethod={paymentMethod}
                    setPaymentMethod={setPaymentMethod}
                    base={base}
                />
            </div>
        </DefaultLayout>
    );
}

export default PaymentCategoriesSettingsEdit;
