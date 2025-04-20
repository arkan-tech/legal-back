import { router } from "@inertiajs/react";
import React, { useEffect, useState } from "react";
import SelectGroup from "../SelectGroup/SelectGroup";
import MultiSelect from "../../Forms/MultiSelectDropdown";
import UserSelectionTable from "../../Tables/UserSelectionTable";
const mailerTypes = [
    {
        id: "0",
        name: "الكل",
    },
    {
        id: "1",
        name: "العملاء",
    },
    {
        id: "2",
        name: "مقدمي الخدمة",
    },
    {
        id: "3",
        name: "الزوار",
    },
    {
        id: "4",
        name: "عميل",
    },
    {
        id: "5",
        name: "مقدم خدمة",
    },
    {
        id: "6",
        name: "زائر",
    },
];
const notificationTypes = [
    {
        id: "1",
        name: "عامة",
    },
    {
        id: "2",
        name: "الشَّذرات",
    },
    {
        id: "3",
        name: "تحديثات متجر",
    },
    {
        id: "4",
        name: "تحديثات داخلية",
    },
];
function NotificationForm({
    saveData,
    errors,
    users,
    lawyers,
    visitors,
    lawyer_sections,
}: {
    saveData: any;
    errors: any;
    users;
    lawyers;
    visitors;
    lawyer_sections;
}) {
    const [formData, setFormData] = useState({
        subject: "",
        description: "",
        type: "0",
        user_ids: [],
        notification_type: "",
    });
    const [selectedType, setSelectedType] = useState("");
    const [notificationType, setNotificationType] = useState("");
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
            notification_type: notificationType,
        }));
    }, [notificationType]);
    useEffect(() => {
        setFormData((prevData) => ({
            ...prevData,
            user_ids: selectedUsers,
        }));
    }, [selectedUsers]);
    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData((prevData) => ({
            ...prevData,
            [name]: value,
        }));
    };
    const handleSubmit = (e) => {
        e.preventDefault();
        saveData(formData);
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
                            ارسال اشعارات
                        </h3>
                    </div>
                    <div className="p-6.5">
                        <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                            <div className="w-full xl:w-1/2">
                                <SelectGroup
                                    firstOptionDisabled={true}
                                    options={mailerTypes}
                                    selectedOption={selectedType}
                                    setSelectedOption={setSelectedType}
                                    title={`نوع الحساب المرسل اليه (
                                        ${
                                            formData.type == "4"
                                                ? `${selectedUsers.length}/${users.length}`
                                                : formData.type == "5"
                                                ? `${selectedUsers.length}/${lawyers.length}`
                                                : formData.type == "6"
                                                ? `${selectedUsers.length}/${visitors.length}`
                                                : formData.type == "0"
                                                ? `${
                                                      users.length +
                                                      lawyers.length
                                                  }`
                                                : formData.type == "1"
                                                ? `${users.length}`
                                                : formData.type == "2"
                                                ? `${lawyers.length}`
                                                : formData.type == "3"
                                                ? `${visitors.length}`
                                                : ""
                                        }
                                        )`}
                                />
                                {errors?.type && (
                                    <p className="text-red-600">
                                        {errors?.type}
                                    </p>
                                )}
                            </div>
                            <div className="w-full xl:w-1/2">
                                <SelectGroup
                                    options={notificationTypes}
                                    selectedOption={notificationType}
                                    setSelectedOption={setNotificationType}
                                    title="نوع الإشعار"
                                />
                                {errors?.notification_type && (
                                    <p className="text-red-600">
                                        {errors?.notification_type}
                                    </p>
                                )}
                            </div>
                        </div>
                        {(formData.type == "4" ||
                            formData.type == "5" ||
                            formData.type == "6") && (
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        الحسابات المرسل اليها
                                    </label>
                                    {formData.type == "4" && (
                                        <UserSelectionTable
                                            users={users}
                                            selectedUsers={selectedUsers}
                                            setSelectedUsers={setSelectedUsers}
                                        />
                                    )}
                                    {formData.type == "5" && (
                                        <UserSelectionTable
                                            users={lawyers}
                                            selectedUsers={selectedUsers}
                                            setSelectedUsers={setSelectedUsers}
                                            lawyer_sections={lawyer_sections}
                                        />
                                    )}
                                    {formData.type == "6" && (
                                        <UserSelectionTable
                                            users={visitors}
                                            selectedUsers={selectedUsers}
                                            setSelectedUsers={setSelectedUsers}
                                        />
                                    )}
                                    {errors?.user_ids && (
                                        <p className="text-red-600">
                                            {errors?.user_ids}
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
                                {errors?.subject && (
                                    <p className="text-red-600">
                                        {errors?.subject}
                                    </p>
                                )}
                            </div>
                        </div>
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
                                {errors?.description && (
                                    <p className="text-red-600">
                                        {errors?.description}
                                    </p>
                                )}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div className="flex">
                <button
                    type="submit"
                    className="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90"
                >
                    ارسال الأشعار
                </button>
            </div>
        </form>
    );
}

export default NotificationForm;
