import React, { useRef, useState } from "react";

import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import DefaultLayout from "../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import PaymentCategoriesSettingsForm from "../../../../components/Forms/Settings/AdvisoryServices/PaymentCategoriesSettingsForm";
import MainSettingsForm from "../../../../components/Forms/Settings/AdvisoryServices/MainSettingsFrom";
import SuccessNotification from "../../../../components/SuccessNotification";
import ErrorNotification from "../../../../components/ErrorNotification";

function MainSettingsEdit({
    advisoryService,
    paymentCategories,
    paymentCategoriesTypes,
    baseCategories,
}) {
    const [errors, setErrors] = useState({});
    const [needAppointment, setNeedAppointment] = useState(
        advisoryService.need_appointment
    );
    const [selectedPaymentCategory, setSelectedPaymentCategory] = useState(
        advisoryService.payment_category.id
    );
    const [about, setAbout] = useState(advisoryService.description);
    const [instructions, setInstructions] = useState(
        advisoryService.instructions
    );
    const contentRef = useRef<HTMLDivElement>(null);

    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);
    const [selectedPaymentCategoryType, setSelectedPaymentCategoryType] =
        useState(advisoryService.payment_category_type_id);
    const [selectedBase, setSelectedBase] = useState(
        advisoryService.payment_category.advisory_services_base.id || ""
    );
    async function saveData() {
        // console.log(selectedBase);
        try {
            const res = await axios.post(`/admin/advisory-services/update`, {
                id: advisoryService.id,
                payment_category_type_id: selectedPaymentCategoryType,
                need_appointment: needAppointment,
                payment_category_id: selectedPaymentCategory,
                description: about,
                instructions: instructions,
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
            <div ref={contentRef}>
                <Breadcrumb pageName="تعديل وسيلة الأستشارة" />
                {isSuccess && <SuccessNotification classNames="my-2" />}
                {isError && <ErrorNotification classNames="my-2" />}
                <MainSettingsForm
                    errors={errors}
                    saveData={saveData}
                    baseCategories={baseCategories}
                    selectedBase={selectedBase}
                    setSelectedBase={setSelectedBase}
                    selectedPaymentCategoryType={selectedPaymentCategoryType}
                    setSelectedPaymentCategoryType={
                        setSelectedPaymentCategoryType
                    }
                    selectedPaymentCategory={selectedPaymentCategory}
                    setSelectedPaymentCategory={setSelectedPaymentCategory}
                    needAppointment={needAppointment}
                    setNeedAppointment={setNeedAppointment}
                    about={about}
                    setAbout={setAbout}
                    paymentCategories={paymentCategories}
                    instructions={instructions}
                    setInstructions={setInstructions}
                    paymentCategoriesTypes={paymentCategoriesTypes}
                />
            </div>
        </DefaultLayout>
    );
}

export default MainSettingsEdit;
