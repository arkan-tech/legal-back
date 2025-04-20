import React, { useState } from "react";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import AccurateSpecialtyForm from "../../../../../components/Forms/Settings/Signup/AccurateSpecialtyForm";
import CountriesForm from "../../../../../components/Forms/Settings/Signup/CountriesForm";
import CitiesForm from "../../../../../components/Forms/Settings/Signup/CitiesForm";

function CitiesCreate({ countries, regions }) {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState("");
    const [selectedCountry, setSelectedCountry] = useState("");
    const [selectedRegion, setSelectedRegion] = useState("");
    async function saveData() {
        router.post(
            "/admin/cities/store",
            {
                name: name,
                country_id: selectedCountry,
                region_id: selectedRegion,
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
            <Breadcrumb pageName="اضافة مدينة" />
            <CitiesForm
                errors={errors}
                saveData={saveData}
                name={name}
                setName={setName}
                selectedCountry={selectedCountry}
                setSelectedCountry={setSelectedCountry}
                selectedRegion={selectedRegion}
                setSelectedRegion={setSelectedRegion}
                countries={countries}
                regions={regions}
            />
        </DefaultLayout>
    );
}

export default CitiesCreate;
