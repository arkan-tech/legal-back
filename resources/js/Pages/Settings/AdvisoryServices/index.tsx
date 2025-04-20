import React, { useState } from "react";

import MainSettingsTable from "../../../components/Tables/Settings/AdvisoryServices/MainSettingsTable";
import Breadcrumb from "../../../components/Breadcrumbs/Breadcrumb";
import DefaultLayout from "../../../layout/DefaultLayout";
import DeleteModal from "../../../components/Modals/DeleteModal";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";

const AdvisoryServicesSettings = ({ advisoryServices, paymentCategories }) => {
    console.log(advisoryServices);
    const headers = [
        "#",
        "فئة الأستشارة",
        "باقة الأستشارة",
        "اسم الوسيلة",
        "تحتاج لموعد؟",
        "العمليات",
    ];
    const [deleteModalOpen, setDeleteModalOpen] = useState({
        state: false,
        id: null,
    });
    advisoryServices = advisoryServices
        .filter((service) =>
            paymentCategories.some((pc) => pc.id == service.payment_category_id)
        )
        .map((service) => ({
            id: service.id,
            name: service.payment_category_type.name,
            category: service.payment_category.name,
            base: service.payment_category.advisory_services_base.title,
            needAppointment: service.need_appointment == 1 ? "نعم" : "لا",
        }));
    return (
        <>
            <DeleteModal
                isOpen={deleteModalOpen.state}
                setIsOpen={setDeleteModalOpen}
                confirmAction={() => {
                    router.get(
                        `/admin/advisory-services/delete/${deleteModalOpen.id}`,
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
                    "عند حذف الوسيلة, سيتم حذف كل الأنواع المندرجة تحتها"
                }
            />
            <DefaultLayout>
                <Breadcrumb pageName="اعدادات وسائل الأستشارات" />
                <MainSettingsTable
                    headers={headers}
                    data={advisoryServices}
                    categories={paymentCategories}
                    setDeleteModalOpen={setDeleteModalOpen}
                />
            </DefaultLayout>
        </>
    );
};

export default AdvisoryServicesSettings;
