import React from "react";
export default function ({ saveData }) {
    return (
        <button
            onClick={saveData}
            className="flex w-full justify-center rounded-xl bg-[#ddb662] py-4 font-medium text-gray hover:bg-opacity-90"
        >
            حفظ الملف
        </button>
    );
}
