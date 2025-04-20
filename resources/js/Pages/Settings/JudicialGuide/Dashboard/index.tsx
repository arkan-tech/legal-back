import React, { useState } from "react";
import DefaultLayout from "../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import JudicialGuideSettingsTable from "../../../../components/Tables/Settings/JudicialGuide/JudicialGuideSettings";
import { HeaderGear } from "../../Products";
import MainTableSettings from "../../../../components/Tables/Settings/JudicialGuide/MainTableSettings";
import SubTableSettings from "../../../../components/Tables/Settings/JudicialGuide/SubTableSettings";

const JudicialGuideDashboardSettings = ({
    judicialGuides,
    mainCategories,
    subCategories,
    countries,
    regions,
    cities,
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
    }));
    const mainHeaders = [
        "#",
        "نوع المحكمة",
        "عدد المحاكم",
        "عدد الدوائر",
        "الدولة",
        "العمليات",
    ];
    let mainCategoriesData = mainCategories.map((item) => ({
        id: item.id,
        name: item.name,
        numberOfCourts: item.sub_categories.length,
        numberOfCourtCircuits: item.sub_categories.reduce(
            (count, subCategory) => {
                return count + subCategory.judicial_guides.length;
            },
            0
        ),
        countryId: item.country_id,
        country: countries.find((c) => c.id == item.country_id).name,
    }));
    const subHeaders = [
        "#",
        "نوع المحكمة",
        "اسم المحكمة",
        "المنطقة",
        "عدد الدوائر",
        "العمليات",
    ];
    let subCategoriesData = subCategories.map((category) => ({
        id: category.id,
        name: category.name,
        mainCategory: category.main_category.name,
        mainCategoryId: category.main_category.id,
        countryId: category.main_category.country_id,
        regionId: category.region_id,
        region: regions.find((r) => r.id == category.region_id).name,
        numberOfCircuits: category.judicial_guides.length,
    }));
    return (
        <>
            <DefaultLayout>
                <Breadcrumb pageName="لوحة تخصيص الدليل العدلي" />
                <div className="flex flex-col gap-8">
                    <hr />
                    <div className="flex flex-col gap-4 ">
                        <HeaderGear
                            title="انواع المحاكم"
                            link="/newAdmin/settings/judicial-guide/main"
                        />
                        <MainTableSettings
                            headers={mainHeaders}
                            data={mainCategoriesData}
                            setDeleteModalOpen={setDeleteModalOpen}
                            compact={true}
                            countries={countries}
                        />
                    </div>
                    <hr />
                    <div className="flex flex-col gap-4 ">
                        <HeaderGear
                            title="المحاكم"
                            link="/newAdmin/settings/judicial-guide/sub"
                        />
                        <SubTableSettings
                            headers={subHeaders}
                            data={subCategoriesData}
                            mainCategories={mainCategories}
                            setDeleteModalOpen={setDeleteModalOpen}
                            countries={countries}
                            regions={regions}
                            cities={cities}
                            compact={true}
                        />
                    </div>
                    <hr />
                    <div className="flex flex-col gap-4 ">
                        <HeaderGear
                            title="الدوائر"
                            link="/newAdmin/settings/judicial-guide"
                        />
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
                    </div>
                </div>
            </DefaultLayout>
        </>
    );
};

export default JudicialGuideDashboardSettings;
