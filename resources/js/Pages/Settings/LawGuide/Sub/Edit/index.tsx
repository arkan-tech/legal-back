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

function SubSettingsEdit({
    mainCategories,
    subCategory,
    allLaws,
    allLawGuides,
}) {
    const [deleteModalOpen, setDeleteModalOpen] = useState({
        state: false,
        id: null,
    });
    const [errors, setErrors] = useState({});
    const [name, setName] = useState(subCategory?.name || "");
    const [selectedMainCategory, setSelectedMainCategory] = useState(
        subCategory?.category_id || ""
    );
    const [laws, setLaws] = useState<any[]>(subCategory.laws || []);
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
    const [about, setAbout] = useState(subCategory.about || "");
    const [aboutEn, setAboutEn] = useState(subCategory.about_en || "");
    const [releaseTool, setReleaseTool] = useState(
        subCategory.release_tool || ""
    );
    const [releaseToolEn, setReleaseToolEn] = useState(
        subCategory.release_tool_en || ""
    );
    const [numberOfChapters, setNumberOfChapters] = useState<string>(
        (subCategory.number_of_chapters || "0").toString()
    );
    const [status, setStatus] = useState(subCategory.status || "");
    const [releasedAt, setReleasedAt] = useState(subCategory.released_at || "");
    const [publishedAt, setPublishedAt] = useState(
        subCategory.published_at || ""
    );
    const [releasedAtHijri, setReleasedAtHijri] = useState("");
    const [publishedAtHijri, setPublishedAtHijri] = useState("");

    const [linkModalOpen, setLinkModalOpen] = useState(false);
    const [linkLawModalOpen, setLinkLawModalOpen] = useState(false);
    const [selectedRelatedGuides, setSelectedRelatedGuides] = useState<any[]>(
        subCategory.related_guides || []
    );
    const [selectedRelatedLaws, setSelectedRelatedLaws] = useState<any[]>(
        subCategory.related_laws || []
    );

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

    const handleSaveRelatedGuides = async (selectedGuides) => {
        try {
            const response = await axios.post(
                `/api/law-guide/${subCategory.id}/related-guides`,
                {
                    guides: selectedGuides.map((guide) => guide.id),
                }
            );
            setSelectedRelatedGuides(selectedGuides);
            toast.success("تم حفظ الأدلة القانونية ذات الصلة بنجاح");
        } catch (error) {
            toast.error("حدث خطأ أثناء حفظ الأدلة القانونية ذات الصلة");
        }
    };

    const handleSaveRelatedLaws = async (selectedLaws) => {
        try {
            const response = await axios.post(
                `/api/law-guide/law/${subCategory.id}/related-laws`,
                {
                    laws: selectedLaws.map((law) => law.id),
                }
            );
            setSelectedRelatedLaws(selectedLaws);
            toast.success("تم حفظ القوانين ذات الصلة بنجاح");
        } catch (error) {
            toast.error("حدث خطأ أثناء حفظ القوانين ذات الصلة");
        }
    };

    async function saveData() {
        setIsSuccess(false);
        setIsError(false);
        const data = new FormData();
        data.append("name", name);
        data.append("name_en", nameEn);
        data.append("mainCategoryId", selectedMainCategory);
        laws.forEach((law: any, index) => {
            data.append(`laws[${index}][name]`, law.name);
            data.append(`laws[${index}][name_en]`, law.name_en || "");
            data.append(`laws[${index}][law]`, law.law);
            data.append(`laws[${index}][law_en]`, law.law_en || "");
            data.append(`laws[${index}][changes]`, law.changes || "");
            data.append(`laws[${index}][changes_en]`, law.changes_en || "");
        });
        data.append("about", about);
        data.append("about_en", aboutEn);
        data.append("release_tool", releaseTool);
        data.append("release_tool_en", releaseToolEn);
        data.append("number_of_chapters", numberOfChapters);
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
                `/newAdmin/settings/law-guide/sub/${subCategory.id}`,
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
                setNumberOfChapters(
                    res.data.item.number_of_chapters.toString()
                );
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
        const element = contentRef.current;
        if (element) {
            const yOffset = -200;
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
                confirmationText={"هل تريد حذف المادة؟"}
            />
            <DefaultLayout ref={contentRef}>
                <Breadcrumb pageName="تعديل قسم فرعي" />
                {isSuccess && <SuccessNotification classNames="my-2" />}
                {isError && <ErrorNotification classNames="my-2" />}
                <LawGuideForm
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
                    law={subCategory}
                    lawGuide={subCategory}
                    setLinkModalOpen={setLinkModalOpen}
                    setLinkLawModalOpen={setLinkLawModalOpen}
                    selectedRelatedGuides={selectedRelatedGuides}
                    selectedRelatedLaws={selectedRelatedLaws}
                    allLaws={allLaws}
                    allLawGuides={allLawGuides}
                    handleSaveRelatedLaws={handleSaveRelatedLaws}
                    handleSaveRelatedGuides={handleSaveRelatedGuides}
                    linkModalOpen={linkModalOpen}
                    linkLawModalOpen={linkLawModalOpen}
                />
            </DefaultLayout>
        </>
    );
}

export default SubSettingsEdit;
