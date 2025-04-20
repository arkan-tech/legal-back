import React, { useState } from "react";
import ServicesSettingsTable from "../../../components/Tables/Services/ServicesSettingsTable";
import Breadcrumb from "../../../components/Breadcrumbs/Breadcrumb";
import DefaultLayout from "../../../layout/DefaultLayout";
import DeleteModal from "../../../components/Modals/DeleteModal";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";

const Services = ({ services, categories }) => {
    const [deleteModalOpen, setDeleteModalOpen] = useState({
        state: false,
        id: null,
    });
    const headers = [
        "#",
        "القسم الرئيسي",
        "اسم الخدمة",
        "حد السعر",
        "اسعار المستويات",
        "العمليات",
    ];
    services = services.map((service) => ({
        id: service.id,
        name: service.title,
        category: service.category,
        minPrice: service.min_price,
        maxPrice: service.max_price,
        isHidden: service.isHidden,
        prices: service.ymtaz_levels_prices,
    }));
    return (
        <>
            <DeleteModal
                isOpen={deleteModalOpen.state}
                setIsOpen={setDeleteModalOpen}
                confirmAction={() => {
                    router.get(
                        `/admin/services/delete/${deleteModalOpen.id}`,
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
                confirmationText={"عند حذف مسمى الخدمة, سيتم حذف كل ملحقاتها"}
            />
            <DefaultLayout>
                <Breadcrumb pageName="اعدادات الخدمات" />
                <ServicesSettingsTable
                    headers={headers}
                    data={services}
                    categories={categories}
                    setDeleteModalOpen={setDeleteModalOpen}
                    compact={false}
                />
            </DefaultLayout>
        </>
    );
};

export default Services;
