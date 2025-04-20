import React, { useState } from "react";

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

interface Section {
    title: string;
    data: string;
}

interface SocialMediaItem {
    url: string;
    name: string;
    logo: string;
}

const IdentitySettings = ({ identity }) => {
    const [errors, setErrors] = useState({});

    // Helper function to safely parse JSON and get content
    const safeParseJSON = (item: any, defaultValue: any = []) => {
        try {
            if (!item) return defaultValue;
            const content = JSON.parse(item.content);
            return content || defaultValue;
        } catch (e) {
            console.error("Error parsing JSON:", e);
            return defaultValue;
        }
    };

    // Helper function to find item by key
    const findByKey = (key: string) =>
        identity?.find((id: any) => id.key === key);

    // Initialize state with proper error handling
    const [whoAreWe, setWhoAreWe] = useState<Section[]>(() => {
        const content = safeParseJSON(findByKey("who-are-we"));
        return Array.isArray(content) ? content : [{ title: "", data: "" }];
    });

    const [termsAndConditions, setTermsAndConditions] = useState<Section[]>(
        () => {
            const content = safeParseJSON(findByKey("terms-and-conditions"));
            return Array.isArray(content) ? content : [{ title: "", data: "" }];
        }
    );

    const [privacyPolicy, setPrivacyPolicy] = useState<Section[]>(() => {
        const content = safeParseJSON(findByKey("privacy-policy"));
        return Array.isArray(content) ? content : [{ title: "", data: "" }];
    });

    const [socialMedia, setSocialMedia] = useState<SocialMediaItem[]>(() => {
        const content = safeParseJSON(findByKey("social-media"));
        return Array.isArray(content)
            ? content
            : [{ url: "", name: "", logo: "" }];
    });

    const [faq, setFaq] = useState<Section[]>(() => {
        const content = safeParseJSON(findByKey("faq"));
        return Array.isArray(content) ? content : [{ title: "", data: "" }];
    });

    async function saveData() {
        const data = {
            who_are_we: whoAreWe,
            terms_and_conditions: termsAndConditions,
            privacy_policy: privacyPolicy,
            social_media: socialMedia,
            faq: faq,
        };

        try {
            const res = await axios.post("/newAdmin/settings/identity", data);
            if (res.status == 200) {
                toast.success("تم حفظ البيانات بنجاح");
                router.get(`/newAdmin/settings/identity`);
            }
        } catch (err) {
            setErrors(err.response.data.errors);
            toast.error("حدث خطأ أثناء حفظ البيانات");
        }
    }

    return (
        <>
            <DefaultLayout>
                <Breadcrumb pageName="اعدادات الهوية" />
                <IdentityForm
                    saveData={saveData}
                    errors={errors}
                    whoAreWe={whoAreWe}
                    setWhoAreWe={setWhoAreWe}
                    termsAndConditions={termsAndConditions}
                    setTermsAndConditions={setTermsAndConditions}
                    privacyPolicy={privacyPolicy}
                    setPrivacyPolicy={setPrivacyPolicy}
                    socialMedia={socialMedia}
                    setSocialMedia={setSocialMedia}
                    faq={faq}
                    setFaq={setFaq}
                />
            </DefaultLayout>
        </>
    );
};

export default IdentitySettings;
