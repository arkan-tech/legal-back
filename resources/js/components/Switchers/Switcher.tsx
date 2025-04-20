import { useState } from "react";
import React from "react";
const Switcher = ({
    enabled,
    setEnabled,
    handleToggle,
    id,
}: {
    enabled;
    setEnabled?;
    handleToggle?;
    id;
}) => {
    return (
        <div>
            <label
                htmlFor={id}
                className="flex cursor-pointer select-none items-center"
            >
                <div className="relative">
                    <input
                        type="checkbox"
                        id={id}
                        name={id}
                        className="sr-only"
                        value={enabled}
                        onChange={() => {
                            setEnabled
                                ? setEnabled(!enabled)
                                : handleToggle(id);
                        }}
                    />
                    <div
                        className={`block h-5 w-10 rounded-full bg-meta-9 dark:bg-[#5A616B] ${
                            enabled && "!bg-[#ddb662]"
                        }`}
                    ></div>
                    <div
                        className={`absolute left-1 top-1 h-3 w-3 rounded-full bg-white transition ${
                            enabled && "!right-4 !translate-x-full !bg-white"
                        }`}
                    ></div>
                </div>
            </label>
        </div>
    );
};

export default Switcher;
