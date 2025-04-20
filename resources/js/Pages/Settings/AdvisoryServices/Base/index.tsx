import React, { useState } from "react";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import DefaultLayout from "../../../../layout/DefaultLayout";
import ServicesCategoriesSettingsTable from "../../../../components/Tables/Services/ServicesCategoriesSettingsTable";
import BaseTableSettings from "../../../../components/Tables/Settings/AdvisoryServices/BaseTableSettings";
import DeleteModal from "../../../../components/Modals/DeleteModal";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";

const Services = ({ advisoryServicesBase }) => {
    const headers = ["#", "الاسم", "العمليات"];
    const [deleteModalOpen, setDeleteModalOpen] = useState({
        state: false,
        id: null,
    });
    advisoryServicesBase = advisoryServicesBase.map((base) => ({
        id: base.id,
        name: base.title,
    }));
    return (
        <>
            <DeleteModal
                isOpen={deleteModalOpen.state}
                setIsOpen={setDeleteModalOpen}
                confirmAction={() => {
                    router.get(
                        `/admin/advisory-services-base/delete/${deleteModalOpen.id}`,
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
                confirmationText={
                    "عند حذف الفئة, سيتم حذف كل الباقات المندرجة تحتها و بالتالي كل الوسائل و انواعها"
                }
            />
            <DefaultLayout>
                <Breadcrumb pageName="اعدادات فئات الأستشارات" />
                <BaseTableSettings
                    headers={headers}
                    data={advisoryServicesBase}
                    setDeleteModalOpen={setDeleteModalOpen}
                />
            </DefaultLayout>
        </>
    );
};

export default Services;
