import React, { useEffect, useState } from "react";

import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import DefaultLayout from "../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import PaymentCategoriesSettingsForm from "../../../../components/Forms/Settings/AdvisoryServices/PaymentCategoriesSettingsForm";
import MainSettingsForm from "../../../../components/Forms/Settings/AdvisoryServices/MainSettingsFrom";
import JudicialGuideSettingsForm from "../../../../components/Forms/Settings/JudicialGuide/JudicialGuideSettingsForm";

function JudicialGuideCreate({
    mainCategories,
    subCategories,
    countries,
    cities,
    regions,
}) {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState("");
    const [url, setUrl] = useState("");
    const [image, setImage] = useState(null);
    const [selectedMainCategory, setSelectedMainCategory] = useState("");
    const [selectedSubCategory, setSelectedSubCategory] = useState("");
    const [selectedRegion, setSelectedRegion] = useState("");
    const [selectedCountry, setSelectedCountry] = useState("");
    const [selectedCity, setSelectedCity] = useState("");
    const [about, setAbout] = useState("");
    const [workingHoursFrom, setWorkingHoursFrom] = useState("");
    const [workingHoursTo, setWorkingHoursTo] = useState("");
    const [emails, setEmails] = useState([]);
    const [numbers, setNumbers] = useState<any[]>([]);
    async function saveData() {
        // console.log(selectedBase);
        const formData = new FormData();
        if (image) {
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
                "/newAdmin/settings/judicial-guide/create",
                formData
            );
            if (res.status == 200) {
                toast.success("تم انشاء الملف بنجاح");
                router.get(
                    `/newAdmin/settings/judicial-guide/${res.data.item.id}`
                );
            }
        } catch (err) {
            setErrors(err.response.data.errors);
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
            <Breadcrumb pageName="اضافة دائرة" />
            <JudicialGuideSettingsForm
                errors={errors}
                countries={countries}
                saveData={saveData}
                name={name}
                setName={setName}
                about={about}
                image={image}
                cities={cities}
                regions={regions}
                selectedCity={selectedCity}
                selectedCountry={selectedCountry}
                selectedRegion={selectedRegion}
                setSelectedCity={setSelectedCity}
                setSelectedCountry={setSelectedCountry}
                setSelectedRegion={setSelectedRegion}
                mainCategories={mainCategories}
                subCategories={subCategories}
                selectedMainCategory={selectedMainCategory}
                selectedSubCategory={selectedSubCategory}
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
        </DefaultLayout>
    );
}

export default JudicialGuideCreate;
