import { router } from "@inertiajs/react";
import React, { useEffect, useState } from "react";
import GetClientType from "../../../helpers/GetClientType";
import GetLawyerType from "../../../helpers/GetLawyerType";
import Switcher from "../../Switchers/Switcher";
import SelectGroup from "../SelectGroup/SelectGroup";
import {
    GetArabicDate,
    GetArabicDateTime,
    GetArabicTime,
} from "../../../helpers/DateFunctions";
function ServiceRequestForm({
    request,
    errors,
    saveData,
    advisories,
    all_lawyers,
    disable_replies = false,
    returnRoute,
}) {
    console.log("request", request);
    const [data, setFormData] = useState({
        file: null,
        replay_message: "",
        for_admin: 1,
        lawyer_id: "",
        advisory_id: "",
    });
    const [changeLawyer, setChangeLawyer] = useState(
        (disable_replies || request.for_admin == 2 || request.for_admin == 3) &&
            request.replay_status == 0
    );
    const [assignToAdvisory, setAssignToAdvisory] = useState(
        request.for_admin == 3
    );
    const [selectedAdvisory, setSelectedAdvisory] = useState(
        request.advisory_id || ""
    );
    const [selectedLawyer, setSelectedLawyer] = useState("");
    const [availableLawyers, setAvailableLawyers] = useState([]);
    const handleChange = (e) => {
        const { name, value, files } = e.target;
        if (name === "file") {
            setFormData((prevData) => ({
                ...prevData,
                file: files[0],
            }));
        } else {
            setFormData((prevData) => ({
                ...prevData,
                [name]: value,
            }));
        }
    };
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
            if (request.lawyer_id) {
                if (
                    request.lawyer.lawyer_advisories.some(
                        (ad) => ad.advisory_id == selectedAdvisory
                    )
                ) {
                    setSelectedLawyer(request.lawyer_id);
                } else {
                    setSelectedLawyer("");
                }
            }
        }
    }, [selectedAdvisory]);
    useEffect(() => {
        if (!assignToAdvisory && changeLawyer) {
            console.log(request.lawyer_id);
            setAvailableLawyers(
                all_lawyers.map((lawyer) => ({
                    id: lawyer.id,
                    name: lawyer.name,
                }))
            );
            if (request.lawyer_id) {
                setSelectedLawyer(request.lawyer_id);
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
        formData.append("replay_message", data.replay_message);
        formData.append("for_admin", data.for_admin.toString());
        formData.append("lawyer_id", data.lawyer_id);
        if (data.advisory_id) {
            formData.append("advisory_id", data.advisory_id.toString());
        }
        if (data.file) {
            formData.append("file", data.file);
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
                                        value={request.account.name}
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
                                        value={
                                            request.account.phone_code +
                                            request.account.phone
                                        }
                                        disabled
                                    />
                                </div>
                                {/* <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        النوع
                                    </label>
                                    <input
                                        type="text"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={
                                            request.reserverType == "lawyer"
                                                ? GetLawyerType(
                                                      request.client.type
                                                  )
                                                : GetClientType(
                                                      request.client.type
                                                  )
                                        }
                                        disabled
                                    />
                                </div> */}
                            </div>
                        </div>
                    </div>
                    <div className="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                        <div className="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                            <h3 className="font-medium text-black dark:text-white">
                                معلومات الخدمة
                            </h3>
                        </div>
                        <div className="p-6.5">
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        مسمى الخدمة
                                    </label>
                                    <input
                                        type="text"
                                        placeholder="الاسم"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={request.type.title}
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
                                        value={request.priority_rel.title}
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
                                    <div className="flex flex-col gap-2">
                                        {request.files.length > 0
                                            ? request.files.map(
                                                  (file, index) => (
                                                      <a
                                                          href={file}
                                                          target="_blank"
                                                          className={`${
                                                              file != null
                                                                  ? "hover:cursor-pointer bg-primary"
                                                                  : "bg-slate-500"
                                                          } flex w-full justify-center rounded p-3 font-medium text-gray hover:bg-opacity-90`}
                                                      ></a>
                                                  )
                                              )
                                            : request.file != null
                                            ? "فتح الملف المرفق"
                                            : "لا يوجد ملف مرفق"}
                                    </div>
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
                                        تاريخ الطلب ووقت الطلب{" "}
                                    </label>
                                    <input
                                        type="text"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={
                                            GetArabicDateTime(
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

                    <div className="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                        <div className="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                            <h3 className="font-medium text-black dark:text-white">
                                الرد على الخدمة
                            </h3>
                        </div>
                        <div className="p-6.5">
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        حالة الرد
                                    </label>
                                    <input
                                        type="text"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={
                                            request.replay_status == 1
                                                ? "تم الرد"
                                                : "لم يتم الرد"
                                        }
                                        disabled
                                    />
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        الرد
                                    </label>
                                    <textarea
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary invalid:border-red-500"
                                        name="replay_message"
                                        required={true}
                                        rows={6}
                                        onChange={handleChange}
                                        value={request.replay}
                                        disabled={
                                            request.replay_status == 1 ||
                                            changeLawyer
                                        }
                                    />
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-1/3">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        ملف
                                    </label>
                                    {request.replay_status == 1 ||
                                    changeLawyer ? (
                                        <a
                                            href={request.replay_file}
                                            target="_blank"
                                            className={`${
                                                request.replay_file != null
                                                    ? "hover:cursor-pointer bg-primary"
                                                    : "bg-slate-500"
                                            } flex w-full justify-center rounded p-3 font-medium text-gray hover:bg-opacity-90`}
                                        >
                                            {request.replay_file != null
                                                ? "فتح الملف المرفق"
                                                : "لا يوجد ملف مرفق"}
                                        </a>
                                    ) : (
                                        <input
                                            type="file"
                                            className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                            name="file"
                                            onChange={handleChange}
                                        />
                                    )}
                                </div>
                            </div>
                            {request.replay_status == 1 ? (
                                <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                    <div className="w-1/3">
                                        <label className="mb-2.5 block text-black dark:text-white">
                                            تاريخ الرد
                                        </label>
                                        <input
                                            type="text"
                                            className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                            value={
                                                GetArabicDate(
                                                    new Date(
                                                        new Date(
                                                            request.replay_date
                                                        ).getFullYear(),
                                                        new Date(
                                                            request.replay_date
                                                        ).getMonth(),
                                                        new Date(
                                                            request.replay_date
                                                        ).getDate(),
                                                        request.replay_time.split(
                                                            ":"
                                                        )[0],
                                                        request.replay_time.split(
                                                            ":"
                                                        )[1]
                                                    )
                                                ) as string
                                            }
                                            disabled
                                        />
                                    </div>
                                </div>
                            ) : null}

                            {/* {request.replay_from_admin != null ||
                                (request.replay_from_lawyer_id != null && (
                                    <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                        <div className="w-full">
                                            <label className="mb-2.5 block text-black dark:text-white">
                                                اسم المستخدم الذي رد
                                            </label>
                                            <input
                                                type="text"
                                                className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                                value={request.user.name}
                                                disabled
                                            />
                                        </div>
                                    </div>
                                ))} */}
                        </div>
                    </div>
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

export default ServiceRequestForm;
