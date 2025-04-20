import React, { useState } from "react";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import DefaultLayout from "../../../../layout/DefaultLayout";
import ServicesCategoriesSettingsTable from "../../../../components/Tables/Services/ServicesCategoriesSettingsTable";
import BaseTableSettings from "../../../../components/Tables/Settings/AdvisoryServices/BaseTableSettings";
import DeleteModal from "../../../../components/Modals/DeleteModal";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import UnifiedTable from "../../../../components/Tables/UnifiedTable";

const Services = ({ activities }) => {
    const headers = ["#", "قاعدة الأكتساب", "النقاط المكتسبة", "العمليات"];
    activities = activities.map((activity) => ({
        id: activity.id,
        name: activity.name,
        experiencePoints: activity.experience_points,
    }));
    return (
        <>
            <DefaultLayout>
                <Breadcrumb pageName="اعدادات قواعد الأكتساب" />
                <UnifiedTable
                    headers={headers}
                    data={activities}
                    hasDelete={false}
                    editLink="/newAdmin/settings/gamification/activities"
                />
            </DefaultLayout>
        </>
    );
};

export default Services;
