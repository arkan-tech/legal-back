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
import CountriesForm from "../../../../../components/Forms/Settings/Signup/CountriesForm";

function AccurateSpecialtyEdit({ country }) {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState(country?.name || "");
    const [phoneCode, setPhoneCode] = useState(
        country?.phone_code?.toString() || ""
    );
    async function saveData() {
        try {
            const res = await axios.post(`/admin/countries/update`, {
                id: country.id,
                name: name,
                phone_code: phoneCode,
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
            <Breadcrumb pageName="تعديل الدولة" />
            <CountriesForm
                errors={errors}
                saveData={saveData}
                name={name}
                setName={setName}
                phoneCode={phoneCode}
                setPhoneCode={setPhoneCode}
            />
        </DefaultLayout>
    );
}

export default AccurateSpecialtyEdit;
