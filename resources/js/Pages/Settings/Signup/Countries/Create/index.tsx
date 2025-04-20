import React, { useState } from "react";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import AccurateSpecialtyForm from "../../../../../components/Forms/Settings/Signup/AccurateSpecialtyForm";
import CountriesForm from "../../../../../components/Forms/Settings/Signup/CountriesForm";

function AccurateSpecialtyCreate() {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState("");
    const [phoneCode, setPhoneCode] = useState("");

    async function saveData() {
        router.post(
            "/admin/countries/store",
            {
                name: name,
                phone_code: phoneCode,
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
            <Breadcrumb pageName="اضافة دولة" />
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

export default AccurateSpecialtyCreate;
