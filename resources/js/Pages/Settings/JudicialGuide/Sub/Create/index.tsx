import React, { useEffect, useState } from "react";

import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import BaseSettingsForm from "../../../../../components/Forms/Settings/AdvisoryServices/BaseSettingsForm";
import PaymentCategoriesSettingsForm from "../../../../../components/Forms/Settings/AdvisoryServices/PaymentCategoriesSettingsForm";
import SubSettingsForm from "../../../../../components/Forms/Settings/JudicialGuide/SubSettingsForm";

function BaseSettingsCreate({ mainCategories, countries, regions }) {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState("");
    const [selectedMainCategory, setSelectedMainCategory] = useState("");
    const [locationUrl, setLocationUrl] = useState("");
    const [selectedCountry, setSelectedCountry] = useState("");

    const [selectedRegion, setSelectedRegion] = useState("");
    const [address, setAddress] = useState("");
    const [about, setAbout] = useState("");
    const [workingHoursFrom, setWorkingHoursFrom] = useState("");
    const [workingHoursTo, setWorkingHoursTo] = useState("");
    const [emails, setEmails] = useState([]);
    const [numbers, setNumbers] = useState<any[]>([]);
    const [image, setImage] = useState(null);
    useEffect(() => {
        if (selectedMainCategory) {
            setSelectedCountry(
                mainCategories.find((c) => c.id == selectedMainCategory)
                    .country_id
            );
        }
    }, [selectedMainCategory]);
    async function saveData() {
        try {
            const formData = new FormData();
            if (image) {
                formData.append("image", image);
            }
            for (let i = 0; i < emails.length; i++) {
                formData.append(`emails[${i}]`, emails[i]);
            }

            for (let i = 0; i < numbers.length; i++) {
                formData.append(
                    `numbers[${i}][phone_code]`,
                    numbers[i].phone_code
                );
                formData.append(
                    `numbers[${i}][phone_number]`,
                    numbers[i].phone_number
                );
            }
            if (address) {
                formData.append("address", address);
            }
            if (about) {
                formData.append("about", about);
            }
            if (workingHoursFrom) {
                formData.append("working_hours_from", workingHoursFrom);
                formData.append("working_hours_to", workingHoursTo);
            }
            formData.append("name", name);
            formData.append("mainCategoryId", selectedMainCategory);
            formData.append("locationUrl", locationUrl);
            formData.append("region_id", selectedRegion);

            const res = await axios.post(
                "/newAdmin/settings/judicial-guide/sub/create",
                formData
            );
            if (res.status == 200) {
                toast.success("تم انشاء الملف بنجاح");
                router.get(
                    `/newAdmin/settings/judicial-guide/sub/${res.data.item.id}`
                );
            }
        } catch (err) {
            setErrors(err.response.data.errors);
        }
    }
    return (
        <DefaultLayout>
            <Breadcrumb pageName="اضافة محكمة" />
            <SubSettingsForm
                errors={errors}
                saveData={saveData}
                name={name}
                setName={setName}
                selectedMainCategory={selectedMainCategory}
                setSelectedMainCategory={setSelectedMainCategory}
                mainCategories={mainCategories}
                countries={countries}
                locationUrl={locationUrl}
                setLocationUrl={setLocationUrl}
                address={address}
                setAddress={setAddress}
                setAbout={setAbout}
                setImage={setImage}
                workingHoursFrom={workingHoursFrom}
                workingHoursTo={workingHoursTo}
                emails={emails}
                setEmails={setEmails}
                numbers={numbers}
                setNumbers={setNumbers}
                about={about}
                image={image}
                setWorkingHoursFrom={setWorkingHoursFrom}
                setWorkingHoursTo={setWorkingHoursTo}
                regions={regions}
                selectedCountry={selectedCountry}
                selectedRegion={selectedRegion}
                setSelectedRegion={setSelectedRegion}
            />
        </DefaultLayout>
    );
}

export default BaseSettingsCreate;
