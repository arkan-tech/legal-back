import React from "react";
export default function ErrorNotification({
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
            className={`flex py-4 px-8 text-black rounded-md border border-red-500 bg-red-300 text-bold ${classNames}`}
        >
            {message ? message : "لقد حدث خطأ في الحفظ"}
        </div>
    );
}
