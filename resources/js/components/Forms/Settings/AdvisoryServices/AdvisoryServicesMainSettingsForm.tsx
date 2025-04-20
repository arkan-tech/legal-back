import { router } from "@inertiajs/react";
import React, { useState } from "react";
import TextInput from "../../../TextInput";
import SaveButton from "../../../SaveButton";
import BackButton from "../../../BackButton";
import SelectGroup from "../../SelectGroup/SelectGroup";
function AdvisoryServicesMainSettingsForm({
    saveData,
    errors,
    name,
    setName,
    description,
    setDescription,
    paymentCategoryType,
    setPaymentCategoryType,
    paymentCategoryTypes,
}: {
    saveData: any;
    errors: any;
    name;
    setName;
    description;
    setDescription;
    paymentCategoryType;
    setPaymentCategoryType;
    paymentCategoryTypes;
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
                                تخصص عام
                            </h3>
                        </div>
                        <div className="p-6.5">
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <SelectGroup
                                        title="وسيلة الأستشارة"
                                        options={paymentCategoryTypes}
                                        selectedOption={paymentCategoryType}
                                        setSelectedOption={
                                            setPaymentCategoryType
                                        }
                                    />
                                    {errors.paymentCategoryType && (
                                        <p className="text-red-600">
                                            {errors.paymentCategoryType}
                                        </p>
                                    )}
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <TextInput
                                        label="الاسم"
                                        type="text"
                                        value={name}
                                        setValue={setName}
                                        error={errors.name}
                                        required={true}
                                    />
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <TextInput
                                        label="شرح التخصص"
                                        type="textarea"
                                        value={description}
                                        setValue={setDescription}
                                        error={errors.description}
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="flex gap-6">
                    <SaveButton saveData={saveData} />
                    <BackButton path="/newAdmin/settings/advisory-services/general-categories" />
                </div>
            </div>
        </>
    );
}

export default AdvisoryServicesMainSettingsForm;
