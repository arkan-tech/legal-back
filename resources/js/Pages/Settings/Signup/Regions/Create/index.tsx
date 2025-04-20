import React, { useState } from "react";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import AccurateSpecialtyForm from "../../../../../components/Forms/Settings/Signup/AccurateSpecialtyForm";
import NationalitiesForm from "../../../../../components/Forms/Settings/Signup/NationalitiesForm";
import RegionsForm from "../../../../../components/Forms/Settings/Signup/RegionsForm";

function RegionsCreate({ countries }) {
    console.log(countries);
    const [errors, setErrors] = useState({});
    const [name, setName] = useState("");
    const [selectedCountry, setSelectedCountry] = useState("");
    async function saveData() {
        router.post(
            "/admin/regions/store",
            {
                name: name,
                country_id: selectedCountry,
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
            <Breadcrumb pageName="اضافة منطقة" />
            <RegionsForm
                errors={errors}
                countries={countries}
                saveData={saveData}
                name={name}
                setName={setName}
                selectedCountry={selectedCountry}
                setSelectedCountry={setSelectedCountry}
            />
        </DefaultLayout>
    );
}

export default RegionsCreate;
