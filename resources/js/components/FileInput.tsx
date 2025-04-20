import {
    faDownload,
    faEye,
    faTrash,
    faTrashAlt,
} from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import React from "react";
export default function ({
    fileSize,
    fileName,
    fileExtension,
    filePath,
    showFile = true,
}: {
    fileSize?: string;
    fileName: string;
    fileExtension?: string;
    filePath?: string;
    showFile?: boolean;
}) {
    return (
        <div className={"flex gap-4 w-full"}>
            {showFile && (
                <div className="shadow-md px-4 py-2 w-full xl:w-1/2 rounded-md">
                    <p className="text-black text-md">
                        {fileName}
                        {filePath && "." + fileExtension}
                    </p>
                    {filePath ? (
                        <p
                            className="text-[#bababa] text-sm text-right"
                            style={{ direction: "ltr" }}
                        >
                            {fileSize}
                        </p>
                    ) : (
                        <p>لم يتم رفع الملف</p>
                    )}
                </div>
            )}
            {filePath && (
                <div className={"flex gap-4 w-full xl:w-1/2 items-center"}>
                    <a
                        href={filePath}
                        target="_blank"
                        className="justify-center rounded-xl flex gap-2 items-center bg-[#f6f6f6] p-3 font-medium text-[#bababa] text-sm hover:bg-opacity-90"
                    >
                        <p>عرض الملف</p>
                        <FontAwesomeIcon icon={faEye} />
                    </a>
                    <a
                        href={filePath}
                        download={filePath}
                        className="justify-center rounded-xl flex gap-2 items-center bg-[#f6f6f6] p-3 font-medium text-[#bababa] text-sm hover:bg-opacity-90"
                    >
                        <p>تحميل الملف</p>
                        <FontAwesomeIcon icon={faDownload} />
                    </a>
                    <button className="justify-center rounded-full bg-[#f9dddb] px-4 h-3/4 font-medium text-[#d63231] hover:bg-opacity-90">
                        <FontAwesomeIcon icon={faTrashAlt} />
                    </button>
                </div>
            )}
            {!filePath && !showFile && (
                <div className="shadow-md px-4 py-2 w-full xl:w-1/2 rounded-md">
                    <p>لم يتم رفع الملف</p>
                </div>
            )}
        </div>
    );
}
