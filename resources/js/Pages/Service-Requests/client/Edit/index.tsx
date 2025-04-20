import React, { useState } from "react";

import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import DefaultLayout from "../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import VisitorForm from "../../../../components/Forms/Visitor/VisitorForm";
import ContactUsRequestsForm from "../../../../components/Forms/ContactUsRequests/ContactUsRequestsForm";
import ServiceRequestForm from "../../../../components/Forms/Service-Requests/ServiceRequestForm";

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
                "/admin/clients/service-request/final-replay",
                formData,
                {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                }
            );
            if (response.status == 200) {
                toast.success("تم حفظ الملف بنجاح");
                if (formData.get("for_admin") == 2) {
                    router.visit(
                        `/newAdmin/services-requests/for-lawyer/client/${formData.get(
                            "id"
                        )}`
                    );
                } else {
                    router.reload();
                }
            }
        } catch (error) {
            console.log(error);
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
                returnRoute={`/newAdmin/services-requests/client`}
            />
        </DefaultLayout>
    );
}

export default ClientServiceRequestEdit;
