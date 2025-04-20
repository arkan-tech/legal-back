import { router } from "@inertiajs/react";
import React, { useEffect, useRef, useState } from "react";
import SelectGroup from "../../SelectGroup/SelectGroup";
import Switcher from "../../../Switchers/Switcher";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faTrash } from "@fortawesome/free-solid-svg-icons";
function JudicialGuideSettingsForm({
    saveData,
    errors,
    mainCategories,
    subCategories,
    name,
    setName,
    url,
    setUrl,
    image,
    setImage,
    workingHoursFrom,
    setWorkingHoursFrom,
    workingHoursTo,
    setWorkingHoursTo,
    selectedMainCategory,
    setSelectedMainCategory,
    selectedSubCategory,
    setSelectedSubCategory,
    about,
    setAbout,
    numbers,
    setNumbers,
    emails,
    setEmails,
    countries,
    cities,
    selectedRegion,
    selectedCity,
    setSelectedCity,
    selectedCountry,
    setSelectedCountry,
}: {
    saveData: any;
    errors: any;
    mainCategories;
    subCategories;
    name;
    setName;
    url;
    setUrl;
    image;
    setImage;
    workingHoursFrom;
    setWorkingHoursFrom;
    workingHoursTo;
    setWorkingHoursTo;
    about;
    setAbout;
    selectedMainCategory;
    setSelectedMainCategory;
    selectedSubCategory;
    setSelectedSubCategory;
    numbers;
    setNumbers;
    emails;
    setEmails;
    countries;
    regions;
    cities;
    selectedCountry;
    setSelectedCountry;
    selectedRegion;
    setSelectedRegion;
    selectedCity;
    setSelectedCity;
}) {
    const isInitialLoad = useRef(true);

    useEffect(() => {
        if (isInitialLoad.current) {
            isInitialLoad.current = false;
            return;
        }
        setSelectedCity("");
    }, [selectedRegion]);
    const [availableSubCategories, setAvailableSubCategories] = useState([]);
    useEffect(() => {
        if (selectedMainCategory) {
            setAvailableSubCategories(
                subCategories.filter(
                    (subCategory) =>
                        subCategory.main_category.id == selectedMainCategory
                )
            );
        }
    }, [selectedMainCategory]);
    const [email, setEmail] = useState("");
    const [phoneNumber, setPhoneNumber] = useState("");
    const [phoneCode, setPhoneCode] = useState("966");
    return (
        <>
            <div
                className="grid grid-cols-1 gap-9"
                style={{ direction: "rtl" }}
            >
                <div className="flex flex-col gap-9">
                    <div className="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                        <div className="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                            <h3 className="font-medium text-black dark:text-white">
                                الدائرة
                            </h3>
                        </div>
                        <div className="p-6.5">
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <SelectGroup
                                        options={mainCategories}
                                        title="القسم الرئيسي"
                                        selectedOption={selectedMainCategory}
                                        setSelectedOption={
                                            setSelectedMainCategory
                                        }
                                    />
                                </div>
                                <div className="w-full xl:w-1/2">
                                    <SelectGroup
                                        options={availableSubCategories}
                                        title="القسم الفرعي"
                                        selectedOption={selectedSubCategory}
                                        setSelectedOption={
                                            setSelectedSubCategory
                                        }
                                    />
                                    {errors?.subCategoryId && (
                                        <p className="text-red-600">
                                            {errors?.subCategoryId}
                                        </p>
                                    )}
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        اسم الفرع
                                    </label>
                                    <input
                                        type="text"
                                        placeholder="الاسم"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={name}
                                        onChange={(e) =>
                                            setName(e.target.value)
                                        }
                                    />
                                    {errors?.name && (
                                        <p className="text-red-600">
                                            {errors?.name}
                                        </p>
                                    )}
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <SelectGroup
                                        options={cities.filter(
                                            (c) =>
                                                c.country_id ==
                                                    selectedCountry &&
                                                c.region_id == selectedRegion
                                        )}
                                        selectedOption={selectedCity}
                                        setSelectedOption={setSelectedCity}
                                        title="المدينة"
                                    />
                                </div>
                            </div>

                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        مواعيد الفرع من
                                    </label>
                                    <input
                                        type="time"
                                        value={workingHoursFrom}
                                        className="w-full rounded border-[1.5px] border-strokedark bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        onChange={(e) => {
                                            setWorkingHoursFrom(e.target.value);
                                        }}
                                    />
                                    {errors?.workingHoursFrom && (
                                        <p className="text-red-600">
                                            {errors?.workingHoursFrom}
                                        </p>
                                    )}
                                </div>
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        مواعيد الفرع الى
                                    </label>
                                    <input
                                        type="time"
                                        value={workingHoursTo}
                                        className="w-full rounded border-[1.5px] border-strokedark bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        onChange={(e) => {
                                            setWorkingHoursTo(e.target.value);
                                        }}
                                    />
                                    {errors?.workingHoursTo && (
                                        <p className="text-red-600">
                                            {errors?.workingHoursTo}
                                        </p>
                                    )}
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        الموقع الألكتروني
                                    </label>
                                    <input
                                        type="text"
                                        placeholder="الموقع الألكتروني"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={url}
                                        onChange={(e) => setUrl(e.target.value)}
                                    />
                                    {errors?.url && (
                                        <p className="text-red-600">
                                            {errors?.url}
                                        </p>
                                    )}
                                </div>
                            </div>

                            <div className="mb-4.5 flex flex-col items-center gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        الصورة
                                    </label>
                                    <input
                                        type="file"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={image?.fileName}
                                        onChange={(e) =>
                                            setImage(e.target.files![0])
                                        }
                                    />

                                    {errors?.image && (
                                        <p className="text-red-600">
                                            {errors?.image}
                                        </p>
                                    )}
                                </div>
                                <div className="w-full xl:w-1/2">
                                    {image != null &&
                                        typeof image == "string" && (
                                            <a
                                                href={image}
                                                target="_blank"
                                                className="bg-primary p-2 rounded-xl text-white"
                                            >
                                                اظهار الصورة
                                            </a>
                                        )}
                                </div>
                            </div>
                            <div className="mb-4.5">
                                <label className="mb-2.5 block text-black dark:text-white">
                                    الأيميلات
                                </label>
                                <table
                                    className="w-full table-auto"
                                    style={{ direction: "rtl" }}
                                >
                                    <thead>
                                        <tr>
                                            <th scope="col">الأيميل </th>
                                            <th scope="col">عمليات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {emails.map((email, index) => (
                                            <>
                                                <tr key={index}>
                                                    <td className="text-center">
                                                        {email}
                                                    </td>

                                                    <td className="text-center">
                                                        <FontAwesomeIcon
                                                            icon={faTrash}
                                                            className="hover:cursor-pointer hover:text-white text-red-500"
                                                            onClick={() => {
                                                                setEmails(
                                                                    emails.filter(
                                                                        (s) =>
                                                                            s !==
                                                                            email
                                                                    )
                                                                );
                                                            }}
                                                        />
                                                    </td>
                                                </tr>
                                            </>
                                        ))}
                                    </tbody>
                                </table>
                                {errors?.emails && (
                                    <p className="text-red-600">
                                        {errors?.emails}
                                    </p>
                                )}
                            </div>
                            <div className="flex gap-2 mb-4.5">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        الأيميل
                                    </label>
                                    <input
                                        type="email"
                                        placeholder="الأيميل"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={email}
                                        onChange={(e) =>
                                            setEmail(e.target.value)
                                        }
                                    />
                                </div>

                                <div className="w-full xl:w-1/4 flex items-center justify-center text-white">
                                    <button
                                        onClick={() => {
                                            if (email == "") return;
                                            setEmails((prev) => [
                                                ...prev,
                                                email,
                                            ]);

                                            setEmail("");
                                        }}
                                        className="bg-purple-500 px-4 py-2 rounded"
                                    >
                                        +
                                    </button>
                                </div>
                            </div>
                            <div className="mb-4.5">
                                <label className="mb-2.5 block text-black dark:text-white">
                                    الأرقام
                                </label>
                                <table
                                    className="w-full table-auto"
                                    style={{ direction: "rtl" }}
                                >
                                    <thead>
                                        <tr>
                                            <th scope="col">مقدمة الدولة </th>
                                            <th scope="col">الرقم </th>
                                            <th scope="col">عمليات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {numbers.map((number, index) => (
                                            <>
                                                <tr key={index}>
                                                    <td className="text-center">
                                                        {number.phone_code}
                                                    </td>
                                                    <td className="text-center">
                                                        {number.phone_number}
                                                    </td>

                                                    <td className="text-center">
                                                        <FontAwesomeIcon
                                                            icon={faTrash}
                                                            className="hover:cursor-pointer hover:text-white text-red-500"
                                                            onClick={() => {
                                                                setNumbers(
                                                                    numbers.filter(
                                                                        (s) =>
                                                                            s.phone_code !==
                                                                                number.phone_code &&
                                                                            s.phone_number !==
                                                                                number.phone_number
                                                                    )
                                                                );
                                                            }}
                                                        />
                                                    </td>
                                                </tr>
                                            </>
                                        ))}
                                    </tbody>
                                </table>
                                {errors?.numbers && (
                                    <p className="text-red-600">
                                        {errors?.numbers}
                                    </p>
                                )}
                            </div>
                            <div className="flex gap-2 mb-4.5">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        مقدمة الدولة
                                    </label>
                                    <select
                                        value={phoneCode}
                                        onChange={(e) =>
                                            setPhoneCode(e.target.value)
                                        }
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                    >
                                        {countries.map((country) => (
                                            <option
                                                value={country.phone_code}
                                            >{`${country.name} (${country.phone_code})`}</option>
                                        ))}
                                    </select>
                                </div>
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        الرقم
                                    </label>
                                    <input
                                        type="number"
                                        placeholder="الرقم"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={phoneNumber}
                                        onChange={(e) =>
                                            setPhoneNumber(e.target.value)
                                        }
                                    />
                                </div>

                                <div className="w-full xl:w-1/4 flex items-center justify-center text-white">
                                    <button
                                        onClick={() => {
                                            if (
                                                phoneCode == "" ||
                                                phoneNumber == ""
                                            )
                                                return;
                                            setNumbers((prev) => [
                                                ...prev,
                                                {
                                                    phone_code: phoneCode,
                                                    phone_number: phoneNumber,
                                                },
                                            ]);

                                            setPhoneCode("");
                                            setPhoneNumber("");
                                        }}
                                        className="bg-purple-500 px-4 py-2 rounded"
                                    >
                                        +
                                    </button>
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        نبذه
                                    </label>
                                    <textarea
                                        placeholder="نبذه"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={about}
                                        onChange={(e) =>
                                            setAbout(e.target.value)
                                        }
                                    />
                                    {errors?.about && (
                                        <p className="text-red-600">
                                            {errors?.about}
                                        </p>
                                    )}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="flex gap-6">
                    <button
                        onClick={saveData}
                        className="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90"
                    >
                        حفظ الملف
                    </button>
                    <button
                        onClick={() =>
                            router.get(
                                "/newAdmin/settings/judicial-guide/dashboard"
                            )
                        }
                        className="flex w-full justify-center rounded bg-danger p-3 font-medium text-gray hover:bg-opacity-90"
                    >
                        الرجوع للتخصيص
                    </button>
                </div>
            </div>
        </>
    );
}

export default JudicialGuideSettingsForm;
