import React, { useState } from "react";

import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import DefaultLayout from "../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import ReservationRequestForm from "../../../../components/Forms/ReservationRequestForm";

function LawyerServiceRequestEdit({ item, advisories, all_lawyers }) {
    console.log(item, advisories, all_lawyers);
    const [errors, setErrors] = useState({});
    item = {
        ...item,
        reserverType: "lawyer",
    };
    const saveData = async (formData) => {
        try {
            const response = await axios.post(
                "/newAdmin/reservations-requests/final-replay",
                formData,
                {
                    headers: {
                        "Content-Type": "multipart/form-data", // Important to set this header for file uploads
                    },
                }
            );
            if (response.status == 200) {
                toast.success("تم الرد على الخدمة");
                if (formData.get("for_admin") == 2) {
                    router.get(
                        `/newAdmin/reservations-requests/for-lawyer/lawyer/${formData.get(
                            "id"
                        )}`
                    );
                } else {
                    router.reload();
                }
            }
        } catch (error) {
            toast.error("حدث خطأ في الرد");
            setErrors(error.response.data.errors);
        }
    };
    return (
        <DefaultLayout>
            <Breadcrumb pageName="تفاصيل وارد الموعد" />
            <ReservationRequestForm
                errors={errors}
                saveData={saveData}
                request={item}
                advisories={advisories}
                all_lawyers={all_lawyers}
                returnRoute={`/newAdmin/reservations-requests/lawyer`}
            />
        </DefaultLayout>
    );
}

export default LawyerServiceRequestEdit;
