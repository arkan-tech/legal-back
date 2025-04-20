import React, { useState } from "react";

import MainSettingsTable from "../../../components/Tables/Settings/AdvisoryServices/MainSettingsTable";
import Breadcrumb from "../../../components/Breadcrumbs/Breadcrumb";
import DefaultLayout from "../../../layout/DefaultLayout";
import DeleteModal from "../../../components/Modals/DeleteModal";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import JudicialGuideSettingsTable from "../../../components/Tables/Settings/JudicialGuide/JudicialGuideSettings";
import BooksSettingsTable from "../../../components/Tables/Settings/Books/BooksSettingsTable";
import UnifiedTable from "../../../components/Tables/UnifiedTable";
import BannersTable from "../../../components/Tables/BannersTable";
import { GetArabicDateTime } from "../../../helpers/DateFunctions";

const JudicialGuideSettings = ({ banners }) => {
    const headers = ["#", "تاريخ انتهاء البانر", "العمليات"];
    const [deleteModalOpen, setDeleteModalOpen] = useState({
        state: false,
        id: null,
    });
    console.log(banners);
    banners = banners.map((banner) => ({
        id: banner.id,
        image: banner.image,
        expires_at: banner.expires_at
            ? GetArabicDateTime(banner.expires_at)
            : "ليس له تاريخ انتهاء",
    }));
    return (
        <>
            <DeleteModal
                isOpen={deleteModalOpen.state}
                setIsOpen={setDeleteModalOpen}
                confirmAction={() => {
                    try {
                        axios.delete(
                            `/newAdmin/settings/banners/${deleteModalOpen.id}`
                        );
                        toast.success("تم حذف الملف");
                        setDeleteModalOpen({
                            state: false,
                            id: null,
                        });
                        router.get("/newAdmin/settings/banners");
                    } catch (err) {
                        toast.error("حدث خطأ");
                    }
                }}
                confirmationText={"ازالة البانر"}
            />
            <DefaultLayout>
                <Breadcrumb pageName="اعدادات البانرات الأعلانية" />
                <BannersTable
                    headers={headers}
                    data={banners}
                    newButtonEnabled={true}
                    newButtonText={"انشاء بانر اعلاني"}
                    newButtonLink={"/newAdmin/settings/banners/create"}
                    editLink={"/newAdmin/settings/banners"}
                    nameKeyForFiltration="id"
                    hasDelete={true}
                    dataFilter={["image"]}
                    setDeleteModalOpen={setDeleteModalOpen}
                />
            </DefaultLayout>
        </>
    );
};

export default JudicialGuideSettings;
