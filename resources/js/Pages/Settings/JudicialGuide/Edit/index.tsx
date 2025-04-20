import React, { useEffect, useRef, useState } from "react";

import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import DefaultLayout from "../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import PaymentCategoriesSettingsForm from "../../../../components/Forms/Settings/AdvisoryServices/PaymentCategoriesSettingsForm";
import MainSettingsForm from "../../../../components/Forms/Settings/AdvisoryServices/MainSettingsFrom";
import JudicialGuideSettingsForm from "../../../../components/Forms/Settings/JudicialGuide/JudicialGuideSettingsForm";
import ErrorNotification from "../../../../components/ErrorNotification";
import SuccessNotification from "../../../../components/SuccessNotification";

function JudicialGuideEdit({
    judicialGuide,
    mainCategories,
    subCategories,
    countries,
    cities,
    regions,
}) {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState(judicialGuide.name || "");
    const [url, setUrl] = useState(judicialGuide.url || "");
    const [image, setImage] = useState(judicialGuide.image || null);
    const [selectedCity, setSelectedCity] = useState(judicialGuide?.city_id);
    const [selectedCountry, setSelectedCountry] = useState(
        judicialGuide.sub_category.main_category.country_id
    );

    const [selectedRegion, setSelectedRegion] = useState(
        judicialGuide?.region_id
    );
    const [selectedMainCategory, setSelectedMainCategory] = useState(
        judicialGuide.sub_category.main_category_id || ""
    );
    const [selectedSubCategory, setSelectedSubCategory] = useState(
        judicialGuide.sub_category_id || ""
    );
    const [about, setAbout] = useState(judicialGuide.about || "");
    const [workingHoursFrom, setWorkingHoursFrom] = useState(
        judicialGuide.working_hours_from || ""
    );
    const [workingHoursTo, setWorkingHoursTo] = useState(
        judicialGuide.working_hours_to || ""
    );
    const [emails, setEmails] = useState(
        judicialGuide.emails.map((email) => email.email) || []
    );
    const [numbers, setNumbers] = useState(
        judicialGuide.numbers.map((number) => ({
            phone_code: number.phone_code,
            phone_number: number.phone_number,
        })) || []
    );
    const contentRef = useRef<HTMLDivElement>(null);

    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);

    async function saveData() {
        // console.log(selectedBase);
        const formData = new FormData();
        if (image && typeof image != "string") {
            formData.append("image", image);
        }
        if (url) {
            formData.append("url", url);
        }
        formData.append("name", name);
        formData.append("about", about);
        formData.append("subCategoryId", selectedSubCategory);
        formData.append("workingHoursFrom", workingHoursFrom);
        formData.append("workingHoursTo", workingHoursTo);
        formData.append("city_id", selectedCity);
        for (let i = 0; i < emails.length; i++) {
            formData.append(`emails[${i}]`, emails[i]);
        }

        for (let i = 0; i < numbers.length; i++) {
            formData.append(`numbers[${i}][phone_code]`, numbers[i].phone_code);
            formData.append(
                `numbers[${i}][phone_number]`,
                numbers[i].phone_number
            );
        }
        try {
            const res = await axios.post(
                `/newAdmin/settings/judicial-guide/${judicialGuide.id}`,
                formData
            );
            if (res.status == 200) {
                setIsSuccess(true);
                contentRef.current?.scrollIntoView({ behavior: "smooth" });
            }
        } catch (err) {
            setErrors(err.response.data.errors);
            setIsError(true);
            contentRef.current?.scrollIntoView({ behavior: "smooth" });
        }
    }
    useEffect(() => {
        if (selectedSubCategory) {
            setSelectedCountry(
                mainCategories.find((c) => c.id == selectedMainCategory)
                    .country_id
            );
            setSelectedRegion(
                subCategories.find((c) => c.id == selectedSubCategory).region_id
            );
        }
    }, [selectedSubCategory]);
    return (
        <DefaultLayout>
            {" "}
            <div ref={contentRef}>
                <Breadcrumb pageName="تعديل الدائرة " />{" "}
                {isSuccess && <SuccessNotification classNames="my-2" />}
                {isError && <ErrorNotification classNames="my-2" />}
                <JudicialGuideSettingsForm
                    errors={errors}
                    countries={countries}
                    saveData={saveData}
                    name={name}
                    setName={setName}
                    about={about}
                    image={image}
                    mainCategories={mainCategories}
                    subCategories={subCategories}
                    selectedMainCategory={selectedMainCategory}
                    selectedSubCategory={selectedSubCategory}
                    cities={cities}
                    regions={regions}
                    selectedCity={selectedCity}
                    selectedCountry={selectedCountry}
                    selectedRegion={selectedRegion}
                    setSelectedCity={setSelectedCity}
                    setSelectedCountry={setSelectedCountry}
                    setSelectedRegion={setSelectedRegion}
                    setAbout={setAbout}
                    setImage={setImage}
                    setSelectedMainCategory={setSelectedMainCategory}
                    setSelectedSubCategory={setSelectedSubCategory}
                    setUrl={setUrl}
                    setWorkingHoursFrom={setWorkingHoursFrom}
                    setWorkingHoursTo={setWorkingHoursTo}
                    url={url}
                    workingHoursFrom={workingHoursFrom}
                    workingHoursTo={workingHoursTo}
                    emails={emails}
                    setEmails={setEmails}
                    numbers={numbers}
                    setNumbers={setNumbers}
                />
            </div>
        </DefaultLayout>
    );
}

export default JudicialGuideEdit;
