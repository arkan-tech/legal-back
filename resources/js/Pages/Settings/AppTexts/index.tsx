import React, { useRef, useState } from "react";

import MainSettingsTable from "../../../components/Tables/Settings/AdvisoryServices/MainSettingsTable";
import Breadcrumb from "../../../components/Breadcrumbs/Breadcrumb";
import DefaultLayout from "../../../layout/DefaultLayout";
import DeleteModal from "../../../components/Modals/DeleteModal";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import JudicialGuideSettingsTable from "../../../components/Tables/Settings/JudicialGuide/JudicialGuideSettings";
import BooksSettingsTable from "../../../components/Tables/Settings/Books/BooksSettingsTable";
import UnifiedTable from "../../../components/Tables/UnifiedTable";
import BannersTable from "../../../components/Tables/BannersTable";
import { GetArabicDateTime } from "../../../helpers/DateFunctions";
import IdentityForm from "../../../components/Forms/Settings/IdentityForm";
import { now } from "moment";
import AppTextsForm from "../../../components/Forms/Settings/AppTextsForm";
import SuccessNotification from "../../../components/SuccessNotification";
import ErrorNotification from "../../../components/ErrorNotification";

const AppTextsSettings = ({ appTexts }) => {
    console.log("apptexts", appTexts);
    const [errors, setErrors] = useState({});
    const [settings, setSettings] = useState([
        {
            key: "confirm-email-link",
            title: "رابط تأكيد البريد الألكتروني",
            content:
                appTexts.find((at) => at.key == "confirm-email-link")?.value ||
                "",
        },
        {
            key: "welcome-message-sms",
            title: "رسالة الترحيب بالرسائل النصية",
            content:
                appTexts.find((at) => at.key == "welcome-message-sms")?.value ||
                "",
        },
        {
            key: "email-otp-message",
            title: "رسالة البريد الألكتروني OTP",
            content:
                appTexts.find((at) => at.key == "email-otp-message")?.value ||
                "",
        },
        {
            key: "completed-profile-email-message",
            title: "رسالة البريد الألكتروني للملف الشخصي المكتمل",
            content:
                appTexts.find(
                    (at) => at.key == "completed-profile-email-message"
                )?.value || "",
        },
        {
            key: "forget-password-email-message",
            title: "رسالة البريد الألكتروني لنسيان كلمة المرور",
            content:
                appTexts.find((at) => at.key == "forget-password-email-message")
                    ?.value || "",
        },
        {
            key: "account-blocked",
            title: "رسالة الحساب المحظور",
            content:
                appTexts.find((at) => at.key == "account-blocked")?.value || "",
        },
        {
            key: "account-new",
            title: "رسالة الحساب الجديد",
            content:
                appTexts.find((at) => at.key == "account-new")?.value || "",
        },
        {
            key: "account-accepted",
            title: "رسالة الحساب المقبول",
            content:
                appTexts.find((at) => at.key == "account-accepted")?.value ||
                "",
        },
        {
            key: "account-pending",
            title: "رسالة الحساب قيد الانتظار",
            content:
                appTexts.find((at) => at.key == "account-pending")?.value || "",
        },
    ]);

    const handleContentChange = (index, content) => {
        const updatedSettings = [...settings];
        updatedSettings[index].content = content;
        setSettings(updatedSettings);
    };
    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);
    const [progress, setProgress] = useState(0);
    const contentRef = useRef<HTMLDivElement>(null);

    async function saveData() {
        setIsSuccess(false);
        setIsError(false);
        const data = settings.map((setting) => ({
            key: setting.key,
            value: setting.content,
        }));

        try {
            contentRef.current?.scroll({ top: 0, behavior: "smooth" });
            const res = await axios.post(
                "/newAdmin/settings/app-texts/update",
                {
                    data,
                },
                {
                    onUploadProgress: (event) => {
                        const percent = Math.floor(
                            (event.loaded * 100) / event.total!
                        );
                        setProgress(percent);
                    },
                }
            );
            if (res.status == 200) {
                setIsSuccess(true);
                contentRef.current?.scroll({ top: 0, behavior: "smooth" });
            }
        } catch (err) {
            setErrors(err.response.data.errors);
            setIsError(true);
            contentRef.current?.scroll({ top: 0, behavior: "smooth" });
        }
    }

    return (
        <>
            <DefaultLayout ref={contentRef}>
                <Breadcrumb pageName="اعدادات الهوية" />
                {isSuccess && <SuccessNotification classNames="my-2" />}
                {isError && <ErrorNotification classNames="my-2" />}

                <AppTextsForm
                    saveData={saveData}
                    errors={errors}
                    settings={settings}
                    handleContentChange={handleContentChange}
                    progress={progress}
                />
            </DefaultLayout>
        </>
    );
};

export default AppTextsSettings;
