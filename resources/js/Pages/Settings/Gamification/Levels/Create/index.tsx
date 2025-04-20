import React, { useState } from "react";

import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import BaseSettingsForm from "../../../../../components/Forms/Settings/AdvisoryServices/BaseSettingsForm";
import LevelSettingsForm from "../../../../../components/Forms/Settings/Leveling/LevelSettingsForm";

function BaseSettingsCreate() {
    const [errors, setErrors] = useState({});
    const [levelName, setLevelName] = useState(0);
    const [pointsNeeded, setPointsNeeded] = useState(0);

    async function saveData() {
        try {
            const res = await axios.post(
                "/newAdmin/settings/gamification/levels/create",
                {
                    level_number: levelName,
                    required_experience: pointsNeeded,
                }
            );
            if (res.status == 200) {
                toast.success("تم انشاء الملف بنجاح");
                router.get(
                    `/newAdmin/settings/gamification/levels/${res.data.item.id}`
                );
            }
        } catch (err) {
            setErrors(err.response.data.errors);
        }
    }
    return (
        <DefaultLayout>
            <Breadcrumb pageName="اضافة مستوى" />
            <LevelSettingsForm
                errors={errors}
                saveData={saveData}
                levelName={levelName}
                setLevelName={setLevelName}
                pointsNeeded={pointsNeeded}
                setPointsNeeded={setPointsNeeded}
            />
        </DefaultLayout>
    );
}

export default BaseSettingsCreate;
