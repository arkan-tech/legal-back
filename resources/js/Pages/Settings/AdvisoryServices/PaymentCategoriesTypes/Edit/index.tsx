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
import PaymentCategoriesTypesForm from "../../../../../components/Forms/Settings/AdvisoryServices/PaymentCategoriesTypesForm";

function BaseSettingsEdit({ paymentCategoriesType }) {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState(paymentCategoriesType?.name || "");
    const [description, setDescription] = useState(
        paymentCategoriesType?.description || ""
    );
    const [requiresAppointment, setRequiresAppointment] = useState(
        paymentCategoriesType?.requires_appointment || false
    );
    const contentRef = useRef<HTMLDivElement>(null);

    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);

    async function saveData() {
        try {
            setIsError(false);
            setIsSuccess(false);
            setErrors({});
            const res = await axios.post(
                `/newAdmin/settings/advisory-services/payment-categories-types/${paymentCategoriesType.id}`,
                {
                    name: name,
                    description: description,
                    requires_appointment: requiresAppointment,
                }
            );
            if (res.status == 200) {
                setIsSuccess(true);
                contentRef.current?.scroll({
                    top: 0,
                    behavior: "smooth",
                });
            }
        } catch (err) {
            setIsError(true);
            contentRef.current?.scroll({
                top: 0,
                behavior: "smooth",
            });
            return setErrors(err.response.data.errors);
        }
    }
    return (
        <DefaultLayout ref={contentRef}>
            <Breadcrumb pageName="تعديل نوع الوسيلة" />
            {isSuccess && <SuccessNotification classNames="my-2" />}
            {isError && <ErrorNotification classNames="my-2" />}
            <PaymentCategoriesTypesForm
                errors={errors}
                saveData={saveData}
                name={name}
                setName={setName}
                description={description}
                setDescription={setDescription}
                requiresAppointment={requiresAppointment}
                setRequiresAppointment={setRequiresAppointment}
            />
        </DefaultLayout>
    );
}

export default BaseSettingsEdit;
