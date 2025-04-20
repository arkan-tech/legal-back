import React, { useState, useEffect } from "react";
import axios from "axios";
import TextInput from "../../TextInput";
import SaveButton from "../../SaveButton";
import BackButton from "../../BackButton";
import LearningPathModal from "../../Modals/LearningPathModal";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import {
    faArrowDown,
    faArrowUp,
    faTrash,
    faSave,
    faBook,
    faGavel,
} from "@fortawesome/free-solid-svg-icons";
import { router } from "@inertiajs/react";

interface LearningPathItem {
    id: number;
    item_type: "law-guide" | "book-guide";
    item_id: number;
    name: string;
    order: number;
    mandatory: boolean;
    main_category: string;
    sub_category: string;
}

interface GroupedSubCategory {
    type: "law-guide" | "book-guide";
    name: string;
    items: LearningPathItem[];
    order: number;
}

interface LearningPathFormProps {
    learningPath?: {
        id: number;
        title: string;
        items: LearningPathItem[];
    };
    lawGuideCategories: any[];
    bookGuideCategories: any[];
    lawGuides: any;
    bookGuides: any;
    lawGuideLaws: any;
    bookGuideSections: any;
    isEdit?: boolean;
}

const LearningPathForm: React.FC<LearningPathFormProps> = ({
    learningPath,
    lawGuideCategories,
    bookGuideCategories,
    lawGuides,
    bookGuides,
    lawGuideLaws,
    bookGuideSections,
    isEdit = false,
}) => {
    const [errors, setErrors] = useState<Record<string, string>>({});
    const [title, setTitle] = useState(learningPath?.title || "");
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [items, setItems] = useState(learningPath?.items || []);
    const [expandedSubCategories, setExpandedSubCategories] = useState<
        string[]
    >([]);
    const [hasChanges, setHasChanges] = useState(false);

    useEffect(() => {
        const handleBeforeUnload = (e: BeforeUnloadEvent) => {
            if (hasChanges) {
                e.preventDefault();
                e.returnValue = "";
                return "";
            }
        };

        const handleInertiaBeforeNavigate = (event: any) => {
            if (
                hasChanges &&
                !window.confirm(
                    "لديك تغييرات غير محفوظة. هل أنت متأكد من المغادرة؟"
                )
            ) {
                event.preventDefault();
            }
        };

        window.addEventListener("beforeunload", handleBeforeUnload);
        document.addEventListener(
            "inertia:before",
            handleInertiaBeforeNavigate
        );

        return () => {
            window.removeEventListener("beforeunload", handleBeforeUnload);
            document.removeEventListener(
                "inertia:before",
                handleInertiaBeforeNavigate
            );
        };
    }, [hasChanges]);

    // Track changes
    useEffect(() => {
        if (!learningPath) {
            setHasChanges(items.length > 0 || title.length > 0);
        } else {
            setHasChanges(
                title !== learningPath.title ||
                    JSON.stringify(items) !== JSON.stringify(learningPath.items)
            );
        }
    }, [title, items, learningPath]);

    const handleAddItems = (data: any) => {
        setItems((prev) => [...prev, ...data.items]);
    };

    const handleMoveUp = (index: number, subCategory: string) => {
        setItems((prev) => {
            const newItems = [...prev];
            const subCategoryItems = newItems.filter(
                (item) => item.sub_category === subCategory
            );
            const otherItems = newItems.filter(
                (item) => item.sub_category !== subCategory
            );

            const itemIndex = subCategoryItems.findIndex((_, i) => i === index);
            if (itemIndex > 0) {
                const temp = subCategoryItems[itemIndex].order;
                subCategoryItems[itemIndex].order =
                    subCategoryItems[itemIndex - 1].order;
                subCategoryItems[itemIndex - 1].order = temp;
            }

            return [...otherItems, ...subCategoryItems].sort(
                (a, b) => a.order - b.order
            );
        });
    };

    const handleMoveDown = (index: number, subCategory: string) => {
        setItems((prev) => {
            const newItems = [...prev];
            const subCategoryItems = newItems.filter(
                (item) => item.sub_category === subCategory
            );
            const otherItems = newItems.filter(
                (item) => item.sub_category !== subCategory
            );

            const itemIndex = subCategoryItems.findIndex((_, i) => i === index);
            if (itemIndex < subCategoryItems.length - 1) {
                const temp = subCategoryItems[itemIndex].order;
                subCategoryItems[itemIndex].order =
                    subCategoryItems[itemIndex + 1].order;
                subCategoryItems[itemIndex + 1].order = temp;
            }

            return [...otherItems, ...subCategoryItems].sort(
                (a, b) => a.order - b.order
            );
        });
    };

    const handleRemoveItem = (
        index: number,
        subCategory: string,
        mainCategory: string
    ) => {
        setItems((prev) => {
            const subCategoryItems = prev.filter(
                (item) =>
                    item.sub_category === subCategory &&
                    item.main_category === mainCategory
            );
            const otherItems = prev.filter(
                (item) =>
                    item.sub_category !== subCategory ||
                    item.main_category !== mainCategory
            );

            const updatedSubCategoryItems = [
                ...subCategoryItems.slice(0, index),
                ...subCategoryItems.slice(index + 1),
            ];

            const allItems = [...otherItems, ...updatedSubCategoryItems].sort(
                (a, b) => a.order - b.order
            );
            return allItems.map((item, i) => ({ ...item, order: i + 1 }));
        });
    };

    const handleToggleMandatory = (index: number) => {
        setItems((prev) =>
            prev.map((item, i) =>
                i === index ? { ...item, mandatory: !item.mandatory } : item
            )
        );
    };

    const toggleSubCategory = (subCategory: string) => {
        setExpandedSubCategories((prev) =>
            prev.includes(subCategory)
                ? prev.filter((c) => c !== subCategory)
                : [...prev, subCategory]
        );
    };

    const handleMoveSubCategoryUp = (subCategory: string) => {
        setItems((prev) => {
            const subCategories = Array.from(
                new Set(prev.map((item) => item.sub_category))
            );
            const currentIndex = subCategories.indexOf(subCategory);
            if (currentIndex <= 0) return prev;

            const prevSubCategory = subCategories[currentIndex - 1];
            const updatedItems = [...prev];

            // Get min order of current subcategory
            const currentMinOrder = Math.min(
                ...updatedItems
                    .filter((item) => item.sub_category === subCategory)
                    .map((item) => item.order)
            );
            // Get min order of previous subcategory
            const prevMinOrder = Math.min(
                ...updatedItems
                    .filter((item) => item.sub_category === prevSubCategory)
                    .map((item) => item.order)
            );

            // Swap orders of items in these subcategories
            updatedItems.forEach((item) => {
                if (item.sub_category === subCategory) {
                    item.order = item.order - (currentMinOrder - prevMinOrder);
                } else if (item.sub_category === prevSubCategory) {
                    item.order = item.order + (currentMinOrder - prevMinOrder);
                }
            });

            return updatedItems.sort((a, b) => a.order - b.order);
        });
    };

    const handleMoveSubCategoryDown = (subCategory: string) => {
        setItems((prev) => {
            const subCategories = Array.from(
                new Set(prev.map((item) => item.sub_category))
            );
            const currentIndex = subCategories.indexOf(subCategory);
            if (currentIndex >= subCategories.length - 1) return prev;

            const nextSubCategory = subCategories[currentIndex + 1];
            const updatedItems = [...prev];

            // Get min order of current subcategory
            const currentMinOrder = Math.min(
                ...updatedItems
                    .filter((item) => item.sub_category === subCategory)
                    .map((item) => item.order)
            );
            // Get min order of next subcategory
            const nextMinOrder = Math.min(
                ...updatedItems
                    .filter((item) => item.sub_category === nextSubCategory)
                    .map((item) => item.order)
            );

            // Swap orders of items in these subcategories
            updatedItems.forEach((item) => {
                if (item.sub_category === subCategory) {
                    item.order = item.order + (nextMinOrder - currentMinOrder);
                } else if (item.sub_category === nextSubCategory) {
                    item.order = item.order - (nextMinOrder - currentMinOrder);
                }
            });

            return updatedItems.sort((a, b) => a.order - b.order);
        });
    };

    const saveData = async () => {
        try {
            const url = isEdit
                ? `/newAdmin/settings/learning-path/${learningPath?.id}`
                : "/newAdmin/settings/learning-path/store";

            const response = await axios.post(url, {
                title,
                items: items.map((item) => ({
                    item_type: item.item_type,
                    item_id: item.item_id,
                    order: item.order,
                    mandatory: item.mandatory,
                })),
            });

            if (response.data.status) {
                // Remove event listeners before navigation
                window.removeEventListener("beforeunload", handleBeforeUnload);
                document.removeEventListener(
                    "inertia:before",
                    handleInertiaBeforeNavigate
                );

                // Set hasChanges to false before navigation
                setHasChanges(false);

                // Navigate after a short delay to ensure state is updated
                setTimeout(() => {
                    router.visit("/newAdmin/settings/learning-path");
                }, 0);
            }
        } catch (error) {
            if (axios.isAxiosError(error) && error.response?.data?.errors) {
                setErrors(error.response.data.errors);
            } else {
                setErrors({ general: "حدث خطأ أثناء حفظ البيانات" });
            }
        }
    };

    const handleBeforeUnload = (e: BeforeUnloadEvent) => {
        if (hasChanges) {
            e.preventDefault();
            e.returnValue = "";
            return "";
        }
    };

    const handleInertiaBeforeNavigate = (event: any) => {
        if (
            hasChanges &&
            !window.confirm(
                "لديك تغييرات غير محفوظة. هل أنت متأكد من المغادرة؟"
            )
        ) {
            event.preventDefault();
        }
    };

    const renderTable = (items: LearningPathItem[]) => {
        // Group items by subcategory
        const groupedBySubCategory = items.reduce<
            Record<string, GroupedSubCategory>
        >((acc, item) => {
            if (!acc[item.sub_category]) {
                acc[item.sub_category] = {
                    type: item.item_type,
                    name: item.sub_category,
                    items: [],
                    order: item.order,
                };
            }
            acc[item.sub_category].items.push(item);
            acc[item.sub_category].order = Math.min(
                acc[item.sub_category].order,
                item.order
            );
            return acc;
        }, {});

        // Sort subcategories by their minimum order
        const sortedSubCategories = Object.values(groupedBySubCategory).sort(
            (a, b) => a.order - b.order
        );

        return (
            <div className="space-y-4">
                {sortedSubCategories.map((subCategory, subCategoryIndex) => (
                    <div key={subCategory.name} className="border rounded">
                        <button
                            onClick={() => toggleSubCategory(subCategory.name)}
                            className="w-full bg-gray-50 p-3 flex justify-between items-center hover:bg-gray-100"
                        >
                            <div className="flex items-center gap-2">
                                <span className="transform transition-transform duration-200">
                                    {expandedSubCategories.includes(
                                        subCategory.name
                                    )
                                        ? "▼"
                                        : "◀"}
                                </span>
                                <FontAwesomeIcon
                                    icon={
                                        subCategory.type === "law-guide"
                                            ? faGavel
                                            : faBook
                                    }
                                    className={
                                        subCategory.type === "law-guide"
                                            ? "text-blue-600"
                                            : "text-green-600"
                                    }
                                />
                                <span className="font-medium">
                                    {subCategory.name}
                                </span>
                            </div>
                            <div className="flex items-center gap-4">
                                <span className="text-sm text-gray-500">
                                    (إجباري:{" "}
                                    {
                                        subCategory.items.filter(
                                            (item) => item.mandatory
                                        ).length
                                    }{" "}
                                    | اختياري:{" "}
                                    {
                                        subCategory.items.filter(
                                            (item) => !item.mandatory
                                        ).length
                                    }
                                    )
                                </span>
                                <div className="flex items-center gap-2">
                                    <button
                                        onClick={(e) => {
                                            e.stopPropagation();
                                            handleMoveSubCategoryUp(
                                                subCategory.name
                                            );
                                        }}
                                        disabled={subCategoryIndex === 0}
                                        className={`p-2 rounded-md ${
                                            subCategoryIndex === 0
                                                ? "text-gray-400 cursor-not-allowed"
                                                : "text-primary hover:bg-gray-100"
                                        }`}
                                    >
                                        <FontAwesomeIcon icon={faArrowUp} />
                                    </button>
                                    <button
                                        onClick={(e) => {
                                            e.stopPropagation();
                                            handleMoveSubCategoryDown(
                                                subCategory.name
                                            );
                                        }}
                                        disabled={
                                            subCategoryIndex ===
                                            sortedSubCategories.length - 1
                                        }
                                        className={`p-2 rounded-md ${
                                            subCategoryIndex ===
                                            sortedSubCategories.length - 1
                                                ? "text-gray-400 cursor-not-allowed"
                                                : "text-primary hover:bg-gray-100"
                                        }`}
                                    >
                                        <FontAwesomeIcon icon={faArrowDown} />
                                    </button>
                                </div>
                            </div>
                        </button>
                        {expandedSubCategories.includes(subCategory.name) && (
                            <div className="p-3">
                                <div className="mb-4 flex justify-end gap-2">
                                    <button
                                        onClick={() => {
                                            setItems((prev) =>
                                                prev.map((item) =>
                                                    item.sub_category ===
                                                    subCategory.name
                                                        ? {
                                                              ...item,
                                                              mandatory: true,
                                                          }
                                                        : item
                                                )
                                            );
                                        }}
                                        className="px-2 py-1 bg-primary text-white text-sm rounded hover:bg-opacity-90"
                                    >
                                        تعيين الكل كإجباري
                                    </button>
                                    <button
                                        onClick={() => {
                                            setItems((prev) =>
                                                prev.map((item) =>
                                                    item.sub_category ===
                                                    subCategory.name
                                                        ? {
                                                              ...item,
                                                              mandatory: false,
                                                          }
                                                        : item
                                                )
                                            );
                                        }}
                                        className="px-2 py-1 border border-gray-300 bg-white text-gray-700 text-sm rounded hover:bg-gray-50"
                                    >
                                        تعيين الكل كاختياري
                                    </button>
                                </div>
                                <table className="w-full">
                                    <thead>
                                        <tr className="border-b">
                                            <th className="text-right p-2">
                                                #
                                            </th>
                                            <th className="text-right p-2">
                                                الاسم
                                            </th>
                                            <th className="text-right p-2">
                                                إجباري
                                            </th>
                                            <th className="text-right p-2">
                                                العمليات
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {subCategory.items.map(
                                            (item, index) => (
                                                <tr
                                                    key={item.id}
                                                    className="border-b last:border-b-0"
                                                >
                                                    <td className="p-2">
                                                        {item.order}
                                                    </td>
                                                    <td className="p-2">
                                                        <div className="flex items-center gap-2">
                                                            <FontAwesomeIcon
                                                                icon={
                                                                    item.item_type ===
                                                                    "law-guide"
                                                                        ? faGavel
                                                                        : faBook
                                                                }
                                                                className={
                                                                    item.item_type ===
                                                                    "law-guide"
                                                                        ? "text-blue-600"
                                                                        : "text-green-600"
                                                                }
                                                            />
                                                            {item.name}
                                                        </div>
                                                    </td>
                                                    <td className="p-2">
                                                        <input
                                                            type="checkbox"
                                                            checked={
                                                                item.mandatory
                                                            }
                                                            onChange={() =>
                                                                handleToggleMandatory(
                                                                    items.findIndex(
                                                                        (i) =>
                                                                            i.id ===
                                                                            item.id
                                                                    )
                                                                )
                                                            }
                                                            className="rounded border-gray-300 text-primary focus:ring-primary"
                                                        />
                                                    </td>
                                                    <td className="p-2">
                                                        <div className="flex items-center gap-2">
                                                            <button
                                                                onClick={() =>
                                                                    handleMoveUp(
                                                                        index,
                                                                        subCategory.name
                                                                    )
                                                                }
                                                                disabled={
                                                                    index === 0
                                                                }
                                                                className={`p-2 rounded-md ${
                                                                    index === 0
                                                                        ? "text-gray-400 cursor-not-allowed"
                                                                        : "text-primary hover:bg-gray-100"
                                                                }`}
                                                            >
                                                                <FontAwesomeIcon
                                                                    icon={
                                                                        faArrowUp
                                                                    }
                                                                />
                                                            </button>
                                                            <button
                                                                onClick={() =>
                                                                    handleMoveDown(
                                                                        index,
                                                                        subCategory.name
                                                                    )
                                                                }
                                                                disabled={
                                                                    index ===
                                                                    subCategory
                                                                        .items
                                                                        .length -
                                                                        1
                                                                }
                                                                className={`p-2 rounded-md ${
                                                                    index ===
                                                                    subCategory
                                                                        .items
                                                                        .length -
                                                                        1
                                                                        ? "text-gray-400 cursor-not-allowed"
                                                                        : "text-primary hover:bg-gray-100"
                                                                }`}
                                                            >
                                                                <FontAwesomeIcon
                                                                    icon={
                                                                        faArrowDown
                                                                    }
                                                                />
                                                            </button>
                                                            <button
                                                                onClick={() =>
                                                                    handleRemoveItem(
                                                                        index,
                                                                        "",
                                                                        ""
                                                                    )
                                                                }
                                                                className="p-2 text-danger hover:bg-gray-100 rounded-md"
                                                            >
                                                                <FontAwesomeIcon
                                                                    icon={
                                                                        faTrash
                                                                    }
                                                                />
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            )
                                        )}
                                    </tbody>
                                </table>
                            </div>
                        )}
                    </div>
                ))}
            </div>
        );
    };

    return (
        <div className="grid grid-cols-1 gap-9" style={{ direction: "rtl" }}>
            <div className="flex flex-col gap-9">
                <div className="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div className="border-b border-stroke px-6 py-4 dark:border-strokedark">
                        <h3 className="font-medium text-black dark:text-white text-right">
                            معلومات المسار
                        </h3>
                    </div>
                    <div className="p-6">
                        <div className="grid grid-cols-1 gap-6">
                            <TextInput
                                label="اسم المسار"
                                value={title}
                                setValue={setTitle}
                                error={errors.title}
                            />
                        </div>
                    </div>
                </div>

                <div className="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div className="border-b border-stroke px-6 py-4 dark:border-strokedark">
                        <div className="flex justify-between items-center">
                            <h3 className="font-medium text-black dark:text-white">
                                العناصر
                            </h3>
                            <button
                                onClick={() => setIsModalOpen(true)}
                                className="bg-primary text-white px-4 py-2 rounded-md hover:bg-opacity-90"
                            >
                                إضافة عناصر
                            </button>
                        </div>
                    </div>

                    <div className="p-6">
                        <div className="overflow-x-auto">
                            {items.length > 0 ? (
                                renderTable(items)
                            ) : (
                                <p className="text-center text-gray-500">
                                    لا توجد عناصر
                                </p>
                            )}
                        </div>
                    </div>
                </div>

                <div className="flex gap-4">
                    <BackButton path="/newAdmin/settings/learning-path" />
                </div>
            </div>

            {hasChanges && (
                <div className="fixed bottom-6 left-6 z-50">
                    <button
                        onClick={saveData}
                        className="flex items-center gap-2 bg-primary text-white px-4 py-2 rounded-full shadow-lg hover:bg-opacity-90 transition-all"
                    >
                        <FontAwesomeIcon icon={faSave} />
                        <span>حفظ التغييرات</span>
                    </button>
                </div>
            )}

            <LearningPathModal
                isOpen={isModalOpen}
                setIsOpen={setIsModalOpen}
                onSave={handleAddItems}
                pathId={learningPath?.id || 0}
                lawGuideCategories={lawGuideCategories}
                bookGuideCategories={bookGuideCategories}
                lawGuides={lawGuides}
                bookGuides={bookGuides}
                lawGuideLaws={lawGuideLaws}
                bookGuideSections={bookGuideSections}
                existingItems={items}
            />
        </div>
    );
};

export default LearningPathForm;
