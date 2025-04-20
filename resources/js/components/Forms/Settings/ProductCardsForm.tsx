import { router } from "@inertiajs/react";
import React, { useEffect } from "react";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faTrash } from "@fortawesome/free-solid-svg-icons";
import SaveButton from "../../SaveButton";
import TextInput from "../../TextInput";

function ProductCardsForm({
    saveData,
    errors,
    contents,
    handleContentChange,
    progress,
}: {
    saveData: any;
    errors: any;
    contents: any;
    handleContentChange: any;
    progress: number;
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
                            key={content.id}
                            className="flex flex-col gap-4 shadow-md border-1 border-solid border-gray-200 p-4 bg-white dark:bg-form-input rounded-md"
                        >
                            <div className="flex flex-row gap-4">
                                <TextInput
                                    label="نص العنوان بالعربية"
                                    value={content.name_ar}
                                    setValue={(value: string) =>
                                        handleContentChange(
                                            content.id,
                                            "name_ar",
                                            value
                                        )
                                    }
                                    type="text"
                                    labelDirection="vertical"
                                    error={errors[content.name_ar]}
                                />
                                <TextInput
                                    label="نص العنوان بالإنجليزية"
                                    value={content.name_en}
                                    setValue={(value: string) =>
                                        handleContentChange(
                                            content.id,
                                            "name_en",
                                            value
                                        )
                                    }
                                    type="text"
                                    error={errors[content.name_en]}
                                    labelDirection="vertical"
                                />
                            </div>
                            <div className="flex flex-row gap-4">
                                <TextInput
                                    label="النص بالعربية"
                                    value={content.text_ar}
                                    setValue={(value: string) =>
                                        handleContentChange(
                                            content.id,
                                            "text_ar",
                                            value
                                        )
                                    }
                                    type="textarea"
                                    error={errors[content.text_ar]}
                                    labelDirection="vertical"
                                />
                                <TextInput
                                    label="النص بالإنجليزية"
                                    value={content.text_en}
                                    setValue={(value: string) =>
                                        handleContentChange(
                                            content.id,
                                            "text_en",
                                            value
                                        )
                                    }
                                    type="textarea"
                                    error={errors[content.text_en]}
                                    labelDirection="vertical"
                                />
                            </div>
                        </div>
                    ))}
                </div>
                <SaveButton saveData={saveData} />
            </div>
        </>
    );
}

export default ProductCardsForm;
