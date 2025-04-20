import { router } from "@inertiajs/react";
import React, { useEffect, useState } from "react";
import SelectGroup from "../SelectGroup/SelectGroup";
import ServicesSelectionTable from "../../Tables/ProductsSelectionTable";
import { DURATIONTYPES, PACKAGETYPES } from "../../../Pages/Settings/Packages";
import LawyerPermissionsTable from "../../Tables/LawyerPermissionsSelectionTable";
import TextInput from "../../TextInput";
import SaveButton from "../../SaveButton";
import BackButton from "../../BackButton";
function LawyerPermissionsForm({
    saveData,
    errors,
    name,
    setName,
    description,
    setDescription,
}: {
    saveData: any;
    errors: any;
    name;
    setName;
    description;
    setDescription;
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
                                تفاصيل المزية
                            </h3>
                        </div>
                        <div className="p-6.5">
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <TextInput
                                        label="اسم المزية"
                                        value={name}
                                        setValue={setName}
                                        error={errors.name}
                                        required={true}
                                        type="text"
                                    />
                                </div>
                            </div>
                        </div>
                        <div className="p-6.5">
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <TextInput
                                        label="وصف المزية"
                                        value={description}
                                        setValue={setDescription}
                                        error={errors.description}
                                        required={true}
                                        type="textarea"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="flex gap-6">
                    <SaveButton saveData={saveData} />
                    <BackButton path="/newAdmin/settings/lawyer-permissions" />
                </div>
            </div>
        </>
    );
}

export default LawyerPermissionsForm;
