import React, { useState } from "react";

import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import DigitalGuidePackagesForm from "../../../components/Forms/DigitalGuidePackagesForm/DigitalGuidePackagesForm";
import DefaultLayout from "../../../layout/DefaultLayout";
import Breadcrumb from "../../../components/Breadcrumbs/Breadcrumb";

function DigitalGuidePackageCreate() {
    const [errors, setErrors] = useState({});
    async function saveData(data) {
        router.post("/admin/digital-guide/packages/store", data, {
            onError: (err) => {
                setErrors(err);
            },
        });
    }
    return (
        <DefaultLayout>
            <Breadcrumb pageName="اضافة باقة" />
            <DigitalGuidePackagesForm errors={errors} saveData={saveData} />
        </DefaultLayout>
    );
}

export default DigitalGuidePackageCreate;
