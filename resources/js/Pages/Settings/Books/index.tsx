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

const JudicialGuideSettings = ({ books, mainCategories, subCategories }) => {
    const headers = [
        "#",
        "القسم الرئيسي",
        "القسم الفرعي",
        "اسم الكتاب",
        "العمليات",
    ];
    const [deleteModalOpen, setDeleteModalOpen] = useState({
        state: false,
        id: null,
    });
    books = books.map((judicialGuide) => ({
        id: judicialGuide.id,
        name: judicialGuide.name,
        subCategory: judicialGuide.sub_category,
        mainCategory: judicialGuide.sub_category.main_category,
    }));
    return (
        <>
            <DeleteModal
                isOpen={deleteModalOpen.state}
                setIsOpen={setDeleteModalOpen}
                confirmAction={() => {
                    try {
                        axios.delete(
                            `/newAdmin/settings/books/${deleteModalOpen.id}`
                        );
                        toast.success("تم حذف الملف");
                        setDeleteModalOpen({
                            state: false,
                            id: null,
                        });
                        router.get("/newAdmin/settings/books");
                    } catch (err) {
                        toast.error("حدث خطأ");
                    }
                }}
                confirmationText={"ازالة الكتاب؟"}
            />
            <DefaultLayout>
                <Breadcrumb pageName="اعدادات الكتب" />
                <BooksSettingsTable
                    headers={headers}
                    data={books}
                    mainCategories={mainCategories}
                    subCategories={subCategories}
                    setDeleteModalOpen={setDeleteModalOpen}
                />
            </DefaultLayout>
        </>
    );
};

export default JudicialGuideSettings;
