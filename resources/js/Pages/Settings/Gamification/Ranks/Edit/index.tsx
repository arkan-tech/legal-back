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

function BaseSettingsEdit({ rank }) {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState(rank?.name || "");
    const [minLevel, setMinLevel] = useState(rank?.min_level || 0);
    const [borderColor, setBorderColor] = useState(rank?.border_color || "");
    const [image, setImage] = useState(rank?.image || null);
    const contentRef = useRef<HTMLDivElement>(null);
    console.log(rank);
    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);

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
                `/newAdmin/settings/gamification/ranks/${rank.id}`,
                formData
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
                <Breadcrumb pageName="تعديل رتبة" />
                {isSuccess && <SuccessNotification classNames="my-2" />}
                {isError && <ErrorNotification classNames="my-2" />}
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
            </div>
        </DefaultLayout>
    );
}

export default BaseSettingsEdit;
