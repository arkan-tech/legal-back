import React from "react";
export default function ({
    value,
    setValue,
    label,
    placeholder = "",
    error = null,
    type = "text",
    required = false,
    disabled = false,
    onInput,
    rows = 5,
    labelDirection = "horizontal",
}: {
    value: string;
    setValue?: (value: string) => void;
    label: string;
    placeholder?: string;
    error?: string | null;
    type?: string;
    required?: boolean;
    disabled?: boolean;
    rows?: number;
    onInput?: (e: React.ChangeEvent<HTMLInputElement>) => void;
    labelDirection?: "vertical" | "horizontal";
}) {
    return (
        <div
            className={`${
                labelDirection == "vertical"
                    ? "flex flex-col w-full"
                    : "flex flex-row w-full"
            } gap-4`}
        >
            <label className="mb-2.5 block text-[#bababa] dark:text-white">
                {label}
                {required && <span className="text-meta-1">*</span>}
            </label>
            {type === "textarea" ? (
                <>
                    <textarea
                        className={`w-full p-2.5 text-black dark:text-white border-[1.5px]
                    border-stroke rounded-lg outline-none transition focus:border-primary
                    active:border-primary disabled:cursor-default disabled:active:border-whiter
                    dark:bg-form-input
                    `}
                        placeholder={placeholder}
                        value={value}
                        onChange={(e) =>
                            setValue ? setValue(e.target.value) : null
                        }
                        rows={rows}
                        disabled={disabled}
                    />
                    {error && <p className="text-red-500">{error}</p>}
                </>
            ) : (
                <>
                    <input
                        type={type}
                        placeholder={placeholder}
                        disabled={disabled}
                        className="w-full rounded-lg border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default  disabled:active:border-whiter disabled:bg-white disabled:text-[#bababa] dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                        value={value}
                        onChange={(e) =>
                            setValue ? setValue(e.target.value) : null
                        }
                        onInput={onInput}
                        min={0}
                    />
                    {error && <p className="text-red-500">{error}</p>}
                </>
            )}
        </div>
    );
}
