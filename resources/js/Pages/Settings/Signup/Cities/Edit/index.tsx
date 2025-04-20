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
import CitiesForm from "../../../../../components/Forms/Settings/Signup/CitiesForm";

function CityEdit({ countries, regions, city }) {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState(city?.title || "");
    const [selectedCountry, setSelectedCountry] = useState(
        city?.country_id || ""
    );
    const [selectedRegion, setSelectedRegion] = useState(city?.region_id || "");
    async function saveData() {
        try {
            const res = await axios.post(`/admin/cities/update`, {
                id: city.id,
                name: name,
                region_id: selectedRegion,
                country_id: selectedCountry,
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
            <Breadcrumb pageName="تعديل المدينة" />
            <CitiesForm
                errors={errors}
                saveData={saveData}
                name={name}
                setName={setName}
                selectedCountry={selectedCountry}
                countries={countries}
                regions={regions}
                selectedRegion={selectedRegion}
                setSelectedCountry={setSelectedCountry}
                setSelectedRegion={setSelectedRegion}
            />
        </DefaultLayout>
    );
}

export default CityEdit;
