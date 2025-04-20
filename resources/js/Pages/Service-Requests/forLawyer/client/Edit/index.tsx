import React, { useState } from "react";

import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import ServiceRequestForm from "../../../../../components/Forms/Service-Requests/ServiceRequestForm";

function ClientServiceRequestEdit({ item, advisories, all_lawyers }) {
    console.log(item, advisories, all_lawyers);
    const [errors, setErrors] = useState({});
    item = {
        ...item,
        reserverType: "client",
    };
    const saveData = async (formData) => {
        try {
            const response = await axios.post(
                "/admin/clients/service-request/final-replay/forLawyer",
                formData,
                {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                }
            );
            if (response.status == 200) {
                toast.success("تم احالة الخدمة");
                if (
                    formData.get("for_admin") == 3 ||
                    formData.get("for_admin") == 1
                ) {
                    router.get(
                        `/newAdmin/services-requests/client/${formData.get(
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
            <Breadcrumb pageName="تفاصيل وارد الخدمة" />
            <ServiceRequestForm
                errors={errors}
                saveData={saveData}
                request={item}
                advisories={advisories}
                all_lawyers={all_lawyers}
                disable_replies={true}
                returnRoute={`/newAdmin/services-requests/for-lawyer/client`}
            />
        </DefaultLayout>
    );
}

export default ClientServiceRequestEdit;
