import { router } from "@inertiajs/react";
import React, { useState } from "react";
import TextInput from "../../../TextInput";
import SaveButton from "../../../SaveButton";
import BackButton from "../../../BackButton";
import Switcher from "../../../Switchers/Switcher";
function PaymentCategoriesTypesForm({
    saveData,
    errors,
    name,
    setName,
    description,
    setDescription,
    requiresAppointment,
    setRequiresAppointment,
}: {
    saveData: any;
    errors: any;
    name: string;
    setName: any;
    description: string;
    setDescription: any;
    requiresAppointment: boolean;
    setRequiresAppointment: any;
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
                                نوع الوسيلة
                            </h3>
                        </div>
                        <div className="p-6.5">
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <TextInput
                                        label="الاسم"
                                        value={name}
                                        setValue={setName}
                                        error={errors.name}
                                        required={true}
                                        type="text"
                                    />
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <TextInput
                                        label="شرح الوسيلة"
                                        value={description}
                                        setValue={setDescription}
                                        error={errors.description}
                                        type="textarea"
                                    />
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-[#bababa] dark:text-white">
                                        هل تحتاج إلى موعد؟
                                    </label>
                                    <Switcher
                                        enabled={requiresAppointment}
                                        setEnabled={setRequiresAppointment}
                                        id="requiresAppointment"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="flex gap-6">
                    <SaveButton saveData={saveData} />
                    <BackButton
                        path={
                            "/newAdmin/settings/advisory-services/payment-categories-types"
                        }
                    />
                </div>
            </div>
        </>
    );
}

export default PaymentCategoriesTypesForm;
