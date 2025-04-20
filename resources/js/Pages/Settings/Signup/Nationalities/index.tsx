import React from "react";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import DefaultLayout from "../../../../layout/DefaultLayout";
import AccurateSpecialtySettingsTable from "../../../../components/Tables/Settings/Signup/AccurateSpecialtySettingsTable";
import NationalitiesSettingsTable from "../../../../components/Tables/Settings/Signup/NationalitiesSettingsTable";

const NationalitiesSettings = ({ nationalities }) => {
    const headers = ["#", "الاسم", "العمليات"];
    nationalities = nationalities.map((job) => ({
        id: job.id,
        name: job.name,
    }));
    return (
        <DefaultLayout>
            <Breadcrumb pageName="اعدادات الجنسيات" />
            <NationalitiesSettingsTable
                headers={headers}
                data={nationalities}
            />
        </DefaultLayout>
    );
};

export default NationalitiesSettings;
