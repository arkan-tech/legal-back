import React from "react";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import DefaultLayout from "../../../../layout/DefaultLayout";
import CountriesSettingsTable from "../../../../components/Tables/Settings/Signup/CountriesSettingsTable";

const CountriesSettings = ({ countries }) => {
    console.log(countries);
    const headers = ["#", "الاسم", "مقدمة الدولة", "العمليات"];
    countries = countries.map((country) => ({
        id: country.id,
        name: country.name,
        phoneCode: country.phone_code,
    }));
    return (
        <DefaultLayout>
            <Breadcrumb pageName="اعدادات الدولة" />
            <CountriesSettingsTable headers={headers} data={countries} />
        </DefaultLayout>
    );
};

export default CountriesSettings;
