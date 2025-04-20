import { router } from "@inertiajs/react";
import React, { useEffect, useState } from "react";
import SelectGroup from "../SelectGroup/SelectGroup";
import MultiSelect from "../../Forms/MultiSelectDropdown";
import UserSelectionTable from "../../Tables/UserSelectionTable";
const mailerTypes = [
    {
        id: "1",
        name: "طلاب الخدمة",
    },
    {
        id: "2",
        name: "مقدمي الخدمة",
    },
    {
        id: "3",
        name: "عميل",
    },
    {
        id: "4",
        name: "مقدم خدمة",
    },
    {
        id: "6",
        name: "طلاب الخدمة القدامى",
    },
    {
        id: "7",
        name: "مقدمي الخدمة القدامى",
    },
    {
        id: "8",
        name: "طالب الخدمة قديم",
    },
    {
        id: "9",
        name: "مقدم الخدمة قديم",
    },
    {
        id: "10",
        name: "القائمة البريدية",
    },
];
const mailTypes = [
    {
        id: "email",
        name: "ايميل عادي",
    },
    {
        id: "email-announcement",
        name: "اعلان الأفتتاح",
    },
];
function MailerForm({
    saveData,
    errors,
    users,
    lawyers,
    oldClients,
    oldLawyers,
    lawyer_sections,
    mailer,
}: {
    saveData: any;
    errors: any;
    users;
    lawyers;
    oldClients;
    oldLawyers;
    lawyer_sections;
    mailer;
}) {
    const [formData, setFormData] = useState({
        subject: "",
        description: "",
        type: "",
        user_ids: [],
        mailType: "",
    });
    const [selectedType, setSelectedType] = useState("");
    const [selectedEmailType, setSelectedEmailType] = useState("email");
    const [selectedUsers, setSelectedUsers] = useState([]);
    useEffect(() => {
        setFormData((prevData) => ({
            ...prevData,
            type: selectedType,
        }));
        setSelectedUsers([]);
    }, [selectedType]);
    useEffect(() => {
        setFormData((prevData) => ({
            ...prevData,
            user_ids: selectedUsers,
        }));
    }, [selectedUsers]);
    useEffect(() => {
        setFormData((prevData) => ({
            ...prevData,
            mailType: selectedEmailType,
        }));
    }, [selectedEmailType]);
    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData((prevData) => ({
            ...prevData,
            [name]: value,
        }));
    };
    const handleSubmit = async (e) => {
        e.preventDefault();
        const submitted = await saveData(formData);
        if (submitted) resetForm();
    };
    const resetForm = () => {
        setFormData({
            subject: "",
            description: "",
            type: "",
            user_ids: [],
            mailType: "",
        });
        setSelectedType("");
        setSelectedEmailType("email");
        setSelectedUsers([]);
    };
    return (
        <form
            onSubmit={handleSubmit}
            className="grid grid-cols-1 gap-9"
            style={{ direction: "rtl" }}
        >
            <div className="flex flex-col gap-9">
                <div className="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div className="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                        <h3 className="font-medium text-black dark:text-white">
                            ارسال بريد
                        </h3>
                    </div>
                    <div className="p-6.5">
                        <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                            <div className="w-full xl:w-1/2">
                                <SelectGroup
                                    firstOptionDisabled={false}
                                    firstOptionName="كل الجدد"
                                    options={mailerTypes}
                                    selectedOption={selectedType}
                                    setSelectedOption={setSelectedType}
                                    title={`نوع الحساب المرسل اليه (
                                        ${
                                            formData.type == "3"
                                                ? `${selectedUsers.length}/${users.length}`
                                                : formData.type == "4"
                                                ? `${selectedUsers.length}/${lawyers.length}`
                                                : formData.type == "8"
                                                ? `${selectedUsers.length}/${oldClients.length}`
                                                : formData.type == "9"
                                                ? `${selectedUsers.length}/${oldLawyers.length}`
                                                : formData.type == "1"
                                                ? `${users.length}`
                                                : formData.type == "2"
                                                ? `${lawyers.length}`
                                                : formData.type == "6"
                                                ? `${oldClients.length}`
                                                : formData.type == "7"
                                                ? `${oldLawyers.length}`
                                                : formData.type == "10"
                                                ? `${selectedUsers.length}/${mailer.length}`
                                                : lawyers.length + users.length
                                        }
                                        )`}
                                />
                                {errors.type && (
                                    <p className="text-red-600">
                                        {errors.type}
                                    </p>
                                )}
                            </div>
                            <div className="w-full xl:w-1/2">
                                <SelectGroup
                                    options={mailTypes}
                                    selectedOption={selectedEmailType}
                                    setSelectedOption={setSelectedEmailType}
                                    title="نوع البريد المرسل"
                                />
                                {errors.type && (
                                    <p className="text-red-600">
                                        {errors.type}
                                    </p>
                                )}
                            </div>
                        </div>
                        {(formData.type == "3" ||
                            formData.type == "4" ||
                            formData.type == "8" ||
                            formData.type == "9" ||
                            formData.type == "10") && (
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full flex flex-col gap-2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        الحسابات المرسل اليها
                                    </label>

                                    {formData.type == "3" && (
                                        <UserSelectionTable
                                            users={users}
                                            selectedUsers={selectedUsers}
                                            setSelectedUsers={setSelectedUsers}
                                        />
                                    )}

                                    {formData.type == "4" && (
                                        <UserSelectionTable
                                            users={lawyers}
                                            selectedUsers={selectedUsers}
                                            setSelectedUsers={setSelectedUsers}
                                            lawyer_sections={lawyer_sections}
                                        />
                                    )}
                                    {formData.type == "8" && (
                                        <UserSelectionTable
                                            users={oldClients}
                                            selectedUsers={selectedUsers}
                                            setSelectedUsers={setSelectedUsers}
                                        />
                                    )}
                                    {formData.type == "9" && (
                                        <UserSelectionTable
                                            users={oldLawyers}
                                            selectedUsers={selectedUsers}
                                            setSelectedUsers={setSelectedUsers}
                                        />
                                    )}
                                    {formData.type == "10" && (
                                        <UserSelectionTable
                                            users={mailer}
                                            selectedUsers={selectedUsers}
                                            setSelectedUsers={setSelectedUsers}
                                            hasName={false}
                                        />
                                    )}
                                    {errors.user_ids && (
                                        <p className="text-red-600">
                                            {errors.user_ids}
                                        </p>
                                    )}
                                </div>
                            </div>
                        )}
                        <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                            <div className="w-full xl:w-1/2">
                                <label className="mb-2.5 block text-black dark:text-white">
                                    الموضوع
                                </label>
                                <input
                                    type="text"
                                    placeholder="الموضوع"
                                    className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                    value={formData.subject}
                                    name="subject"
                                    onChange={handleChange}
                                />
                                {errors.subject && (
                                    <p className="text-red-600">
                                        {errors.subject}
                                    </p>
                                )}
                            </div>
                        </div>
                        {selectedEmailType == "email" ? (
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        الوصف
                                    </label>
                                    <textarea
                                        placeholder="الوصف"
                                        rows={6}
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={formData.description}
                                        name="description"
                                        onChange={handleChange}
                                    />
                                    {errors.description && (
                                        <p className="text-red-600">
                                            {errors.description}
                                        </p>
                                    )}
                                </div>
                            </div>
                        ) : (
                            <></>
                        )}
                    </div>
                </div>
            </div>
            <div className="flex">
                <button
                    type="submit"
                    className="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90"
                >
                    ارسال البريد
                </button>
            </div>
        </form>
    );
}

export default MailerForm;
