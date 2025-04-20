import React, { useEffect, useRef, useState } from "react";

import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import BaseSettingsForm from "../../../../../components/Forms/Settings/AdvisoryServices/BaseSettingsForm";
import PaymentCategoriesSettingsForm from "../../../../../components/Forms/Settings/AdvisoryServices/PaymentCategoriesSettingsForm";
import SubSettingsForm from "../../../../../components/Forms/Settings/JudicialGuide/SubSettingsForm";
import LawGuideForm from "../../../../../components/Forms/Settings/LawGuideForm";
import HijriDate, { toHijri } from "hijri-date/lib/safe";
import BookGuideForm from "../../../../../components/Forms/Settings/BookGuideForm";

function BaseSettingsCreate({ mainCategories }) {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState("");
    const [selectedMainCategory, setSelectedMainCategory] = useState("");
    const [laws, setLaws] = useState([]);
    const [nameEn, setNameEn] = useState("");
    const [PDF, setPDF] = useState<Blob | null>(null);
    const [PDFEn, setPDFEn] = useState<Blob | null>(null);
    const [word, setWord] = useState<Blob | null>(null);
    const [wordEn, setWordEn] = useState<Blob | null>(null);
    const [about, setAbout] = useState("");
    const [aboutEn, setAboutEn] = useState("");
    const [releaseTool, setReleaseTool] = useState("");
    const [releaseToolEn, setReleaseToolEn] = useState("");
    const [numberOfChapters, setNumberOfChapters] = useState(0);
    const [status, setStatus] = useState("");
    const [releasedAt, setReleasedAt] = useState("");
    const [publishedAt, setPublishedAt] = useState("");
    const [releasedAtHijri, setReleasedAtHijri] = useState("");
    const [publishedAtHijri, setPublishedAtHijri] = useState("");
    const [deleteModalOpen, setDeleteModalOpen] = useState({
        state: false,
        id: null,
    });
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
    const [progress, setProgress] = useState(0);
    const scrollToTop = () => {
        // @ts-ignore
        const element = contentRef.current;
        if (element) {
            element.scrollTo({ top: 0, behavior: "smooth" });
        }
    };
    const contentRef = useRef<HTMLDivElement>(null);
    async function saveData() {
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
                "/newAdmin/settings/book-guide/sub/create",
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
                toast.success("تم انشاء الملف بنجاح");
                router.get(
                    `/newAdmin/settings/book-guide/sub/${res.data.item.id}`
                );
            }
        } catch (err) {
            setErrors(err.response.data.errors);
        }
    }
    return (
        <DefaultLayout ref={contentRef}>
            <Breadcrumb pageName="اضافة محتوى" />
            <BookGuideForm
                errors={errors}
                saveData={saveData}
                name={name}
                setName={setName}
                mainCategories={mainCategories}
                selectedMainCategory={selectedMainCategory}
                setSelectedMainCategory={setSelectedMainCategory}
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
    );
}

export default BaseSettingsCreate;
