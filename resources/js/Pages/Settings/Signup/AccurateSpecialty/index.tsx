import React from "react";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import DefaultLayout from "../../../../layout/DefaultLayout";
import AccurateSpecialtySettingsTable from "../../../../components/Tables/Settings/Signup/AccurateSpecialtySettingsTable";

const AccurateSpecialtySettings = ({ accurateSpecialties }) => {
    const headers = ["#", "الاسم", "العمليات"];
    accurateSpecialties = accurateSpecialties.map((job) => ({
        id: job.id,
        name: job.title,
    }));
    return (
        <DefaultLayout>
            <Breadcrumb pageName="اعدادات التخصصات الدقيقة" />
            <AccurateSpecialtySettingsTable
                headers={headers}
                data={accurateSpecialties}
            />
        </DefaultLayout>
    );
};

export default AccurateSpecialtySettings;
