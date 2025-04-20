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
import NationalitiesForm from "../../../../../components/Forms/Settings/Signup/NationalitiesForm";
import RegionsForm from "../../../../../components/Forms/Settings/Signup/RegionsForm";

function RegionEdit({ region, countries }) {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState(region?.name || "");
    const [selectedCountry, setSelectedCountry] = useState(
        region?.country_id.toString() || ""
    );
    async function saveData() {
        try {
            const res = await axios.post(`/admin/regions/update`, {
                id: region.id,
                name: name,
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
            <Breadcrumb pageName="تعديل المنطقة" />
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

export default RegionEdit;
