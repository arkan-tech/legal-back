import React from "react";
export default function SuccessNotification({
    classNames,
    message,
}: {
    classNames?: string;
    message?: string;
}) {
    return (
        <div
            style={{
                direction: "rtl",
            }}
            className={`flex py-4 px-8 text-black rounded-md border border-green-500 bg-green-300 text-bold ${classNames}`}
        >
            {message ? message : "تم تعديل الملف بنجاح"}
        </div>
    );
}
