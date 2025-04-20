import React, { useRef, useState } from "react";
import ServicesCategoriesSettingsForm from "../../../../../components/Forms/Settings/Services/Categories/ServicesCategoriesSettingsForm";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import BaseSettingsForm from "../../../../../components/Forms/Settings/AdvisoryServices/BaseSettingsForm";
import SuccessNotification from "../../../../../components/SuccessNotification";
import ErrorNotification from "../../../../../components/ErrorNotification";
import LevelSettingsForm from "../../../../../components/Forms/Settings/Leveling/LevelSettingsForm";

function BaseSettingsEdit({ level }) {
    const [errors, setErrors] = useState({});
    const [levelName, setLevelName] = useState(level?.level_number || 0);
    const [pointsNeeded, setPointsNeeded] = useState(
        level?.required_experience || 0
    );
    const contentRef = useRef<HTMLDivElement>(null);

    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);

    async function saveData() {
        try {
            const res = await axios.post(
                `/newAdmin/settings/gamification/levels/${level.id}`,
                {
                    level_number: levelName,
                    required_experience: pointsNeeded,
                }
            );
            if (res.status == 200) {
                setIsSuccess(true);
                contentRef.current?.scrollIntoView({ behavior: "smooth" });
            }
        } catch (err) {
            setIsError(true);
            contentRef.current?.scrollIntoView({ behavior: "smooth" });
            return setErrors(err.response.data.errors);
        }
    }
    return (
        <DefaultLayout>
            <div ref={contentRef}>
                <Breadcrumb pageName="تعديل مستوى" />
                {isSuccess && <SuccessNotification classNames="my-2" />}
                {isError && <ErrorNotification classNames="my-2" />}
                <LevelSettingsForm
                    errors={errors}
                    saveData={saveData}
                    levelName={levelName}
                    setLevelName={setLevelName}
                    pointsNeeded={pointsNeeded}
                    setPointsNeeded={setPointsNeeded}
                />
            </div>
        </DefaultLayout>
    );
}

export default BaseSettingsEdit;
