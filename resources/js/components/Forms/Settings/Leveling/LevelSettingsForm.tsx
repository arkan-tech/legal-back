import { router } from "@inertiajs/react";
import React, { useState } from "react";
function LevelSettingsForm({
    saveData,
    errors,
    levelName,
    setLevelName,
    pointsNeeded,
    setPointsNeeded,
}: {
    saveData: any;
    errors: any;
    levelName: any;
    setLevelName: any;
    pointsNeeded;
    setPointsNeeded;
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
                                المستوى
                            </h3>
                        </div>
                        <div className="p-6.5">
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        رقم المستوى
                                    </label>
                                    <input
                                        type="number"
                                        placeholder="رقم المستوى"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={levelName}
                                        onChange={(e) =>
                                            setLevelName(e.target.value)
                                        }
                                    />
                                    {errors.level_number && (
                                        <p className="text-red-600">
                                            {errors.level_number}
                                        </p>
                                    )}
                                </div>
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        عدد النقاط المطلوبة
                                    </label>
                                    <input
                                        type="number"
                                        placeholder="عدد النقاط المطلوبة"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={pointsNeeded}
                                        onChange={(e) =>
                                            setPointsNeeded(e.target.value)
                                        }
                                    />
                                    {errors.required_experience && (
                                        <p className="text-red-600">
                                            {errors.required_experience}
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
                            router.get("/newAdmin/settings/gamification/levels")
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

export default LevelSettingsForm;
