import { router } from "@inertiajs/react";
import React from "react";
export default function ({ path }) {
    return (
        <button
            onClick={() => router.get(path)}
            className="flex w-full justify-center rounded-xl bg-[#e4e4e4] py-4 font-medium text-[#a5a4a4] hover:bg-opacity-90"
        >
            الرجوع للقائمة
        </button>
    );
}
