import { router } from "@inertiajs/react";
import React, { useState } from "react";
import SelectGroup from "../../SelectGroup/SelectGroup";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faTrash } from "@fortawesome/free-solid-svg-icons";
import MultiSelectDropdown from "../../MultiSelectDropdown";
function TypeSettingsForm({
    saveData,
    errors,
    advisoryServices,
    selectedAdvisoryService,
    setSelectedAdvisoryService,
    typeName,
    setTypeName,
    minPrice,
    setMinPrice,
    maxPrice,
    setMaxPrice,
    prices,
    setPrices,
    availableImportance,
    setAvailableImportance,
    sections,
    selectedOptions,
    setSelectedOptions,
    baseCategories,
    paymentCategories,
    selectedBaseCategory,
    setSelectedBaseCategory,
    paymentCategory,
    setSelectedPaymentCategory,
}: {
    saveData: any;
    errors: any;
    advisoryServices;
    selectedAdvisoryService;
    setSelectedAdvisoryService;
    typeName;
    setTypeName;
    minPrice;
    setMinPrice;
    maxPrice;
    setMaxPrice;
    prices;
    setPrices;
    availableImportance;
    setAvailableImportance;
    sections;
    selectedOptions;
    setSelectedOptions;
    baseCategories;
    paymentCategories;
    selectedBaseCategory;
    setSelectedBaseCategory;
    paymentCategory;
    setSelectedPaymentCategory;
}) {
    console.log("available", availableImportance);
    const [reqLevel, setReqLevel] = useState("");
    const [reqPrice, setReqPrice] = useState("");
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
                                نوع الأستشارة
                            </h3>
                        </div>
                        <div className="p-6.5">
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <SelectGroup
                                        options={baseCategories}
                                        title="فئة الاستشارة"
                                        selectedOption={selectedBaseCategory}
                                        setSelectedOption={
                                            setSelectedBaseCategory
                                        }
                                    />
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <SelectGroup
                                        options={paymentCategories.filter(
                                            (pc) =>
                                                pc.advisory_service_base_id ==
                                                selectedBaseCategory
                                        )}
                                        title="باقة الاستشارة"
                                        selectedOption={paymentCategory}
                                        setSelectedOption={
                                            setSelectedPaymentCategory
                                        }
                                    />
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <SelectGroup
                                        options={advisoryServices.filter(
                                            (as) =>
                                                as.payment_category_id ==
                                                paymentCategory
                                        )}
                                        title="وسيلة الاستشارة"
                                        selectedOption={selectedAdvisoryService}
                                        setSelectedOption={
                                            setSelectedAdvisoryService
                                        }
                                    />
                                    {errors?.advisory_service && (
                                        <p className="text-red-600">
                                            {errors?.advisory_service}
                                        </p>
                                    )}
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        الاسم
                                    </label>
                                    <input
                                        type="text"
                                        placeholder="الاسم"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={typeName}
                                        onChange={(e) =>
                                            setTypeName(e.target.value)
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
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        السعر الأدنى
                                    </label>
                                    <input
                                        type="number"
                                        placeholder="السعر الأدنى"
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
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        السعر الأقصى
                                    </label>
                                    <input
                                        type="number"
                                        placeholder="السعر الأقصى"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={maxPrice}
                                        onChange={(e) =>
                                            setMaxPrice(e.target.value)
                                        }
                                    />
                                    {errors?.max_price && (
                                        <p className="text-red-600">
                                            {errors?.max_price}
                                        </p>
                                    )}
                                </div>
                            </div>
                            <div className="mb-4.5">
                                <table
                                    className="w-full table-auto"
                                    style={{ direction: "rtl" }}
                                >
                                    <thead>
                                        <tr>
                                            <th scope="col">المستوى </th>
                                            <th scope="col">السعر </th>
                                            <th scope="col">عمليات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {prices.map((price, index) => (
                                            <>
                                                <tr key={price.id}>
                                                    <td className="text-center">
                                                        {price.name}
                                                    </td>

                                                    <td className="text-center">
                                                        {price.price}
                                                    </td>

                                                    <td className="text-center">
                                                        <FontAwesomeIcon
                                                            icon={faTrash}
                                                            className="hover:cursor-pointer hover:text-white text-red-500"
                                                            onClick={() => {
                                                                setPrices(
                                                                    prices.filter(
                                                                        (s) =>
                                                                            s.id !==
                                                                            price.id
                                                                    )
                                                                );
                                                                setAvailableImportance(
                                                                    [
                                                                        ...availableImportance,
                                                                        {
                                                                            id: price.id,
                                                                            name: price.name,
                                                                        },
                                                                    ]
                                                                );
                                                            }}
                                                        />
                                                    </td>
                                                </tr>
                                                {errors[
                                                    `importance.${index}.price`
                                                ] && (
                                                    <p className="text-red-600">
                                                        {
                                                            errors[
                                                                `importance.${index}.price`
                                                            ]
                                                        }
                                                    </p>
                                                )}
                                            </>
                                        ))}
                                    </tbody>
                                </table>
                                {errors.importance && (
                                    <p className="text-red-600">
                                        {errors.importance}
                                    </p>
                                )}
                            </div>
                            <div className="flex gap-2">
                                <div className="w-full xl:w-1/2">
                                    <SelectGroup
                                        options={availableImportance}
                                        title="المستوى"
                                        selectedOption={reqLevel}
                                        setSelectedOption={setReqLevel}
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
                                                reqPrice == ""
                                            )
                                                return;
                                            setPrices((prev) => [
                                                ...prev,
                                                {
                                                    id: reqLevel,
                                                    name: availableImportance.find(
                                                        (r) => r.id == reqLevel
                                                    ).name,
                                                    price: reqPrice,
                                                    levelId: reqLevel,
                                                },
                                            ]);
                                            setAvailableImportance(
                                                availableImportance.filter(
                                                    (r) => r.id != reqLevel
                                                )
                                            );
                                            setReqLevel("");
                                            setReqPrice("");
                                        }}
                                        className="bg-purple-500 px-4 py-2 rounded"
                                    >
                                        +
                                    </button>
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
                                "/newAdmin/settings/advisory-services/types"
                            )
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

export default TypeSettingsForm;
