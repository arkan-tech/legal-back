import { router } from "@inertiajs/react";
import React, { useEffect } from "react";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faTrash } from "@fortawesome/free-solid-svg-icons";
import SaveButton from "../../SaveButton";
import TextInput from "../../TextInput";

export enum landingPageTranslations {
    header = "تحميل يمتاز",
    newsletter = "القائمة البريدية",
    cards = "قائمة المنتجات",
    "why-chose-us" = "لماذا يمتاز",
    sponsors = "الشركاء والرعاة",
    government = "النوافذ الحكومية",
    footer = "الفوتر",
    "digital-guide" = "الدليل الرقمي",
}
function OrderingContentForm({
    saveData,
    errors,
    contents,
    handleContentChange,
    progress,
    handleOrderChange,
}: {
    saveData: any;
    errors: any;
    contents: any;
    handleContentChange: any;
    progress: number;
    handleOrderChange: any;
}) {
    return (
        <>
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
                    {contents.map((content, index) => (
                        <div
                            key={content.title}
                            className="flex flex-col gap-4 shadow-md border-1 border-solid border-gray-200 p-4 bg-white dark:bg-form-input rounded-md"
                        >
                            <label className="font-bold w-full border-solid border-b-2 pb-4 border-gray-200">
                                {landingPageTranslations[content.title]}
                            </label>
                            {content.hasContent && (
                                <div className="flex flex-row gap-4">
                                    <TextInput
                                        label="النص بالعربية"
                                        value={content.content_ar}
                                        setValue={(value: string) =>
                                            handleContentChange(
                                                content.title,
                                                "content_ar",
                                                value
                                            )
                                        }
                                        type="textarea"
                                        error={errors[content.title]}
                                        labelDirection="vertical"
                                    />
                                    <TextInput
                                        label="النص بالإنجليزية"
                                        value={content.content_en}
                                        setValue={(value: string) =>
                                            handleContentChange(
                                                content.title,
                                                "content_en",
                                                value
                                            )
                                        }
                                        type="textarea"
                                        error={errors[content.title]}
                                        labelDirection="vertical"
                                    />
                                </div>
                            )}
                            {content.hasImage && (
                                <div className="flex flex-row gap-4">
                                    <input
                                        type="file"
                                        accept=".png, .jpg"
                                        onChange={(e) =>
                                            handleContentChange(
                                                content.title,
                                                "image",
                                                e.target.files
                                                    ? e.target.files[0]
                                                    : null
                                            )
                                        }
                                    />
                                    {content.image && (
                                        <img
                                            src={
                                                content.image?.url
                                                    ? content.image.url
                                                    : URL.createObjectURL(
                                                          content.image
                                                      )
                                            }
                                            alt=""
                                            className="w-20 h-20"
                                        />
                                    )}
                                </div>
                            )}

                            {/* Add buttons to control order on content.order */}
                            <div className="flex flex-row gap-4">
                                <button
                                    className={`rounded bg-[#ddb662] p-2 text-white font-medium hover:bg-opacity-90 ${
                                        index == 0
                                            ? "opacity-50 cursor-not-allowed"
                                            : ""
                                    }`}
                                    onClick={() => {
                                        handleOrderChange(content.title, "up");
                                    }}
                                >
                                    التحريك للأعلى
                                </button>

                                <button
                                    className={`rounded bg-[#ddb662] p-2 text-white font-medium hover:bg-opacity-90 ${
                                        index === contents.length - 1
                                            ? "opacity-50 cursor-not-allowed"
                                            : ""
                                    }`}
                                    onClick={() => {
                                        handleOrderChange(
                                            content.title,
                                            "down"
                                        );
                                    }}
                                >
                                    التحريك للأسفل
                                </button>
                            </div>
                            {errors[content.title] && (
                                <div className="text-red-500">
                                    {errors[content.title]}
                                </div>
                            )}
                        </div>
                    ))}
                </div>
                <SaveButton saveData={saveData} />
            </div>
        </>
    );
}

export default OrderingContentForm;
