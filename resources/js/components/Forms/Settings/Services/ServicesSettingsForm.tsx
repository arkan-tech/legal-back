import { router } from "@inertiajs/react";
import React, { useState } from "react";
import SelectGroup from "../../SelectGroup/SelectGroup";
import MultiSelect from "../../MultiSelect";
import MultiSelectDropdown from "../../MultiSelectDropdown";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faTrash } from "@fortawesome/free-solid-svg-icons";
import Switcher from "../../../Switchers/Switcher";
function ServicesSettingsForm({
    saveData,
    errors,
    serviceName,
    setServiceName,
    categoryId,
    setCategoryId,
    about,
    setAbout,
    minPrice,
    setMinPrice,
    maxPrice,
    setMaxPrice,
    image,
    setImage,
    categories,
    sections,
    selectedOptions,
    setSelectedOptions,
    setRequestLevels,
    requestLevels,
    request_levels,
    setRequest_Levels,
    needAppointment,
    setNeedAppointment,
}: {
    saveData: any;
    errors: any;
    serviceName: string;
    setServiceName: any;
    categoryId: any;
    setCategoryId: any;
    about: any;
    setAbout: any;
    minPrice: any;
    setMinPrice: any;
    maxPrice: any;
    setMaxPrice: any;
    image: any;
    setImage: any;
    categories: any[];
    sections: any[];
    selectedOptions: any;
    setSelectedOptions: any;
    setRequestLevels: any;
    requestLevels: any;
    request_levels: any;
    setRequest_Levels: any;
    needAppointment;
    setNeedAppointment;
}) {
    console.log(selectedOptions);
    console.log(sections);
    const [reqLevel, setReqLevel] = useState("");
    const [reqPrice, setReqPrice] = useState("");
    const [duration, setDuration] = useState(1);
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
                                قسم الخدمة
                            </h3>
                        </div>
                        <div className="p-6.5">
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        اسم الخدمة
                                    </label>
                                    <input
                                        type="text"
                                        placeholder="اسم الخدمة"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={serviceName}
                                        onChange={(e) =>
                                            setServiceName(e.target.value)
                                        }
                                    />
                                    {errors.name && (
                                        <p className="text-red-600">
                                            {errors.name}
                                        </p>
                                    )}
                                </div>
                                <div className="w-full xl:w-1/2">
                                    <SelectGroup
                                        options={categories}
                                        title="القسم الرئيسي"
                                        selectedOption={categoryId}
                                        setSelectedOption={setCategoryId}
                                    />
                                    {errors.name && (
                                        <p className="text-red-600">
                                            {errors.name}
                                        </p>
                                    )}
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        تعريف الخدمة
                                    </label>
                                    <textarea
                                        placeholder="اسم الخدمة"
                                        className="w-full h-30 rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={about}
                                        onChange={(e) =>
                                            setAbout(e.target.value)
                                        }
                                    />
                                    {errors.name && (
                                        <p className="text-red-600">
                                            {errors.name}
                                        </p>
                                    )}
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        التخصص{" "}
                                    </label>
                                    <MultiSelectDropdown
                                        options={sections}
                                        selectedOptions={selectedOptions}
                                        setSelectedOptions={setSelectedOptions}
                                    />
                                    {errors.name && (
                                        <p className="text-red-600">
                                            {errors.name}
                                        </p>
                                    )}
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        السعر الادني{" "}
                                    </label>
                                    <input
                                        type="number"
                                        placeholder="السعر الادني"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={minPrice}
                                        onChange={(e) =>
                                            setMinPrice(e.target.value)
                                        }
                                    />
                                    {errors.min_price && (
                                        <p className="text-red-600">
                                            {errors.min_price}
                                        </p>
                                    )}
                                </div>
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        السعر الاقصى
                                    </label>
                                    <input
                                        type="number"
                                        placeholder="السعر الاقصى"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={maxPrice}
                                        onChange={(e) =>
                                            setMaxPrice(e.target.value)
                                        }
                                    />
                                    {errors.max_price && (
                                        <p className="text-red-600">
                                            {errors.max_price}
                                        </p>
                                    )}
                                </div>
                            </div>
                            {/* <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        تحتاج لموعد
                                    </label>
                                    <Switcher
                                        id="تحتاج لموعد"
                                        enabled={needAppointment}
                                        setEnabled={setNeedAppointment}
                                    />
                                    {errors.name && (
                                        <p className="text-red-600">
                                            {errors.name}
                                        </p>
                                    )}
                                </div>
                            </div> */}
                            <div className="mb-4.5">
                                {/* <div className="max-w-full overflow-x-auto"> */}
                                <table
                                    className="w-full table-auto"
                                    style={{ direction: "rtl" }}
                                >
                                    <thead>
                                        <tr>
                                            <th scope="col">المستوى </th>
                                            <th scope="col">
                                                مدة الرد (بالساعات){" "}
                                            </th>
                                            <th scope="col">السعر </th>
                                            <th scope="col">عمليات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {requestLevels.map((specialty) => (
                                            <tr key={specialty.id}>
                                                <td className="text-center">
                                                    {specialty.name}
                                                </td>
                                                <td className="text-center">
                                                    {specialty.duration}
                                                </td>

                                                <td className="text-center">
                                                    {specialty.price}
                                                </td>

                                                <td className="text-center">
                                                    <FontAwesomeIcon
                                                        icon={faTrash}
                                                        className="hover:cursor-pointer hover:text-white text-red-500"
                                                        onClick={() => {
                                                            setRequestLevels(
                                                                requestLevels.filter(
                                                                    (s) =>
                                                                        s.id !==
                                                                        specialty.id
                                                                )
                                                            );
                                                            setRequest_Levels([
                                                                ...request_levels,
                                                                {
                                                                    id: specialty.id,
                                                                    title: specialty.name,
                                                                },
                                                            ]);
                                                        }}
                                                    />
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                                {errors.sections && (
                                    <p className="text-red">
                                        {errors.sections}
                                    </p>
                                )}
                            </div>
                            <div className="flex gap-2">
                                <div className="w-full xl:w-1/2">
                                    <SelectGroup
                                        options={request_levels}
                                        title="المستوى"
                                        selectedOption={reqLevel}
                                        setSelectedOption={setReqLevel}
                                    />
                                </div>
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        المدة (بالساعات)
                                    </label>
                                    <input
                                        type="number"
                                        placeholder="السعر"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={duration}
                                        min="0"
                                        onChange={(e) =>
                                            setDuration(
                                                parseInt(e.target.value)
                                            )
                                        }
                                    />
                                </div>
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        السعر
                                    </label>
                                    <input
                                        type="number"
                                        placeholder="السعر"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={reqPrice}
                                        onChange={(e) =>
                                            setReqPrice(e.target.value)
                                        }
                                    />
                                </div>
                                <div className="w-full xl:w-1/4 flex items-center justify-center text-white">
                                    <button
                                        onClick={() => {
                                            if (
                                                reqLevel == "" ||
                                                reqPrice == "" ||
                                                duration < 1
                                            )
                                                return;
                                            setRequestLevels((prev) => [
                                                ...prev,
                                                {
                                                    id: reqLevel,
                                                    name: request_levels.find(
                                                        (r) => r.id == reqLevel
                                                    ).title,
                                                    price: reqPrice,
                                                    duration,
                                                    levelId: reqLevel,
                                                },
                                            ]);
                                            setRequest_Levels(
                                                request_levels.filter(
                                                    (r) => r.id != reqLevel
                                                )
                                            );
                                            setReqLevel("");
                                            setReqPrice("");
                                            setDuration(1);
                                        }}
                                        className="bg-purple-500 px-4 py-2 rounded"
                                    >
                                        +
                                    </button>
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
                            router.get("/newAdmin/settings/products")
                        }
                        className="flex w-full justify-center rounded bg-danger p-3 font-medium text-gray hover:bg-opacity-90"
                    >
                        الرجوع للقائمة
                    </button>
                </div>
            </div>
        </>
    );
}

export default ServicesSettingsForm;
