import React, { useRef, useState } from "react";

import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import DefaultLayout from "../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import PaymentCategoriesSettingsForm from "../../../../components/Forms/Settings/AdvisoryServices/PaymentCategoriesSettingsForm";
import MainSettingsForm from "../../../../components/Forms/Settings/AdvisoryServices/MainSettingsFrom";
import JudicialGuideSettingsForm from "../../../../components/Forms/Settings/JudicialGuide/JudicialGuideSettingsForm";
import ErrorNotification from "../../../../components/ErrorNotification";
import SuccessNotification from "../../../../components/SuccessNotification";
import BooksSettingsForm from "../../../../components/Forms/Settings/Books/BooksSettingsForm";

function JudicialGuideEdit({ book, mainCategories, subCategories }) {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState(book.name || "");
    const [selectedMainCategory, setSelectedMainCategory] = useState(
        book.sub_category.main_category_id || ""
    );
    const [selectedSubCategory, setSelectedSubCategory] = useState(
        book.sub_category_id || ""
    );

    const contentRef = useRef<HTMLDivElement>(null);
    const [authorName, setAuthorName] = useState(book.author_name || "");
    const [file, setFile] = useState(book.file || null);
    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);
    const [progress, setProgress] = useState(0);

    async function saveData() {
        const formData = new FormData();
        if (file && typeof file != "string") {
            formData.append("file", file);
        }

        formData.append("name", name);
        formData.append("sub_category_id", selectedSubCategory);
        formData.append("author_name", authorName);
        console.log(formData);
        try {
            const res = await axios.post(
                `/newAdmin/settings/books/${book.id}`,
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
                contentRef.current?.scrollIntoView({ behavior: "smooth" });
            }
        } catch (err) {
            setErrors(err.response.data.errors);
            setIsError(true);
            contentRef.current?.scrollIntoView({ behavior: "smooth" });
        }
    }
    console.log(book);
    return (
        <DefaultLayout>
            {" "}
            <div ref={contentRef}>
                <Breadcrumb pageName="تعديل الكتاب " />{" "}
                {isSuccess && <SuccessNotification classNames="my-2" />}
                {isError && <ErrorNotification classNames="my-2" />}
                <BooksSettingsForm
                    errors={errors}
                    saveData={saveData}
                    name={name}
                    setName={setName}
                    mainCategories={mainCategories}
                    subCategories={subCategories}
                    selectedMainCategory={selectedMainCategory}
                    selectedSubCategory={selectedSubCategory}
                    setSelectedMainCategory={setSelectedMainCategory}
                    setSelectedSubCategory={setSelectedSubCategory}
                    file={file}
                    setFile={setFile}
                    authorName={authorName}
                    setAuthorName={setAuthorName}
                    progress={progress}
                />
            </div>
        </DefaultLayout>
    );
}

export default JudicialGuideEdit;
