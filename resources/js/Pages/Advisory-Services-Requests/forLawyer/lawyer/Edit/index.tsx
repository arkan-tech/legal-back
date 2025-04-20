import React, { useState } from "react";

import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import ServiceRequestForm from "../../../../../components/Forms/Service-Requests/ServiceRequestForm";
import AdvisoryServiceRequestForm from "../../../../../components/Forms/AdviosryServiceRequestForm";

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
                "/newAdmin/advisory-services-requests/lawyers/final-replay/forLawyer",
                formData,
                {
                    headers: {
                        "Content-Type": "multipart/form-data", // Important to set this header for file uploads
                    },
                }
            );
            if (response.status == 200) {
                toast.success("تم احالة الخدمة");
                if (formData.get("for_admin") != 2) {
                    router.get(
                        `/newAdmin/advisory-services-requests/lawyer/${formData.get(
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
            <Breadcrumb pageName="تفاصيل وارد الأستشارة" />
            <AdvisoryServiceRequestForm
                errors={errors}
                saveData={saveData}
                request={item}
                advisories={advisories}
                all_lawyers={all_lawyers}
                disable_replies={true}
                returnRoute={`/newAdmin/advisory-services-requests/for-lawyer/lawyer`}
            />
        </DefaultLayout>
    );
}

export default LawyerServiceRequestEdit;
