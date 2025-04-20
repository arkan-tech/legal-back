import { router } from "@inertiajs/react";
import React, { useEffect, useState } from "react";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faTrash } from "@fortawesome/free-solid-svg-icons";
function BannersForm({
    saveData,
    errors,
    file,
    setFile,
    expiresAt,
    setExpiresAt,
    progress,
}: {
    saveData: any;
    errors: any;
    file;
    setFile;
    expiresAt;
    setExpiresAt;
    progress;
}) {
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
                                تفاصيل البانر
                            </h3>
                        </div>
                        <div className="p-6.5">
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full flex flex-col gap-2 xl:w-1/4">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        ملف البانر
                                    </label>
                                    <input
                                        type="file"
                                        accept=".jpg,.jpeg,.png"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        onChange={(e) =>
                                            setFile(e.target.files![0])
                                        }
                                    />
                                    {errors?.image && (
                                        <p className="text-red-600">
                                            {errors?.image}
                                        </p>
                                    )}
                                    {file != null &&
                                        typeof file == "string" && (
                                            <a
                                                target="_blank"
                                                href={file}
                                                className="
                                            w-full text-center py-2 rounded border-[1.5px] border-stroke bg-transparent py px-3
                                        "
                                            >
                                                فتح الملف
                                            </a>
                                        )}
                                </div>
                            </div>
                            <div className="w-full xl:w-1/2">
                                <label className="mb-2.5 block text-black dark:text-white">
                                    تاريخ انتهاء البانر
                                </label>
                                <input
                                    type="datetime-local"
                                    value={expiresAt}
                                    className="w-full rounded border-[1.5px] border-strokedark bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                    onChange={(e) => {
                                        setExpiresAt(e.target.value);
                                    }}
                                />
                                {errors?.expires_at && (
                                    <p className="text-red-600">
                                        {errors?.expires_at}
                                    </p>
                                )}
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
                        onClick={() => router.get("/newAdmin/settings/banners")}
                        className="flex w-full justify-center rounded bg-danger p-3 font-medium text-gray hover:bg-opacity-90"
                    >
                        الرجوع للقائمة
                    </button>
                </div>
            </div>
        </>
    );
}

export default BannersForm;
