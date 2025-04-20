import { router } from "@inertiajs/react";
import React from "react";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faTrash } from "@fortawesome/free-solid-svg-icons";
import SaveButton from "../../SaveButton";

function AppTextsForm({
    saveData,
    errors,
    settings,
    handleContentChange,
    progress,
}: {
    saveData: any;
    errors: any;
    settings: any;
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
                    {settings.map((setting, index) => (
                        <div key={index} className="flex flex-col gap-4">
                            <label>{setting.title}</label>
                            <textarea
                                value={setting.content}
                                onChange={(e) =>
                                    handleContentChange(index, e.target.value)
                                }
                                className="form-textarea mt-1 block w-full"
                                rows={5}
                                contentEditable
                            />
                            {errors[setting.key] && (
                                <div className="text-red-500">
                                    {errors[setting.key]}
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

export default AppTextsForm;
