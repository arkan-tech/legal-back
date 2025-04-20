import React, { useEffect, useState } from "react";
import Select, { StylesConfig } from "react-select";
const SelectGroup = ({
    options,
    title,
    selectedOption,
    setSelectedOption,
    firstOptionName = "اختر من القائمة",
    firstOptionDisabled = true,
    disabled = false,
    error,
}: {
    options: { id: number | string; name?: string; title?: string }[];
    title: string;
    selectedOption: string;
    setSelectedOption;
    firstOptionName?: string;
    firstOptionDisabled?: boolean;
    disabled?: boolean;
    error?: string;
}) => {
    const allOptions: {
        label: string;
        value: string;
        disabled: boolean;
    }[] = [];
    allOptions.unshift({
        label: firstOptionName,
        value: "",
        disabled: firstOptionDisabled,
    });
    options.forEach((option) => {
        allOptions.push({
            label: (option.name as string) || (option.title as string),
            value: option.id.toString(),
            disabled: false,
        });
    });

    const customStyles: StylesConfig = {
        control: (provided, state) => ({
            ...provided,
            border: error ? "1.5px solid #ef4444" : "1.5px solid #e2e8f0",
            borderRadius: "0.5rem",
            minHeight: "36px",
            boxShadow: "none",
            paddingTop: "5px",
            paddingBottom: "5px",
            outline: "none",
            backgroundColor: state.isFocused ? "#fff" : "transparent",
            borderColor: error
                ? "#ef4444"
                : state.isFocused
                ? "#007bff"
                : "#e2e8f0",
            "&:hover": {
                borderColor: error ? "#ef4444" : "#007bff",
            },
            ".dark &": {
                backgroundColor: state.isFocused ? "#1d2a39" : "transparent",
                borderColor: error
                    ? "#ef4444"
                    : state.isFocused
                    ? "#007bff"
                    : "#555",
                "&:hover": {
                    borderColor: error ? "#ef4444" : "#007bff",
                },
            },
        }),
        menu: (provided) => ({
            ...provided,
            backgroundColor: "#fff",
            ".dark &": {
                backgroundColor: "#1d2a39",
            },
        }),
        singleValue: (provided) => ({
            ...provided,
            color: "#bababa",
            ".dark &": {
                color: "#fff",
            },
        }),
        option: (provided, state) => ({
            ...provided,
            backgroundColor: state.isSelected ? "#007bff" : "#fff",
            color: state.isSelected ? "#fff" : "#000",
            "&:hover": {
                backgroundColor: "#007bff",
                color: "#fff",
            },
            ".dark &": {
                backgroundColor: state.isSelected ? "#007bff" : "#1d2a39",
                color: state.isSelected ? "#fff" : "#fff",
                "&:hover": {
                    backgroundColor: "#007bff",
                    color: "#fff",
                },
            },
        }),
    };

    return (
        <div className="mb-4.5" style={{ direction: "rtl" }}>
            <label className="mb-2.5 block text-[#bababa] dark:text-white">
                {title}
            </label>

            <div className="relative bg-transparent dark:bg-form-input">
                <Select
                    options={allOptions}
                    isOptionDisabled={(option: any) => option.disabled}
                    styles={customStyles}
                    value={allOptions.find(
                        (option) =>
                            option.value === (selectedOption?.toString() || "")
                    )}
                    isDisabled={disabled}
                    onChange={(e: any) => {
                        setSelectedOption(e?.value);
                    }}
                    className="relative w-full appearance-none rounded-lg border border-stroke bg-transparent outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                />
                {error && <p className="text-danger mt-2">{error}</p>}
            </div>
        </div>
    );
};

export default SelectGroup;
