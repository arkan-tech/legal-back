import React from "react";

export function ProductRequestStatus({ status, statusText }) {
    return (
        <span
            className={`flex rounded-full justify-center items-center py-1 px-3 text-sm font-medium ${
                status == 1
                    ? "bg-sky-500 text-white"
                    : status == 2
                    ? "bg-yellow-500 text-white"
                    : status == 3
                    ? "bg-orange-500 text-white"
                    : status == 4
                    ? "bg-red-500 text-white"
                    : "bg-green-500 text-white"
            }`}
        >
            {statusText}
        </span>
    );
}
