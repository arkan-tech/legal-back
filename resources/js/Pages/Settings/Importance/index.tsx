import React, { useState } from "react";

import MainSettingsTable from "../../../components/Tables/Settings/AdvisoryServices/MainSettingsTable";
import Breadcrumb from "../../../components/Breadcrumbs/Breadcrumb";
import DefaultLayout from "../../../layout/DefaultLayout";
import ImportanceSettingsTable from "../../../components/Tables/Settings/Importance/ImportanceSettingsTable";
import DeleteModal from "../../../components/Modals/DeleteModal";
import axios from "axios";
import toast from "react-hot-toast";
import { router } from "@inertiajs/react";

const ImportanceSettings = ({ importances }) => {
    // console.log(importances);
    const headers = ["#", "اسم المستوى", "العمليات"];
    importances = importances.map((importance) => ({
        id: importance.id,
        name: importance.title,
    }));
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
                    try {
                        axios.delete(
                            `/newAdmin/settings/importance/${deleteModalOpen.id}/delete`
                        );
                        toast.success("تم حذف الملف");
                        setDeleteModalOpen({
                            state: false,
                            id: null,
                        });
                        router.get("/newAdmin/settings/importance");
                    } catch (err) {
                        toast.error("حدث خطأ");
                    }
                }}
                confirmationText={
                    "عند حذف القسم الفرعي, سيتم حذف كل الفروع المندرجة تحتها"
                }
            />
            <DefaultLayout>
                <Breadcrumb pageName="اعدادات مستويات الخدمات و الأستشارات" />
                <ImportanceSettingsTable
                    headers={headers}
                    data={importances}
                    setDeleteModalOpen={setDeleteModalOpen}
                />
            </DefaultLayout>
        </>
    );
};

export default ImportanceSettings;
