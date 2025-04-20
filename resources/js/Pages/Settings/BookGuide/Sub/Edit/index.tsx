import React, { useEffect, useRef, useState } from "react";
import ServicesCategoriesSettingsForm from "../../../../../components/Forms/Settings/Services/Categories/ServicesCategoriesSettingsForm";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import BaseSettingsForm from "../../../../../components/Forms/Settings/AdvisoryServices/BaseSettingsForm";
import PaymentCategoriesSettingsForm from "../../../../../components/Forms/Settings/AdvisoryServices/PaymentCategoriesSettingsForm";
import SubSettingsForm from "../../../../../components/Forms/Settings/JudicialGuide/SubSettingsForm";
import SuccessNotification from "../../../../../components/SuccessNotification";
import ErrorNotification from "../../../../../components/ErrorNotification";
import LawGuideForm from "../../../../../components/Forms/Settings/LawGuideForm";
import HijriDate, { toHijri } from "hijri-date/lib/safe";
import DeleteModal from "../../../../../components/Modals/DeleteModal";
import BookGuideForm from "../../../../../components/Forms/Settings/BookGuideForm";

function SubSettingsEdit({ mainCategories, subCategory }) {
    const [deleteModalOpen, setDeleteModalOpen] = useState({
        state: false,
        id: null,
    });
    const [errors, setErrors] = useState({});
    const [name, setName] = useState(subCategory?.name_ar || "");
    const [selectedMainCategory, setSelectedMainCategory] = useState(
        subCategory?.category_id || ""
    );
    const [laws, setLaws] = useState(subCategory.sections || []);
    const contentRef = useRef<HTMLDivElement>(null);
    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);
    const [nameEn, setNameEn] = useState(subCategory.name_en || "");
    const [progress, setProgress] = useState(0);

    const [PDF, setPDF] = useState<Blob | string | null>(
        subCategory.pdf_file_ar || null
    );
    const [PDFEn, setPDFEn] = useState<Blob | string | null>(
        subCategory.pdf_file_en || null
    );
    const [word, setWord] = useState<Blob | string | null>(
        subCategory.word_file_ar || null
    );
    const [wordEn, setWordEn] = useState<Blob | string | null>(
        subCategory.word_file_ar || null
    );
    const [about, setAbout] = useState(subCategory.about_ar || "");
    const [aboutEn, setAboutEn] = useState(subCategory.about_en || "");
    const [releaseTool, setReleaseTool] = useState(
        subCategory.release_tool_ar || ""
    );
    const [releaseToolEn, setReleaseToolEn] = useState(
        subCategory.release_tool_en || ""
    );
    const [numberOfChapters, setNumberOfChapters] = useState(
        subCategory.number_of_chapters || 0
    );
    const [status, setStatus] = useState(subCategory.status || "");
    const [releasedAt, setReleasedAt] = useState(subCategory.released_at || "");
    const [publishedAt, setPublishedAt] = useState(
        subCategory.published_at || ""
    );
    const [releasedAtHijri, setReleasedAtHijri] = useState("");
    const [publishedAtHijri, setPublishedAtHijri] = useState("");
    useEffect(() => {
        if (releasedAt != "") {
            const date = new Date(releasedAt);
            const hijriDate = toHijri(date);

            setReleasedAtHijri(
                `${hijriDate.year}-${hijriDate.month}-${hijriDate.date}`
            );
        }
        if (publishedAt != "") {
            const date = new Date(publishedAt);
            const hijriDate = toHijri(date);
            setPublishedAtHijri(
                `${hijriDate.year}-${hijriDate.month}-${hijriDate.date}`
            );
        }
    }, [releasedAt, publishedAt]);
    async function saveData() {
        setIsSuccess(false);
        setIsError(false);
        const data = new FormData();
        data.append("name_ar", name);
        data.append("name_en", nameEn);
        data.append("category_id", selectedMainCategory);
        // data.append("laws", JSON.stringify(laws));
        laws.forEach((law: any, index) => {
            data.append(`sections[${index}][name_ar]`, law.name);
            data.append(`sections[${index}][name_en]`, law.name_en || "");
            data.append(`sections[${index}][section_text_ar]`, law.law);
            data.append(
                `sections[${index}][section_text_en]`,
                law.law_en || ""
            );
            data.append(`sections[${index}][changes_ar]`, law.changes || "");
            data.append(`sections[${index}][changes_en]`, law.changes_en || "");
        });
        data.append("about_ar", about);
        data.append("about_en", aboutEn);
        data.append("release_tool_ar", releaseTool);
        data.append("release_tool_en", releaseToolEn);
        data.append("number_of_chapters", numberOfChapters.toString());
        data.append("status", status);
        data.append("published_at", publishedAt);
        data.append("released_at", releasedAt);
        if (PDF != null) {
            data.append("pdf", PDF);
        }
        if (PDFEn != null) {
            data.append("pdf_en", PDFEn);
        }
        if (word != null) {
            data.append("word", word);
        }
        if (wordEn != null) {
            data.append("word_en", wordEn);
        }

        try {
            const res = await axios.post(
                `/newAdmin/settings/book-guide/sub/${subCategory.id}`,
                data,
                {
                    onUploadProgress: (event) => {
                        const percent = Math.floor(
                            (event.loaded * 100) / event.total!
                        );
                        setProgress(percent);
                    },
                }
            );
            if (res.status == 200) {
                setIsSuccess(true);
                setName(res.data.item.name);
                setNameEn(res.data.item.name_en);
                setSelectedMainCategory(res.data.item.category_id);
                setLaws(res.data.item.laws);
                setAbout(res.data.item.about);
                setAboutEn(res.data.item.about_en);
                setReleaseTool(res.data.item.release_tool);
                setReleaseToolEn(res.data.item.release_tool_en);
                setNumberOfChapters(res.data.item.number_of_chapters);
                setStatus(res.data.item.status);
                setPublishedAt(res.data.item.published_at);
                setReleasedAt(res.data.item.released_at);
                setPDF(res.data.item.pdf);
                setPDFEn(res.data.item.pdf_en);
                setWord(res.data.item.word);
                setWordEn(res.data.item.word_en);
                contentRef.current?.scrollIntoView({ behavior: "smooth" });
            }
        } catch (err) {
            setErrors(err.response.data.errors);
            setIsError(true);
            contentRef.current?.scrollIntoView({ behavior: "smooth" });
        }
    }
    const scrollToTop = () => {
        // @ts-ignore
        const element = contentRef.current;
        if (element) {
            const yOffset = -200; // Negative value for 200px offset
            const yPosition =
                element.scrollTop +
                element.getBoundingClientRect().top -
                element.offsetTop +
                yOffset;

            element.scrollTo({ top: 0, behavior: "smooth" });
        }
    };
    return (
        <>
            <DeleteModal
                isOpen={deleteModalOpen.state}
                setIsOpen={setDeleteModalOpen}
                confirmAction={() => {
                    setLaws(
                        laws.filter((law) => law.id !== deleteModalOpen.id)
                    );
                    setDeleteModalOpen({ state: false, id: null });
                }}
                confirmationText={"هل تريد حذف الفصل؟"}
            />
            <DefaultLayout ref={contentRef}>
                <Breadcrumb pageName="تعديل محتوى" />
                {isSuccess && <SuccessNotification classNames="my-2" />}
                {isError && <ErrorNotification classNames="my-2" />}
                <BookGuideForm
                    errors={errors}
                    saveData={saveData}
                    name={name}
                    setName={setName}
                    selectedMainCategory={selectedMainCategory}
                    setSelectedMainCategory={setSelectedMainCategory}
                    mainCategories={mainCategories}
                    laws={laws}
                    setLaws={setLaws}
                    nameEn={nameEn}
                    setNameEn={setNameEn}
                    PDF={PDF}
                    setPDF={setPDF}
                    PDFEn={PDFEn}
                    setPDFEn={setPDFEn}
                    word={word}
                    setWord={setWord}
                    wordEn={wordEn}
                    setWordEn={setWordEn}
                    status={status}
                    setStatus={setStatus}
                    about={about}
                    aboutEn={aboutEn}
                    setAbout={setAbout}
                    setAboutEn={setAboutEn}
                    releaseTool={releaseTool}
                    setReleaseTool={setReleaseTool}
                    releaseToolEn={releaseToolEn}
                    setReleaseToolEn={setReleaseToolEn}
                    numberOfChapters={numberOfChapters}
                    setNumberOfChapters={setNumberOfChapters}
                    releasedAt={releasedAt}
                    setReleasedAt={setReleasedAt}
                    publishedAt={publishedAt}
                    setPublishedAt={setPublishedAt}
                    publishedAtHijri={publishedAtHijri}
                    releasedAtHijri={releasedAtHijri}
                    setDeleteModalOpen={setDeleteModalOpen}
                    progress={progress}
                    scrollToTop={scrollToTop}
                />
            </DefaultLayout>
        </>
    );
}

export default SubSettingsEdit;
