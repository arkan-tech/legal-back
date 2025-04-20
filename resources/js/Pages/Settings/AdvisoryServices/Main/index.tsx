import React, { useState } from "react";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import DefaultLayout from "../../../../layout/DefaultLayout";
import DeleteModal from "../../../../components/Modals/DeleteModal";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import AdvisoryServicesMainTableSettings from "../../../../components/Tables/Settings/AdvisoryServices/AdvisoryServicesMainTableSettings";

const Services = ({ generalCategories }) => {
    console.log(generalCategories);
    const headers = ["#", "الاسم", "الوسيلة", "العمليات"];
    const [deleteModalOpen, setDeleteModalOpen] = useState({
        state: false,
        id: null,
    });
    return (
        <>
            <DeleteModal
                isOpen={deleteModalOpen.state}
                setIsOpen={setDeleteModalOpen}
                confirmAction={() => {
                    router.delete(
                        `/newAdmin/settings/advisory-services/general-categories/${deleteModalOpen.id}`,
                        {
                            onSuccess: () => {
                                toast.success("تم حذف التخصص العام");
                                setDeleteModalOpen({ state: false, id: null });
                                router.get(
                                    "/newAdmin/settings/advisory-services/general-categories"
                                );
                            },
                        }
                    );
                }}
                confirmationText={
                    "عند حذف التخصص العام, سيتم حذف كل التخصصات الدقيقة المندرجة تحتها"
                }
            />
            <DefaultLayout>
                <Breadcrumb pageName="اعدادات التخصصات العامة للأستشارات" />
                <AdvisoryServicesMainTableSettings
                    headers={headers}
                    data={generalCategories}
                    setDeleteModalOpen={setDeleteModalOpen}
                />
            </DefaultLayout>
        </>
    );
};

export default Services;
