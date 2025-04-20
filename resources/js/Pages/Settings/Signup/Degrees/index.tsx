import React, { useState } from "react";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import DefaultLayout from "../../../../layout/DefaultLayout";
import ServicesCategoriesSettingsTable from "../../../../components/Tables/Services/ServicesCategoriesSettingsTable";
import JobsSettingsTable from "../../../../components/Tables/Settings/Signup/JobsSettingsTable";
import DeleteModal from "../../../../components/Modals/DeleteModal";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import DegreesSettingsTable from "../../../../components/Tables/Settings/Signup/DegreesSettingsTable";

const JobsSettings = ({ degrees }) => {
    const headers = ["#", "الاسم", "العمليات"];
    const [deleteModalOpen, setDeleteModalOpen] = useState({
        state: false,
        id: null,
    });
    degrees = degrees.map((job) => ({
        id: job.id,
        name: job.title,
    }));
    return (
        <>
            <DeleteModal
                isOpen={deleteModalOpen.state}
                setIsOpen={setDeleteModalOpen}
                confirmAction={() => {
                    router.get(
                        `/admin/digital-guide/sections/delete/${deleteModalOpen.id}`,
                        {},
                        {
                            onSuccess: () => {
                                toast.success("تم حذف الملف");
                            },
                            onError: () => {
                                toast.error("حدث خطأ");
                            },
                        }
                    );
                }}
                confirmationText={"اتريد ان تحذف هذه الدرجة؟"}
            />
            <DefaultLayout>
                <Breadcrumb pageName="اعدادات قائمة الدرجات العلمية" />
                <DegreesSettingsTable headers={headers} data={degrees} />
            </DefaultLayout>
        </>
    );
};

export default JobsSettings;
