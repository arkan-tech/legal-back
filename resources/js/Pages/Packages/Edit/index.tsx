import React, { useRef, useState } from "react";

import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import DefaultLayout from "../../../layout/DefaultLayout";
import Breadcrumb from "../../../components/Breadcrumbs/Breadcrumb";
import DigitalGuidePackagesForm from "../../../components/Forms/DigitalGuidePackagesForm/DigitalGuidePackagesForm";
import SuccessNotification from "../../../components/SuccessNotification";
import ErrorNotification from "../../../components/ErrorNotification";

function DigitalGuidePackageEdit({ packageDetails }) {
    const [errors, setErrors] = useState({});
    const contentRef = useRef<HTMLDivElement>(null);

    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);

    async function saveData(formData) {
        try {
            const response = await axios.post(
                "/admin/digital-guide/packages/update",
                {
                    ...formData,
                    id: packageDetails.id,
                }
            );
            if (response.status == 200) {
                toast.success("تم تعديل الباقة بنجاح");
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
            <div ref={contentRef}>
                <Breadcrumb pageName="تعديل باقة" />
                {isSuccess && <SuccessNotification classNames="my-2" />}
                {isError && <ErrorNotification classNames="my-2" />}
                <DigitalGuidePackagesForm
                    errors={errors}
                    saveData={saveData}
                    packageDetails={packageDetails}
                />
            </div>
        </DefaultLayout>
    );
}

export default DigitalGuidePackageEdit;
