import React, { useState } from "react";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import DefaultLayout from "../../../../layout/DefaultLayout";
import DeleteModal from "../../../../components/Modals/DeleteModal";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import SubTableSettings from "../../../../components/Tables/Settings/JudicialGuide/SubTableSettings";
import LawGuideSubTableSettings from "../../../../components/Tables/LawGuideSubTableSettings";

const SubTable = ({ subCategories, mainCategories }) => {
    const headers = ["#", "القسم الرئيسي", "الاسم", "عدد المواد", "العمليات"];
    const [deleteModalOpen, setDeleteModalOpen] = useState({
        state: false,
        id: null,
    });
    console.log(subCategories);
    subCategories = subCategories.map((category) => ({
        id: category.id,
        name: category.name_ar,
        mainCategory: mainCategories.filter(
            (cat) => cat.id == category.category.id
        )[0].name_ar,
        mainCategoryId: category.category.id,
        lawsCount: category.sections.length,
    }));
    return (
        <>
            <DeleteModal
                isOpen={deleteModalOpen.state}
                setIsOpen={setDeleteModalOpen}
                confirmAction={() => {
                    try {
                        axios.delete(
                            `/newAdmin/settings/book-guide/sub/${deleteModalOpen.id}`
                        );
                        toast.success("تم حذف الملف");
                        setDeleteModalOpen({
                            state: false,
                            id: null,
                        });
                        router.get("/newAdmin/settings/book-guide/sub");
                    } catch (err) {
                        toast.error("حدث خطأ");
                    }
                }}
                confirmationText={
                    "عند حذف النظام, سيتم حذف كل المواد المندرجة تحتها"
                }
            />
            <DefaultLayout>
                <Breadcrumb pageName="اعدادات المحتوى القانوني وفصوله" />
                <LawGuideSubTableSettings
                    headers={headers}
                    data={subCategories}
                    mainCategories={mainCategories}
                    setDeleteModalOpen={setDeleteModalOpen}
                    type="book-guide"
                />
            </DefaultLayout>
        </>
    );
};

export default SubTable;
