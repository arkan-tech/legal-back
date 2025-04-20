import { router } from "@inertiajs/react";
import React, { useState } from "react";
import SelectGroup from "../../SelectGroup/SelectGroup";
import MultiSelect from "../../MultiSelect";
import MultiSelectDropdown from "../../MultiSelectDropdown";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faTrash } from "@fortawesome/free-solid-svg-icons";
function ReservationsTypesForm({
    saveData,
    errors,
    name,
    setName,
    minPrice,
    setMinPrice,
    maxPrice,
    setMaxPrice,
    prices,
    setPrices,
    availableImportances,
    setAvailableImportances,
}: {
    saveData: any;
    errors: any;
    name;
    setName;
    minPrice;
    setMinPrice;
    maxPrice;
    setMaxPrice;
    prices;
    setPrices;
    availableImportances;
    setAvailableImportances;
}) {
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
                                نوع الموعد{" "}
                            </h3>
                        </div>
                        <div className="p-6.5">
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        اسم نوع الموعد
                                    </label>
                                    <input
                                        type="text"
                                        placeholder="اسم نوع الموعد"
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
                                    {errors.minPrice && (
                                        <p className="text-red-600">
                                            {errors.minPrice}
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
                                    {errors.maxPrice && (
                                        <p className="text-red-600">
                                            {errors.maxPrice}
                                        </p>
                                    )}
                                </div>
                            </div>
                            <div className="mb-4.5">
                                {/* <div className="max-w-full overflow-x-auto"> */}
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
                                        {prices.map((typePrice, index) => (
                                            <>
                                                <tr key={typePrice.id}>
                                                    <td className="text-center">
                                                        {typePrice.name}
                                                    </td>

                                                    <td className="text-center">
                                                        {typePrice.price}
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
                                                                            typePrice.id
                                                                    )
                                                                );
                                                                setAvailableImportances(
                                                                    [
                                                                        ...availableImportances,
                                                                        {
                                                                            id: typePrice.id,
                                                                            name: typePrice.name,
                                                                        },
                                                                    ]
                                                                );
                                                            }}
                                                        />
                                                    </td>
                                                </tr>
                                                {errors[
                                                    `prices.${index}.price`
                                                ] && (
                                                    <p className="text-red-600">
                                                        {
                                                            errors[
                                                                `prices.${index}.price`
                                                            ]
                                                        }
                                                    </p>
                                                )}
                                            </>
                                        ))}
                                    </tbody>
                                </table>
                                {errors.prices && (
                                    <p className="text-red-600">
                                        {errors.prices}
                                    </p>
                                )}
                            </div>
                            <div className="flex gap-2">
                                <div className="w-full xl:w-1/2">
                                    <SelectGroup
                                        options={availableImportances}
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
                                                    name: availableImportances.find(
                                                        (r) => r.id == reqLevel
                                                    ).name,
                                                    price: reqPrice,
                                                },
                                            ]);
                                            setAvailableImportances(
                                                availableImportances.filter(
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
                            router.get("/newAdmin/settings/reservations/types")
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

export default ReservationsTypesForm;
