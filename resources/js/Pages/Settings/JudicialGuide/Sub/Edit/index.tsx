import React, { useEffect, useRef, useState } from "react";
import ServicesCategoriesSettingsForm from "../../../../../components/Forms/Settings/Services/Categories/ServicesCategoriesSettingsForm";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import BaseSettingsForm from "../../../../../components/Forms/Settings/AdvisoryServices/BaseSettingsForm";
import PaymentCategoriesSettingsForm from "../../../../../components/Forms/Settings/AdvisoryServices/PaymentCategoriesSettingsForm";
import SubSettingsForm from "../../../../../components/Forms/Settings/JudicialGuide/SubSettingsForm";
import SuccessNotification from "../../../../../components/SuccessNotification";
import ErrorNotification from "../../../../../components/ErrorNotification";

function SubSettingsEdit({ mainCategories, subCategory, countries, regions }) {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState(subCategory?.name || "");
    const [selectedMainCategory, setSelectedMainCategory] = useState(
        subCategory?.main_category.id || ""
    );
    const [locationUrl, setLocationUrl] = useState(
        subCategory?.locationUrl || ""
    );
    const [selectedCountry, setSelectedCountry] = useState(
        subCategory.main_category.country_id
    );

    const [selectedRegion, setSelectedRegion] = useState(
        subCategory?.region_id
    );
    const [address, setAddress] = useState(subCategory.address || "");
    const [about, setAbout] = useState(subCategory.about || "");
    const [workingHoursFrom, setWorkingHoursFrom] = useState(
        subCategory.working_hours_from || ""
    );
    const [workingHoursTo, setWorkingHoursTo] = useState(
        subCategory.working_hours_to || ""
    );
    const [emails, setEmails] = useState(
        subCategory.emails.map((email) => email.email) || []
    );
    const [numbers, setNumbers] = useState<any[]>(
        subCategory.numbers.map((number) => ({
            phone_code: number.phone_code,
            phone_number: number.phone_number,
        })) || []
    );
    const [image, setImage] = useState(subCategory.image || null);
    const contentRef = useRef<HTMLDivElement>(null);
    useEffect(() => {
        if (selectedMainCategory) {
            setSelectedCountry(
                mainCategories.find((c) => c.id == selectedMainCategory)
                    .country_id
            );
        }
    }, [selectedMainCategory]);
    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);
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
                `/newAdmin/settings/judicial-guide/sub/${subCategory.id}`,
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

    return (
        <DefaultLayout>
            {" "}
            <div ref={contentRef}>
                <Breadcrumb pageName="تعديل محكمة" />
                {isSuccess && <SuccessNotification classNames="my-2" />}
                {isError && <ErrorNotification classNames="my-2" />}
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
            </div>
        </DefaultLayout>
    );
}

export default SubSettingsEdit;
