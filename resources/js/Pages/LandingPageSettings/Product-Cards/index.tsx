import axios from "axios";
import Breadcrumb from "../../../components/Breadcrumbs/Breadcrumb";
import OrderingContentForm from "../../../components/Forms/Settings/OrderingContentForm";
import DefaultLayout from "../../../layout/DefaultLayout";
import React, { useRef, useState } from "react";
import SuccessNotification from "../../../components/SuccessNotification";
import ErrorNotification from "../../../components/ErrorNotification";
import ProductCardsForm from "../../../components/Forms/Settings/ProductCardsForm";
export default function OrderingContentSettings({ content }) {
    const [errors, setErrors] = useState({});
    const [contents, setContents] = useState(content);
    // content can be the image or the text content_en or content_ar
    const handleContentChange = (id, content, value) => {
        let updatedSettings = [...contents];
        let settingToUpdate = updatedSettings.find(
            (setting) => setting.id == id
        );
        settingToUpdate[content] = value;
        updatedSettings = updatedSettings.map((setting) =>
            setting.id == id ? settingToUpdate : setting
        );
        setContents(updatedSettings);
    };
    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);
    const [progress, setProgress] = useState(0);
    const contentRef = useRef<HTMLDivElement>(null);

    async function saveData() {
        setIsSuccess(false);
        setIsError(false);
        setProgress(0);
        try {
            contentRef.current?.scroll({ top: 0, behavior: "smooth" });
            const res = await axios.post(
                "/newAdmin/settings/landing-page/product-cards/update",
                {
                    content: contents,
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
        <DefaultLayout ref={contentRef}>
            <Breadcrumb pageName="إعدادات قائمة المنتجات" />
            {isSuccess && <SuccessNotification />}
            {isError && <ErrorNotification />}
            <ProductCardsForm
                contents={contents}
                errors={errors}
                handleContentChange={handleContentChange}
                progress={progress}
                saveData={saveData}
            />
        </DefaultLayout>
    );
}
