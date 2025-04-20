import React, { useState } from "react";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import DefaultLayout from "../../../../layout/DefaultLayout";
import ServicesCategoriesSettingsTable from "../../../../components/Tables/Services/ServicesCategoriesSettingsTable";
import BaseTableSettings from "../../../../components/Tables/Settings/AdvisoryServices/BaseTableSettings";
import DeleteModal from "../../../../components/Modals/DeleteModal";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import MainTableSettings from "../../../../components/Tables/Settings/JudicialGuide/MainTableSettings";
import axios from "axios";

const Services = ({ mainCategories }) => {
    const headers = ["#", "الاسم", "العمليات"];
    const [deleteModalOpen, setDeleteModalOpen] = useState({
        state: false,
        id: null,
    });
    mainCategories = mainCategories.map((item) => ({
        id: item.id,
        name: item.name,
    }));
    return (
        <>
            <DeleteModal
                isOpen={deleteModalOpen.state}
                setIsOpen={setDeleteModalOpen}
                confirmAction={async () => {
                    try {
                        axios.delete(
                            `/newAdmin/settings/books/main/${deleteModalOpen.id}`
                        );
                        toast.success("تم حذف الملف");
                        setDeleteModalOpen({
                            state: false,
                            id: null,
                        });
                        router.get("/newAdmin/settings/books/main");
                    } catch (err) {
                        toast.error("حدث خطأ");
                    }
                }}
                confirmationText={
                    "عند حذف القسم الرئيسي, سيتم حذف كل الاقسام الفرعية المندرجة تحتها و فروعها"
                }
            />
            <DefaultLayout>
                <Breadcrumb pageName="اعدادات الأقسام الرئيسية" />
                <MainTableSettings
                    headers={headers}
                    data={mainCategories}
                    setDeleteModalOpen={setDeleteModalOpen}
                    route="books"
                />
            </DefaultLayout>
        </>
    );
};

export default Services;
