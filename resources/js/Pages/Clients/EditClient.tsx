import { Link, router, usePage } from "@inertiajs/react";
import Breadcrumb from "../../components/Breadcrumbs/Breadcrumb";
import SelectGroup from "../../components/Forms/SelectGroup/SelectGroup";
import DefaultLayout from "../../layout/DefaultLayout";
import React, { useEffect, useRef, useState } from "react";
import SelectGroupTwo from "../../components/Forms/SelectGroup/SelectGroupTwo";
import { ClientUser } from "../../types/ClientUser";
import GoogleMapReact from "google-map-react";
import toast from "react-hot-toast";
import SuccessNotification from "../../components/SuccessNotification";
import ErrorNotification from "../../components/ErrorNotification";
import TextInput from "../../components/TextInput";
const EditClient = ({
    client,
    nationalities,
    countries,
    regions,
    cities,
    types,
    success,
}: {
    client: ClientUser;
    nationalities;
    countries;
    regions;
    cities;
    types;
    success?;
}) => {
    const contentRef = useRef<HTMLDivElement>(null);
    const [name, setName] = useState(client.name);
    const [phoneCode, setPhoneCode] = useState(client.phone_code);
    const [mobile, setMobile] = useState(client.phone);
    const [email, setEmail] = useState(client.email);
    const [selectedType, setSelectedType] = useState(
        client.type?.toString() || ""
    );
    console.log(client);
    const [selectedNationality, setSelectedNationality] = useState(
        client.nationality_id?.toString() || ""
    );
    const [selectedCountry, setSelectedCountry] = useState(
        client.country_id?.toString() || ""
    );
    const [availableRegions, setAvailableRegions] = useState(
        regions.filter((r) => r.country_id == client?.country_id)
    );
    const [availableCities, setAvailableCities] = useState(
        cities.filter((c) => c.region_id == client?.region_id)
    );
    const [selectedRegion, setSelectedRegion] = useState(
        client?.region_id || ""
    );
    const [selectedCity, setSelectedCity] = useState(client?.city_id || "");
    const [gender, setGender] = useState(client.gender || "");
    const [status, setStatus] = useState(client.status?.toString() || "");
    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);
    const [statusReason, setStatusReason] = useState("");
    const saveData = () => {
        router.post(
            "/admin/clients/update",
            {
                id: client.id,
                name,
                gender: gender,
                type: selectedType,
                phone_code: phoneCode,
                mobil: mobile,
                email,
                country_id: selectedCountry,
                region_id: selectedRegion,
                city_id: selectedCity,
                nationality_id: selectedNationality,
                status,
                status_reason: statusReason,
            },
            {
                onSuccess: () => {
                    // toast.success(success);
                    setIsSuccess(true);
                    contentRef.current?.scrollIntoView({ behavior: "smooth" });
                },
                onError: () => {
                    setIsError(true);
                    contentRef.current?.scrollIntoView({ behavior: "smooth" });
                },
            }
        );
    };

    useEffect(() => {
        // Filter regions based on the selected country
        setAvailableRegions(
            regions.filter((region) => region.country_id == selectedCountry)
        );
        // Reset selected region and city when country changes
        setSelectedRegion("");
        setSelectedCity("");
        setAvailableCities([]);
    }, [selectedCountry]);

    useEffect(() => {
        // Filter cities based on the selected region
        setAvailableCities(
            cities.filter((city) => city.region_id == selectedRegion)
        );
        // Reset selected city when region changes
        setSelectedCity("");
    }, [selectedRegion]);
    useEffect(() => {
        // Filter regions based on the selected country and set available regions
        const filteredRegions = regions.filter(
            (region) => region.country_id == selectedCountry
        );
        setAvailableRegions(filteredRegions);

        // If the client has a region_id, make sure it's in the filtered regions
        if (client.region_id) {
            setSelectedRegion(client.region_id);
        } else {
            setSelectedRegion("");
        }

        // Filter cities based on the client's region_id (if available)
        const filteredCities = cities.filter(
            (city) => city.region_id == client.region_id
        );
        setAvailableCities(filteredCities);

        // If the client has a city_id, make sure it's in the filtered cities
        if (client.city_id) {
            setSelectedCity(client.city_id);
        } else {
            setSelectedCity("");
        }
    }, []);
    const mapsLink =
        "https://maps.google.com/maps?q=" +
        client.latitude +
        "," +
        client.longitude +
        "&hl=es;z=14&output=embed";
    const {
        props: { errors },
    } = usePage();
    console.log(errors);
    return (
        <DefaultLayout>
            <div ref={contentRef}>
                <Breadcrumb pageName="تعديل طالب الخدمة" />

                <div
                    className="grid grid-cols-1 gap-9"
                    style={{ direction: "rtl" }}
                >
                    {isSuccess && <SuccessNotification />}
                    {isError && <ErrorNotification />}
                    <div className="flex flex-col gap-9">
                        {/* <!-- Contact Form --> */}
                        <div className="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                            <div className="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                                <h3 className="font-medium text-black dark:text-white">
                                    المعلومات الشخصية
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
                                        {errors.name && (
                                            <p className="text-red-600">
                                                {errors.name}
                                            </p>
                                        )}
                                    </div>

                                    <div className="w-full xl:w-1/2">
                                        <label className="mb-2.5 block text-black dark:text-white">
                                            رقم الجوال
                                        </label>
                                        <div className="flex">
                                            <select
                                                value={phoneCode}
                                                onChange={(e) =>
                                                    setPhoneCode(e.target.value)
                                                }
                                                className="w-1/2 rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                            >
                                                {countries.map((country) => (
                                                    <option
                                                        value={
                                                            country.phone_code
                                                        }
                                                    >{`${country.name} (${country.phone_code})`}</option>
                                                ))}
                                            </select>
                                            <input
                                                type="number"
                                                placeholder="رقم الجوال"
                                                value={mobile}
                                                onChange={(e) =>
                                                    setMobile(e.target.value)
                                                }
                                                className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                            />
                                        </div>
                                        {errors.phone && (
                                            <p className="text-red-600">
                                                {errors.phone}
                                            </p>
                                        )}
                                    </div>
                                </div>

                                <div className="mb-4.5">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        البريد الالكتروني
                                        <span className="text-meta-1">*</span>
                                    </label>
                                    <input
                                        type="email"
                                        placeholder="Enter your email address"
                                        value={email}
                                        onChange={(e) =>
                                            setEmail(e.target.value)
                                        }
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                    />
                                    {errors.email && (
                                        <p className="text-red-600">
                                            {errors.email}
                                        </p>
                                    )}
                                </div>
                                <div className="mb-4.5">
                                    <SelectGroup
                                        options={types}
                                        title="النوع"
                                        selectedOption={selectedType}
                                        setSelectedOption={setSelectedType}
                                    />
                                    {errors.type && (
                                        <p className="text-red-600">
                                            {errors.type}
                                        </p>
                                    )}
                                </div>
                                <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                    <div className="w-full">
                                        <SelectGroup
                                            options={nationalities}
                                            title="الجنسية"
                                            selectedOption={selectedNationality}
                                            setSelectedOption={
                                                setSelectedNationality
                                            }
                                        />
                                        {errors.nationality && (
                                            <p className="text-red-600">
                                                {errors.nationality}
                                            </p>
                                        )}
                                    </div>
                                    <div className="w-full">
                                        <SelectGroup
                                            options={countries}
                                            title="الدولة"
                                            selectedOption={selectedCountry}
                                            setSelectedOption={
                                                setSelectedCountry
                                            }
                                        />
                                        {errors.country_id && (
                                            <p className="text-red-600">
                                                {errors.country_id}
                                            </p>
                                        )}
                                    </div>
                                    <div className="w-full">
                                        <SelectGroup
                                            options={availableRegions}
                                            title="المنطقة"
                                            selectedOption={selectedRegion}
                                            setSelectedOption={
                                                setSelectedRegion
                                            }
                                        />
                                        {errors.region && (
                                            <p className="text-red-600">
                                                {errors.region}
                                            </p>
                                        )}
                                    </div>
                                </div>
                                <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                    <div className="w-full">
                                        <SelectGroup
                                            options={availableCities}
                                            title="المدينة"
                                            selectedOption={selectedCity}
                                            setSelectedOption={setSelectedCity}
                                        />
                                        {errors.city && (
                                            <p className="text-red-600">
                                                {errors.city}
                                            </p>
                                        )}
                                    </div>
                                    <div className="w-full">
                                        <SelectGroup
                                            options={[
                                                { id: "Male", name: "ذكر" },
                                                { id: "Female", name: "انثى" },
                                            ]}
                                            title="الجنس"
                                            selectedOption={gender}
                                            setSelectedOption={setGender}
                                        />
                                        {errors.gender && (
                                            <p className="text-red-600">
                                                {errors.gender}
                                            </p>
                                        )}
                                    </div>
                                </div>
                                <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                    <div className="w-full xl:w-1/2">
                                        <label className="mb-2.5 block text-black dark:text-white">
                                            خط الطول :
                                        </label>
                                        <input
                                            type="text"
                                            disabled={true}
                                            placeholder="خط الطول"
                                            className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                            value={client.latitude}
                                        />
                                        {errors.latitude && (
                                            <p className="text-red-600">
                                                {errors.latitude}
                                            </p>
                                        )}
                                    </div>

                                    <div className="w-full xl:w-1/2">
                                        <label className="mb-2.5 block text-black dark:text-white">
                                            خط العرض :{" "}
                                        </label>
                                        <input
                                            type="text"
                                            disabled={true}
                                            placeholder="خط العرض"
                                            className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                            value={client.longitude}
                                        />
                                        {errors.longitude && (
                                            <p className="text-red-600">
                                                {errors.longitude}
                                            </p>
                                        )}
                                    </div>
                                </div>
                                <div className="mb-4.5 w-full h-150">
                                    <iframe
                                        className="w-full h-full"
                                        src={mapsLink}
                                    ></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                        <div className="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                            <h3 className="font-medium text-black dark:text-white">
                                حالة الحساب
                            </h3>
                        </div>
                        <div className="p-6.5 flex-col">
                            <SelectGroup
                                options={[
                                    { id: 1, name: "جديد" },
                                    { id: 2, name: "قبول" },
                                    { id: 3, name: "انتظار" },
                                    { id: 0, name: "حظر" },
                                ]}
                                title={""}
                                selectedOption={status}
                                setSelectedOption={setStatus}
                            />
                            {errors.status && (
                                <p className="text-red-600">{errors.status}</p>
                            )}
                            {client.status.toString() != status && (
                                <div className="w-full">
                                    <TextInput
                                        label="سبب التغيير"
                                        type="textarea"
                                        value={statusReason}
                                        setValue={setStatusReason}
                                        error={errors.status_reason}
                                        required={true}
                                    />
                                </div>
                            )}
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
                            onClick={() => router.get("/newAdmin/clients")}
                            className="flex w-full justify-center rounded bg-danger p-3 font-medium text-gray hover:bg-opacity-90"
                        >
                            الرجوع للقائمة
                        </button>
                    </div>
                </div>
            </div>
        </DefaultLayout>
    );
};

export default EditClient;
