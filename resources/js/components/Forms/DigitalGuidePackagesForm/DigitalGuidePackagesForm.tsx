import { router } from "@inertiajs/react";
import React, { useState } from "react";
function DigitalGuidePackagesForm({
    saveData,
    errors,
    packageDetails,
}: {
    saveData: any;
    errors: any;
    packageDetails?;
}) {
    const [formData, setFormData] = useState(
        {
            title: packageDetails?.title,
            price: packageDetails?.price,
            intro: packageDetails?.intro,
            rules: packageDetails?.rules,
            period: packageDetails?.period,
        } || {}
    );
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
        <>
            <div
                className="grid grid-cols-1 gap-9"
                style={{ direction: "rtl" }}
            >
                <form onSubmit={handleSubmit} className="flex flex-col gap-9">
                    <div className="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                        <div className="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                            <h3 className="font-medium text-black dark:text-white">
                                الباقة
                            </h3>
                        </div>
                        <div className="p-6.5">
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        الاسم
                                    </label>
                                    <input
                                        type="text"
                                        placeholder="الاسم"
                                        name="title"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={formData.title}
                                        onChange={handleChange}
                                    />
                                    {errors.title && (
                                        <p className="text-red-600">
                                            {errors.title}
                                        </p>
                                    )}
                                </div>
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        السعر
                                    </label>
                                    <input
                                        type="number"
                                        placeholder="السعر"
                                        name="price"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={formData.price}
                                        onChange={handleChange}
                                    />
                                    {errors.price && (
                                        <p className="text-red-600">
                                            {errors.price}
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
                                        name="intro"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={formData.intro}
                                        onChange={handleChange}
                                    />
                                    {errors.intro && (
                                        <p className="text-red-600">
                                            {errors.intro}
                                        </p>
                                    )}
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        التعليمات
                                    </label>
                                    <textarea
                                        placeholder="التعليمات"
                                        name="rules"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={formData.rules}
                                        onChange={handleChange}
                                    />
                                    {errors.rules && (
                                        <p className="text-red-600">
                                            {errors.rules}
                                        </p>
                                    )}
                                </div>
                                <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                    <div className="w-full xl:w-1/2">
                                        <label className="mb-2.5 block text-black dark:text-white">
                                            المدة
                                        </label>
                                        <input
                                            type="number"
                                            placeholder="المدة"
                                            name="period"
                                            className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                            value={formData.period}
                                            onChange={handleChange}
                                        />
                                        {errors.period && (
                                            <p className="text-red-600">
                                                {errors.period}
                                            </p>
                                        )}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="flex gap-6">
                        <button
                            type="submit"
                            className="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90"
                        >
                            حفظ الملف
                        </button>
                        <button
                            type="button"
                            onClick={() => router.get("/newAdmin/packages")}
                            className="flex w-full justify-center rounded bg-danger p-3 font-medium text-gray hover:bg-opacity-90"
                        >
                            الرجوع للقائمة
                        </button>
                    </div>
                </form>
            </div>
        </>
    );
}

export default DigitalGuidePackagesForm;
