import React, { useRef, useState } from "react";

import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import DefaultLayout from "../../../layout/DefaultLayout";
import Breadcrumb from "../../../components/Breadcrumbs/Breadcrumb";
import DigitalGuidePackagesForm from "../../../components/Forms/DigitalGuidePackagesForm/DigitalGuidePackagesForm";
import SuccessNotification from "../../../components/SuccessNotification";
import ErrorNotification from "../../../components/ErrorNotification";
import LawyerPayoutForm from "../../../components/Forms/LawyerPayoutForm";

function LawyerPayoutsEdit({ lawyerPayout }) {
    const [payout, setPayout] = useState(lawyerPayout);
    const [errors, setErrors] = useState({});
    const contentRef = useRef<HTMLDivElement>(null);

    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);

    async function saveData(formData) {
        setIsError(false);
        setIsSuccess(false);
        setErrors({});
        try {
            const response = await axios.post("/newAdmin/payouts/update", {
                ...formData,
                id: lawyerPayout.id,
            });
            if (response.status == 200) {
                setIsSuccess(true);
                contentRef.current?.scrollIntoView({ behavior: "smooth" });
                setPayout(response.data.data);
            }
        } catch (err) {
            setErrors(err.response.data.errors);
            setIsError(true);
            contentRef.current?.scrollIntoView({ behavior: "smooth" });
        }
    }
    return (
        <DefaultLayout>
            <div ref={contentRef}>
                <Breadcrumb pageName="تعديل طلب تحويل رصيد" />
                {isSuccess && <SuccessNotification classNames="my-2" />}
                {isError && <ErrorNotification classNames="my-2" />}
                <LawyerPayoutForm
                    errors={errors}
                    saveData={saveData}
                    lawyerPayout={payout}
                />
            </div>
        </DefaultLayout>
    );
}

export default LawyerPayoutsEdit;
