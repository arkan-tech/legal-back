import React, { useState } from "react";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import DefaultLayout from "../../../../layout/DefaultLayout";
import DeleteModal from "../../../../components/Modals/DeleteModal";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import SubTableSettings from "../../../../components/Tables/Settings/Books/SubTableSettings";

const SubTable = ({ subCategories, mainCategories }) => {
    const headers = ["#", "القسم الرئيسي", "الاسم", "العمليات"];
    const [deleteModalOpen, setDeleteModalOpen] = useState({
        state: false,
        id: null,
    });
    subCategories = subCategories.map((category) => ({
        id: category.id,
        name: category.name,
        mainCategory: category.main_category.name,
        mainCategoryId: category.main_category.id,
    }));
    return (
        <>
            <DeleteModal
                isOpen={deleteModalOpen.state}
                setIsOpen={setDeleteModalOpen}
                confirmAction={() => {
                    try {
                        axios.delete(
                            `/newAdmin/settings/books/sub/${deleteModalOpen.id}`
                        );
                        toast.success("تم حذف الملف");
                        setDeleteModalOpen({
                            state: false,
                            id: null,
                        });
                        router.get("/newAdmin/settings/books/sub");
                    } catch (err) {
                        toast.error("حدث خطأ");
                    }
                }}
                confirmationText={
                    "عند حذف القسم الفرعي, سيتم حذف كل الكتب المندرجة تحتها"
                }
            />
            <DefaultLayout>
                <Breadcrumb pageName="اعدادات الاقسام الفرعية" />
                <SubTableSettings
                    headers={headers}
                    data={subCategories}
                    mainCategories={mainCategories}
                    setDeleteModalOpen={setDeleteModalOpen}
                />
            </DefaultLayout>
        </>
    );
};

export default SubTable;
