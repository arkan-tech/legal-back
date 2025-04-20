import { router } from "@inertiajs/react";
import React, { useState } from "react";
import SelectGroup from "../../SelectGroup/SelectGroup";
function PaymentCategoriesSettingsForm({
    saveData,
    errors,
    base,
    paymentCategoryName,
    setPaymentCategoryName,
    selectedBase,
    setSelectedBase,
    paymentMethod,
    setPaymentMethod,
}: {
    saveData: any;
    errors: any;
    base: any[];
    paymentCategoryName: string;
    setPaymentCategoryName: any;
    selectedBase;
    setSelectedBase;
    paymentMethod;
    setPaymentMethod;
}) {
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
                                باقة الأستشارة
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
                                        value={paymentCategoryName}
                                        onChange={(e) =>
                                            setPaymentCategoryName(
                                                e.target.value
                                            )
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
                                        options={base}
                                        title="فئة الاستشارة"
                                        selectedOption={selectedBase}
                                        setSelectedOption={setSelectedBase}
                                    />
                                    {errors.advisory_service_base_id && (
                                        <p className="text-red-600">
                                            {errors.advisory_service_base_id}
                                        </p>
                                    )}
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <SelectGroup
                                        options={[
                                            {
                                                id: 1,
                                                name: "مجانية",
                                            },
                                            {
                                                id: 2,
                                                name: "مدفوعة",
                                            },
                                            {
                                                id: 3,
                                                name: "متخصصة",
                                            },
                                        ]}
                                        title="طريقة الدفع"
                                        selectedOption={paymentMethod}
                                        setSelectedOption={setPaymentMethod}
                                    />
                                    {errors.payment_method && (
                                        <p className="text-red-600">
                                            {errors.payment_method}
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
                                "/newAdmin/settings/advisory-services/payment-categories"
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

export default PaymentCategoriesSettingsForm;
