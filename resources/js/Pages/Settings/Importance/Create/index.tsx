import React, { useState } from "react";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import DefaultLayout from "../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import ImportanceSettingsForm from "../../../../components/Forms/Settings/Importance/ImportanceSettingsForm";

function ImportanceSettingsCreate({}) {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState("");

    async function saveData() {
        try {
            const res = await axios.post(
                `/newAdmin/settings/importance/create`,
                {
                    title: name,
                }
            );
            if (res.status == 200) {
                toast.success("done");
                router.visit("/newAdmin/settings/importance");
            }
        } catch (err) {
            return setErrors(err.response.data.errors);
        }
    }
    return (
        <DefaultLayout>
            <Breadcrumb pageName="تعديل المستوى" />
            <ImportanceSettingsForm
                errors={errors}
                saveData={saveData}
                name={name}
                setName={setName}
            />
        </DefaultLayout>
    );
}

export default ImportanceSettingsCreate;
