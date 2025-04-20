import React, { useState } from "react";
import ServicesCategoriesSettingsForm from "../../../../../components/Forms/Settings/Services/Categories/ServicesCategoriesSettingsForm";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import JobsSettingsForm from "../../../../../components/Forms/Settings/Signup/JobsSettingsForm";
import GeneralSpecialtyForm from "../../../../../components/Forms/Settings/Signup/GeneralSpecialtyForm";
import AccurateSpecialtyForm from "../../../../../components/Forms/Settings/Signup/AccurateSpecialtyForm";
import FunctionalCasesForm from "../../../../../components/Forms/Settings/Signup/FunctionalCasesForm";

function FunctionalCasesEdit({ functionalCase }) {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState(functionalCase?.title || "");

    async function saveData() {
        try {
            const res = await axios.post(`/admin/functional-cases/update`, {
                id: functionalCase.id,
                name: name,
            });
            if (res.status == 200) {
                toast.success("done");
            }
        } catch (err) {
            return setErrors(err.response.data.errors);
        }
    }
    return (
        <DefaultLayout>
            <Breadcrumb pageName="تعديل الحالة الوظيفية" />
            <FunctionalCasesForm
                errors={errors}
                saveData={saveData}
                name={name}
                setName={setName}
            />
        </DefaultLayout>
    );
}

export default FunctionalCasesEdit;
