import React, { useState } from "react";
import { Dialog } from "@headlessui/react";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faCheck, faTimes } from "@fortawesome/free-solid-svg-icons";
import SelectGroup, { Option } from "../SelectGroup/SelectGroup";

interface Item {
    id: string | number;
    name: string;
    mandatory?: boolean;
    order?: number;
    item_type?: string;
    item_id?: number;
    main_category?: string;
    sub_category?: string;
}

interface Category {
    id: number;
    name: string;
}

interface LearningPathModalProps {
    isOpen: boolean;
    setIsOpen: (isOpen: boolean) => void;
    onSave: (data: any) => void;
    pathId: number;
    lawGuideCategories: Category[];
    bookGuideCategories: Category[];
    lawGuides: Record<string, Item[]>;
    bookGuides: Record<string, Item[]>;
    lawGuideLaws: Record<string, Item[]>;
    bookGuideSections: Record<string, Item[]>;
    existingItems: Item[];
}

const LearningPathModal: React.FC<LearningPathModalProps> = ({
    isOpen,
    setIsOpen,
    onSave,
    pathId,
    lawGuideCategories,
    bookGuideCategories,
    lawGuides,
    bookGuides,
    lawGuideLaws,
    bookGuideSections,
    existingItems,
}) => {
    const [activeTab, setActiveTab] = useState<"law-guide" | "book-guide">(
        "law-guide"
    );
    const [step, setStep] = useState(1);
    const [selectedMainCategory, setSelectedMainCategory] =
        useState<Option | null>(null);
    const [selectedSubCategory, setSelectedSubCategory] =
        useState<Option | null>(null);
    const [selectedItems, setSelectedItems] = useState<Item[]>([]);
    const [selectWholeSubCategory, setSelectWholeSubCategory] = useState(false);
    const [isMandatory, setIsMandatory] = useState(false);
    const [errors, setErrors] = useState<Record<string, string>>({});

    const mainCategories = React.useMemo(() => {
        const categories =
            activeTab === "law-guide"
                ? lawGuideCategories
                : bookGuideCategories;
        return categories.map((category) => ({
            id: category.id.toString(),
            name: category.name,
        }));
    }, [activeTab, lawGuideCategories, bookGuideCategories]);

    const subCategories =
        activeTab === "law-guide"
            ? lawGuides[selectedMainCategory?.id || ""] || []
            : bookGuides[selectedMainCategory?.id || ""] || [];

    const items = React.useMemo(() => {
        const rawItems =
            activeTab === "law-guide"
                ? lawGuideLaws[selectedSubCategory?.id || ""] || []
                : bookGuideSections[selectedSubCategory?.id || ""] || [];

        // Filter out both existing items and currently selected items
        return rawItems.filter((item) => {
            const isExisting = existingItems.some(
                (existingItem) =>
                    existingItem.item_type === activeTab &&
                    Number(existingItem.item_id) === Number(item.id)
            );
            const isSelected = selectedItems.some(
                (selectedItem) =>
                    selectedItem.item_type === activeTab &&
                    Number(selectedItem.id) === Number(item.id)
            );
            return !isExisting && !isSelected;
        });
    }, [
        activeTab,
        selectedSubCategory?.id,
        lawGuideLaws,
        bookGuideSections,
        existingItems,
        selectedItems,
    ]);

    React.useEffect(() => {
        setSelectedMainCategory(null);
        setSelectedSubCategory(null);
        setSelectedItems([]);
    }, [activeTab]);

    React.useEffect(() => {
        setSelectedSubCategory(null);
        setSelectedItems([]);
    }, [selectedMainCategory]);

    React.useEffect(() => {
        setSelectedItems([]);
    }, [selectedSubCategory]);

    const resetForm = () => {
        setStep(1);
        setSelectedMainCategory(null);
        setSelectedSubCategory(null);
        setSelectedItems([]);
        setSelectWholeSubCategory(false);
        setIsMandatory(false);
        setErrors({});
    };

    const handleClose = () => {
        resetForm();
        setIsOpen(false);
    };

    const handleNext = () => {
        if (step === 1 && !selectedMainCategory) {
            setErrors({ mainCategory: "القسم الرئيسي مطلوب" });
            return;
        }
        if (step === 2 && !selectedSubCategory) {
            setErrors({ subCategory: "القسم الفرعي مطلوب" });
            return;
        }
        setErrors({});
        setStep(step + 1);
    };

    const handleBack = () => {
        setStep(step - 1);
    };

    const handleSave = () => {
        if (selectedItems.length === 0) {
            setErrors({ items: "يجب اختيار عنصر واحد على الأقل" });
            return;
        }

        const formattedItems = selectedItems.map((item, index) => ({
            item_type: activeTab,
            item_id: Number(item.id),
            name: item.name,
            order: existingItems.length + index + 1,
            mandatory: item.mandatory ?? true,
            main_category: item.main_category,
            sub_category: item.sub_category,
        }));

        onSave({
            type: activeTab,
            items: formattedItems,
        });
        handleClose();
    };

    const handleItemSelect = (item: Item) => {
        setSelectedItems((prev) => {
            const exists = prev.find((i) => Number(i.id) === Number(item.id));
            if (exists) {
                return prev.filter((i) => Number(i.id) !== Number(item.id));
            }

            const mainCategoryName = selectedMainCategory?.name || "";
            const subCategoryName = selectedSubCategory?.name || "";

            return [
                ...prev,
                {
                    ...item,
                    mandatory: true,
                    order: prev.length + 1,
                    item_type: activeTab,
                    item_id: Number(item.id),
                    main_category: mainCategoryName,
                    sub_category: subCategoryName,
                },
            ];
        });
    };

    const handleToggleMandatory = (itemId: number | string) => {
        setSelectedItems((prev) =>
            prev.map((item) =>
                Number(item.id) === Number(itemId)
                    ? { ...item, mandatory: !item.mandatory }
                    : item
            )
        );
    };

    const handleUpdateOrder = (itemId: number | string, newOrder: number) => {
        setSelectedItems((prev) => {
            const items = [...prev];
            const itemIndex = items.findIndex(
                (i) => Number(i.id) === Number(itemId)
            );
            if (itemIndex === -1) return items;

            const item = items[itemIndex];
            items.splice(itemIndex, 1);
            items.splice(newOrder - 1, 0, item);

            return items.map((item, index) => ({
                ...item,
                order: index + 1,
            }));
        });
    };

    const handleRemoveItem = (itemId: number | string) => {
        setSelectedItems((prev) => {
            // Filter items by type and ID
            const currentTypeItems = prev.filter(
                (item) => item.item_type === activeTab
            );
            const otherTypeItems = prev.filter(
                (item) => item.item_type !== activeTab
            );

            // Find the exact item to remove from current type items
            const itemToRemoveIndex = currentTypeItems.findIndex(
                (item) => Number(item.id) === Number(itemId)
            );

            if (itemToRemoveIndex !== -1) {
                // Remove the item
                currentTypeItems.splice(itemToRemoveIndex, 1);

                // Recalculate order for current type items
                const updatedCurrentTypeItems = currentTypeItems.map(
                    (item, index) => ({
                        ...item,
                        order: index + 1,
                    })
                );

                // Combine both arrays maintaining other type items unchanged
                return [...otherTypeItems, ...updatedCurrentTypeItems];
            }

            return prev;
        });
    };

    const handleMoveUp = (index: number) => {
        if (index === 0) return;
        setSelectedItems((prev) => {
            const newItems = [...prev];
            const currentItem = newItems[index];
            const prevItem = newItems[index - 1];

            // Only swap if they're the same type
            if (currentItem.item_type === prevItem.item_type) {
                newItems[index] = prevItem;
                newItems[index - 1] = currentItem;
            }

            return newItems.map((item, i) => ({ ...item, order: i + 1 }));
        });
    };

    const handleMoveDown = (index: number) => {
        setSelectedItems((prev) => {
            if (index === prev.length - 1) return prev;
            const newItems = [...prev];
            const currentItem = newItems[index];
            const nextItem = newItems[index + 1];

            // Only swap if they're the same type
            if (currentItem.item_type === nextItem.item_type) {
                newItems[index] = nextItem;
                newItems[index + 1] = currentItem;
            }

            return newItems.map((item, i) => ({ ...item, order: i + 1 }));
        });
    };

    const handleSelectAll = () => {
        const availableItems = items.map((item) => ({
            ...item,
            main_category: selectedMainCategory?.name || "",
            sub_category: selectedSubCategory?.name || "",
        }));

        setSelectedItems((prev) => {
            const newItems = [...prev];
            availableItems.forEach((item) => {
                if (!prev.find((i) => Number(i.id) === Number(item.id))) {
                    newItems.push({
                        ...item,
                        mandatory: true,
                        order: newItems.length + 1,
                        item_type: activeTab,
                        item_id: Number(item.id),
                    });
                }
            });
            return newItems;
        });
    };

    if (!isOpen) return null;

    return (
        <div className="fixed inset-0 z-[99999] flex items-center justify-center overflow-hidden">
            <div
                className="fixed inset-0 bg-black bg-opacity-50"
                onClick={handleClose}
            />
            <div
                className="relative bg-white rounded-lg w-full max-w-2xl flex flex-col max-h-[90vh]"
                style={{ direction: "rtl" }}
            >
                {/* Header */}
                <div className="flex justify-between items-center p-6 border-b">
                    <h2 className="text-xl font-semibold">إضافة عناصر جديدة</h2>
                    <button
                        onClick={handleClose}
                        className="text-gray-500 hover:text-gray-700"
                    >
                        ✕
                    </button>
                </div>

                {/* Tabs */}
                <div className="border-b">
                    <div className="flex">
                        <button
                            className={`flex-1 py-2 px-4 text-center ${
                                activeTab === "law-guide"
                                    ? "text-primary border-b-2 border-primary"
                                    : "text-gray-500"
                            }`}
                            onClick={() => setActiveTab("law-guide")}
                        >
                            دليل الأنظمة
                        </button>
                        <button
                            className={`flex-1 py-2 px-4 text-center ${
                                activeTab === "book-guide"
                                    ? "text-primary border-b-2 border-primary"
                                    : "text-gray-500"
                            }`}
                            onClick={() => setActiveTab("book-guide")}
                        >
                            دليل الكتب
                        </button>
                    </div>
                </div>

                {/* Steps indicator */}
                <div className="border-b">
                    <div className="flex justify-between">
                        {[1, 2, 3].map((s) => (
                            <div
                                key={s}
                                className={`flex-1 text-center py-2 ${
                                    s === step
                                        ? "text-primary border-b-2 border-primary"
                                        : "text-gray-500"
                                }`}
                            >
                                {s === 1 && "اختر القسم الرئيسي"}
                                {s === 2 && "اختر القسم الفرعي"}
                                {s === 3 && "اختر العناصر"}
                            </div>
                        ))}
                    </div>
                </div>

                {/* Content */}
                <div className="flex-1 overflow-y-auto p-6">
                    {step <= 2 && (
                        <SelectGroup
                            options={
                                step === 1
                                    ? mainCategories
                                    : subCategories.map((sc) => ({
                                          id: sc.id.toString(),
                                          name: sc.name,
                                      }))
                            }
                            title={
                                step === 1 ? "القسم الرئيسي" : "القسم الفرعي"
                            }
                            selectedOption={
                                step === 1
                                    ? selectedMainCategory
                                    : selectedSubCategory
                            }
                            setSelectedOption={
                                step === 1
                                    ? setSelectedMainCategory
                                    : setSelectedSubCategory
                            }
                            required={true}
                        />
                    )}

                    {step === 3 && (
                        <div>
                            <div className="flex justify-between items-center mb-4">
                                <div className="flex items-center gap-4">
                                    <h3>العناصر المحددة</h3>
                                    <div className="text-sm text-gray-500">
                                        (إجباري:{" "}
                                        {
                                            selectedItems.filter(
                                                (item) =>
                                                    item.item_type ===
                                                        activeTab &&
                                                    item.mandatory
                                            ).length
                                        }{" "}
                                        | اختياري:{" "}
                                        {
                                            selectedItems.filter(
                                                (item) =>
                                                    item.item_type ===
                                                        activeTab &&
                                                    !item.mandatory
                                            ).length
                                        }
                                        )
                                    </div>
                                </div>
                                <div className="flex items-center gap-4">
                                    <div className="flex items-center gap-2">
                                        <label className="text-sm text-gray-600">
                                            تعيين الكل كـ
                                        </label>
                                        <button
                                            onClick={() => {
                                                setSelectedItems((prev) =>
                                                    prev.map((item) =>
                                                        item.item_type ===
                                                        activeTab
                                                            ? {
                                                                  ...item,
                                                                  mandatory:
                                                                      true,
                                                              }
                                                            : item
                                                    )
                                                );
                                            }}
                                            className="px-3 py-1 bg-primary text-white rounded text-sm hover:bg-opacity-90 ml-2"
                                        >
                                            إجباري
                                        </button>
                                        <button
                                            onClick={() => {
                                                setSelectedItems((prev) =>
                                                    prev.map((item) =>
                                                        item.item_type ===
                                                        activeTab
                                                            ? {
                                                                  ...item,
                                                                  mandatory:
                                                                      false,
                                                              }
                                                            : item
                                                    )
                                                );
                                            }}
                                            className="px-3 py-1 border border-gray-300 bg-white text-gray-700 rounded text-sm hover:bg-gray-50"
                                        >
                                            اختياري
                                        </button>
                                    </div>
                                    <button
                                        onClick={handleSelectAll}
                                        className="px-3 py-1 bg-primary text-white rounded text-sm hover:bg-opacity-90"
                                    >
                                        تحديد الكل
                                    </button>
                                </div>
                            </div>
                            <div className="space-y-2 mb-6">
                                {selectedItems
                                    .filter(
                                        (item) => item.item_type === activeTab
                                    )
                                    .map((item, index) => (
                                        <div
                                            key={item.id}
                                            className="flex items-center gap-4 p-2 border rounded"
                                        >
                                            <span>{index + 1}</span>
                                            <div className="flex-1">
                                                <div>{item.name}</div>
                                                <div className="text-sm text-gray-500">
                                                    {item.main_category} -{" "}
                                                    {item.sub_category}
                                                </div>
                                            </div>
                                            <div className="flex items-center gap-2">
                                                <label className="text-sm text-gray-600">
                                                    إجباري
                                                </label>
                                                <input
                                                    type="checkbox"
                                                    checked={item.mandatory}
                                                    onChange={() =>
                                                        handleToggleMandatory(
                                                            item.id
                                                        )
                                                    }
                                                    className="rounded border-gray-300 text-primary shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                                />
                                            </div>
                                            <div className="flex items-center gap-2">
                                                <button
                                                    onClick={() =>
                                                        handleMoveUp(index)
                                                    }
                                                    disabled={index === 0}
                                                    className={`px-2 py-1 rounded ${
                                                        index === 0
                                                            ? "text-gray-400 cursor-not-allowed"
                                                            : "text-primary hover:bg-gray-100"
                                                    }`}
                                                >
                                                    ↑
                                                </button>
                                                <button
                                                    onClick={() =>
                                                        handleMoveDown(index)
                                                    }
                                                    disabled={
                                                        index ===
                                                        selectedItems.filter(
                                                            (item) =>
                                                                item.item_type ===
                                                                activeTab
                                                        ).length -
                                                            1
                                                    }
                                                    className={`px-2 py-1 rounded ${
                                                        index ===
                                                        selectedItems.filter(
                                                            (item) =>
                                                                item.item_type ===
                                                                activeTab
                                                        ).length -
                                                            1
                                                            ? "text-gray-400 cursor-not-allowed"
                                                            : "text-primary hover:bg-gray-100"
                                                    }`}
                                                >
                                                    ↓
                                                </button>
                                                <button
                                                    onClick={() =>
                                                        handleRemoveItem(
                                                            item.id
                                                        )
                                                    }
                                                    className="text-red-500 hover:text-red-700 px-2 py-1"
                                                >
                                                    ×
                                                </button>
                                            </div>
                                        </div>
                                    ))}
                            </div>

                            <h3 className="mt-4 mb-2">العناصر المتاحة</h3>
                            <div className="space-y-2">
                                {items.map((item) => (
                                    <div
                                        key={item.id}
                                        className="flex items-center gap-4 p-2 border rounded"
                                    >
                                        <span className="flex-1">
                                            {item.name}
                                        </span>
                                        <button
                                            onClick={() =>
                                                handleItemSelect(item)
                                            }
                                            className="text-primary hover:text-primary-dark"
                                        >
                                            إضافة
                                        </button>
                                    </div>
                                ))}
                            </div>
                        </div>
                    )}
                </div>

                {/* Footer */}
                <div className="border-t p-6 flex justify-end gap-2">
                    {step > 1 && (
                        <button
                            onClick={handleBack}
                            className="px-4 py-2 text-gray-600 hover:text-gray-800"
                        >
                            رجوع
                        </button>
                    )}
                    {step < 3 ? (
                        <button
                            onClick={handleNext}
                            className="px-4 py-2 bg-primary text-white rounded hover:bg-opacity-90"
                        >
                            التالي
                        </button>
                    ) : (
                        <button
                            onClick={handleSave}
                            className="px-4 py-2 bg-primary text-white rounded hover:bg-opacity-90"
                        >
                            حفظ
                        </button>
                    )}
                </div>
            </div>
        </div>
    );
};

export default LearningPathModal;
