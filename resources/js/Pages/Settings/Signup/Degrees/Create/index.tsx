import React, { useState } from "react";
import ServicesCategoriesSettingsForm from "../../../../../components/Forms/Settings/Services/Categories/ServicesCategoriesSettingsForm";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import JobsSettingsForm from "../../../../../components/Forms/Settings/Signup/JobsSettingsForm";
import DegreesSettingsForm from "../../../../../components/Forms/Settings/Signup/DegreesSettingsForm";

function JobsSettingsCreate() {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState("");
    const [isSpecial, setIsSpecial] = useState(false);
    async function saveData() {
        try {
            console.log("here");
            const res = await axios.post(
                "/newAdmin/settings/signup/degrees/create",
                {
                    name: name,
                    isSpecial,
                }
            );
            if (res.status == 200) {
                router.get(
                    `/newAdmin/settings/signup/degrees/${res.data.item.id}`
                );
            }
        } catch (err) {
            setErrors(err.response.data.errors);
        }
    }
    return (
        <DefaultLayout>
            <Breadcrumb pageName="اضافة درجة علمية" />
            <DegreesSettingsForm
                errors={errors}
                saveData={saveData}
                name={name}
                setName={setName}
                isSpecial={isSpecial}
                setIsSpecial={setIsSpecial}
            />
        </DefaultLayout>
    );
}

export default JobsSettingsCreate;
