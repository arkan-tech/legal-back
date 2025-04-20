import { router } from "@inertiajs/react";
import React, { useState } from "react";
function RankSettingsForm({
    saveData,
    errors,
    name,
    setName,
    minLevel,
    setMinLevel,
    borderColor,
    setBorderColor,
    image,
    setImage,
}: {
    saveData: any;
    errors: any;
    name;
    setName;
    minLevel;
    setMinLevel;
    borderColor;
    setBorderColor;
    image;
    setImage;
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
                                الرتبة
                            </h3>
                        </div>
                        <div className="p-6.5">
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        اسم الرتبة
                                    </label>
                                    <input
                                        type="text"
                                        placeholder="اسم الرتبة"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={name}
                                        onChange={(e) =>
                                            setName(e.target.value)
                                        }
                                    />
                                    {errors.name && (
                                        <p className="text-red-600">
                                            {errors.name}
                                        </p>
                                    )}
                                </div>
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        المستوى المطلوب
                                    </label>
                                    <input
                                        type="text"
                                        placeholder="المستوى المطلوب"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={minLevel}
                                        onChange={(e) =>
                                            setMinLevel(e.target.value)
                                        }
                                    />
                                    {errors.min_level && (
                                        <p className="text-red-600">
                                            {errors.min_level}
                                        </p>
                                    )}
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        اللون
                                    </label>
                                    <input
                                        type="text"
                                        placeholder="اللون"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={borderColor}
                                        onChange={(e) =>
                                            setBorderColor(e.target.value)
                                        }
                                    />
                                    {errors.border_color && (
                                        <p className="text-red-600">
                                            {errors.border_color}
                                        </p>
                                    )}
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col items-center gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        الصورة
                                    </label>
                                    <input
                                        type="file"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={image?.fileName}
                                        onChange={(e) =>
                                            setImage(e.target.files![0])
                                        }
                                    />

                                    {errors?.image && (
                                        <p className="text-red-600">
                                            {errors?.image}
                                        </p>
                                    )}
                                </div>
                                <div className="w-full xl:w-1/2">
                                    {image != null &&
                                        typeof image == "string" && (
                                            <a
                                                href={image}
                                                target="_blank"
                                                className="bg-primary p-2 rounded-xl text-white"
                                            >
                                                اظهار الصورة
                                            </a>
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
                            router.get("/newAdmin/settings/gamification/ranks")
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

export default RankSettingsForm;
