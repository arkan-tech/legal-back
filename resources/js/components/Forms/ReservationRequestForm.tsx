import { router } from "@inertiajs/react";
import React, { useEffect, useState } from "react";
import GetClientType from "../../helpers/GetClientType";
import GetLawyerType from "../../helpers/GetLawyerType";
import Switcher from "../Switchers/Switcher";
import SelectGroup from "./SelectGroup/SelectGroup";
import { GetArabicDate, GetArabicTime } from "../../helpers/DateFunctions";
function ReservationRequestForm({
    request,
    errors,
    saveData,
    advisories,
    all_lawyers,
    disable_replies = false,
    returnRoute,
}) {
    const [data, setFormData] = useState({
        for_admin: 1,
        lawyer_id: "",
        advisory_id: "",
    });
    const [changeLawyer, setChangeLawyer] = useState(
        disable_replies || request.for_admin == 2 || request.for_admin == 3
    );
    const [assignToAdvisory, setAssignToAdvisory] = useState(
        request.for_admin == 3
    );
    const [selectedAdvisory, setSelectedAdvisory] = useState(
        request.advisory_id || ""
    );
    const [selectedLawyer, setSelectedLawyer] = useState("");
    const [availableLawyers, setAvailableLawyers] = useState([]);
    useEffect(() => {
        if (selectedAdvisory) {
            setAvailableLawyers(() => {
                let lawyers = all_lawyers
                    .filter((lawyer) =>
                        lawyer.lawyer_advisories.some(
                            (lw) => lw.advisory_id == selectedAdvisory
                        )
                    )
                    .map((lawyer) => ({
                        id: lawyer.id,
                        name: lawyer.name,
                    }));
                return lawyers;
            });
            if (request.reserved_from_lawyer_id) {
                if (
                    request.reserved_lawyer.lawyer_advisories.some(
                        (ad) => ad.advisory_id == selectedAdvisory
                    )
                ) {
                    setSelectedLawyer(request.reserved_from_lawyer_id);
                } else {
                    setSelectedLawyer("");
                }
            }
        }
    }, [selectedAdvisory]);
    useEffect(() => {
        if (!assignToAdvisory && changeLawyer) {
            console.log(request.reserved_from_lawyer_id);
            setAvailableLawyers(
                all_lawyers.map((lawyer) => ({
                    id: lawyer.id,
                    name: lawyer.name,
                }))
            );
            if (request.reserved_from_lawyer_id) {
                setSelectedLawyer(request.reserved_from_lawyer_id);
            }
        }
    }, [assignToAdvisory, changeLawyer]);
    useEffect(() => {
        if (selectedLawyer) {
            console.log("selectedLawyer", selectedLawyer);
            setFormData((prevData) => ({
                ...prevData,
                lawyer_id: selectedLawyer,
                for_admin: assignToAdvisory ? 3 : 2,
                advisory_id: assignToAdvisory ? selectedAdvisory : "",
            }));
        }
    }, [selectedLawyer]);
    useEffect(() => {
        console.log(data);
    }, [data]);
    const handleSubmit = (e) => {
        e.preventDefault();
        console.log(data);
        const formData = new FormData();
        formData.append("id", request.id);
        formData.append("for_admin", data.for_admin.toString());
        formData.append("lawyer_id", data.lawyer_id);
        if (data.advisory_id) {
            formData.append("advisory_id", data.advisory_id.toString());
        }
        saveData(formData);
    };
    useEffect(() => {
        if (changeLawyer == false) {
            setFormData((prevData) => ({
                ...prevData,
                for_admin: 1,
            }));
        } else {
            setFormData((prevData) => ({
                ...prevData,
                replay_message: "",
                file: null,
            }));
        }
    }, [changeLawyer]);
    return (
        <>
            <form
                onSubmit={handleSubmit}
                className="grid grid-cols-1 gap-9"
                style={{ direction: "rtl" }}
            >
                <div className="flex flex-col gap-9">
                    <div className="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                        <div className="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                            <h3 className="font-medium text-black dark:text-white">
                                معلومات العميل
                            </h3>
                        </div>
                        <div className="p-6.5">
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        اسم العميل
                                    </label>
                                    <input
                                        type="text"
                                        placeholder="الاسم"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={
                                            request.account?.name ??
                                            "الحساب غير موجود"
                                        }
                                        disabled
                                    />
                                </div>
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        نوع الحساب
                                    </label>
                                    <input
                                        type="text"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={
                                            request.account.account_type ==
                                            "lawyer"
                                                ? "مقدم خدمة"
                                                : "عميل"
                                        }
                                        disabled
                                    />
                                </div>
                            </div>

                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        الهاتف
                                    </label>
                                    <input
                                        type="text"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={request.account.phone}
                                        disabled
                                    />
                                </div>
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        النوع
                                    </label>
                                    <input
                                        type="text"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={GetLawyerType(
                                            request.account.type
                                        )}
                                        disabled
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                        <div className="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                            <h3 className="font-medium text-black dark:text-white">
                                معلومات طلب الموعد
                            </h3>
                        </div>
                        <div className="p-6.5">
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        نوع الموعد
                                    </label>
                                    <input
                                        type="text"
                                        placeholder="الاسم"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={request.reservation_type.name}
                                        disabled
                                    />
                                </div>
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        مستوى الأهمية
                                    </label>
                                    <input
                                        type="text"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={request.importance.title}
                                        disabled
                                    />
                                </div>
                            </div>

                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        الوصف
                                    </label>
                                    <textarea
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={request.description}
                                        disabled
                                    />
                                </div>
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        ملف
                                    </label>
                                    <a
                                        href={request.file}
                                        target="_blank"
                                        className={`${
                                            request.file != null
                                                ? "hover:cursor-pointer bg-primary"
                                                : "bg-slate-500"
                                        } flex w-full justify-center rounded p-3 font-medium text-gray hover:bg-opacity-90`}
                                    >
                                        {request.file != null
                                            ? "فتح الملف المرفق"
                                            : "لا يوجد ملف مرفق"}
                                    </a>
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        السعر{" "}
                                    </label>
                                    <input
                                        type="text"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={request.price}
                                        disabled
                                    />
                                </div>
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        حالة الدفع{" "}
                                    </label>
                                    <input
                                        type="text"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={
                                            request.transaction_complete == 1
                                                ? "تم الدفع"
                                                : request.transaction_complete ==
                                                  3
                                                ? "تم رفض عملية الدفع"
                                                : "لم يتم الدفع"
                                        }
                                        disabled
                                    />
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        المدة الطلوبة
                                    </label>
                                    <input
                                        type="text"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={request.hours}
                                        disabled
                                    />
                                </div>
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        موعد الطلب
                                    </label>
                                    <input
                                        type="text"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={
                                            GetArabicDate(request.day) as string
                                        }
                                        disabled
                                    />
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        من
                                    </label>
                                    <input
                                        type="text"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={GetArabicTime(
                                            request.from.split(" ")[1]
                                        )}
                                        disabled
                                    />
                                </div>
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        الى
                                    </label>
                                    <input
                                        type="text"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={GetArabicTime(
                                            request.to.split(" ")[1]
                                        )}
                                        disabled
                                    />
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        تاريخ الطلب ووقت الطلب{" "}
                                    </label>
                                    <input
                                        type="text"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={
                                            GetArabicDate(
                                                request.created_at
                                            ) as string
                                        }
                                        disabled
                                    />
                                </div>
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        احالة الطلب{" "}
                                    </label>
                                    <Switcher
                                        id="changeLawyer"
                                        enabled={changeLawyer}
                                        setEnabled={setChangeLawyer}
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    {changeLawyer ? (
                        <div className="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                            <div className="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                                <h3 className="font-medium text-black dark:text-white">
                                    احالة الطلب
                                </h3>
                            </div>
                            <div className="p-6.5">
                                <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                    <div className="w-full xl:w-1/2">
                                        <label className="mb-2.5 block text-black dark:text-white">
                                            احالة الطلب الى هيئة استشارية
                                        </label>
                                        <Switcher
                                            id="assignToAdvisory"
                                            enabled={assignToAdvisory}
                                            setEnabled={setAssignToAdvisory}
                                        />
                                    </div>
                                </div>
                                {assignToAdvisory && (
                                    <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                        <div className="w-full">
                                            <SelectGroup
                                                options={advisories}
                                                selectedOption={
                                                    selectedAdvisory
                                                }
                                                setSelectedOption={
                                                    setSelectedAdvisory
                                                }
                                                title="الهيئة الأستشارية"
                                            />
                                        </div>
                                        <div className="w-full">
                                            <SelectGroup
                                                options={availableLawyers}
                                                selectedOption={selectedLawyer}
                                                setSelectedOption={
                                                    setSelectedLawyer
                                                }
                                                title="المحامي"
                                            />
                                        </div>
                                    </div>
                                )}
                                {!assignToAdvisory && (
                                    <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                        <div className="w-full">
                                            <SelectGroup
                                                options={availableLawyers}
                                                selectedOption={selectedLawyer}
                                                setSelectedOption={
                                                    setSelectedLawyer
                                                }
                                                title="المحامي"
                                            />
                                        </div>
                                    </div>
                                )}
                            </div>
                        </div>
                    ) : null}
                </div>
                <div className="flex gap-6">
                    <button
                        type="submit"
                        className={`flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90 disabled:bg-slate-500 disabled:bg-opacity-100 `}
                    >
                        حفظ الملف
                    </button>
                    <button
                        type="button"
                        onClick={() => router.get(returnRoute)}
                        className="flex w-full justify-center rounded bg-danger p-3 font-medium text-gray hover:bg-opacity-90"
                    >
                        الرجوع للقائمة
                    </button>
                </div>
            </form>
        </>
    );
}

export default ReservationRequestForm;
