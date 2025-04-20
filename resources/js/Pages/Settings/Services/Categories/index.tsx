import React, { useState } from "react";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import DefaultLayout from "../../../../layout/DefaultLayout";
import ServicesCategoriesSettingsTable from "../../../../components/Tables/Services/ServicesCategoriesSettingsTable";
import DeleteModal from "../../../../components/Modals/DeleteModal";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";

const Services = ({ categories }) => {
    const headers = ["#", "الاسم", "العمليات"];
    const [deleteModalOpen, setDeleteModalOpen] = useState({
        state: false,
        id: null,
    });
    categories = categories.map((service) => ({
        id: service.id,
        name: service.name,
    }));
    return (
        <>
            <DeleteModal
                isOpen={deleteModalOpen.state}
                setIsOpen={setDeleteModalOpen}
                confirmAction={() => {
                    router.get(
                        `/admin/services/categories/delete/${deleteModalOpen.id}`,
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
                    "عند حذف القسم, سيتم حذف كل المسميات المندرجة تحتها و ملحقاتها"
                }
            />
            <DefaultLayout>
                <Breadcrumb pageName="اعدادات اقسام الخدمات" />
                <ServicesCategoriesSettingsTable
                    headers={headers}
                    data={categories}
                    setDeleteModalOpen={setDeleteModalOpen}
                />
            </DefaultLayout>
        </>
    );
};

export default Services;
