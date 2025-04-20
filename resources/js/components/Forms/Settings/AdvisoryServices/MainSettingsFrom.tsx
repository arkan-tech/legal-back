import { router } from "@inertiajs/react";
import React, { useState } from "react";
import SelectGroup from "../../SelectGroup/SelectGroup";
import Switcher from "../../../Switchers/Switcher";
function MainSettingsForm({
    saveData,
    errors,
    paymentCategories,
    selectedPaymentCategoryType,
    setSelectedPaymentCategoryType,
    selectedPaymentCategory,
    setSelectedPaymentCategory,
    needAppointment,
    setNeedAppointment,
    about,
    setAbout,
    instructions,
    setInstructions,
    paymentCategoriesTypes,
    selectedBase,
    setSelectedBase,
    baseCategories,
}: {
    saveData: any;
    errors: any;
    paymentCategories;
    selectedPaymentCategoryType;
    setSelectedPaymentCategoryType;
    needAppointment;
    setNeedAppointment;
    about;
    setAbout;
    selectedPaymentCategory;
    setSelectedPaymentCategory;
    instructions;
    setInstructions;
    paymentCategoriesTypes;
    selectedBase;
    setSelectedBase;
    baseCategories;
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
                                وسيلة الأستشارة
                            </h3>
                        </div>
                        <div className="p-6.5">
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <SelectGroup
                                        options={baseCategories}
                                        title="فئة الاستشارة"
                                        selectedOption={selectedBase}
                                        setSelectedOption={setSelectedBase}
                                    />
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <SelectGroup
                                        options={paymentCategories.filter(
                                            (pc) =>
                                                pc.advisory_service_base_id ==
                                                selectedBase
                                        )}
                                        title="باقة الاستشارة"
                                        selectedOption={selectedPaymentCategory}
                                        setSelectedOption={
                                            setSelectedPaymentCategory
                                        }
                                    />
                                    {errors.payment_category_id && (
                                        <p className="text-red-600">
                                            {errors.payment_category_id}
                                        </p>
                                    )}
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <SelectGroup
                                        options={paymentCategoriesTypes}
                                        selectedOption={
                                            selectedPaymentCategoryType
                                        }
                                        setSelectedOption={
                                            setSelectedPaymentCategoryType
                                        }
                                        title="اسم الوسيلة"
                                    />
                                    {errors.payment_category_type_id && (
                                        <p className="text-red-600">
                                            {errors.payment_category_type_id}
                                        </p>
                                    )}
                                </div>
                            </div>

                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full flex gap-4 xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        هل تحتاج لموعد؟
                                    </label>
                                    <Switcher
                                        id="needAppointment"
                                        enabled={needAppointment}
                                        setEnabled={setNeedAppointment}
                                    />
                                    {errors.need_appointment && (
                                        <p className="text-red-600">
                                            {errors.need_appointment}
                                        </p>
                                    )}
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        وصف قصير
                                    </label>
                                    <textarea
                                        placeholder="الوصف"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={about}
                                        onChange={(e) =>
                                            setAbout(e.target.value)
                                        }
                                    />
                                    {errors.description && (
                                        <p className="text-red-600">
                                            {errors.description}
                                        </p>
                                    )}
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        التعليمات
                                    </label>
                                    <textarea
                                        placeholder="التعليمات"
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
                            router.get("/newAdmin/settings/advisory-services")
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

export default MainSettingsForm;
