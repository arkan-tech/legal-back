import React from "react";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import DefaultLayout from "../../../../layout/DefaultLayout";
import ServicesCategoriesSettingsTable from "../../../../components/Tables/Services/ServicesCategoriesSettingsTable";
import JobsSettingsTable from "../../../../components/Tables/Settings/Signup/JobsSettingsTable";
import GeneralSpecialtySettingsTable from "../../../../components/Tables/Settings/Signup/GeneralSpecialtySettingsTable";

const GeneralSpecialtySettings = ({ generalSpecialties }) => {
    const headers = ["#", "الاسم", "العمليات"];
    generalSpecialties = generalSpecialties.map((job) => ({
        id: job.id,
        name: job.title,
    }));
    return (
        <DefaultLayout>
            <Breadcrumb pageName="اعدادات التخصصات العامة" />
            <GeneralSpecialtySettingsTable
                headers={headers}
                data={generalSpecialties}
            />
        </DefaultLayout>
    );
};

export default GeneralSpecialtySettings;
