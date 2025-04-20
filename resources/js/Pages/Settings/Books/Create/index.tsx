import React, { useState } from "react";

import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import DefaultLayout from "../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import PaymentCategoriesSettingsForm from "../../../../components/Forms/Settings/AdvisoryServices/PaymentCategoriesSettingsForm";
import MainSettingsForm from "../../../../components/Forms/Settings/AdvisoryServices/MainSettingsFrom";
import JudicialGuideSettingsForm from "../../../../components/Forms/Settings/JudicialGuide/JudicialGuideSettingsForm";
import BooksSettingsForm from "../../../../components/Forms/Settings/Books/BooksSettingsForm";

function JudicialGuideCreate({ mainCategories, subCategories }) {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState("");
    const [selectedMainCategory, setSelectedMainCategory] = useState("");
    const [selectedSubCategory, setSelectedSubCategory] = useState("");
    const [authorName, setAuthorName] = useState("");
    const [file, setFile] = useState(null);
    const [progress, setProgress] = useState(0);
    async function saveData() {
        const formData = new FormData();
        if (file) {
            formData.append("file", file);
        }
        formData.append("name", name);
        formData.append("sub_category_id", selectedSubCategory);
        formData.append("author_name", authorName);

        try {
            const res = await axios.post(
                "/newAdmin/settings/books/create",
                formData,
                {
                    onUploadProgress: (event) => {
                        const percent = Math.floor(
                            (event.loaded * 100) / event.total!
                        );
                        setProgress(percent);
                    },
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                }
            );
            if (res.status == 200) {
                toast.success("تم انشاء الملف بنجاح");
                router.get(`/newAdmin/settings/books/${res.data.item.id}`);
            }
        } catch (err) {
            setErrors(err.response.data.errors);
        }
    }
    return (
        <DefaultLayout>
            <Breadcrumb pageName="اضافة كتاب" />
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
                setAuthorName={setAuthorName}
                authorName={authorName}
                setFile={setFile}
                file={file}
                progress={progress}
            />
        </DefaultLayout>
    );
}

export default JudicialGuideCreate;
