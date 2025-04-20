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
import RankSettingsForm from "../../../../../components/Forms/Settings/Leveling/RankSettingsForm";
import ActivitiesSettingsForm from "../../../../../components/Forms/Settings/Leveling/ActivitiesSettingsForm";

function BaseSettingsEdit({ activity }) {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState(activity?.name || "");
    const [experiencePoints, setExperiencePoints] = useState(
        activity?.experience_points || 0
    );
    const [notification, setNotification] = useState(
        activity?.notification || ""
    );
    const contentRef = useRef<HTMLDivElement>(null);
    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);

    async function saveData() {
        try {
            const res = await axios.post(
                `/newAdmin/settings/gamification/activities/${activity.id}`,
                {
                    name,
                    experience_points: experiencePoints,
                    notification,
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
                <Breadcrumb pageName="تعديل نقاط الأكتساب" />
                {isSuccess && <SuccessNotification classNames="my-2" />}
                {isError && <ErrorNotification classNames="my-2" />}
                <ActivitiesSettingsForm
                    errors={errors}
                    saveData={saveData}
                    name={name}
                    setName={setName}
                    experiencePoints={experiencePoints}
                    setExperiencePoints={setExperiencePoints}
                    notification={notification}
                    setNotification={setNotification}
                />
            </div>
        </DefaultLayout>
    );
}

export default BaseSettingsEdit;
