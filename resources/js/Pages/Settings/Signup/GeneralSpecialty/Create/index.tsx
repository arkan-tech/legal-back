import React, { useState } from "react";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import GeneralSpecialtyForm from "../../../../../components/Forms/Settings/Signup/GeneralSpecialtyForm";

function GeneralSpecialtyCreate() {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState("");
    async function saveData() {
        router.post(
            "/admin/general-specialty/store",
            {
                name: name,
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
            <Breadcrumb pageName="اضافة تخصص دقيق" />
            <GeneralSpecialtyForm
                errors={errors}
                saveData={saveData}
                name={name}
                setName={setName}
            />
        </DefaultLayout>
    );
}

export default GeneralSpecialtyCreate;
