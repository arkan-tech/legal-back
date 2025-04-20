import React, { useState } from "react";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import DefaultLayout from "../../../../layout/DefaultLayout";
import ServicesCategoriesSettingsTable from "../../../../components/Tables/Services/ServicesCategoriesSettingsTable";
import BaseTableSettings from "../../../../components/Tables/Settings/AdvisoryServices/BaseTableSettings";
import DeleteModal from "../../../../components/Modals/DeleteModal";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import UnifiedTable from "../../../../components/Tables/UnifiedTable";

const Services = ({ streaks }) => {
    const headers = ["#", "المستوى", "النقاط المكتسبة", "العمليات"];
    const [deleteModalOpen, setDeleteModalOpen] = useState({
        state: false,
        id: null,
    });
    streaks = streaks.map((level) => ({
        id: level.id,
        streak_milestone: level.streak_milestone,
        milestone_xp: level.milestone_xp,
    }));
    return (
        <>
            <DeleteModal
                isOpen={deleteModalOpen.state}
                setIsOpen={setDeleteModalOpen}
                confirmAction={() => {
                    router.delete(
                        `/newAdmin/settings/gamification/streaks/${deleteModalOpen.id}`,
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
                confirmationText={"هل تريد حذف سلسلة المستوى"}
            />
            <DefaultLayout>
                <Breadcrumb pageName="اعدادات سلاسل المستويات" />
                <UnifiedTable
                    headers={headers}
                    data={streaks}
                    newButtonEnabled={true}
                    newButtonText="اضافة سلسلة مستوى"
                    newButtonLink="/newAdmin/settings/gamification/streaks/create"
                    setDeleteModalOpen={setDeleteModalOpen}
                    editLink="/newAdmin/settings/gamification/streaks"
                    nameKeyForFiltration="levelNumber"
                />
            </DefaultLayout>
        </>
    );
};

export default Services;
