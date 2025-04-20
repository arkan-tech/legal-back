import React, { useState } from "react";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import DefaultLayout from "../../../../layout/DefaultLayout";
import ServicesCategoriesSettingsTable from "../../../../components/Tables/Services/ServicesCategoriesSettingsTable";
import BaseTableSettings from "../../../../components/Tables/Settings/AdvisoryServices/BaseTableSettings";
import DeleteModal from "../../../../components/Modals/DeleteModal";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import UnifiedTable from "../../../../components/Tables/UnifiedTable";

const Services = ({ ranks }) => {
    const headers = ["#", "الرتبة", "المستوى المطلوب", "العمليات"];
    const [deleteModalOpen, setDeleteModalOpen] = useState({
        state: false,
        id: null,
    });
    ranks = ranks.map((rank) => ({
        id: rank.id,
        name: rank.name,
        min_level: rank.min_level,
        border_color: rank.border_color,
        image: rank.image,
    }));
    return (
        <>
            <DeleteModal
                isOpen={deleteModalOpen.state}
                setIsOpen={setDeleteModalOpen}
                confirmAction={() => {
                    router.delete(
                        `/newAdmin/settings/gamification/ranks/${deleteModalOpen.id}`,
                        {
                            onSuccess: () => {
                                toast.success("تم حذف الملف");
                                router.reload();
                            },
                            onError: () => {
                                toast.error("حدث خطأ");
                            },
                        }
                    );
                }}
                confirmationText={"عند حذف الرتبة سيؤثر على حسابات العملاء"}
            />
            <DefaultLayout>
                <Breadcrumb pageName="اعدادات الرتب" />
                <UnifiedTable
                    headers={headers}
                    data={ranks}
                    newButtonEnabled={true}
                    newButtonText="اضافة رتبة"
                    newButtonLink="/newAdmin/settings/gamification/ranks/create"
                    setDeleteModalOpen={setDeleteModalOpen}
                    editLink="/newAdmin/settings/gamification/ranks"
                    dataFilter={["image", "border_color"]}
                />
            </DefaultLayout>
        </>
    );
};

export default Services;
