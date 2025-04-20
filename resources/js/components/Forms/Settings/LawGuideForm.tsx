import { router } from "@inertiajs/react";
import React, { useEffect, useRef, useState } from "react";
import SelectGroup from "../SelectGroup/SelectGroup";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import {
    faArrowDown,
    faArrowUp,
    faPlus,
    faTrash,
    faLink,
} from "@fortawesome/free-solid-svg-icons";
import TextInput from "../../TextInput";
import DatePicker from "../DatePicker/DatePicker";
import SaveButton from "../../SaveButton";
import BackButton from "../../BackButton";

interface LinkModalProps {
    isOpen: boolean;
    onClose: () => void;
    title: string;
    items: any[];
    selectedItems: any[];
    onSelect: (items: any[]) => void;
    isLawModal?: boolean;
    lawGuides?: any[];
    mainCategories: any[];
}

const LinkModal: React.FC<LinkModalProps> = ({
    isOpen,
    onClose,
    title,
    items,
    selectedItems,
    onSelect,
    isLawModal = false,
    lawGuides = [],
    mainCategories = [],
}) => {
    console.log("LinkModal Props:", {
        items,
        selectedItems,
        mainCategories,
        lawGuides,
    });

    const [searchTerm, setSearchTerm] = useState("");
    const [selected, setSelected] = useState<any[]>(selectedItems);
    const [selectedMainCategory, setSelectedMainCategory] =
        useState<string>("");
    const [showAddForm, setShowAddForm] = useState(false);

    useEffect(() => {
        setSelected(selectedItems);
    }, [selectedItems]);

    useEffect(() => {
        console.log("Items received:", items);
        console.log("Sample item:", items?.[0]);
        console.log("Main Categories received:", mainCategories);
    }, [items, mainCategories]);

    const handleRemoveItem = (itemToRemove: any) => {
        setSelected((prev) =>
            prev.filter((item) => item.id !== itemToRemove.id)
        );
    };

    const handleSave = () => {
        onSelect(selected);
        onClose();
    };

    const filteredItems = React.useMemo(() => {
        console.log("Filtering with:", {
            selectedMainCategory,
            searchTerm,
            itemsCount: items?.length || 0,
            items: items,
        });

        if (!items || items.length === 0) {
            console.log("No items to filter");
            return [];
        }

        return items.filter((item) => {
            console.log("Checking item:", item);

            const nameMatch =
                item.name?.toLowerCase().includes(searchTerm.toLowerCase()) ||
                (item.name_en &&
                    item.name_en
                        .toLowerCase()
                        .includes(searchTerm.toLowerCase()));

            if (!selectedMainCategory) {
                console.log(
                    "No main category selected, returning based on name match:",
                    nameMatch
                );
                return nameMatch;
            }

            const categoryMatch =
                item.category_id?.toString() ===
                selectedMainCategory.toString();
            console.log("Category match:", {
                itemCategoryId: item.category_id,
                selectedCategory: selectedMainCategory,
                matches: categoryMatch,
            });

            return nameMatch && categoryMatch;
        });
    }, [items, searchTerm, selectedMainCategory]);

    if (!isOpen) return null;

    return (
        <div
            className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            style={{ direction: "rtl" }}
        >
            <div className="bg-white rounded-lg p-6 w-full max-w-4xl max-h-[80vh] overflow-y-auto">
                <h2 className="text-xl font-bold mb-4">{title}</h2>

                {/* Current Relations Table */}
                {selected.length > 0 && (
                    <div className="mb-6">
                        <h3 className="font-medium mb-2">العلاقات الحالية:</h3>
                        <div className="overflow-x-auto">
                            <table className="min-w-full bg-white border border-gray-300">
                                <thead>
                                    <tr className="bg-gray-100">
                                        <th className="py-2 px-4 border-b text-right">
                                            القسم الرئيسي
                                        </th>
                                        <th className="py-2 px-4 border-b text-right">
                                            القسم الفرعي
                                        </th>
                                        <th className="py-2 px-4 border-b text-center">
                                            إجراءات
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {selected.map((item) => (
                                        <tr
                                            key={item.id}
                                            className="hover:bg-gray-50"
                                        >
                                            <td className="py-2 px-4 border-b">
                                                {item.main_category?.name}
                                            </td>
                                            <td className="py-2 px-4 border-b">
                                                {item.name}
                                            </td>
                                            <td className="py-2 px-4 border-b text-center">
                                                <button
                                                    onClick={() =>
                                                        handleRemoveItem(item)
                                                    }
                                                    className="text-red-600 hover:text-red-800"
                                                >
                                                    <FontAwesomeIcon
                                                        icon={faTrash}
                                                    />
                                                </button>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                )}

                {/* Add New Relation Form */}
                <div className="mb-6">
                    <button
                        onClick={() => setShowAddForm(!showAddForm)}
                        className="mb-4 px-4 py-2 bg-primary text-white rounded hover:bg-primary-dark flex items-center gap-2"
                    >
                        <FontAwesomeIcon icon={faPlus} />
                        إضافة علاقة جديدة
                    </button>

                    {showAddForm && (
                        <div className="p-4 border rounded-md">
                            <div className="flex gap-4 mb-4">
                                <div className="flex-1">
                                    <label className="block mb-2">
                                        القسم الرئيسي
                                    </label>
                                    <select
                                        className="w-full p-2 border rounded"
                                        value={selectedMainCategory}
                                        onChange={(e) =>
                                            setSelectedMainCategory(
                                                e.target.value
                                            )
                                        }
                                    >
                                        <option value="">
                                            اختر القسم الرئيسي
                                        </option>
                                        {mainCategories.map((category) => (
                                            <option
                                                key={category.id}
                                                value={category.id}
                                            >
                                                {category.name}
                                            </option>
                                        ))}
                                    </select>
                                </div>
                                <div className="flex-1">
                                    <label className="block mb-2">
                                        بحث في الأقسام الفرعية
                                    </label>
                                    <input
                                        type="text"
                                        placeholder="ابحث..."
                                        className="w-full p-2 border rounded"
                                        value={searchTerm}
                                        onChange={(e) =>
                                            setSearchTerm(e.target.value)
                                        }
                                    />
                                </div>
                            </div>

                            <div className="max-h-60 overflow-y-auto border rounded">
                                <table className="min-w-full bg-white">
                                    <thead className="bg-gray-50 sticky top-0">
                                        <tr>
                                            <th className="py-2 px-4 text-right">
                                                القسم الرئيسي
                                            </th>
                                            <th className="py-2 px-4 text-right">
                                                القسم الفرعي
                                            </th>
                                            <th className="py-2 px-4 text-center">
                                                اختيار
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {filteredItems.map((item) => {
                                            const isSelected = selected.some(
                                                (s) => s.id === item.id
                                            );
                                            return (
                                                <tr
                                                    key={item.id}
                                                    className="hover:bg-gray-50"
                                                >
                                                    <td className="py-2 px-4 border-b">
                                                        {
                                                            item.main_category
                                                                ?.name
                                                        }
                                                    </td>
                                                    <td className="py-2 px-4 border-b">
                                                        {item.name}
                                                    </td>
                                                    <td className="py-2 px-4 border-b text-center">
                                                        <input
                                                            type="checkbox"
                                                            checked={isSelected}
                                                            onChange={() => {
                                                                if (
                                                                    isSelected
                                                                ) {
                                                                    handleRemoveItem(
                                                                        item
                                                                    );
                                                                } else {
                                                                    setSelected(
                                                                        (
                                                                            prev
                                                                        ) => [
                                                                            ...prev,
                                                                            item,
                                                                        ]
                                                                    );
                                                                }
                                                            }}
                                                            className="form-checkbox h-5 w-5 text-primary"
                                                        />
                                                    </td>
                                                </tr>
                                            );
                                        })}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    )}
                </div>

                <div className="flex justify-start gap-2">
                    <button
                        onClick={handleSave}
                        className="px-4 py-2 bg-primary text-white rounded hover:bg-primary-dark"
                    >
                        حفظ
                    </button>
                    <button
                        onClick={onClose}
                        className="px-4 py-2 border rounded hover:bg-gray-100"
                    >
                        إلغاء
                    </button>
                </div>
            </div>
        </div>
    );
};

interface LawGuideFormProps {
    saveData: () => void;
    errors: any;
    mainCategories: any[];
    name: string;
    setName: (name: string) => void;
    nameEn: string;
    setNameEn: (nameEn: string) => void;
    selectedMainCategory: string;
    setSelectedMainCategory: (category: string) => void;
    laws: any[];
    setLaws: (laws: any[]) => void;
    PDF: any;
    setPDF: (pdf: any) => void;
    PDFEn: any;
    setPDFEn: (pdfEn: any) => void;
    word: any;
    setWord: (word: any) => void;
    wordEn: any;
    setWordEn: (wordEn: any) => void;
    status: string;
    setStatus: (status: string) => void;
    about: string;
    aboutEn: string;
    setAbout: (about: string) => void;
    setAboutEn: (aboutEn: string) => void;
    releaseTool: string;
    setReleaseTool: (tool: string) => void;
    releaseToolEn: string;
    setReleaseToolEn: (toolEn: string) => void;
    numberOfChapters: string;
    setNumberOfChapters: (num: string) => void;
    releasedAt: string;
    setReleasedAt: (date: string) => void;
    publishedAt: string;
    setPublishedAt: (date: string) => void;
    releasedAtHijri: string;
    publishedAtHijri: string;
    setDeleteModalOpen: (state: { state: boolean; id: any }) => void;
    progress: number;
    scrollToTop: () => void;
    law: any;
    lawGuide: any;
    setLinkModalOpen: (state: boolean) => void;
    setLinkLawModalOpen: (state: boolean) => void;
    selectedRelatedLaws: any[];
    selectedRelatedGuides: any[];
    allLaws: any[];
    allLawGuides: any[];
    handleSaveRelatedLaws: (laws: any[], currentLaw?: any) => void;
    linkModalOpen: boolean;
    linkLawModalOpen: boolean;
}

const LawGuideForm: React.FC<LawGuideFormProps> = ({
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
    law,
    lawGuide,
    setLinkModalOpen,
    setLinkLawModalOpen,
    selectedRelatedLaws,
    selectedRelatedGuides,
    allLaws,
    allLawGuides,
    handleSaveRelatedLaws,
    linkModalOpen,
    linkLawModalOpen,
}) => {
    const [currentLaw, setCurrentLaw] = useState<any>(null);

    const handleAddLaw = (index: number) => {
        const newLaw = {
            id: Date.now(),
            name: "",
            law: "",
            changes: "",
            name_en: "",
            law_en: "",
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
                                معلومات النظام
                            </h3>
                        </div>
                        <div className="p-6.5">
                            <div className="mb-4.5">
                                <div className="w-full mb-4">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        القسم الرئيسي
                                    </label>
                                    <div className="relative z-20 bg-transparent dark:bg-form-input">
                                        <select
                                            value={selectedMainCategory}
                                            onChange={(e) =>
                                                setSelectedMainCategory(
                                                    e.target.value
                                                )
                                            }
                                            className={`relative z-20 w-full appearance-none rounded border ${
                                                errors.mainCategoryId
                                                    ? "border-danger"
                                                    : "border-stroke"
                                            } py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary`}
                                        >
                                            <option value="">
                                                اختر القسم الرئيسي
                                            </option>
                                            {mainCategories.map((category) => (
                                                <option
                                                    key={category.id}
                                                    value={category.id}
                                                >
                                                    {category.name}
                                                </option>
                                            ))}
                                        </select>
                                        {errors.mainCategoryId && (
                                            <span className="text-danger">
                                                {errors.mainCategoryId}
                                            </span>
                                        )}
                                    </div>
                                </div>
                                <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                    <div className="w-full xl:w-1/2">
                                        <TextInput
                                            type="text"
                                            label="اسم النظام"
                                            value={name}
                                            setValue={setName}
                                            error={errors?.name}
                                            required={true}
                                        />
                                    </div>
                                    <div className="w-full xl:w-1/2">
                                        <TextInput
                                            type="text"
                                            label="اسم النظام بالأنجليزية"
                                            value={nameEn}
                                            setValue={setNameEn}
                                            error={errors?.nameEn}
                                        />
                                    </div>
                                </div>
                                <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                    <div className="w-full xl:w-1/2">
                                        <label className="mb-2.5 block text-[#bababa] dark:text-white">
                                            اداة اصدار النظام
                                        </label>
                                        <textarea
                                            placeholder="اداة اصدار النظام"
                                            className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                            value={releaseTool}
                                            onChange={(e) =>
                                                setReleaseTool(e.target.value)
                                            }
                                        />
                                        {errors?.release_tool && (
                                            <p className="text-red-600">
                                                {errors?.release_tool}
                                            </p>
                                        )}
                                    </div>
                                    <div className="w-full xl:w-1/2">
                                        <label className="mb-2.5 block text-[#bababa] dark:text-white">
                                            اداة اصدار النظام بالأنجليزية
                                        </label>
                                        <textarea
                                            placeholder="اداة اصدار النظام بالأنجليزية"
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
                                            نبذة عن النظام
                                        </label>
                                        <textarea
                                            placeholder="نبذة عن النظام"
                                            className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                            value={about}
                                            onChange={(e) =>
                                                setAbout(e.target.value)
                                            }
                                        />
                                        {errors?.about && (
                                            <p className="text-red-600">
                                                {errors?.about}
                                            </p>
                                        )}
                                    </div>
                                    <div className="w-full xl:w-1/2">
                                        <label className="mb-2.5 block text-[#bababa] dark:text-white">
                                            نبذة عم النظام بالأنجليزية
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
                                            PDF رفع القانون
                                        </label>
                                        <input
                                            type="file"
                                            accept=".pdf"
                                            className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                            onChange={(e) =>
                                                setPDF(e.target.files![0])
                                            }
                                        />
                                        {PDF != null &&
                                            typeof PDF == "string" && (
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
                                            PDF رفع القانون بالأنجليزية
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
                                            Word رفع القانون
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
                                            Word رفع القانون بالأنجليزية
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
                                <div className="mb-4.5">
                                    <div className="flex justify-between items-center mb-4">
                                        <h4 className="font-medium text-black dark:text-white">
                                            العلاقات
                                        </h4>
                                        <button
                                            onClick={() =>
                                                setLinkModalOpen(true)
                                            }
                                            className="px-4 py-2 bg-primary text-white rounded hover:bg-primary-dark flex items-center gap-2"
                                        >
                                            <FontAwesomeIcon icon={faLink} />
                                            ربط مع أدلة قانونية أخرى
                                        </button>
                                    </div>

                                    {selectedRelatedGuides.length > 0 && (
                                        <div className="mb-4 p-4 border rounded-md">
                                            <h5 className="font-medium mb-2">
                                                الأدلة القانونية المرتبطة:
                                            </h5>
                                            <div className="flex flex-wrap gap-2">
                                                {selectedRelatedGuides.map(
                                                    (guide) => (
                                                        <span
                                                            key={guide.id}
                                                            className="px-3 py-1 bg-gray-100 rounded-full text-sm"
                                                        >
                                                            {guide.name}
                                                        </span>
                                                    )
                                                )}
                                            </div>
                                        </div>
                                    )}
                                </div>
                                <div className="mb-4.5 flex flex-col gap-4">
                                    <div className="flex justify-between items-center">
                                        <h4 className="font-medium mb-4 text-black dark:text-white">
                                            القوانين
                                        </h4>
                                    </div>

                                    {laws.map((law, index) => (
                                        <div
                                            key={index}
                                            className="border border-solid flex border-black shadow-md px-2 py-4 rounded-md"
                                        >
                                            <div className="flex flex-col w-full">
                                                <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                                    <div className="w-full xl:w-1/3">
                                                        <label className="mb-2.5 block text-black dark:text-white">
                                                            اسم القانون
                                                        </label>
                                                        <input
                                                            type="text"
                                                            placeholder="اسم القانون"
                                                            className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                                            value={law.name}
                                                            onChange={(e) =>
                                                                handleLawChange(
                                                                    index,
                                                                    "name",
                                                                    e.target
                                                                        .value
                                                                )
                                                            }
                                                        />
                                                        {errors[
                                                            `laws.${index}.name`
                                                        ] && (
                                                            <p className="text-red-600">
                                                                {
                                                                    errors[
                                                                        `laws.${index}.name`
                                                                    ]
                                                                }
                                                            </p>
                                                        )}
                                                    </div>
                                                    <div className="w-full xl:w-1/3">
                                                        <label className="mb-2.5 block text-black dark:text-white">
                                                            القانون
                                                        </label>
                                                        <textarea
                                                            placeholder="القانون"
                                                            className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                                            value={law.law}
                                                            onChange={(e) =>
                                                                handleLawChange(
                                                                    index,
                                                                    "law",
                                                                    e.target
                                                                        .value
                                                                )
                                                            }
                                                        />
                                                        {errors[
                                                            `laws.${index}.law`
                                                        ] && (
                                                            <p className="text-red-600">
                                                                {
                                                                    errors[
                                                                        `laws.${index}.law`
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
                                                            value={law.changes}
                                                            onChange={(e) =>
                                                                handleLawChange(
                                                                    index,
                                                                    "changes",
                                                                    e.target
                                                                        .value
                                                                )
                                                            }
                                                        />
                                                    </div>
                                                </div>
                                                <div
                                                    key={law.id}
                                                    className="mb-4.5 flex flex-col gap-6 xl:flex-row"
                                                >
                                                    <div className="w-full xl:w-1/3">
                                                        <label className="mb-2.5 block text-black dark:text-white">
                                                            اسم القانون
                                                            بالأنجليزية
                                                        </label>
                                                        <input
                                                            type="text"
                                                            placeholder="اسم القانون بالأنجليزية"
                                                            className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                                            value={law.name_en}
                                                            onChange={(e) =>
                                                                handleLawChange(
                                                                    index,
                                                                    "name_en",
                                                                    e.target
                                                                        .value
                                                                )
                                                            }
                                                        />
                                                    </div>
                                                    <div className="w-full xl:w-1/3">
                                                        <label className="mb-2.5 block text-black dark:text-white">
                                                            القانون بالأنجليزية
                                                        </label>
                                                        <textarea
                                                            placeholder="القانون بالأنجليزية"
                                                            className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                                            value={law.law_en}
                                                            onChange={(e) =>
                                                                handleLawChange(
                                                                    index,
                                                                    "law_en",
                                                                    e.target
                                                                        .value
                                                                )
                                                            }
                                                        />
                                                    </div>
                                                    <div className="w-full xl:w-1/3">
                                                        <label className="mb-2.5 block text-black dark:text-white">
                                                            التغييرات
                                                            بالأنجليزية
                                                        </label>
                                                        <textarea
                                                            placeholder="التغييرات بالأنجليزية"
                                                            className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                                            value={
                                                                law.changes_en
                                                            }
                                                            onChange={(e) =>
                                                                handleLawChange(
                                                                    index,
                                                                    "changes_en",
                                                                    e.target
                                                                        .value
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
                                                            handleMoveDown(
                                                                index
                                                            )
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
                                                <div className="mb-4 flex justify-end">
                                                    <button
                                                        onClick={() => {
                                                            setCurrentLaw(law);
                                                            setLinkLawModalOpen(
                                                                true
                                                            );
                                                        }}
                                                        className="px-4 py-2 bg-primary text-white rounded hover:bg-primary-dark flex items-center gap-2"
                                                    >
                                                        <FontAwesomeIcon
                                                            icon={faLink}
                                                        />
                                                        ربط مع قوانين أخرى
                                                    </button>
                                                </div>
                                                {law.related_laws &&
                                                    law.related_laws.length >
                                                        0 && (
                                                        <div className="mb-4 p-4 border rounded-md">
                                                            <h5 className="font-medium mb-2">
                                                                القوانين
                                                                المرتبطة:
                                                            </h5>
                                                            <div className="flex flex-wrap gap-2">
                                                                {law.related_laws.map(
                                                                    (
                                                                        relatedLaw
                                                                    ) => (
                                                                        <span
                                                                            key={
                                                                                relatedLaw.id
                                                                            }
                                                                            className="px-3 py-1 bg-gray-100 rounded-full text-sm"
                                                                        >
                                                                            {
                                                                                relatedLaw.name
                                                                            }
                                                                        </span>
                                                                    )
                                                                )}
                                                            </div>
                                                        </div>
                                                    )}
                                            </div>
                                            <div className="flex flex-col px-4">
                                                <button
                                                    onClick={() =>
                                                        setDeleteModalOpen({
                                                            state: true,
                                                            id: law.id,
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
                                        onClick={() =>
                                            handleAddLaw(laws.length)
                                        }
                                        className="mt-4 rounded bg-[#ddb662] p-3 font-medium text-white hover:bg-opacity-90"
                                    >
                                        إضافة قانون جديد
                                    </button>
                                </div>

                                {lawGuide && (
                                    <div className="mb-4.5">
                                        <button
                                            onClick={() =>
                                                setLinkModalOpen(true)
                                            }
                                            className="px-4 py-2 bg-primary text-white rounded hover:bg-primary-dark flex items-center gap-2"
                                        >
                                            <FontAwesomeIcon icon={faLink} />
                                            ربط الأدلة القانونية ذات الصلة
                                        </button>

                                        {selectedRelatedGuides.length > 0 && (
                                            <div className="mt-4 p-4 border rounded-md">
                                                <h5 className="font-medium mb-2">
                                                    الأدلة القانونية ذات الصلة:
                                                </h5>
                                                <div className="flex flex-wrap gap-2">
                                                    {selectedRelatedGuides.map(
                                                        (guide) => (
                                                            <span
                                                                key={guide.id}
                                                                className="px-3 py-1 bg-gray-100 rounded-full text-sm"
                                                            >
                                                                {guide.name}
                                                            </span>
                                                        )
                                                    )}
                                                </div>
                                            </div>
                                        )}
                                    </div>
                                )}
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
                    <BackButton path={"/newAdmin/settings/law-guide/sub"} />
                </div>
            </div>

            {/* Link Modals */}
            <LinkModal
                isOpen={linkModalOpen}
                onClose={() => setLinkModalOpen(false)}
                title="ربط الأدلة القانونية ذات الصلة"
                items={
                    allLawGuides?.filter((guide) => {
                        console.log("Checking guide:", guide);
                        return guide.id !== lawGuide?.id;
                    }) || []
                }
                selectedItems={selectedRelatedGuides}
                onSelect={(selectedGuides) => {
                    handleSaveRelatedLaws(selectedGuides, lawGuide);
                }}
                mainCategories={mainCategories}
            />

            <LinkModal
                isOpen={linkLawModalOpen}
                onClose={() => {
                    setLinkLawModalOpen(false);
                    setCurrentLaw(null);
                }}
                title="ربط القوانين ذات الصلة"
                items={allLaws?.filter((l) => l.id !== currentLaw?.id) || []}
                selectedItems={currentLaw?.related_laws || []}
                onSelect={(selectedLaws) => {
                    handleSaveRelatedLaws(selectedLaws, currentLaw);
                    setCurrentLaw(null);
                }}
                isLawModal={true}
                lawGuides={allLawGuides}
                mainCategories={mainCategories}
            />
        </>
    );
};

export default LawGuideForm;
