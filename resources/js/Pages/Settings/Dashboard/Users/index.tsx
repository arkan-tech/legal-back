import React, { useState } from "react";
import DefaultLayout from "../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import ImportanceSettingsTable from "../../../../components/Tables/Settings/Importance/ImportanceSettingsTable";
import DashboardUsersSettingsTable from "../../../../components/Tables/Settings/Dashboard/Users/DashboardUsersSettingsTable";
import DeleteModal from "../../../../components/Modals/DeleteModal";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";

const DashboardUsersSettings = ({ users }) => {
    // console.log(importances);
    const [deleteModalOpen, setDeleteModalOpen] = useState({
        state: false,
        id: null,
    });
    const headers = ["#", "اسم المستخدم", "البريد الالكتروني", "العمليات"];
    users = users.map((user) => ({
        id: user.id,
        name: user.name,
        email: user.email,
    }));
    return (
        <DefaultLayout>
            <DeleteModal
                isOpen={deleteModalOpen.state}
                setIsOpen={setDeleteModalOpen}
                confirmAction={() => {
                    router.delete(
                        `/newAdmin/settings/dashboard/users/${deleteModalOpen.id}`,
                        {
                            onSuccess: () => {
                                toast.success("تم حذف الملف");
                                router.get(
                                    "/newAdmin/settings/dashboard/users"
                                );
                            },
                            onError: () => {
                                toast.error("حدث خطأ");
                            },
                        }
                    );
                }}
                confirmationText={
                    "عند حذف الفئة, سيتم حذف كل الباقات المندرجة تحتها و بالتالي كل الوسائل و انواعها"
                }
            />
            <Breadcrumb pageName="اعدادات مستخدمي اللوحة" />
            <DashboardUsersSettingsTable
                headers={headers}
                data={users}
                setDeleteModalOpen={setDeleteModalOpen}
            />
        </DefaultLayout>
    );
};

export default DashboardUsersSettings;
