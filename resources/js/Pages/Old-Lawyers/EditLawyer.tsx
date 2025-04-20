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
import SaveButton from "../../components/SaveButton";
import BackButton from "../../components/BackButton";
const EditLawyer = ({
    lawyer,
    countries,
    success,
}: {
    lawyer;
    countries;
    success?;
}) => {
    const contentRef = useRef<HTMLDivElement>(null);
    const [firstName, setFirstName] = useState(lawyer.first_name);
    const [secondName, setSecondName] = useState(lawyer.second_name);
    const [thirdName, setThirdName] = useState(lawyer.third_name);
    const [fourthName, setFourthName] = useState(lawyer.fourth_name);
    const [phoneCode, setPhoneCode] = useState(lawyer.phone_code);
    const [mobile, setMobile] = useState(
        lawyer.phone.replace(new RegExp(`${phoneCode}`), "")
    );
    const [email, setEmail] = useState(lawyer.email);

    const [successState, setSuccessState] = useState(success);

    const {
        props: { errors },
    } = usePage();
    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);
    useEffect(() => {
        if (Object.keys(errors).length > 0) {
            contentRef.current?.scrollIntoView({ behavior: "smooth" });
        }
    }, [errors]);
    const saveData = () => {
        router.post(
            `/newAdmin/old-lawyers/${lawyer.id}`,
            {
                id: lawyer.id,
                phone_code: phoneCode,
                phone: mobile,
                email: email,
                first_name: firstName,
                second_name: secondName,
                third_name: thirdName,
                fourth_name: fourthName,
            },
            {
                onSuccess: () => {
                    setIsSuccess(true);
                    contentRef.current?.scrollIntoView({ behavior: "smooth" });
                },
                onError: () => {},
            }
        );
    };

    return (
        <DefaultLayout>
            <div ref={contentRef}>
                <Breadcrumb pageName="تعديل مقدم الخدمة القديم" />
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
                                        <label className="mb-2.5 block text-black dark:text-white">
                                            الاسم الاول
                                        </label>
                                        <input
                                            type="text"
                                            placeholder="الاسم"
                                            className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                            value={firstName}
                                            onChange={(e) =>
                                                setFirstName(e.target.value)
                                            }
                                        />
                                        {errors.first_name && (
                                            <p className="text-red-500">
                                                {errors.first_name}
                                            </p>
                                        )}
                                    </div>
                                    <div className="w-full xl:w-1/2">
                                        <label className="mb-2.5 block text-black dark:text-white">
                                            الاسم الثاني
                                        </label>
                                        <input
                                            type="text"
                                            placeholder="الاسم"
                                            className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                            value={secondName}
                                            onChange={(e) =>
                                                setSecondName(e.target.value)
                                            }
                                        />
                                        {errors.second_name && (
                                            <p className="text-red-500">
                                                {errors.second_name}
                                            </p>
                                        )}
                                    </div>
                                    <div className="w-full xl:w-1/2">
                                        <label className="mb-2.5 block text-black dark:text-white">
                                            الاسم الثالث{" "}
                                        </label>
                                        <input
                                            type="text"
                                            placeholder="الاسم"
                                            className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                            value={thirdName}
                                            onChange={(e) =>
                                                setThirdName(e.target.value)
                                            }
                                        />
                                        {errors.third_name && (
                                            <p className="text-red-500">
                                                {errors.third_name}
                                            </p>
                                        )}
                                    </div>
                                    <div className="w-full xl:w-1/2">
                                        <label className="mb-2.5 block text-black dark:text-white">
                                            الاسم الرابع
                                        </label>
                                        <input
                                            type="text"
                                            placeholder="الاسم"
                                            className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                            value={fourthName}
                                            onChange={(e) =>
                                                setFourthName(e.target.value)
                                            }
                                        />
                                        {errors.fourth_name && (
                                            <p className="text-red-500">
                                                {errors.fourth_name}
                                            </p>
                                        )}
                                    </div>
                                </div>

                                <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                    <div className="w-full xl:w-1/2">
                                        <label className="mb-2.5 block text-black dark:text-white">
                                            رقم الجوال
                                        </label>
                                        <div className="flex">
                                            <select
                                                value={phoneCode}
                                                onChange={(e) =>
                                                    // @ts-ignore
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
                                            <p className="text-red-500">
                                                {errors.phone}
                                            </p>
                                        )}
                                    </div>
                                    <div className="w-full xl:w-1/2">
                                        <label className="mb-2.5 block text-black dark:text-white">
                                            البريد الالكتروني
                                            <span className="text-meta-1">
                                                *
                                            </span>
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
                                            <p className="text-red-500">
                                                {errors.email}
                                            </p>
                                        )}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div className="flex gap-6">
                            <SaveButton saveData={saveData} />
                            <BackButton path="/newAdmin/old-lawyers" />
                        </div>
                    </div>
                </div>
            </div>
        </DefaultLayout>
    );
};

export default EditLawyer;
