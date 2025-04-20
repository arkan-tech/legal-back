import React, { useState } from "react";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import DefaultLayout from "../../../../layout/DefaultLayout";
import ServicesCategoriesSettingsTable from "../../../../components/Tables/Services/ServicesCategoriesSettingsTable";
import BaseTableSettings from "../../../../components/Tables/Settings/AdvisoryServices/BaseTableSettings";
import DeleteModal from "../../../../components/Modals/DeleteModal";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import UnifiedTable from "../../../../components/Tables/UnifiedTable";

const Services = ({ levels }) => {
    const headers = ["#", "المستوى", "عدد النقاط المطلوبة", "العمليات"];
    const [deleteModalOpen, setDeleteModalOpen] = useState({
        state: false,
        id: null,
    });
    levels = levels.map((level) => ({
        id: level.id,
        levelNumber: level.level_number,
        requiredXp: level.required_experience,
    }));
    return (
        <>
            <DeleteModal
                isOpen={deleteModalOpen.state}
                setIsOpen={setDeleteModalOpen}
                confirmAction={() => {
                    router.delete(
                        `/newAdmin/settings/gamification/levels/${deleteModalOpen.id}`,
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
                confirmationText={"عند حذف المستوى سيؤثر على حسابات العملاء"}
            />
            <DefaultLayout>
                <Breadcrumb pageName="اعدادات المستويات" />
                <UnifiedTable
                    headers={headers}
                    data={levels}
                    newButtonEnabled={true}
                    newButtonText="اضافة مستوى"
                    newButtonLink="/newAdmin/settings/gamification/levels/create"
                    setDeleteModalOpen={setDeleteModalOpen}
                    editLink="/newAdmin/settings/gamification/levels"
                    nameKeyForFiltration="levelNumber"
                />
            </DefaultLayout>
        </>
    );
};

export default Services;
