import React from "react";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import DefaultLayout from "../../../../layout/DefaultLayout";
import AccurateSpecialtySettingsTable from "../../../../components/Tables/Settings/Signup/AccurateSpecialtySettingsTable";
import FunctionalCasesSettingsTable from "../../../../components/Tables/Settings/Signup/FunctionalCasesSettingsTable";

const FunctionalCasesSettings = ({ functionalCases }) => {
    const headers = ["#", "الاسم", "العمليات"];
    functionalCases = functionalCases.map((functionalCase) => ({
        id: functionalCase.id,
        name: functionalCase.title,
    }));
    return (
        <DefaultLayout>
            <Breadcrumb pageName="اعدادات الحالة الوظيفية" />
            <FunctionalCasesSettingsTable
                headers={headers}
                data={functionalCases}
            />
        </DefaultLayout>
    );
};

export default FunctionalCasesSettings;
