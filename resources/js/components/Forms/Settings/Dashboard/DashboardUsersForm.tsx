import { router } from "@inertiajs/react";
import React, { useEffect, useState } from "react";
import SelectGroup from "../../SelectGroup/SelectGroup";
import Switcher from "../../../Switchers/Switcher";
import MultiSelectDropdown from "../../MultiSelectDropdown";
function DashboardUsersForm({
    saveData,
    errors,
    name,
    setName,
    email,
    setEmail,
    roles,
    permissions,
    selectedRoles,
    selectedPermissions,
    setSelectedRoles,
    setSelectedPermissions,
}: {
    saveData: any;
    errors: any;
    name;
    setName;
    email;
    setEmail;
    roles;
    permissions;
    selectedRoles;
    selectedPermissions;
    setSelectedRoles;
    setSelectedPermissions;
}) {
    useEffect(() => {
        if (selectedRoles.length > 0) {
            const selectedPermissions = roles
                .filter((role) => selectedRoles.includes(role.id))
                .flatMap((role) => role.permissions.map((perm) => perm.id));
            setSelectedPermissions((prevSelectedPermissions) => {
                // Filter out permissions associated with removed roles
                const removedPermissions = prevSelectedPermissions.filter(
                    (permission) => !selectedPermissions.includes(permission)
                );
                console.log("re", removedPermissions);

                // Merge permissions from new roles with permissions from removed roles
                return [
                    ...selectedPermissions,
                    ...prevSelectedPermissions.filter(
                        (permission) => !removedPermissions.includes(permission)
                    ),
                ];
            });
        } else {
            setSelectedPermissions([]);
        }
    }, [selectedRoles]);
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
                                بيانات المستخدم
                            </h3>
                        </div>
                        <div className="p-6.5">
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        اسم المستخدم
                                    </label>
                                    <input
                                        type="text"
                                        placeholder="الاسم"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={name}
                                        onChange={(e) =>
                                            setName(e.target.value)
                                        }
                                    />
                                    {errors?.name && (
                                        <p className="text-red-600">
                                            {errors?.name}
                                        </p>
                                    )}
                                </div>
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        البريد الالكتروني
                                    </label>
                                    <input
                                        type="email"
                                        placeholder="البريد الالكتروني"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={email}
                                        onChange={(e) =>
                                            setEmail(e.target.value)
                                        }
                                    />
                                    {errors?.email && (
                                        <p className="text-red-600">
                                            {errors?.email}
                                        </p>
                                    )}
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full ">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        الأدوار
                                    </label>
                                    <MultiSelectDropdown
                                        options={roles}
                                        selectedOptions={selectedRoles}
                                        setSelectedOptions={setSelectedRoles}
                                    />
                                    {errors?.roles && (
                                        <p className="text-red-600">
                                            {errors?.roles}
                                        </p>
                                    )}
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full ">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        الصلاحيات{" "}
                                    </label>
                                    <MultiSelectDropdown
                                        options={permissions}
                                        selectedOptions={selectedPermissions}
                                        setSelectedOptions={
                                            setSelectedPermissions
                                        }
                                    />
                                    {errors?.permissions && (
                                        <p className="text-red-600">
                                            {errors?.permissions}
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
                            router.get("/newAdmin/settings/dashboard/users")
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

export default DashboardUsersForm;
