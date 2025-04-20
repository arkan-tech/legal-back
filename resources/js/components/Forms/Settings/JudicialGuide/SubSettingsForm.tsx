import { router } from "@inertiajs/react";
import React, { useEffect, useRef, useState } from "react";
import SelectGroup from "../../SelectGroup/SelectGroup";
import { faTrash } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
function SubSettingsForm({
    saveData,
    errors,
    mainCategories,
    countries,
    name,
    setName,
    selectedMainCategory,
    setSelectedMainCategory,
    locationUrl,
    setLocationUrl,
    address,
    setAddress,
    about,
    setAbout,
    workingHoursFrom,
    setWorkingHoursFrom,
    workingHoursTo,
    setWorkingHoursTo,
    emails,
    setEmails,
    numbers,
    setNumbers,
    image,
    setImage,
    regions,
    selectedCountry,
    selectedRegion,
    setSelectedRegion,
}: {
    saveData: any;
    errors: any;
    mainCategories: any[];
    name: string;
    setName: any;
    selectedMainCategory;
    setSelectedMainCategory;
    countries;
    locationUrl;
    setLocationUrl;
    address;
    setAddress;
    about;
    setAbout;
    workingHoursFrom;
    setWorkingHoursFrom;
    workingHoursTo;
    setWorkingHoursTo;
    emails;
    setEmails;
    numbers;
    setNumbers;
    image;
    setImage;
    regions;
    selectedCountry;
    selectedRegion;
    setSelectedRegion;
}) {
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
                                المحكمة
                            </h3>
                        </div>
                        <div className="p-6.5">
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        الاسم
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
                                        options={mainCategories}
                                        title="القسم الرئيسي"
                                        selectedOption={selectedMainCategory}
                                        setSelectedOption={
                                            setSelectedMainCategory
                                        }
                                    />
                                    {errors?.mainCategoryId && (
                                        <p className="text-red-600">
                                            {errors?.mainCategoryId}
                                        </p>
                                    )}
                                </div>
                                <div className="w-full xl:w-1/2">
                                    <SelectGroup
                                        options={regions.filter(
                                            (r) =>
                                                r.country_id == selectedCountry
                                        )}
                                        selectedOption={selectedRegion}
                                        setSelectedOption={setSelectedRegion}
                                        title="المنطقة"
                                    />
                                </div>
                            </div>

                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        العنوان
                                    </label>
                                    <input
                                        type="text"
                                        placeholder="العنوان"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={address}
                                        onChange={(e) =>
                                            setAddress(e.target.value)
                                        }
                                    />
                                    {errors?.address && (
                                        <p className="text-red-600">
                                            {errors?.address}
                                        </p>
                                    )}
                                </div>
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        لينك العنوان
                                    </label>
                                    <input
                                        type="text"
                                        placeholder="لينك العنوان"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={locationUrl}
                                        onChange={(e) =>
                                            setLocationUrl(e.target.value)
                                        }
                                    />
                                    {errors?.locationUrl && (
                                        <p className="text-red-600">
                                            {errors?.locationUrl}
                                        </p>
                                    )}
                                </div>
                            </div>

                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        مواعيد القسم من
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
                                        مواعيد القسم الى
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
                                        onChange={(e) => {
                                            setPhoneCode(e.target.value);
                                        }}
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
                                            ) {
                                                console.log(
                                                    "empty",
                                                    phoneCode,
                                                    phoneNumber
                                                );
                                                return;
                                            }
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

export default SubSettingsForm;
