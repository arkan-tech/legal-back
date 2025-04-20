import { router } from "@inertiajs/react";
import React, { useState } from "react";
function BaseSettingsForm({
    saveData,
    errors,
    whoAreWeDescription,
    setWhoAreWeDescription,
    privacyPolicyDescription,
    setPrivacyPolicyDescription,
    faq,
    setFaq,
    socialMediaLinks,
    setSocialMediaLinks,
}: {
    saveData: any;
    errors: any;
    whoAreWeDescription;
    setWhoAreWeDescription;
    privacyPolicyDescription;
    setPrivacyPolicyDescription;
    faq;
    setFaq;
    socialMediaLinks;
    setSocialMediaLinks;
}) {
    const addFaqItem = () => {
        setFaq([...faq, { title: "", data: "" }]);
    };

    const addSocialMediaLink = () => {
        setSocialMediaLinks([
            ...socialMediaLinks,
            { name: "", url: "", logo: "" },
        ]);
    };

    const handleLogoChange = (index, file) => {
        const reader = new FileReader();
        reader.onloadend = () => {
            const updatedLinks = [...socialMediaLinks];
            updatedLinks[index].logo = reader.result;
            setSocialMediaLinks(updatedLinks);
        };
        if (file) {
            reader.readAsDataURL(file);
        }
    };
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
                                من نحن
                            </h3>
                        </div>
                        <div className="p-6.5">
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        النص
                                    </label>
                                    <textarea
                                        placeholder="النص"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={whoAreWeDescription}
                                        onChange={(e) =>
                                            setWhoAreWeDescription(
                                                e.target.value
                                            )
                                        }
                                    />
                                    {errors.whoAreWe && (
                                        <p className="text-red-600">
                                            {errors.whoAreWe}
                                        </p>
                                    )}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                        <div className="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                            <h3 className="font-medium text-black dark:text-white">
                                سياسة الخصوصية
                            </h3>
                        </div>
                        <div className="p-6.5">
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        النص
                                    </label>
                                    <textarea
                                        placeholder="النص"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={privacyPolicyDescription}
                                        onChange={(e) =>
                                            setPrivacyPolicyDescription(
                                                e.target.value
                                            )
                                        }
                                    />
                                    {errors.privacyPolicy && (
                                        <p className="text-red-600">
                                            {errors.privacyPolicy}
                                        </p>
                                    )}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                        <div className="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                            <h3 className="font-medium text-black dark:text-white">
                                الأسالة الشائعة
                            </h3>
                        </div>
                        <div className="p-6.5">
                            {faq.map((question, index) => (
                                <div
                                    key={index}
                                    className="mb-4.5 flex flex-col gap-6 xl:flex-row"
                                >
                                    <div className="w-full">
                                        <label className="mb-2.5 block text-black dark:text-white">
                                            السؤال {index + 1}
                                        </label>
                                        <input
                                            type="text"
                                            placeholder="عنوان السؤال"
                                            className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                            value={question.title}
                                            onChange={(e) =>
                                                setFaq(
                                                    faq.map((q, i) =>
                                                        i === index
                                                            ? {
                                                                  ...q,
                                                                  title: e
                                                                      .target
                                                                      .value,
                                                              }
                                                            : q
                                                    )
                                                )
                                            }
                                        />
                                        <textarea
                                            placeholder="الإجابة"
                                            className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                            value={question.data}
                                            onChange={(e) =>
                                                setFaq(
                                                    faq.map((q, i) =>
                                                        i === index
                                                            ? {
                                                                  ...q,
                                                                  data: e.target
                                                                      .value,
                                                              }
                                                            : q
                                                    )
                                                )
                                            }
                                        />
                                        {errors.faq && errors.faq[index] && (
                                            <p className="text-red-600">
                                                {errors.faq[index]}
                                            </p>
                                        )}
                                    </div>
                                </div>
                            ))}
                            <button
                                onClick={addFaqItem}
                                className="mt-4 rounded bg-primary p-2 text-white hover:bg-opacity-90"
                            >
                                إضافة سؤال جديد
                            </button>
                        </div>
                    </div>
                    <div className="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                        <div className="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                            <h3 className="font-medium text-black dark:text-white">
                                وسائل التواصل
                            </h3>
                        </div>
                        <div className="p-6.5">
                            {socialMediaLinks.map((link, index) => (
                                <div
                                    key={index}
                                    className="mb-4.5 flex flex-col gap-6 xl:flex-row"
                                >
                                    <div className="w-full">
                                        <label className="mb-2.5 block text-black dark:text-white">
                                            اسم الوسيلة
                                        </label>
                                        <input
                                            type="text"
                                            placeholder="اسم الوسيلة"
                                            className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                            value={link.name}
                                            onChange={(e) =>
                                                setSocialMediaLinks(
                                                    socialMediaLinks.map(
                                                        (s, i) =>
                                                            i === index
                                                                ? {
                                                                      ...s,
                                                                      name: e
                                                                          .target
                                                                          .value,
                                                                  }
                                                                : s
                                                    )
                                                )
                                            }
                                        />
                                        <label className="mb-2.5 block text-black dark:text-white">
                                            الرابط
                                        </label>
                                        <input
                                            type="text"
                                            placeholder="الرابط"
                                            className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                            value={link.url}
                                            onChange={(e) =>
                                                setSocialMediaLinks(
                                                    socialMediaLinks.map(
                                                        (s, i) =>
                                                            i === index
                                                                ? {
                                                                      ...s,
                                                                      url: e
                                                                          .target
                                                                          .value,
                                                                  }
                                                                : s
                                                    )
                                                )
                                            }
                                        />
                                        <label className="mb-2.5 block text-black dark:text-white">
                                            الشعار
                                        </label>
                                        <input
                                            type="text"
                                            placeholder="الشعار"
                                            className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                            value={link.logo}
                                            onChange={(e) =>
                                                setSocialMediaLinks(
                                                    socialMediaLinks.map(
                                                        (s, i) =>
                                                            i === index
                                                                ? {
                                                                      ...s,
                                                                      logo: e
                                                                          .target
                                                                          .value,
                                                                  }
                                                                : s
                                                    )
                                                )
                                            }
                                        />
                                        {errors.socialMedia &&
                                            errors.socialMedia[index] && (
                                                <p className="text-red-600">
                                                    {errors.socialMedia[index]}
                                                </p>
                                            )}
                                    </div>
                                </div>
                            ))}
                            <button
                                onClick={addSocialMediaLink}
                                className="mt-4 rounded bg-primary p-2 text-white hover:bg-opacity-90"
                            >
                                إضافة وسيلة جديد
                            </button>
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
                            router.get(
                                "/newAdmin/settings/advisory-services/base"
                            )
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

export default BaseSettingsForm;
