import { router } from "@inertiajs/react";
import React, { useEffect, useState } from "react";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faTrash } from "@fortawesome/free-solid-svg-icons";

interface Section {
    title: string;
    data: string;
}

interface SocialMediaItem {
    url: string;
    name: string;
    logo: string;
}

interface IdentityFormProps {
    saveData: () => void;
    errors: any;
    whoAreWe: Section[];
    setWhoAreWe: (sections: Section[]) => void;
    termsAndConditions: Section[];
    setTermsAndConditions: (sections: Section[]) => void;
    privacyPolicy: Section[];
    setPrivacyPolicy: (sections: Section[]) => void;
    socialMedia: SocialMediaItem[];
    setSocialMedia: (items: SocialMediaItem[]) => void;
    faq: Section[];
    setFaq: (items: Section[]) => void;
}

function IdentityForm({
    saveData,
    errors,
    whoAreWe = [],
    setWhoAreWe,
    termsAndConditions = [],
    setTermsAndConditions,
    privacyPolicy = [],
    setPrivacyPolicy,
    socialMedia = [],
    setSocialMedia,
    faq = [],
    setFaq,
}: IdentityFormProps) {
    // Ensure arrays are initialized
    useEffect(() => {
        if (!Array.isArray(whoAreWe) || whoAreWe.length === 0) {
            setWhoAreWe([{ title: "", data: "" }]);
        }
        if (
            !Array.isArray(termsAndConditions) ||
            termsAndConditions.length === 0
        ) {
            setTermsAndConditions([{ title: "", data: "" }]);
        }
        if (!Array.isArray(privacyPolicy) || privacyPolicy.length === 0) {
            setPrivacyPolicy([{ title: "", data: "" }]);
        }
        if (!Array.isArray(faq) || faq.length === 0) {
            setFaq([{ title: "", data: "" }]);
        }
        if (!Array.isArray(socialMedia) || socialMedia.length === 0) {
            setSocialMedia([{ url: "", name: "", logo: "" }]);
        }
    }, []);

    const addFaqItem = () => setFaq([...faq, { title: "", data: "" }]);
    const removeFaqItem = (index: number) =>
        setFaq(faq.filter((_, i) => i !== index));
    const updateFaqItem = (index: number, field: string, value: string) => {
        const updatedFaq = [...faq];
        updatedFaq[index][field] = value;
        setFaq(updatedFaq);
    };

    const addWhoAreWeSection = () =>
        setWhoAreWe([...whoAreWe, { title: "", data: "" }]);
    const removeWhoAreWeSection = (index: number) =>
        setWhoAreWe(whoAreWe.filter((_, i) => i !== index));
    const updateWhoAreWeSection = (
        index: number,
        field: string,
        value: string
    ) => {
        const updatedSections = [...whoAreWe];
        updatedSections[index][field] = value;
        setWhoAreWe(updatedSections);
    };

    const addTermsSection = () =>
        setTermsAndConditions([...termsAndConditions, { title: "", data: "" }]);
    const removeTermsSection = (index: number) =>
        setTermsAndConditions(termsAndConditions.filter((_, i) => i !== index));
    const updateTermsSection = (
        index: number,
        field: string,
        value: string
    ) => {
        const updatedSections = [...termsAndConditions];
        updatedSections[index][field] = value;
        setTermsAndConditions(updatedSections);
    };

    const addPrivacySection = () =>
        setPrivacyPolicy([...privacyPolicy, { title: "", data: "" }]);
    const removePrivacySection = (index: number) =>
        setPrivacyPolicy(privacyPolicy.filter((_, i) => i !== index));
    const updatePrivacySection = (
        index: number,
        field: string,
        value: string
    ) => {
        const updatedSections = [...privacyPolicy];
        updatedSections[index][field] = value;
        setPrivacyPolicy(updatedSections);
    };

    const addSocialMediaItem = () =>
        setSocialMedia([...socialMedia, { url: "", name: "", logo: "" }]);
    const removeSocialMediaItem = (index: number) =>
        setSocialMedia(socialMedia.filter((_, i) => i !== index));
    const updateSocialMediaItem = (
        index: number,
        field: string,
        value: string
    ) => {
        const updatedSocialMedia = [...socialMedia];
        updatedSocialMedia[index][field] = value;
        setSocialMedia(updatedSocialMedia);
    };

    return (
        <>
            <div
                className="grid grid-cols-1 gap-9"
                style={{ direction: "rtl" }}
            >
                <div className="flex flex-col gap-9">
                    {/* Who Are We Section */}
                    <div className="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                        <div className="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                            <h3 className="font-medium text-black dark:text-white">
                                من نحن
                            </h3>
                        </div>
                        <div className="p-6.5">
                            {Array.isArray(whoAreWe) &&
                                whoAreWe.map((section, index) => (
                                    <div
                                        key={index}
                                        className="mb-4.5 flex gap-6 xl:flex-row"
                                    >
                                        <textarea
                                            className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black dark:text-white"
                                            value={section.title}
                                            onChange={(e) =>
                                                updateWhoAreWeSection(
                                                    index,
                                                    "title",
                                                    e.target.value
                                                )
                                            }
                                            placeholder="العنوان"
                                        />
                                        <textarea
                                            className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black dark:text-white"
                                            value={section.data}
                                            onChange={(e) =>
                                                updateWhoAreWeSection(
                                                    index,
                                                    "data",
                                                    e.target.value
                                                )
                                            }
                                            placeholder="المحتوى"
                                        />
                                        <button
                                            type="button"
                                            onClick={() =>
                                                removeWhoAreWeSection(index)
                                            }
                                        >
                                            <FontAwesomeIcon icon={faTrash} />
                                        </button>
                                    </div>
                                ))}
                            <button
                                type="button"
                                onClick={addWhoAreWeSection}
                                className="btn btn-secondary"
                            >
                                إضافة قسم جديد
                            </button>
                            {errors?.who_are_we && (
                                <p className="text-red-600">
                                    {errors.who_are_we}
                                </p>
                            )}
                        </div>
                    </div>

                    {/* Terms and Conditions Section */}
                    <div className="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                        <div className="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                            <h3 className="font-medium text-black dark:text-white">
                                الشروط والأحكام
                            </h3>
                        </div>
                        <div className="p-6.5">
                            {Array.isArray(termsAndConditions) &&
                                termsAndConditions.map((section, index) => (
                                    <div
                                        key={index}
                                        className="mb-4.5 flex gap-6 xl:flex-row"
                                    >
                                        <textarea
                                            className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black dark:text-white"
                                            value={section.title}
                                            onChange={(e) =>
                                                updateTermsSection(
                                                    index,
                                                    "title",
                                                    e.target.value
                                                )
                                            }
                                            placeholder="العنوان"
                                        />
                                        <textarea
                                            className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black dark:text-white"
                                            value={section.data}
                                            onChange={(e) =>
                                                updateTermsSection(
                                                    index,
                                                    "data",
                                                    e.target.value
                                                )
                                            }
                                            placeholder="المحتوى"
                                        />
                                        <button
                                            type="button"
                                            onClick={() =>
                                                removeTermsSection(index)
                                            }
                                        >
                                            <FontAwesomeIcon icon={faTrash} />
                                        </button>
                                    </div>
                                ))}
                            <button
                                type="button"
                                onClick={addTermsSection}
                                className="btn btn-secondary"
                            >
                                إضافة قسم جديد
                            </button>
                            {errors?.terms_and_conditions && (
                                <p className="text-red-600">
                                    {errors.terms_and_conditions}
                                </p>
                            )}
                        </div>
                    </div>

                    {/* Privacy Policy Section */}
                    <div className="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                        <div className="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                            <h3 className="font-medium text-black dark:text-white">
                                سياسة الخصوصية
                            </h3>
                        </div>
                        <div className="p-6.5">
                            {Array.isArray(privacyPolicy) &&
                                privacyPolicy.map((section, index) => (
                                    <div
                                        key={index}
                                        className="mb-4.5 flex gap-6 xl:flex-row"
                                    >
                                        <textarea
                                            className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black dark:text-white"
                                            value={section.title}
                                            onChange={(e) =>
                                                updatePrivacySection(
                                                    index,
                                                    "title",
                                                    e.target.value
                                                )
                                            }
                                            placeholder="العنوان"
                                        />
                                        <textarea
                                            className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black dark:text-white"
                                            value={section.data}
                                            onChange={(e) =>
                                                updatePrivacySection(
                                                    index,
                                                    "data",
                                                    e.target.value
                                                )
                                            }
                                            placeholder="المحتوى"
                                        />
                                        <button
                                            type="button"
                                            onClick={() =>
                                                removePrivacySection(index)
                                            }
                                        >
                                            <FontAwesomeIcon icon={faTrash} />
                                        </button>
                                    </div>
                                ))}
                            <button
                                type="button"
                                onClick={addPrivacySection}
                                className="btn btn-secondary"
                            >
                                إضافة قسم جديد
                            </button>
                            {errors?.privacy_policy && (
                                <p className="text-red-600">
                                    {errors.privacy_policy}
                                </p>
                            )}
                        </div>
                    </div>

                    {/* FAQ Section */}
                    <div className="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                        <div className="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                            <h3 className="font-medium text-black dark:text-white">
                                الأسئلة الشائعة
                            </h3>
                        </div>
                        <div className="p-6.5">
                            {Array.isArray(faq) &&
                                faq.map((item, index) => (
                                    <div
                                        key={index}
                                        className="mb-4.5 flex gap-6 xl:flex-row"
                                    >
                                        <textarea
                                            className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black dark:text-white"
                                            value={item.title}
                                            onChange={(e) =>
                                                updateFaqItem(
                                                    index,
                                                    "title",
                                                    e.target.value
                                                )
                                            }
                                            placeholder="العنوان"
                                        />
                                        <textarea
                                            className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black dark:text-white"
                                            value={item.data}
                                            onChange={(e) =>
                                                updateFaqItem(
                                                    index,
                                                    "data",
                                                    e.target.value
                                                )
                                            }
                                            placeholder="البيانات"
                                        />
                                        <button
                                            type="button"
                                            onClick={() => removeFaqItem(index)}
                                        >
                                            <FontAwesomeIcon icon={faTrash} />
                                        </button>
                                    </div>
                                ))}
                            <button
                                type="button"
                                onClick={addFaqItem}
                                className="btn btn-secondary"
                            >
                                إضافة سؤال جديد
                            </button>
                        </div>
                    </div>

                    {/* Social Media Links */}
                    <div className="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                        <div className="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                            <h3 className="font-medium text-black dark:text-white">
                                روابط مواقع التواصل الاجتماعي
                            </h3>
                        </div>
                        <div className="p-6.5">
                            {Array.isArray(socialMedia) &&
                                socialMedia.map((item, index) => (
                                    <div
                                        key={index}
                                        className="mb-4.5 flex gap-6 xl:flex-row"
                                    >
                                        <div className="flex flex-col items-center">
                                            <img
                                                src={item.logo}
                                                alt={`${item.name} logo`}
                                                className="w-12 h-12"
                                            />
                                        </div>
                                        <input
                                            type="text"
                                            className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black dark:text-white"
                                            value={item.url}
                                            onChange={(e) =>
                                                updateSocialMediaItem(
                                                    index,
                                                    "url",
                                                    e.target.value
                                                )
                                            }
                                            placeholder="URL"
                                        />
                                    </div>
                                ))}
                        </div>
                    </div>

                    <div className="flex gap-6">
                        <button
                            onClick={saveData}
                            className="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90"
                        >
                            حفظ الملف
                        </button>
                    </div>
                </div>
            </div>
        </>
    );
}

export default IdentityForm;
