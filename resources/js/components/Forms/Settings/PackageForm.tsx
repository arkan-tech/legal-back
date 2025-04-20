import { router } from "@inertiajs/react";
import React, { useEffect, useState } from "react";
import SelectGroup from "../SelectGroup/SelectGroup";
import ServicesSelectionTable from "../../Tables/ProductsSelectionTable";
import { DURATIONTYPES, PACKAGETYPES } from "../../../Pages/Settings/Packages";
import LawyerPermissionsTable from "../../Tables/LawyerPermissionsSelectionTable";
import MultiSelectDropdown from "../MultiSelectDropdown";
function PackageForm({
    saveData,
    errors,
    // setErrors,
    packageName,
    setPackageName,
    duration,
    setDuration,
    durationType,
    setDurationType,
    targetedType,
    setTargetedType,
    types,
    priceBeforeDiscount,
    setPriceBeforeDiscount,
    priceAfterDiscount,
    setPriceAfterDiscount,
    instructions,
    setInstructions,
    selectedServices,
    services,
    advisoryServicesTypes,
    selectedAdvisoryServicesTypes,
    setSelectedAdvisoryServicesTypes,
    reservationTypes,
    selectedReservationTypes,
    setSelectedReservationTypes,
    setSelectedServices,
    packageType,
    setPackageType,
    numberOfServices,
    setNumberOfServices,
    numberOfAdvisoryServices,
    setNumberOfAdvisoryServices,
    numberOfReservations,
    setNumberOfReservations,
    progress,
    taxes,
    setTaxes,
    setSelectedLawyerPermissions,
    selectedLawyerPermissions,
    permissions,
    sections,
    selectedSections,
    setSelectedSections,
}: {
    saveData: any;
    errors: any;
    // setErrors: any;
    packageName;
    setPackageName;
    duration;
    setDuration;
    durationType: string;
    setDurationType: (value: string) => void;
    targetedType;
    setTargetedType;
    types;
    services;
    priceBeforeDiscount;
    setPriceBeforeDiscount;
    priceAfterDiscount;
    setPriceAfterDiscount;
    instructions;
    setInstructions;
    advisoryServicesTypes;
    selectedAdvisoryServicesTypes;
    setSelectedAdvisoryServicesTypes;
    reservationTypes;
    selectedReservationTypes;
    setSelectedReservationTypes;
    selectedServices;
    setSelectedServices;
    packageType;
    setPackageType;
    numberOfServices: number;
    progress;
    setNumberOfServices: (value: number) => void;
    numberOfAdvisoryServices: number;
    setNumberOfAdvisoryServices: (value: number) => void;
    numberOfReservations: number;
    setNumberOfReservations: (value: number) => void;
    taxes;
    setTaxes;
    setSelectedLawyerPermissions;
    selectedLawyerPermissions;
    permissions;
    sections;
    selectedSections;
    setSelectedSections;
}) {
    const [profitAfterTax, setProfitAfterTax] = useState(0);
    useEffect(() => {
        if (taxes && priceAfterDiscount) {
            const taxAmount =
                Number(priceAfterDiscount) * (Number(taxes) / 100);
            setProfitAfterTax(Number(priceAfterDiscount) - taxAmount);
        }
    }, [priceAfterDiscount, taxes]);

    // const validateTotalBookings = () => {
    //     const totalServicesBookings = selectedServices.reduce(
    //         (total, item) => total + item.number_of_bookings,
    //         0
    //     );
    //     const totalAdvisoryServicesBookings =
    //         selectedAdvisoryServicesTypes.reduce(
    //             (total, item) => total + item.number_of_bookings,
    //             0
    //         );
    //     const totalReservationsBookings = selectedReservationTypes.reduce(
    //         (total, item) => total + item.number_of_bookings,
    //         0
    //     );

    //     if (
    //         totalServicesBookings !== numberOfServices ||
    //         totalAdvisoryServicesBookings !== numberOfAdvisoryServices ||
    //         totalReservationsBookings !== numberOfReservations
    //     ) {
    //         return false;
    //     }
    //     return true;
    // };

    // const handleSaveData = () => {
    //     if (validateTotalBookings()) {
    //         saveData();
    //     } else {
    //         const totalServicesBookings = selectedServices.reduce(
    //             (total, item) => total + item.number_of_bookings,
    //             0
    //         );
    //         const totalAdvisoryServicesBookings =
    //             selectedAdvisoryServicesTypes.reduce(
    //                 (total, item) => total + item.number_of_bookings,
    //                 0
    //             );
    //         const totalReservationsBookings = selectedReservationTypes.reduce(
    //             (total, item) => total + item.number_of_bookings,
    //             0
    //         );
    //         setErrors({
    //             ...errors,

    //             servicesBookings:
    //                 totalServicesBookings !== numberOfServices
    //                     ? "عدد الحجوزات لكل نوع من الخدمات يجب أن يساوي العدد الكلي المحدد."
    //                     : null,
    //             advisoryServicesBookings:
    //                 totalAdvisoryServicesBookings !== numberOfAdvisoryServices
    //                     ? "عدد الحجوزات لكل نوع من الخدمات الاستشارية يجب أن يساوي العدد الكلي المحدد."
    //                     : null,
    //             reservationsBookings:
    //                 totalReservationsBookings !== numberOfReservations
    //                     ? "عدد الحجوزات لكل نوع من الحجوزات يجب أن يساوي العدد الكلي المحدد."
    //                     : null,
    //         });
    //     }
    // };

    return (
        <>
            <div
                className="grid grid-cols-1 gap-9"
                style={{ direction: "rtl" }}
            >
                <div className="flex flex-col gap-9">
                    {progress > 0 && (
                        <div className="mt-4">
                            <div className="bg-gray-200 rounded-full">
                                <div
                                    className="bg-blue-500 text-xs font-medium text-center text-white rounded-full"
                                    style={{ width: `${progress}%` }}
                                >
                                    {progress}%
                                </div>
                            </div>
                        </div>
                    )}
                    <div className="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                        <div className="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                            <h3 className="font-medium text-black dark:text-white">
                                تفاصيل الباقة
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
                                        value={packageName}
                                        onChange={(e) =>
                                            setPackageName(e.target.value)
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
                                    <SelectGroup
                                        title="نوع مدة الباقة"
                                        options={DURATIONTYPES}
                                        selectedOption={durationType}
                                        setSelectedOption={setDurationType}
                                    />
                                    {errors.durationType && (
                                        <p className="text-red-600">
                                            {errors.durationType}
                                        </p>
                                    )}
                                </div>
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        مدة الباقة
                                    </label>
                                    <input
                                        type="number"
                                        placeholder="مدة الباقة"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={duration}
                                        onChange={(e) =>
                                            setDuration(e.target.value)
                                        }
                                    />
                                    {errors.duration && (
                                        <p className="text-red-600">
                                            {errors.duration}
                                        </p>
                                    )}
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <SelectGroup
                                        title="النوع المستهدف"
                                        options={PACKAGETYPES}
                                        selectedOption={packageType}
                                        setSelectedOption={setPackageType}
                                    />

                                    {errors.packageType && (
                                        <p className="text-red-600">
                                            {errors.packageType}
                                        </p>
                                    )}
                                </div>
                                <div className="w-full xl:w-1/2">
                                    <SelectGroup
                                        title="الفئة المستهدفة"
                                        options={types}
                                        selectedOption={targetedType}
                                        setSelectedOption={setTargetedType}
                                    />

                                    {errors.targetedType && (
                                        <p className="text-red-600">
                                            {errors.targetedType}
                                        </p>
                                    )}
                                </div>
                            </div>

                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/4">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        السعر قبل الخصم
                                    </label>
                                    <input
                                        type="number"
                                        placeholder="السعر قبل الخصم"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={priceBeforeDiscount}
                                        onChange={(e) =>
                                            setPriceBeforeDiscount(
                                                e.target.value
                                            )
                                        }
                                    />
                                    {errors.priceBeforeDiscount && (
                                        <p className="text-red-600">
                                            {errors.priceBeforeDiscount}
                                        </p>
                                    )}
                                </div>
                                <div className="w-full xl:w-1/4">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        السعر بعد الخصم
                                    </label>
                                    <input
                                        type="number"
                                        placeholder="السعر بعد الخصم"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={priceAfterDiscount}
                                        onChange={(e) =>
                                            setPriceAfterDiscount(
                                                e.target.value
                                            )
                                        }
                                    />
                                    {errors.priceAfterDiscount && (
                                        <p className="text-red-600">
                                            {errors.priceAfterDiscount}
                                        </p>
                                    )}
                                </div>
                                <div className="w-full xl:w-1/4">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        الضريبة
                                    </label>
                                    <input
                                        type="number"
                                        placeholder="الضريبة"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={taxes}
                                        onChange={(e) =>
                                            setTaxes(e.target.value)
                                        }
                                    />
                                    {errors.taxes && (
                                        <p className="text-red-600">
                                            {errors.taxes}
                                        </p>
                                    )}
                                </div>
                                <div className="w-full xl:w-1/4">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        الربح بعد الضريبة
                                    </label>
                                    <input
                                        type="number"
                                        placeholder="الربح بعد الضريبة"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={profitAfterTax}
                                        disabled={true}
                                    />
                                </div>
                            </div>
                            {packageType == "1" && (
                                <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                    <div className="w-full xl:w-1/3">
                                        <label className="mb-2.5 block text-black dark:text-white">
                                            عدد الخدمات المتاحة
                                        </label>
                                        <input
                                            type="number"
                                            placeholder="عدد الخدمات المتاحة"
                                            className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                            value={numberOfServices}
                                            onChange={(e) =>
                                                setNumberOfServices(
                                                    Number(e.target.value)
                                                )
                                            }
                                        />
                                        {errors.number_of_services && (
                                            <p className="text-red-600">
                                                {errors.number_of_services}
                                            </p>
                                        )}
                                    </div>
                                    <div className="w-full xl:w-1/3">
                                        <label className="mb-2.5 block text-black dark:text-white">
                                            عدد الأستشارات المتاحة
                                        </label>
                                        <input
                                            type="number"
                                            placeholder="عدد الأستشارات المتاحة"
                                            className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                            value={numberOfAdvisoryServices}
                                            onChange={(e) =>
                                                setNumberOfAdvisoryServices(
                                                    Number(e.target.value)
                                                )
                                            }
                                        />
                                        {errors.number_of_advisory_services && (
                                            <p className="text-red-600">
                                                {
                                                    errors.number_of_advisory_services
                                                }
                                            </p>
                                        )}
                                    </div>
                                    <div className="w-full xl:w-1/3">
                                        <label className="mb-2.5 block text-black dark:text-white">
                                            عدد المواعيد المتاحة
                                        </label>
                                        <input
                                            type="number"
                                            placeholder="عدد المواعيد المتاحة"
                                            className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                            value={numberOfReservations}
                                            onChange={(e) =>
                                                setNumberOfReservations(
                                                    Number(e.target.value)
                                                )
                                            }
                                        />
                                        {errors.number_of_reservations && (
                                            <p className="text-red-600">
                                                {errors.number_of_reservations}
                                            </p>
                                        )}
                                    </div>
                                </div>
                            )}
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        تعليمات الباقة
                                    </label>
                                    <textarea
                                        placeholder="تعليمات الباقة"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={instructions}
                                        onChange={(e) =>
                                            setInstructions(e.target.value)
                                        }
                                    />
                                    {errors.instructions && (
                                        <p className="text-red-600">
                                            {errors.instructions}
                                        </p>
                                    )}
                                </div>
                            </div>
                            {packageType == "1" && (
                                <>
                                    <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                        <ServicesSelectionTable
                                            title="الخدمات"
                                            products={services}
                                            selectedProducts={selectedServices}
                                            setSelectedProducts={
                                                setSelectedServices
                                            }
                                            error={errors.servicesSelected}
                                        />
                                    </div>
                                    <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                        <ServicesSelectionTable
                                            title="الاستشارات"
                                            products={advisoryServicesTypes}
                                            selectedProducts={
                                                selectedAdvisoryServicesTypes
                                            }
                                            setSelectedProducts={
                                                setSelectedAdvisoryServicesTypes
                                            }
                                            error={
                                                errors.advisoryServicesSelected
                                            }
                                        />
                                    </div>
                                    <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                        <ServicesSelectionTable
                                            title="المواعيد"
                                            products={reservationTypes}
                                            selectedProducts={
                                                selectedReservationTypes
                                            }
                                            setSelectedProducts={
                                                setSelectedReservationTypes
                                            }
                                            error={errors.reservationsSelected}
                                        />
                                    </div>
                                </>
                            )}
                            {packageType == "2" && (
                                <>
                                    <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                        <div className="w-full">
                                            <label className="mb-2.5 block text-black dark:text-white">
                                                المهن
                                            </label>
                                            <MultiSelectDropdown
                                                options={sections}
                                                selectedOptions={
                                                    selectedSections
                                                }
                                                setSelectedOptions={
                                                    setSelectedSections
                                                }
                                            />
                                            {errors.sections && (
                                                <p className="text-red-600">
                                                    {errors.sections}
                                                </p>
                                            )}
                                        </div>
                                    </div>
                                    <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                        <LawyerPermissionsTable
                                            selectedPermissions={
                                                selectedLawyerPermissions
                                            }
                                            setSelectedPermissions={
                                                setSelectedLawyerPermissions
                                            }
                                            permissions={permissions}
                                        />
                                    </div>
                                </>
                            )}
                        </div>
                    </div>
                </div>
                <div className="flex gap-6">
                    <button
                        // onClick={handleSaveData}
                        onClick={saveData}
                        className="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90"
                    >
                        حفظ الملف
                    </button>
                    <button
                        onClick={() =>
                            router.get(`/newAdmin/settings/packages`)
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

export default PackageForm;
