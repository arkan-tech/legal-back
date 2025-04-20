import { router } from "@inertiajs/react";
import React, { useState } from "react";
import SelectGroup from "./SelectGroup/SelectGroup";
import { VisitorStatusOptions } from "../Tables/VisitorsTable";
import TextInput from "../TextInput";
import { MailerAccountsStatusOptions } from "../Tables/MailerAccountsTable";
import SaveButton from "../SaveButton";
import BackButton from "../BackButton";
function MailerAccountsForm({
    saveData,
    errors,
    email,
    setEmail,
    status,
    setStatus,
}: {
    saveData: any;
    errors: any;
    email;
    setEmail;
    status;
    setStatus;
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
                                حساب القائمة البريدية
                            </h3>
                        </div>
                        <div className="p-6.5">
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <TextInput
                                        label="الأيميل"
                                        type="email"
                                        placeholder="الأيميل"
                                        value={email}
                                        setValue={setEmail}
                                        required={true}
                                        error={errors.email}
                                    />
                                </div>
                                <div className="w-full xl:w-1/2">
                                    <SelectGroup
                                        title="الحالة"
                                        options={MailerAccountsStatusOptions}
                                        selectedOption={status}
                                        setSelectedOption={setStatus}
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="flex gap-6">
                    <SaveButton saveData={saveData} />
                    <BackButton path={"/newAdmin/mailer-accounts"} />
                </div>
            </div>
        </>
    );
}

export default MailerAccountsForm;
