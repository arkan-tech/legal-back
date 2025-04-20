import React, { useState } from "react";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import AccurateSpecialtyForm from "../../../../../components/Forms/Settings/Signup/AccurateSpecialtyForm";
import FunctionalCasesForm from "../../../../../components/Forms/Settings/Signup/FunctionalCasesForm";

function FunctionatlCasesCreate() {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState("");
    async function saveData() {
        router.post(
            "/admin/functional-cases/store",
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
            <Breadcrumb pageName="اضافة حالة وظيفية" />
            <FunctionalCasesForm
                errors={errors}
                saveData={saveData}
                name={name}
                setName={setName}
            />
        </DefaultLayout>
    );
}

export default FunctionatlCasesCreate;
