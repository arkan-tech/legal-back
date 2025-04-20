import { Link, router, usePage } from "@inertiajs/react";
import Breadcrumb from "../../components/Breadcrumbs/Breadcrumb";
import SelectGroup from "../../components/Forms/SelectGroup/SelectGroup";
import DefaultLayout from "../../layout/DefaultLayout";
import React, { useEffect, useRef, useState } from "react";
import GoogleMapReact from "google-map-react";
import { LawyerUser } from "../../types/LawyerUser";
import DatePicker from "../../components/Forms/DatePicker/DatePicker";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faTrash } from "@fortawesome/free-solid-svg-icons";
import SuccessModal from "../../components/Modal/SuccessModal";
import toast from "react-hot-toast";
import MultiSelectDropdown from "../../components/Forms/MultiSelectDropdown";
import SuccessNotification from "../../components/SuccessNotification";
import ErrorNotification from "../../components/ErrorNotification";
import TextInput from "../../components/TextInput";
import SaveButton from "../../components/SaveButton";
import BackButton from "../../components/BackButton";
import FileInput from "../../components/FileInput";
const EditLawyer = ({
    lawyer,
    nationalities,
    countries,
    regions,
    cities,
    districts,
    degrees,
    sections,
    advisories,
    GeneralSpecialty,
    AccurateSpecialty,
    lawyer_advisories,
    functional_cases,
    lawyer_sections,
    types,
    success,
}: {
    lawyer: LawyerUser;
    nationalities;
    countries;
    regions;
    cities;
    types;
    success?;
    districts;
    degrees;
    sections;
    advisories;
    GeneralSpecialty;
    AccurateSpecialty;
    lawyer_advisories;
    functional_cases;
    lawyer_sections;
}) => {
    const contentRef = useRef<HTMLDivElement>(null);
    types = types.slice(0, 4);
    types.push({ id: 5, name: "هيئة" });
    console.log(lawyer);
    const nameParts = lawyer.name.split(" ");
    const [firstName, setFirstName] = useState(nameParts[0] || "");
    const [secondName, setSecondName] = useState(nameParts[1] || "");
    const [thirdName, setThirdName] = useState(
        nameParts.length > 3 ? nameParts[2] : ""
    );
    const [fourthName, setFourthName] = useState(
        nameParts.length > 3 ? nameParts.slice(3).join(" ") : nameParts[2] || ""
    );
    const [phoneCode, setPhoneCode] = useState(lawyer.phone_code.toString());
    const [mobile, setMobile] = useState(lawyer.phone);
    const [email, setEmail] = useState(lawyer.email);
    const [selectedType, setSelectedType] = useState(
        lawyer?.type?.toString() || ""
    );
    const [selectedNationality, setSelectedNationality] = useState(
        lawyer?.nationality_id?.toString() || ""
    );
    const [showInNewAdvisors, setShowInNewAdvisors] = useState(
        lawyer.lawyer_details.show_in_advisory_website?.toString() || ""
    );
    const [companyName, setCompanyName] = useState(
        lawyer.lawyer_details.company_name
    );
    const [companyLicensesNo, setCompanyLicensesNo] = useState(
        lawyer.lawyer_details.company_licenses_no
    );
    const [selectedCountry, setSelectedCountry] = useState(
        lawyer?.country_id?.toString() || ""
    );
    const [selectedRegion, setSelectedRegion] = useState(
        lawyer?.region_id?.toString() || ""
    );
    const [selectedCity, setSelectedCity] = useState(
        lawyer?.city_id?.toString() || ""
    );
    const [gender, setGender] = useState(lawyer.gender || "");
    const [status, setStatus] = useState(lawyer?.status?.toString() || "");

    const [identityType, setIdentityType] = useState(
        lawyer?.lawyer_details.identity_type?.toString() || ""
    );
    const [about, setAbout] = useState(lawyer.lawyer_details.about);
    const [natId, setNatId] = useState(lawyer.lawyer_details.national_id);
    const [generalSpecialty, setGeneralSpecialty] = useState(
        lawyer?.lawyer_details.general_specialty?.toString() || ""
    );
    const [successState, setSuccessState] = useState(success);
    const [accurateSpecialty, setAccurateSpecialty] = useState(
        lawyer?.lawyer_details.accurate_specialty?.toString() || ""
    );
    const [functionalCases, setFunctionalCases] = useState(
        lawyer?.lawyer_details.functional_cases?.toString() || ""
    );
    const [degree, setDegree] = useState(
        lawyer?.lawyer_details.degree?.toString() || ""
    );
    const [dateOfBirth, setDateOfBirth] = useState(lawyer.birthdate);
    const [digitalGuideSubscription, setDigitalGuideSubscription] = useState(
        lawyer?.lawyer_details.digital_guide_subscription?.toString() || ""
    );

    const [showAtDigitalGuide, setShowAtDigitalGuide] = useState(
        lawyer?.lawyer_details.show_at_digital_guide?.toString() || ""
    );
    const [special, setSpecial] = useState(
        lawyer.lawyer_details.is_special?.toString() || ""
    );
    const [isAdvisor, setIsAdvisor] = useState(
        lawyer?.lawyer_details.is_advisor?.toString() || "0"
    );
    const [lawyerAdvisories, setLawyerAdvisoies] = useState(
        lawyer_advisories?.map((l) => l) || []
    );
    const [isPricingCommittee, setIsPricingCommittee] = useState(
        lawyer.pricing_committee != null ? "1" : "0"
    );
    const [photo, setPhoto] = useState();
    const [logo, setLogo] = useState();
    const [statusReason, setStatusReason] = useState("");
    const mapsLink =
        "https://maps.google.com/maps?q=" +
        lawyer.latitude +
        "," +
        lawyer.longitude +
        "&hl=es;z=14&output=embed";

    const {
        props: { errors },
    } = usePage();
    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);
    const [cvFileSize, setCvFileSize] = useState<string | null>(null);

    useEffect(() => {
        if (lawyer.lawyer_details.cv_file) {
            fetch(lawyer.lawyer_details.cv_file)
                .then((response) => response.blob())
                .then((blob) => {
                    setCvFileSize(
                        (blob.size / (1024 * 1024)).toFixed(2) + " MB"
                    );
                });
        }
    }, [lawyer.lawyer_details.cv_file]);
    const [companyLicenseFileSize, setCompanyLicenseFileSize] = useState<
        string | null
    >(null);
    useEffect(() => {
        if (lawyer.lawyer_details.company_license_file) {
            fetch(lawyer.lawyer_details.company_license_file)
                .then((response) => response.blob())
                .then((blob) => {
                    setCompanyLicenseFileSize(
                        (blob.size / (1024 * 1024)).toFixed(2) + " MB"
                    );
                });
        }
    }, [lawyer.lawyer_details.company_license_file]);
    const [nationalIdImageSize, setNationalIdImageSize] = useState<
        string | null
    >(null);
    useEffect(() => {
        if (lawyer.lawyer_details.national_id_image) {
            fetch(lawyer.lawyer_details.national_id_image)
                .then((response) => response.blob())
                .then((blob) => {
                    setNationalIdImageSize(
                        (blob.size / (1024 * 1024)).toFixed(2) + " MB"
                    );
                });
        }
    }, [lawyer.lawyer_details.national_id_image]);
    useEffect(() => {
        if (Object.keys(errors).length > 0) {
            contentRef.current?.scrollIntoView({ behavior: "smooth" });
        }
    }, [errors]);
    const saveData = () => {
        // Change the controller to return a request and make it use axios to show the toast correctly
        const formData = new FormData();
        formData.append("id", lawyer.id.toString());
        formData.append("birth_date", dateOfBirth);
        formData.append("phone_code", phoneCode.toString());
        formData.append("phone", mobile);
        formData.append("status", status);
        formData.append("type", selectedType);
        formData.append("show_in_advisory_website", showInNewAdvisors);
        formData.append("show_at_digital_guide", showAtDigitalGuide);
        formData.append("is_advisor", isAdvisor);
        if (isAdvisor == "1") {
            lawyerAdvisories.forEach((advisory, index) => {
                formData.append(`advisor_cat_id[${index}]`, advisory);
            });
        }
        formData.append("gender", gender);
        formData.append("email", email);
        formData.append("country_id", selectedCountry);
        formData.append("region", selectedRegion);
        formData.append("city", selectedCity);
        formData.append("nationality", selectedNationality);
        formData.append("degree", degree);
        formData.append("fname", firstName);
        formData.append("sname", secondName);
        formData.append("tname", thirdName);
        formData.append("fourthname", fourthName);
        formData.append("company_licence_no", companyLicensesNo);
        formData.append("company_name", companyName);
        formData.append("about", about);
        formData.append("identity_type", identityType);
        formData.append("nat_id", natId);
        formData.append("general_specialty", generalSpecialty);
        formData.append("accurate_specialty", accurateSpecialty);
        formData.append("functional_cases", functionalCases);
        formData.append("digital_guide_subscription", digitalGuideSubscription);
        formData.append("status_reason", statusReason);
        formData.append("is_pricing_committee", isPricingCommittee);
        // formData.append(
        //     "digital_guide_subscription_to",
        //     digitalGuideSubscriptionTo
        // );
        // formData.append(
        //     "digital_guide_subscription_from",
        //     digitalGuideSubscriptionFrom
        // );
        formData.append("special", special);
        if (photo && typeof photo != "string") {
            formData.append("profile_photo", photo);
        }
        // formData.append("company_lisences_file", companyLicensesFile);
        if (logo && typeof logo != "string") {
            formData.append("logo", logo);
        }
        // formData.append("national_id_image", idFile);
        // formData.append("cv_file", cv);
        // formData.append("degree_certificate", degreeCertificate);
        // formData.append("office_request", officeRequest);
        // formData.append("office_request_status", officeRequestStatus);
        // formData.append("office_request_from", officeRequestFrom);
        // formData.append("office_request_to", officeRequestTo);

        router.post("/admin/digital-guide/update", formData, {
            onSuccess: () => {
                setIsSuccess(true);
                contentRef.current?.scrollIntoView({ behavior: "smooth" });
            },
            onError: () => {},
        });
    };
    const [availableRegions, setAvailableRegions] = useState(
        regions.filter((r) => r.country_id == lawyer.country_id)
    );
    const [availableCities, setAvailableCities] = useState(
        cities.filter((c) => c.region_id == lawyer.region_id)
    );
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
        if (lawyer.region_id) {
            setSelectedRegion(lawyer.region_id.toString());
        } else {
            setSelectedRegion("");
        }

        // Filter cities based on the client's region_id (if available)
        const filteredCities = cities.filter(
            (city) => city.region_id == lawyer.region_id
        );
        setAvailableCities(filteredCities);

        // If the client has a city_id, make sure it's in the filtered cities
        if (lawyer.city_id) {
            setSelectedCity(lawyer.city_id.toString());
        } else {
            setSelectedCity("");
        }
    }, []);
    return (
        <DefaultLayout>
            <div ref={contentRef}>
                <Breadcrumb pageName="تعديل مقدم خدمة" />
                {isSuccess && <SuccessNotification />}
                {isError && <ErrorNotification />}
                <div
                    className="grid grid-cols-1 gap-9"
                    style={{ direction: "rtl" }}
                >
                    {/* change success to a modal, show errors */}
                    <div className="flex flex-col gap-9">
                        <div className="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                            <div className="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                                <h3 className="font-medium text-black dark:text-white">
                                    الشاشة الاولى
                                </h3>
                            </div>
                            <div className="p-6.5">
                                <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                    <div className="w-full xl:w-1/2">
                                        <TextInput
                                            label="الاسم الاول"
                                            value={firstName}
                                            setValue={setFirstName}
                                            error={errors.fname}
                                            required={true}
                                        />
                                    </div>
                                    <div className="w-full xl:w-1/2">
                                        <TextInput
                                            label="الاسم الثاني"
                                            value={secondName}
                                            setValue={setSecondName}
                                            error={errors.sname}
                                            required={true}
                                        />
                                    </div>
                                    <div className="w-full xl:w-1/2">
                                        <TextInput
                                            label="الاسم الثالث"
                                            value={thirdName}
                                            setValue={setThirdName}
                                            error={errors.tname}
                                        />
                                    </div>
                                    <div className="w-full xl:w-1/2">
                                        <TextInput
                                            label="الاسم الرابع"
                                            value={fourthName}
                                            setValue={setFourthName}
                                            error={errors.fourthname}
                                            required={true}
                                        />
                                    </div>
                                </div>

                                <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                    <div className="w-full xl:w-1/2">
                                        <label className="mb-2.5 block text-[#bababa] dark:text-white">
                                            رقم الجوال
                                            <span className="text-meta-1">
                                                *
                                            </span>
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
                                                        key={country.phone_code}
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
                                            <p className="text-red-500">
                                                {errors.phone}
                                            </p>
                                        )}
                                    </div>
                                    <div className="w-full xl:w-1/2">
                                        <TextInput
                                            label="البريد الالكتروني"
                                            value={email}
                                            setValue={setEmail}
                                            error={errors.email}
                                            required={true}
                                            type="email"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                            <div className="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                                <h3 className="font-medium text-black dark:text-white">
                                    الشاشة الثانية
                                </h3>
                            </div>
                            <div className="p-6.5">
                                <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                    <div className="w-full xl:w-1/2">
                                        <SelectGroup
                                            options={types}
                                            title="النوع"
                                            selectedOption={selectedType}
                                            setSelectedOption={setSelectedType}
                                        />
                                        {errors.type && (
                                            <p className="text-red-500">
                                                {errors.type}
                                            </p>
                                        )}
                                    </div>
                                </div>
                                <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                    {selectedType == "5" ||
                                    selectedType == "4" ? (
                                        <div className="w-full xl:w-1/2">
                                            <TextInput
                                                label="اسم الجهة"
                                                value={companyName}
                                                setValue={setCompanyName}
                                                error={errors.company_name}
                                            />
                                        </div>
                                    ) : selectedType == "2" ||
                                      selectedType == "3" ? (
                                        <>
                                            <div className="w-full xl:w-1/2">
                                                <TextInput
                                                    label="الرقم التجاري"
                                                    value={companyLicensesNo}
                                                    setValue={
                                                        setCompanyLicensesNo
                                                    }
                                                    error={
                                                        errors.company_lisences_no
                                                    }
                                                />
                                            </div>
                                            <div className="w-full xl:w-1/2">
                                                <FileInput
                                                    fileName="ملف الترخيص"
                                                    fileExtension="pdf"
                                                    fileSize={
                                                        companyLicenseFileSize as string
                                                    }
                                                    filePath={
                                                        lawyer.lawyer_details
                                                            ?.company_license_file
                                                    }
                                                />
                                                {errors.company_lisences_file && (
                                                    <p className="text-red-500">
                                                        {
                                                            errors.company_lisences_file
                                                        }
                                                    </p>
                                                )}
                                            </div>
                                        </>
                                    ) : (
                                        <div className="w-full">
                                            <FileInput
                                                fileName="ملف السيرة الذاتية"
                                                fileExtension="pdf"
                                                fileSize={cvFileSize as string}
                                                filePath={
                                                    lawyer.lawyer_details
                                                        ?.cv_file
                                                }
                                            />
                                            {errors.cv && (
                                                <p className="text-red-500">
                                                    {errors.cv}
                                                </p>
                                            )}
                                        </div>
                                    )}
                                </div>

                                <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                    <div className="w-full">
                                        <label className="mb-2.5 block text-black dark:text-white">
                                            تعريف مختصر :{" "}
                                        </label>
                                        <textarea
                                            className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                            rows={5}
                                            value={about}
                                            onChange={(e) =>
                                                setAbout(e.target.value)
                                            }
                                        />
                                        {errors.about && (
                                            <p className="text-red-500">
                                                {errors.about}
                                            </p>
                                        )}
                                    </div>
                                </div>
                                <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                    <div className="w-full xl:w-1/2">
                                        <DatePicker
                                            uniqueKey={"DOB"}
                                            title="تاريخ الميلاد"
                                            selectedDate={dateOfBirth}
                                            setSelectedDate={setDateOfBirth}
                                        />
                                        {errors.birth_date && (
                                            <p className="text-red-500">
                                                {errors.birth_date}
                                            </p>
                                        )}
                                    </div>
                                    <div className="w-full xl:w-1/2">
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
                                            <p className="text-red-500">
                                                {errors.gender}
                                            </p>
                                        )}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                            <div className="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                                <h3 className="font-medium text-black dark:text-white">
                                    الشاشة الثالثة
                                </h3>
                            </div>
                            <div className="p-6.5">
                                <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                    <div className="w-full xl:w-1/2">
                                        <SelectGroup
                                            options={nationalities}
                                            title="الجنسية"
                                            selectedOption={selectedNationality}
                                            setSelectedOption={
                                                setSelectedNationality
                                            }
                                        />
                                        {errors.nationality && (
                                            <p className="text-red-500">
                                                {errors.nationality}
                                            </p>
                                        )}
                                    </div>
                                    <div className="w-full xl:w-1/2">
                                        <SelectGroup
                                            options={countries}
                                            title="الدولة"
                                            selectedOption={selectedCountry}
                                            setSelectedOption={
                                                setSelectedCountry
                                            }
                                        />
                                        {errors.country_id && (
                                            <p className="text-red-500">
                                                {errors.country_id}
                                            </p>
                                        )}
                                    </div>
                                </div>
                                <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                    <div className="w-full xl:w-1/2">
                                        <SelectGroup
                                            options={availableRegions}
                                            title="المنطقة"
                                            selectedOption={selectedRegion}
                                            setSelectedOption={
                                                setSelectedRegion
                                            }
                                        />
                                        {errors.region && (
                                            <p className="text-red-500">
                                                {errors.region}
                                            </p>
                                        )}
                                    </div>
                                    <div className="w-full xl:w-1/2">
                                        <SelectGroup
                                            options={availableCities}
                                            title="المدينة"
                                            selectedOption={selectedCity}
                                            setSelectedOption={setSelectedCity}
                                        />
                                        {errors.city && (
                                            <p className="text-red-500">
                                                {errors.city}
                                            </p>
                                        )}
                                    </div>
                                </div>
                                <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                    <div className="w-full xl:w-1/2">
                                        <TextInput
                                            type="text"
                                            label="خط الطول"
                                            disabled={true}
                                            value={lawyer.latitude}
                                            error={errors.latitude}
                                        />
                                    </div>

                                    <div className="w-full xl:w-1/2">
                                        <TextInput
                                            type="text"
                                            label="خط العرض"
                                            disabled={true}
                                            value={lawyer.longitude}
                                            error={errors.longitude}
                                        />
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
                        <div className="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                            <div className="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                                <h3 className="font-medium text-black dark:text-white">
                                    الشاشة الرابعة
                                </h3>
                            </div>
                            <div className="p-6.5">
                                <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                    <div className="w-full xl:w-1/2">
                                        <SelectGroup
                                            options={[
                                                { id: 1, name: "هوية وطنية" },
                                                { id: 2, name: "جواز السفر" },
                                                { id: 3, name: "هوية مقيم" },
                                            ]}
                                            title={"نوع الهوية"}
                                            selectedOption={identityType}
                                            setSelectedOption={setIdentityType}
                                        />
                                        {errors.identity_type && (
                                            <p className="text-red-500">
                                                {errors.identity_type}
                                            </p>
                                        )}
                                    </div>
                                    <div className="w-full xl:w-1/2">
                                        <TextInput
                                            label="الرقم"
                                            value={natId}
                                            setValue={setNatId}
                                            error={errors.nat_id}
                                            onInput={(e) => {
                                                e.currentTarget.value.length >
                                                10
                                                    ? (e.currentTarget.value =
                                                          e.currentTarget.value.slice(
                                                              0,
                                                              10
                                                          ))
                                                    : e.currentTarget.value;
                                            }}
                                            type={
                                                identityType == "2"
                                                    ? "text"
                                                    : "number"
                                            }
                                        />
                                    </div>
                                </div>
                                <div className="mb-4.5 flex items-center">
                                    <FileInput
                                        fileName="ملف الهوية"
                                        fileExtension="pdf"
                                        fileSize={nationalIdImageSize as string}
                                        filePath={
                                            lawyer.lawyer_details
                                                ?.national_id_image
                                        }
                                    />

                                    {errors.id_file && (
                                        <p className="text-red">
                                            {errors.id_file}
                                        </p>
                                    )}
                                </div>
                                <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                    <div className="w-full xl:w-1/2">
                                        <SelectGroup
                                            options={GeneralSpecialty}
                                            title={"التخصص العام"}
                                            selectedOption={generalSpecialty}
                                            setSelectedOption={
                                                setGeneralSpecialty
                                            }
                                        />
                                        {errors.general_specialty && (
                                            <p className="text-red-500">
                                                {errors.general_specialty}
                                            </p>
                                        )}
                                    </div>
                                    <div className="w-full xl:w-1/2">
                                        <SelectGroup
                                            options={AccurateSpecialty}
                                            title={"التخصص الدقيق"}
                                            selectedOption={accurateSpecialty}
                                            setSelectedOption={
                                                setAccurateSpecialty
                                            }
                                        />
                                        {errors.accurate_specialty && (
                                            <p className="text-red-500">
                                                {errors.accurate_specialty}
                                            </p>
                                        )}
                                    </div>
                                </div>
                                <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                    <div className="w-full xl:w-1/2">
                                        <SelectGroup
                                            options={functional_cases}
                                            title={"الحالة الوظيفية"}
                                            selectedOption={functionalCases}
                                            setSelectedOption={
                                                setFunctionalCases
                                            }
                                        />
                                        {errors.functional_cases && (
                                            <p className="text-red-500">
                                                {errors.functional_cases}
                                            </p>
                                        )}
                                    </div>
                                    <div className="w-full xl:w-1/2">
                                        <SelectGroup
                                            options={degrees}
                                            title={"الدرجة العلمية"}
                                            selectedOption={degree}
                                            setSelectedOption={setDegree}
                                        />
                                        {errors.degree && (
                                            <p className="text-red-500">
                                                {errors.degree}
                                            </p>
                                        )}
                                    </div>
                                    {lawyer.lawyer_details
                                        .degree_certificate ? (
                                        <div className="w-full flex flex-col gap-2">
                                            <label>
                                                {lawyer.lawyer_details
                                                    .degree_certificate
                                                    ? "✅ "
                                                    : "❌ "}
                                                الشهادة العلمية:
                                            </label>
                                            <div className="flex gap-2">
                                                <a
                                                    href={
                                                        lawyer.lawyer_details
                                                            .degree_certificate
                                                    }
                                                    target="_blank"
                                                    className="justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90"
                                                >
                                                    عرض الملف
                                                </a>
                                                <a
                                                    href={
                                                        lawyer.lawyer_details
                                                            .degree_certificate
                                                    }
                                                    download={
                                                        lawyer.lawyer_details
                                                            .degree_certificate
                                                    }
                                                    className="justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90"
                                                >
                                                    تحميل الملف
                                                </a>
                                                <button className="justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90">
                                                    ازالة الملف
                                                </button>
                                            </div>

                                            {errors.degree_certificate && (
                                                <p className="text-red-500">
                                                    {errors.degree_certificate}
                                                </p>
                                            )}
                                        </div>
                                    ) : null}
                                </div>
                                <div className="mb-4.5">
                                    <label className="mb-2.5 block text-[#bababa] dark:text-white">
                                        المهن
                                    </label>
                                    <div
                                        className="w-full flex flex-col gap-4"
                                        style={{ direction: "rtl" }}
                                    >
                                        {lawyer_sections.map((section) => (
                                            <div className="flex gap-4 w-full">
                                                <div className="flex gap-4 py-3 border justify-center border-[#bababa] rounded-lg w-1/2">
                                                    {section.section ? (
                                                        <div className="flex flex-col gap-1 items-center">
                                                            <p className="text-[#bababa]">
                                                                المهنة
                                                            </p>
                                                            <p className="text-center text-black font-semibold">
                                                                {
                                                                    section
                                                                        .section
                                                                        .title
                                                                }
                                                            </p>
                                                        </div>
                                                    ) : (
                                                        "غير معروف"
                                                    )}
                                                    <div className="border-l border-[#bababa] h-full mx-4"></div>{" "}
                                                    {section.section &&
                                                    section.section
                                                        .need_license == 1 ? (
                                                        <div className="flex flex-col gap-1 items-center">
                                                            <p className="text-[#bababa]">
                                                                المهنة تحتاج
                                                                ترخيص
                                                            </p>
                                                            <p className="text-center text-black font-semibold">
                                                                تحتاج ترخيص
                                                            </p>
                                                        </div>
                                                    ) : (
                                                        <div className="flex flex-col gap-1 items-center">
                                                            <p className="text-[#bababa]">
                                                                المهنة تحتاج
                                                                ترخيص
                                                            </p>
                                                            <p className="text-center text-black font-semibold">
                                                                لا تحتاج ترخيص
                                                            </p>
                                                        </div>
                                                    )}
                                                    <div className="border-l border-[#bababa] h-full mx-4"></div>{" "}
                                                    <div className="flex flex-col gap-1 items-center">
                                                        <p className="text-[#bababa]">
                                                            رقم الترخيص
                                                        </p>
                                                        <p className="text-center text-black font-semibold">
                                                            {section.licence_no}
                                                        </p>
                                                    </div>
                                                </div>
                                                <FileInput
                                                    fileName="ملف الترخيص"
                                                    filePath={
                                                        section.licence_file
                                                    }
                                                    showFile={false}
                                                />
                                            </div>
                                        ))}
                                    </div>
                                    {errors.sections && (
                                        <p className="text-red">
                                            {errors.sections}
                                        </p>
                                    )}
                                </div>
                            </div>
                        </div>
                        <div className="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                            <div className="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                                <h3 className="font-medium text-black dark:text-white">
                                    الشاشة الخامسة
                                </h3>
                            </div>
                            <div className="flex flex-col xl:flex-row py-6.5 items-center justify-center w-full">
                                <div className="w-full justify-center items-center flex flex-col gap-2">
                                    <label>
                                        {!lawyer.lawyer_details.logo.endsWith(
                                            "person.png"
                                        )
                                            ? "✅ "
                                            : "❌ "}
                                        الشعار
                                    </label>
                                    <img
                                        src={lawyer.lawyer_details.logo}
                                        alt="logo"
                                        className="w-50"
                                    />
                                    <div className="flex flex-row gap-3">
                                        <div className="flex gap-2">
                                            <a
                                                href={
                                                    lawyer.lawyer_details.logo
                                                }
                                                target="_blank"
                                                className="justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90"
                                            >
                                                عرض الملف
                                            </a>
                                            <a
                                                href={
                                                    lawyer.lawyer_details.logo
                                                }
                                                download={
                                                    lawyer.lawyer_details.logo
                                                }
                                                className="justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90"
                                            >
                                                تحميل الملف
                                            </a>
                                            <button className="justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90">
                                                ازالة الملف
                                            </button>
                                        </div>
                                    </div>
                                    <p>يسمح فقط بنوع : png, jpg, jpeg.</p>
                                    {errors.logo && (
                                        <p className="text-red">
                                            {errors.logo}
                                        </p>
                                    )}
                                </div>
                                <div className="w-full justify-center items-center flex flex-col gap-2">
                                    <label>
                                        {!lawyer.profile_photo_url?.endsWith(
                                            "person.png"
                                        ) &&
                                        !lawyer.profile_photo_url?.endsWith(
                                            "Male.png"
                                        ) &&
                                        !lawyer.profile_photo_url?.endsWith(
                                            "Female.png"
                                        )
                                            ? "✅ "
                                            : "❌ "}
                                        الصورة الشخصية
                                    </label>

                                    <img
                                        src={
                                            photo
                                                ? URL.createObjectURL(photo)
                                                : lawyer.profile_photo_url
                                        }
                                        alt="photo"
                                        className="w-50"
                                    />
                                    <div className="flex flex-row gap-3">
                                        <div className="flex gap-2">
                                            <a
                                                href={lawyer.profile_photo}
                                                target="_blank"
                                                className="justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90"
                                            >
                                                عرض الملف
                                            </a>
                                            <a
                                                href={lawyer.profile_photo}
                                                download={lawyer.profile_photo}
                                                className="justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90"
                                            >
                                                تحميل الملف
                                            </a>
                                            <button className="justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90">
                                                ازالة الملف
                                            </button>
                                        </div>
                                    </div>
                                    <p>يسمح فقط بنوع : png, jpg, jpeg.</p>
                                    {errors.photo && (
                                        <p className="text-red">
                                            {errors.photo}
                                        </p>
                                    )}
                                </div>
                            </div>
                        </div>
                        <div className="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                            <div className="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                                <h3 className="font-medium text-black dark:text-white">
                                    معلومات تتعلق في هيئة المستشارين
                                </h3>
                            </div>
                            <div className="flex flex-col xl:flex-row gap-6 p-6.5">
                                <div className="w-full">
                                    <SelectGroup
                                        options={[
                                            { id: 0, name: "لا" },
                                            { id: 1, name: "نعم" },
                                        ]}
                                        title={"مضاف الى هيئة المستشارين:"}
                                        selectedOption={isAdvisor}
                                        setSelectedOption={setIsAdvisor}
                                    />
                                    {errors.is_advisor && (
                                        <p className="text-red">
                                            {errors.is_advisor}
                                        </p>
                                    )}
                                </div>
                                {isAdvisor == "1" && (
                                    <div className="w-full">
                                        <label className="mb-2.5 block text-black dark:text-white">
                                            التخصص{" "}
                                        </label>
                                        <MultiSelectDropdown
                                            options={advisories}
                                            selectedOptions={lawyerAdvisories}
                                            setSelectedOptions={
                                                setLawyerAdvisoies
                                            }
                                        />
                                        {errors.advisor_cat_id && (
                                            <p className="text-red-600">
                                                {errors.advisor_cat_id}
                                            </p>
                                        )}
                                    </div>
                                )}
                            </div>
                            <div className="flex flex-col xl:flex-row gap-6 p-6.5">
                                <div className="w-full">
                                    <SelectGroup
                                        options={[
                                            { id: 0, name: "لا" },
                                            { id: 1, name: "نعم" },
                                        ]}
                                        title={"مضاف الى هيئة المسعرين:"}
                                        selectedOption={isPricingCommittee}
                                        setSelectedOption={
                                            setIsPricingCommittee
                                        }
                                    />
                                    {errors.is_pricing_committee && (
                                        <p className="text-red">
                                            {errors.is_pricing_committee}
                                        </p>
                                    )}
                                </div>
                            </div>
                        </div>
                        <div className="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                            <div className="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                                <h3 className="font-medium text-black dark:text-white">
                                    حالة الحساب
                                </h3>
                            </div>
                            <div className="flex flex-col xl:flex-row gap-6 p-6.5">
                                <div className="w-full flex flex-col gap-4">
                                    <div className="w-full">
                                        <SelectGroup
                                            options={[
                                                { id: 1, name: "جديد" },
                                                { id: 2, name: "قبول" },
                                                { id: 3, name: "انتظار" },
                                                { id: 0, name: "حظر" },
                                            ]}
                                            title={"حالة القبول :"}
                                            selectedOption={status}
                                            setSelectedOption={setStatus}
                                        />
                                        {errors.accepted && (
                                            <p className="text-red">
                                                {errors.accepted}
                                            </p>
                                        )}
                                    </div>
                                    {lawyer.status.toString() != status && (
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
                                <div className="w-full">
                                    <SelectGroup
                                        options={[
                                            { id: 0, name: "غير ظاهر" },
                                            { id: 1, name: "ظاهر" },
                                        ]}
                                        title={
                                            "الظهور في المستشارين المنضمين حديثا في الموقع :"
                                        }
                                        selectedOption={showInNewAdvisors}
                                        setSelectedOption={setShowInNewAdvisors}
                                    />
                                    {errors.paid_status && (
                                        <p className="text-red">
                                            {errors.paid_status}
                                        </p>
                                    )}
                                </div>
                            </div>
                        </div>
                        <div className="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                            <div className="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                                <h3 className="font-medium text-black dark:text-white">
                                    معلومات الدليل الرقمي
                                </h3>
                            </div>
                            {/* <div className="flex flex-col xl:flex-row gap-6 p-6.5">
                                <div className="w-full">
                                    <SelectGroup
                                        options={[
                                            { id: 1, name: "مشترك" },
                                            { id: 0, name: "غير مشترك" },
                                        ]}
                                        title={
                                            "حالة الاشتراك في باقة احد باقات الدليل الرقمي :"
                                        }
                                        selectedOption={
                                            digitalGuideSubscription
                                        }
                                        setSelectedOption={
                                            setDigitalGuideSubscription
                                        }
                                    />
                                    {errors.digital_guide_subscription && (
                                        <p className="text-red">
                                            {errors.digital_guide_subscription}
                                        </p>
                                    )}
                                </div>
                            </div> */}
                            <div className="flex flex-col xl:flex-row gap-6 p-6.5">
                                <div className="w-full">
                                    <SelectGroup
                                        options={[
                                            { id: 0, name: "مخفي" },
                                            { id: 1, name: "ظاهر" },
                                        ]}
                                        title={"حالة الظهور في الدليل الرقمي :"}
                                        selectedOption={showAtDigitalGuide}
                                        setSelectedOption={
                                            setShowAtDigitalGuide
                                        }
                                    />
                                    {errors.show_at_digital_guide && (
                                        <p className="text-red">
                                            {errors.show_at_digital_guide}
                                        </p>
                                    )}
                                </div>
                                <div className="w-full">
                                    <SelectGroup
                                        options={[
                                            { id: 0, name: "غير مميز" },
                                            { id: 1, name: "مميز" },
                                        ]}
                                        title={"هل العضو مميز ؟ :"}
                                        selectedOption={special}
                                        setSelectedOption={setSpecial}
                                    />
                                    {errors.special && (
                                        <p className="text-red">
                                            {errors.special}
                                        </p>
                                    )}
                                </div>
                            </div>
                        </div>
                        <div className="flex gap-6">
                            <SaveButton saveData={saveData} />
                            <BackButton path={"/newAdmin/lawyers"} />
                        </div>
                    </div>
                </div>
            </div>
        </DefaultLayout>
    );
};

export default EditLawyer;
