import React, { useState } from "react";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import DefaultLayout from "../../../../layout/DefaultLayout";
import DeleteModal from "../../../../components/Modals/DeleteModal";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import SubTableSettings from "../../../../components/Tables/Settings/JudicialGuide/SubTableSettings";

const SubTable = ({
    subCategories,
    mainCategories,
    countries,
    regions,
    cities,
}) => {
    const headers = [
        "#",
        "نوع المحكمة",
        "اسم المحكمة",
        "المنطقة",
        "عدد الدوائر",
        "العمليات",
    ];
    const [deleteModalOpen, setDeleteModalOpen] = useState({
        state: false,
        id: null,
    });
    console.log(subCategories);
    subCategories = subCategories.map((category) => ({
        id: category.id,
        name: category.name,
        mainCategory: category.main_category.name,
        mainCategoryId: category.main_category.id,
        countryId: category.main_category.country_id,
        regionId: category.region_id,
        region: regions.find((r) => r.id == category.region_id).name,
        numberOfCircuits: category.judicial_guides.length,
    }));
    return (
        <>
            <DeleteModal
                isOpen={deleteModalOpen.state}
                setIsOpen={setDeleteModalOpen}
                confirmAction={() => {
                    try {
                        axios.delete(
                            `/newAdmin/settings/judicial-guide/sub/${deleteModalOpen.id}`
                        );
                        toast.success("تم حذف الملف");
                        setDeleteModalOpen({
                            state: false,
                            id: null,
                        });
                        router.get("/newAdmin/settings/judicial-guide/sub");
                    } catch (err) {
                        toast.error("حدث خطأ");
                    }
                }}
                confirmationText={
                    "عند حذف المحكمة, سيتم حذف كل الدوائر المندرجة تحتها"
                }
            />
            <DefaultLayout>
                <Breadcrumb pageName="اعدادات المحاكم" />
                <SubTableSettings
                    headers={headers}
                    data={subCategories}
                    mainCategories={mainCategories}
                    setDeleteModalOpen={setDeleteModalOpen}
                    countries={countries}
                    regions={regions}
                    cities={cities}
                />
            </DefaultLayout>
        </>
    );
};

export default SubTable;
