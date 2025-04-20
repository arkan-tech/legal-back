import React, { useState } from "react";

import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import MainSettingsForm from "../../../../../components/Forms/Settings/JudicialGuide/MainSettingsForm";

function MainSettingsCreate({ countries }) {
    console.log(countries);

    const [errors, setErrors] = useState({});
    const [name, setName] = useState("");
    const [selectedCountry, setSelectedCountry] = useState("");

    async function saveData() {
        try {
            const res = await axios.post(
                "/newAdmin/settings/judicial-guide/main/create",
                {
                    name: name,
                    country_id: selectedCountry,
                }
            );
            if (res.status == 200) {
                toast.success("تم انشاء الملف بنجاح");
                router.get(
                    `/newAdmin/settings/judicial-guide/main/${res.data.item.id}`
                );
            }
        } catch (err) {
            setErrors(err.response.data.errors);
        }
    }
    return (
        <DefaultLayout>
            <Breadcrumb pageName="اضافة نوع محكمة" />
            <MainSettingsForm
                errors={errors}
                saveData={saveData}
                name={name}
                setName={setName}
                selectedCountry={selectedCountry}
                setSelectedCountry={setSelectedCountry}
                countries={countries}
            />
        </DefaultLayout>
    );
}

export default MainSettingsCreate;
