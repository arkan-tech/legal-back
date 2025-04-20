import React from "react";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import DefaultLayout from "../../../../layout/DefaultLayout";
import AccurateSpecialtySettingsTable from "../../../../components/Tables/Settings/Signup/AccurateSpecialtySettingsTable";
import NationalitiesSettingsTable from "../../../../components/Tables/Settings/Signup/NationalitiesSettingsTable";
import RegionsSettingsTable from "../../../../components/Tables/Settings/Signup/RegionsSettingsTable";

const RegionsSettings = ({ regions, countries }) => {
    console.log(regions, countries);
    const headers = ["#", "الاسم", "الدولة", "العمليات"];
    regions = regions.map((region) => ({
        id: region.id,
        name: region.name,
        country: countries.find((c) => c.id == region.country_id).name,
    }));
    return (
        <DefaultLayout>
            <Breadcrumb pageName="اعدادات المنطقة" />
            <RegionsSettingsTable headers={headers} data={regions} />
        </DefaultLayout>
    );
};

export default RegionsSettings;
