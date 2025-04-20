import React, { useState } from "react";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import DefaultLayout from "../../../../layout/DefaultLayout";
import DeleteModal from "../../../../components/Modals/DeleteModal";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import LanguageTableSettings from "../../../../components/Tables/Settings/Languages/LanguageTableSettings";
import axios from "axios";

const Services = ({ languages }) => {
    const headers = ["#", "الاسم", "العمليات"];
    const [deleteModalOpen, setDeleteModalOpen] = useState({
        state: false,
        id: null,
    });
    languages = languages.map((base) => ({
        id: base.id,
        name: base.name,
    }));
    return (
        <>
            <DeleteModal
                isOpen={deleteModalOpen.state}
                setIsOpen={setDeleteModalOpen}
                confirmAction={() => {
                    try {
                        axios.delete(
                            `/newAdmin/settings/signup/languages/${deleteModalOpen.id}`
                        );
                        toast.success("تم حذف الملف");
                        setDeleteModalOpen({
                            state: false,
                            id: null,
                        });
                        router.get("/newAdmin/settings/signup/languages");
                    } catch (err) {
                        toast.error("حدث خطأ");
                    }
                }}
                confirmationText={
                    "عند حذف الفئة, سيتم حذف كل الباقات المندرجة تحتها و بالتالي كل الوسائل و انواعها"
                }
            />
            <DefaultLayout>
                <Breadcrumb pageName="اعدادات اللغات" />
                <LanguageTableSettings
                    headers={headers}
                    data={languages}
                    setDeleteModalOpen={setDeleteModalOpen}
                />
            </DefaultLayout>
        </>
    );
};

export default Services;
