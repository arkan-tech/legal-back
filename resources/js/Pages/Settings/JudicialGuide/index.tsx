import React, { useState } from "react";

import MainSettingsTable from "../../../components/Tables/Settings/AdvisoryServices/MainSettingsTable";
import Breadcrumb from "../../../components/Breadcrumbs/Breadcrumb";
import DefaultLayout from "../../../layout/DefaultLayout";
import DeleteModal from "../../../components/Modals/DeleteModal";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import JudicialGuideSettingsTable from "../../../components/Tables/Settings/JudicialGuide/JudicialGuideSettings";

const JudicialGuideSettings = ({
    judicialGuides,
    mainCategories,
    subCategories,
    cities,
    regions,
    countries,
}) => {
    const headers = [
        "#",
        "نوع المحكمة",
        "اسم المحكمة",
        "اسم الدائرة",
        "المدينة",
        "العمليات",
    ];
    const [deleteModalOpen, setDeleteModalOpen] = useState({
        state: false,
        id: null,
    });
    judicialGuides = judicialGuides.map((judicialGuide) => ({
        id: judicialGuide.id,
        name: judicialGuide.name,
        subCategory: judicialGuide.sub_category,
        mainCategory: judicialGuide.sub_category.main_category,
        cityId: judicialGuide.city_id,
        city: cities.find((c) => c.id == judicialGuide.city_id).title,
        regionId: judicialGuide.sub_category.region_id,
        countryId: judicialGuide.sub_category.main_category.country_id,
    }));
    return (
        <>
            <DeleteModal
                isOpen={deleteModalOpen.state}
                setIsOpen={setDeleteModalOpen}
                confirmAction={() => {
                    try {
                        axios.delete(
                            `/newAdmin/settings/judicial-guide/${deleteModalOpen.id}`
                        );
                        toast.success("تم حذف الملف");
                        setDeleteModalOpen({
                            state: false,
                            id: null,
                        });
                        router.get("/newAdmin/settings/judicial-guide");
                    } catch (err) {
                        toast.error("حدث خطأ");
                    }
                }}
                confirmationText={"ازالة الدائرة؟"}
            />
            <DefaultLayout>
                <Breadcrumb pageName="اعدادات الدوائر" />
                <JudicialGuideSettingsTable
                    headers={headers}
                    data={judicialGuides}
                    mainCategories={mainCategories}
                    subCategories={subCategories}
                    setDeleteModalOpen={setDeleteModalOpen}
                    compact={true}
                    cities={cities}
                    countries={countries}
                    regions={regions}
                />
            </DefaultLayout>
        </>
    );
};

export default JudicialGuideSettings;
