import React from "react";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import DefaultLayout from "../../../../layout/DefaultLayout";
import CountriesSettingsTable from "../../../../components/Tables/Settings/Signup/CountriesSettingsTable";
import CitiesSettingsTable from "../../../../components/Tables/Settings/Signup/CitiesSettingsTable";

const CitiesSettings = ({ cities }) => {
    const headers = ["#", "الاسم", "الدولة", "المنطقة", "العمليات"];
    cities = cities.map((city) => ({
        id: city.id,
        name: city.title,
        region: city.region.name,
        country: city.country.name,
    }));
    return (
        <DefaultLayout>
            <Breadcrumb pageName="اعدادات المدن" />
            <CitiesSettingsTable headers={headers} data={cities} />
        </DefaultLayout>
    );
};

export default CitiesSettings;
