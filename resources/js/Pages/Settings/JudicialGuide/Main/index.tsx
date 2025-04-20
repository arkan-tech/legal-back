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

const Services = ({ mainCategories, countries }) => {
    const mainHeaders = [
        "#",
        "نوع المحكمة",
        "عدد المحاكم",
        "عدد الدوائر",
        "الدولة",
        "العمليات",
    ];
    const [deleteModalOpen, setDeleteModalOpen] = useState({
        state: false,
        id: null,
    });
    let mainCategoriesData = mainCategories.map((item) => ({
        id: item.id,
        name: item.name,
        numberOfCourts: item.sub_categories.length,
        numberOfCourtCircuits: item.sub_categories.reduce(
            (count, subCategory) => {
                return count + subCategory.judicial_guides.length;
            },
            0
        ),
        countryId: item.id,
        country: countries.find((c) => c.id == item.id).name,
    }));
    return (
        <>
            <DeleteModal
                isOpen={deleteModalOpen.state}
                setIsOpen={setDeleteModalOpen}
                confirmAction={async () => {
                    try {
                        axios.delete(
                            `/newAdmin/settings/judicial-guide/main/${deleteModalOpen.id}`
                        );
                        toast.success("تم حذف الملف");
                        setDeleteModalOpen({
                            state: false,
                            id: null,
                        });
                        router.get("/newAdmin/settings/judicial-guide/main");
                    } catch (err) {
                        toast.error("حدث خطأ");
                    }
                }}
                confirmationText={
                    "عند حذف القسم الرئيسي, سيتم حذف كل الاقسام الفرعية المندرجة تحتها و فروعها"
                }
            />
            <DefaultLayout>
                <Breadcrumb pageName="اعدادات انواع المحاكم" />
                <MainTableSettings
                    headers={mainHeaders}
                    data={mainCategoriesData}
                    setDeleteModalOpen={setDeleteModalOpen}
                    countries={countries}
                />
            </DefaultLayout>
        </>
    );
};

export default Services;
