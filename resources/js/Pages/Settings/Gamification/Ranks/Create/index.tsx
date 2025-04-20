import React, { useState } from "react";

import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import RankSettingsForm from "../../../../../components/Forms/Settings/Leveling/RankSettingsForm";

function BaseSettingsCreate() {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState("");
    const [minLevel, setMinLevel] = useState(0);
    const [borderColor, setBorderColor] = useState("");
    const [image, setImage] = useState(null);
    async function saveData() {
        try {
            const formData = new FormData();
            formData.append("name", name);
            formData.append("min_level", minLevel.toString());
            formData.append("border_color", borderColor);
            if (image) {
                formData.append("image", image);
            }

            const res = await axios.post(
                "/newAdmin/settings/gamification/ranks/create",
                formData
            );
            if (res.status == 200) {
                toast.success("تم انشاء الملف بنجاح");
                router.get(
                    `/newAdmin/settings/gamification/ranks/${res.data.item.id}`
                );
            }
        } catch (err) {
            setErrors(err.response.data.errors);
        }
    }
    return (
        <DefaultLayout>
            <Breadcrumb pageName="اضافة رتبة" />
            <RankSettingsForm
                errors={errors}
                saveData={saveData}
                name={name}
                setName={setName}
                minLevel={minLevel}
                setMinLevel={setMinLevel}
                borderColor={borderColor}
                image={image}
                setBorderColor={setBorderColor}
                setImage={setImage}
            />
        </DefaultLayout>
    );
}

export default BaseSettingsCreate;
