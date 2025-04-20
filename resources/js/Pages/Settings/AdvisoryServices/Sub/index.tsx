import React, { useState } from "react";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import DefaultLayout from "../../../../layout/DefaultLayout";
import DeleteModal from "../../../../components/Modals/DeleteModal";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import AdvisoryServicesSubTableSettings from "../../../../components/Tables/Settings/AdvisoryServices/AdvisoryServicesSubTableSettings";

const SubCategories = ({ subCategories }) => {
    const headers = ["#", "الاسم", "التخصص العام", "المستويات", "العمليات"];
    const [deleteModalOpen, setDeleteModalOpen] = useState({
        state: false,
        id: null,
    });
    console.log(subCategories);
    return (
        <>
            <DeleteModal
                isOpen={deleteModalOpen.state}
                setIsOpen={setDeleteModalOpen}
                confirmAction={() => {
                    router.delete(
                        `/newAdmin/settings/advisory-services/sub-categories/${deleteModalOpen.id}`,
                        {
                            onSuccess: () => {
                                toast.success("تم حذف التخصص الدقيق بنجاح");
                                setDeleteModalOpen({ state: false, id: null });
                                router.get(
                                    "/newAdmin/settings/advisory-services/sub-categories"
                                );
                            },
                            onError: () => {
                                toast.error("حدث خطأ");
                            },
                        }
                    );
                }}
                confirmationText={
                    "عند حذف التخصص الدقيق, سيتم حذف كل الأسعار المرتبطة بها"
                }
            />
            <DefaultLayout>
                <Breadcrumb pageName="اعدادات التخصصات الدقيقة للأستشارات" />
                <AdvisoryServicesSubTableSettings
                    headers={headers}
                    data={subCategories}
                    setDeleteModalOpen={setDeleteModalOpen}
                />
            </DefaultLayout>
        </>
    );
};

export default SubCategories;
