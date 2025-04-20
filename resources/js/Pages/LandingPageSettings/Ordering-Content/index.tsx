import axios from "axios";
import Breadcrumb from "../../../components/Breadcrumbs/Breadcrumb";
import OrderingContentForm from "../../../components/Forms/Settings/OrderingContentForm";
import DefaultLayout from "../../../layout/DefaultLayout";
import React, { useRef, useState } from "react";
import SuccessNotification from "../../../components/SuccessNotification";
import ErrorNotification from "../../../components/ErrorNotification";
export default function OrderingContentSettings({ content }) {
    console.log(content);
    content = content.map((content) => ({
        ...content,
        hasContent:
            content.title == "header" ||
            content.title == "footer" ||
            content.title == "newsletter"
                ? true
                : false,
        hasImage:
            content.title == "header" || content.title == "why-chose-us"
                ? true
                : false,
    }));
    const [errors, setErrors] = useState({});
    const [contents, setContents] = useState(content);
    // content can be the image or the text content_en or content_ar
    const handleContentChange = (title, content, value) => {
        let updatedSettings = [...contents];
        let settingToUpdate = updatedSettings.find(
            (setting) => setting.title == title
        );
        settingToUpdate[content] = value;
        updatedSettings = updatedSettings.map((setting) =>
            setting.title == title ? settingToUpdate : setting
        );
        setContents(updatedSettings);
    };

    const handleOrderChange = (title, direction) => {
        let updatedSettings = [...contents];
        const index = updatedSettings.findIndex(
            (setting) => setting.title == title
        );
        const newIndex =
            direction == "up"
                ? index - 1
                : direction == "down"
                ? index + 1
                : index;
        if (newIndex < 0 || newIndex >= updatedSettings.length) return;
        let [movedItem] = updatedSettings.splice(index, 1);
        movedItem.order = newIndex;
        updatedSettings.splice(newIndex, 0, movedItem);
        updatedSettings = updatedSettings.map((setting, index) => ({
            ...setting,
            order: index + 1,
        }));
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
        const formData = new FormData();
        contents.forEach((content, index) => {
            formData.append(`content[${index}][id]`, content.id);
            formData.append(`content[${index}][title]`, content.title);
            if (content.hasImage) {
                if (content.image instanceof File) {
                    formData.append(`content[${index}][image]`, content.image);
                }
            }
            if (content.hasContent) {
                formData.append(
                    `content[${index}][content_ar]`,
                    content.content_ar
                );
                formData.append(
                    `content[${index}][content_en]`,
                    content.content_en
                );
            }
            formData.append(`content[${index}][order]`, content.order);
        });
        console.log(formData.get("content[5][title]"));
        try {
            contentRef.current?.scroll({ top: 0, behavior: "smooth" });
            const res = await axios.post(
                "/newAdmin/settings/landing-page/ordering-content/update",
                formData,
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
            <Breadcrumb pageName="إعدادات ترتيب المحتوى" />
            {isSuccess && <SuccessNotification />}
            {isError && <ErrorNotification />}
            <OrderingContentForm
                contents={contents}
                errors={errors}
                handleContentChange={handleContentChange}
                handleOrderChange={handleOrderChange}
                progress={progress}
                saveData={saveData}
            />
        </DefaultLayout>
    );
}
