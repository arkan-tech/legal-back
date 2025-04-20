import React, { useState } from "react";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import DefaultLayout from "../../../../layout/DefaultLayout";
import TypesSettingsTable from "../../../../components/Tables/Settings/AdvisoryServices/TypesSettingsTable";
import DeleteModal from "../../../../components/Modals/DeleteModal";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";

const Types = ({ types, advisoryServices }) => {
    console.log(types);
    const [deleteModalOpen, setDeleteModalOpen] = useState({
        state: false,
        id: null,
    });
    const headers = [
        "#",
        "الفئة",
        "الباقة",
        "الوسيلة",
        "اسم النوع",
        "السعر الأدنى",
        "السعر الأقصى",
        "العمليات",
    ];
    types = types
        .filter((type) =>
            advisoryServices.some((b) => b.id == type.advisory_service_id)
        )
        .map((type) => ({
            id: type.id,
            name: type.title,
            minPrice: type.min_price,
            maxPrice: type.max_price,
            base: type.advisory_service.payment_category.advisory_services_base
                .title,
            payment_category: type.advisory_service.payment_category.name,
            payment_category_type:
                type.advisory_service.payment_category_type.name,
        }));
    return (
        <>
            <DeleteModal
                isOpen={deleteModalOpen.state}
                setIsOpen={setDeleteModalOpen}
                confirmAction={() => {
                    router.get(
                        `/admin/advisory-services/types/delete/${deleteModalOpen.id}`,
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
                confirmationText={""}
            />
            <DefaultLayout>
                <Breadcrumb pageName="اعدادات انواع الأستشارات" />
                <TypesSettingsTable
                    headers={headers}
                    data={types}
                    advisoryServices={advisoryServices}
                    setDeleteModalOpen={setDeleteModalOpen}
                />
            </DefaultLayout>
        </>
    );
};

export default Types;
