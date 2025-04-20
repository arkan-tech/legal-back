import React, { useState } from "react";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import DefaultLayout from "../../../../layout/DefaultLayout";
import PaymentCategoriesSettingsTable from "../../../../components/Tables/Settings/AdvisoryServices/PaymentCategoriesSettingsTable";
import DeleteModal from "../../../../components/Modals/DeleteModal";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";

const PaymentCategories = ({ advisoryServicesPaymentCategory, base }) => {
    const headers = ["#", "الفئة الرئيسية", "الاسم", "حالة الدفع", "العمليات"];
    const [deleteModalOpen, setDeleteModalOpen] = useState({
        state: false,
        id: null,
    });
    advisoryServicesPaymentCategory = advisoryServicesPaymentCategory
        .filter((category) =>
            base.some((b) => b.id == category.advisory_service_base_id)
        )
        .map((category) => {
            let paymentStatus;
            if (category.payment_method == 1) {
                paymentStatus = "مجانية";
            } else if (category.payment_method == 2) {
                paymentStatus = "مدفوعة";
            } else {
                paymentStatus = "متخصصة";
            }

            return {
                id: category.id,
                name: category.name,
                paymentStatus,
                base: base.find(
                    (b) => b.id == category.advisory_service_base_id
                ).title,
            };
        });
    console.log(advisoryServicesPaymentCategory);
    return (
        <>
            <DeleteModal
                isOpen={deleteModalOpen.state}
                setIsOpen={setDeleteModalOpen}
                confirmAction={() => {
                    router.get(
                        `/admin/advisory-services/payment-categories/delete/${deleteModalOpen.id}`,
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
                    "عند حذف الباقة, سيتم حذف كل الوسائل المندرجة تحتها و انواعها"
                }
            />
            <DefaultLayout>
                <Breadcrumb pageName="اعدادات باقات الأستشارات" />
                <PaymentCategoriesSettingsTable
                    headers={headers}
                    data={advisoryServicesPaymentCategory}
                    base={base}
                    setDeleteModalOpen={setDeleteModalOpen}
                />
            </DefaultLayout>
        </>
    );
};

export default PaymentCategories;
