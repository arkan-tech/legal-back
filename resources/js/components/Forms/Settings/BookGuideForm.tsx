import { router } from "@inertiajs/react";
import React, { useEffect, useRef, useState } from "react";
import SelectGroup from "../SelectGroup/SelectGroup";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import {
    faArrowDown,
    faArrowUp,
    faPlus,
    faTrash,
} from "@fortawesome/free-solid-svg-icons";
import TextInput from "../../TextInput";
import DatePicker from "../DatePicker/DatePicker";
import SaveButton from "../../SaveButton";
import BackButton from "../../BackButton";
function BookGuideForm({
    saveData,
    errors,
    mainCategories,
    name,
    setName,
    nameEn,
    setNameEn,
    selectedMainCategory,
    setSelectedMainCategory,
    laws,
    setLaws,
    PDF,
    setPDF,
    PDFEn,
    setPDFEn,
    word,
    setWord,
    wordEn,
    setWordEn,
    status,
    setStatus,
    about,
    aboutEn,
    setAbout,
    setAboutEn,
    releaseTool,
    setReleaseTool,
    releaseToolEn,
    setReleaseToolEn,
    numberOfChapters,
    setNumberOfChapters,
    releasedAt,
    setReleasedAt,
    publishedAt,
    setPublishedAt,
    releasedAtHijri,
    publishedAtHijri,
    setDeleteModalOpen,
    progress,
    scrollToTop,
}: {
    saveData: any;
    errors: any;
    mainCategories: any[];
    name: string;
    nameEn;
    setNameEn;
    setName: any;
    selectedMainCategory;
    setSelectedMainCategory;
    laws;
    setLaws;
    PDF;
    setPDF;
    PDFEn;
    setPDFEn;
    word;
    setWord;
    wordEn;
    setWordEn;
    status;
    setStatus;
    about;
    aboutEn;
    setAbout;
    setAboutEn;
    releaseTool;
    setReleaseTool;
    releaseToolEn;
    setReleaseToolEn;
    numberOfChapters;
    setNumberOfChapters;
    releasedAt;
    setReleasedAt;
    publishedAt;
    setPublishedAt;
    releasedAtHijri;
    publishedAtHijri;
    setDeleteModalOpen;
    progress;
    scrollToTop;
}) {
    const handleAddLaw = (index: number) => {
        const newLaw = {
            id: Date.now(),
            name_ar: "",
            section_text_ar: "",
            changes_ar: "",
            name_en: "",
            section_text_en: "",
            changes_en: "",
        };
        const updatedLaws = [...laws];
        updatedLaws.splice(index, 0, newLaw);
        setLaws(updatedLaws);
    };
    const handleMoveUp = (index: number) => {
        if (index > 0) {
            const updatedLaws = [...laws];
            const temp = updatedLaws[index];
            updatedLaws[index] = updatedLaws[index - 1];
            updatedLaws[index - 1] = temp;
            setLaws(updatedLaws);
        }
    };

    const handleMoveDown = (index: number) => {
        if (index < laws.length - 1) {
            const updatedLaws = [...laws];
            const temp = updatedLaws[index];
            updatedLaws[index] = updatedLaws[index + 1];
            updatedLaws[index + 1] = temp;
            setLaws(updatedLaws);
        }
    };
    const handleRemoveLaw = (id: number) => {
        setLaws(laws.filter((law) => law.id !== id));
    };
    const handleLawChange = (index: number, field: string, value: string) => {
        const updatedLaws = laws.map((law, i) =>
            i === index ? { ...law, [field]: value } : law
        );
        setLaws(updatedLaws);
    };
    const scrollToBottom = () => {
        // @ts-ignore
        targetRef.current?.scrollIntoView({ behavior: "smooth" });
    };

    const targetRef = useRef(null);

    return (
        <>
            <div className="flex gap-2 fixed bottom-0">
                <button
                    onClick={scrollToBottom}
                    className="relative bottom-5 left-0 bg-primary text-white p-3 rounded-full shadow-lg hover:bg-primary-dark transition"
                >
                    <FontAwesomeIcon icon={faArrowDown} />
                </button>
                <button
                    onClick={scrollToTop}
                    className="relative bottom-5 left-0 bg-primary text-white p-3 rounded-full shadow-lg hover:bg-primary-dark transition"
                >
                    <FontAwesomeIcon icon={faArrowUp} />
                </button>
            </div>
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
                                النظام
                            </h3>
                        </div>
                        <div className="p-6.5">
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <SelectGroup
                                        options={mainCategories}
                                        title="القسم الرئيسي"
                                        selectedOption={selectedMainCategory}
                                        setSelectedOption={
                                            setSelectedMainCategory
                                        }
                                    />
                                    {errors?.category_id && (
                                        <p className="text-red-600">
                                            {errors?.category_id}
                                        </p>
                                    )}
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <TextInput
                                        type="text"
                                        label="اسم المحتوى القانوني"
                                        value={name}
                                        setValue={setName}
                                        error={errors?.name_ar}
                                        required={true}
                                    />
                                </div>
                                <div className="w-full xl:w-1/2">
                                    <TextInput
                                        type="text"
                                        label="اسم المحتوى القانوني بالأنجليزية"
                                        value={nameEn}
                                        setValue={setNameEn}
                                        error={errors?.name_en}
                                    />
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-[#bababa] dark:text-white">
                                        اداة اصدار المحتوى القانوني
                                    </label>
                                    <textarea
                                        placeholder="اداة اصدار المحتوى القانوني"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={releaseTool}
                                        onChange={(e) =>
                                            setReleaseTool(e.target.value)
                                        }
                                    />
                                    {errors?.release_tool && (
                                        <p className="text-red-600">
                                            {errors?.release_tool_ar}
                                        </p>
                                    )}
                                </div>
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-[#bababa] dark:text-white">
                                        اداة اصدار المحتوى القانوني بالأنجليزية
                                    </label>
                                    <textarea
                                        placeholder="اداة اصدار المحتوى القانوني بالأنجليزية"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={releaseToolEn}
                                        onChange={(e) =>
                                            setReleaseToolEn(e.target.value)
                                        }
                                    />
                                    {errors?.release_tool_en && (
                                        <p className="text-red-600">
                                            {errors?.release_tool_en}
                                        </p>
                                    )}
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-[#bababa] dark:text-white">
                                        نبذة عن المحتوى القانوني
                                    </label>
                                    <textarea
                                        placeholder="نبذة عن المحتوى القانوني"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={about}
                                        onChange={(e) =>
                                            setAbout(e.target.value)
                                        }
                                    />
                                    {errors?.about_ar && (
                                        <p className="text-red-600">
                                            {errors?.about_ar}
                                        </p>
                                    )}
                                </div>
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-[#bababa] dark:text-white">
                                        نبذة عم المحتوى القانوني بالأنجليزية
                                    </label>
                                    <textarea
                                        placeholder="نبذة عن النظام بالأنجليزية"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={aboutEn}
                                        onChange={(e) =>
                                            setAboutEn(e.target.value)
                                        }
                                    />
                                    {errors?.about_en && (
                                        <p className="text-red-600">
                                            {errors?.about_en}
                                        </p>
                                    )}
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <DatePicker
                                        title={"تاريخ الأصدار"}
                                        uniqueKey={"releasedAtDate"}
                                        selectedDate={releasedAt}
                                        setSelectedDate={setReleasedAt}
                                        error={errors.released_at}
                                    />
                                </div>
                                <div className="w-full xl:w-1/2">
                                    <DatePicker
                                        title="تاريخ النشر"
                                        uniqueKey="publishedAtDate"
                                        selectedDate={publishedAt}
                                        setSelectedDate={setPublishedAt}
                                        error={errors.published_at}
                                    />
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <TextInput
                                        type="text"
                                        label="تاريخ الأصدار الهجري"
                                        value={releasedAtHijri}
                                        disabled={true}
                                    />
                                </div>
                                <div className="w-full xl:w-1/2">
                                    <TextInput
                                        type="text"
                                        label="تاريخ النشر الهجري"
                                        value={publishedAtHijri}
                                        disabled={true}
                                    />
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <SelectGroup
                                        title="الحالة"
                                        options={[
                                            {
                                                id: 1,
                                                name: "ساري",
                                            },
                                            {
                                                id: 2,
                                                name: "غير ساري",
                                            },
                                        ]}
                                        selectedOption={status}
                                        setSelectedOption={setStatus}
                                    />
                                    {errors?.status && (
                                        <p className="text-red-600">
                                            {errors?.status}
                                        </p>
                                    )}
                                </div>
                                <div className="w-full xl:w-1/2">
                                    <TextInput
                                        type="number"
                                        label="عدد الابواب"
                                        value={numberOfChapters}
                                        setValue={setNumberOfChapters}
                                        error={errors?.number_of_chapters}
                                        required={true}
                                    />
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full flex flex-col gap-2 xl:w-1/4">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        PDF رفع الكتاب
                                    </label>
                                    <input
                                        type="file"
                                        accept=".pdf"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        onChange={(e) =>
                                            setPDF(e.target.files![0])
                                        }
                                    />
                                    {PDF != null && typeof PDF == "string" && (
                                        <a
                                            target="_blank"
                                            href={PDF}
                                            className="
                                            w-full text-center py-2 rounded border-[1.5px] border-stroke bg-transparent py px-3
                                        "
                                        >
                                            Open
                                        </a>
                                    )}
                                </div>
                                <div className="w-full flex flex-col gap-2 xl:w-1/4">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        PDF رفع الكتاب بالأنجليزية
                                    </label>
                                    <input
                                        type="file"
                                        accept=".pdf"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        onChange={(e) =>
                                            setPDFEn(e.target.files![0])
                                        }
                                    />
                                    {PDFEn != null &&
                                        typeof PDFEn == "string" && (
                                            <a
                                                target="_blank"
                                                href={PDFEn}
                                                className="
                                            w-full text-center py-2 rounded border-[1.5px] border-stroke bg-transparent py px-3
                                        "
                                            >
                                                Open
                                            </a>
                                        )}
                                </div>
                                <div className="w-full flex flex-col gap-2 xl:w-1/4">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        Word رفع الكتاب
                                    </label>
                                    <input
                                        type="file"
                                        accept=".doc,.docx"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        onChange={(e) =>
                                            setWord(e.target.files![0])
                                        }
                                    />
                                    {word != null &&
                                        typeof word == "string" && (
                                            <a
                                                target="_blank"
                                                href={word}
                                                className="
                                            w-full text-center py-2 rounded border-[1.5px] border-stroke bg-transparent py px-3
                                        "
                                            >
                                                Open
                                            </a>
                                        )}
                                </div>
                                <div className="w-full flex flex-col gap-2 xl:w-1/4">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        Word رفع الكتاب بالأنجليزية
                                    </label>
                                    <input
                                        type="file"
                                        accept=".doc,.docx"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        onChange={(e) =>
                                            setWordEn(e.target.files![0])
                                        }
                                    />
                                    {wordEn != null &&
                                        typeof wordEn == "string" && (
                                            <a
                                                target="_blank"
                                                href={wordEn}
                                                className="
                                            w-full text-center py-2 rounded border-[1.5px] border-stroke bg-transparent py px-3
                                        "
                                            >
                                                Open
                                            </a>
                                        )}
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-4">
                                <h4 className="font-medium mb-4 text-black dark:text-white">
                                    الفصول
                                </h4>
                                {laws.map((section, index) => (
                                    <div
                                        key={index}
                                        className="border border-solid flex border-black shadow-md px-2 py-4 rounded-md"
                                    >
                                        <div className="flex flex-col w-full">
                                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                                <div className="w-full xl:w-1/3">
                                                    <label className="mb-2.5 block text-black dark:text-white">
                                                        اسم الفصل
                                                    </label>
                                                    <input
                                                        type="text"
                                                        placeholder="اسم الفصل"
                                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                                        value={section.name_ar}
                                                        onChange={(e) =>
                                                            handleLawChange(
                                                                index,
                                                                "name_ar",
                                                                e.target.value
                                                            )
                                                        }
                                                    />
                                                    {errors[
                                                        `sections.${index}.name_ar`
                                                    ] && (
                                                        <p className="text-red-600">
                                                            {
                                                                errors[
                                                                    `sections.${index}.name_ar`
                                                                ]
                                                            }
                                                        </p>
                                                    )}
                                                </div>
                                                <div className="w-full xl:w-1/3">
                                                    <label className="mb-2.5 block text-black dark:text-white">
                                                        محتوى الفصل
                                                    </label>
                                                    <textarea
                                                        placeholder="محتوى الفصل"
                                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                                        value={
                                                            section.section_text_ar
                                                        }
                                                        onChange={(e) =>
                                                            handleLawChange(
                                                                index,
                                                                "section_text_ar",
                                                                e.target.value
                                                            )
                                                        }
                                                    />
                                                    {errors[
                                                        `sections.${index}.section_text_ar`
                                                    ] && (
                                                        <p className="text-red-600">
                                                            {
                                                                errors[
                                                                    `sections.${index}.section_text_ar`
                                                                ]
                                                            }
                                                        </p>
                                                    )}
                                                </div>
                                                <div className="w-full xl:w-1/3">
                                                    <label className="mb-2.5 block text-black dark:text-white">
                                                        التغييرات
                                                    </label>
                                                    <textarea
                                                        placeholder="التغييرات"
                                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                                        value={
                                                            section.changes_ar
                                                        }
                                                        onChange={(e) =>
                                                            handleLawChange(
                                                                index,
                                                                "changes_ar",
                                                                e.target.value
                                                            )
                                                        }
                                                    />
                                                </div>
                                            </div>
                                            <div
                                                key={section.id}
                                                className="mb-4.5 flex flex-col gap-6 xl:flex-row"
                                            >
                                                <div className="w-full xl:w-1/3">
                                                    <label className="mb-2.5 block text-black dark:text-white">
                                                        اسم الفصل بالأنجليزية
                                                    </label>
                                                    <input
                                                        type="text"
                                                        placeholder="اسم الفصل بالأنجليزية"
                                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                                        value={section.name_en}
                                                        onChange={(e) =>
                                                            handleLawChange(
                                                                index,
                                                                "name_en",
                                                                e.target.value
                                                            )
                                                        }
                                                    />
                                                </div>
                                                <div className="w-full xl:w-1/3">
                                                    <label className="mb-2.5 block text-black dark:text-white">
                                                        محتوى الفصل بالأنجليزية
                                                    </label>
                                                    <textarea
                                                        placeholder="القانون بالأنجليزية"
                                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                                        value={
                                                            section.section_text_en
                                                        }
                                                        onChange={(e) =>
                                                            handleLawChange(
                                                                index,
                                                                "section_text_en",
                                                                e.target.value
                                                            )
                                                        }
                                                    />
                                                </div>
                                                <div className="w-full xl:w-1/3">
                                                    <label className="mb-2.5 block text-black dark:text-white">
                                                        التغييرات بالأنجليزية
                                                    </label>
                                                    <textarea
                                                        placeholder="التغييرات بالأنجليزية"
                                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                                        value={
                                                            section.changes_en
                                                        }
                                                        onChange={(e) =>
                                                            handleLawChange(
                                                                index,
                                                                "changes_en",
                                                                e.target.value
                                                            )
                                                        }
                                                    />
                                                </div>
                                            </div>
                                            <div className="flex gap-4 mb-4">
                                                <button
                                                    onClick={() =>
                                                        handleMoveUp(index)
                                                    }
                                                    disabled={index === 0}
                                                    className={`rounded bg-[#ddb662] p-2 text-white font-medium hover:bg-opacity-90 ${
                                                        index === 0
                                                            ? "opacity-50 cursor-not-allowed"
                                                            : ""
                                                    }`}
                                                >
                                                    التحريك للأعلى
                                                </button>
                                                <button
                                                    onClick={() =>
                                                        handleMoveDown(index)
                                                    }
                                                    disabled={
                                                        index ===
                                                        laws.length - 1
                                                    }
                                                    className={`rounded bg-[#ddb662] p-2 text-white font-medium hover:bg-opacity-90 ${
                                                        index ===
                                                        laws.length - 1
                                                            ? "opacity-50 cursor-not-allowed"
                                                            : ""
                                                    }`}
                                                >
                                                    التحريك للأسفل
                                                </button>
                                            </div>
                                        </div>
                                        <div className="flex flex-col px-4">
                                            <button
                                                onClick={() =>
                                                    setDeleteModalOpen({
                                                        state: true,
                                                        id: section.id,
                                                    })
                                                }
                                                className="w-16 h-16 self-center mt-4 rounded bg-danger p-3 font-medium text-white hover:bg-opacity-90"
                                            >
                                                <FontAwesomeIcon
                                                    icon={faTrash}
                                                />
                                            </button>
                                            <button
                                                onClick={() =>
                                                    handleAddLaw(index + 1)
                                                }
                                                className="w-16 h-16 self-center mt-4 rounded bg-[#ddb662] p-3 font-medium text-white hover:bg-opacity-90"
                                            >
                                                <FontAwesomeIcon
                                                    icon={faPlus}
                                                />
                                            </button>
                                        </div>
                                    </div>
                                ))}
                                <button
                                    onClick={() => handleAddLaw(laws.length)}
                                    className="mt-4 rounded bg-[#ddb662] p-3 font-medium text-white hover:bg-opacity-90"
                                >
                                    إضافة فصل جديد
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="flex gap-6" ref={targetRef}>
                    <SaveButton
                        saveData={() => {
                            scrollToTop();
                            saveData();
                        }}
                    />
                    <BackButton path={"/newAdmin/settings/book-guide/sub"} />
                </div>
            </div>
        </>
    );
}

export default BookGuideForm;
