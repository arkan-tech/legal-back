import React, { useState } from "react";

import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import DefaultLayout from "../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import PaymentCategoriesSettingsForm from "../../../../components/Forms/Settings/AdvisoryServices/PaymentCategoriesSettingsForm";
import MainSettingsForm from "../../../../components/Forms/Settings/AdvisoryServices/MainSettingsFrom";

function MainSettingsCreate({
    paymentCategories,
    paymentCategoriesTypes,
    baseCategories,
}) {
    const [errors, setErrors] = useState({});
    const [needAppointment, setNeedAppointment] = useState(false);
    const [selectedPaymentCategory, setSelectedPaymentCategory] = useState("");
    const [about, setAbout] = useState("");
    const [instructions, setInstructions] = useState("");
    const [selectedPaymentCategoryType, setSelectedPaymentCategoryType] =
        useState("");
    const [selectedBase, setSelectedBase] = useState("");
    async function saveData() {
        // console.log(selectedBase);
        router.post(
            "/admin/advisory-services/store",
            {
                payment_category_type_id: selectedPaymentCategoryType,
                description: about,
                need_appointment: needAppointment == true ? "on" : "off",
                payment_category_id: selectedPaymentCategory,
                instructions,
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
            <Breadcrumb pageName="اضافة وسيلة استشارة" />
            <MainSettingsForm
                errors={errors}
                saveData={saveData}
                baseCategories={baseCategories}
                selectedBase={selectedBase}
                setSelectedBase={setSelectedBase}
                selectedPaymentCategoryType={selectedPaymentCategoryType}
                setSelectedPaymentCategoryType={setSelectedPaymentCategoryType}
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
        </DefaultLayout>
    );
}

export default MainSettingsCreate;
