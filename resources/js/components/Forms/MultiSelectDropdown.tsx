import React, { useState } from "react";
import Select, { components } from "react-select";

const MultiSelectDropdown = ({
    options,
    selectedOptions,
    setSelectedOptions,
    disabled = false,
}) => {
    options = options.map((option) => {
        return {
            value: option.id,
            label: option?.title || option?.name,
        };
    });
    const handleChange = (selectedItems) => {
        setSelectedOptions(
            selectedItems.map((selectedItem) => selectedItem.value.toString())
        );
    };

    const customStyles = {
        control: (provided) => ({
            ...provided,
            border: "1px solid #ccc",
            borderRadius: "4px",
            minHeight: "36px",
            boxShadow: "none",
        }),
    };

    return (
        <Select
            options={options}
            value={options.filter((option) =>
                selectedOptions.includes(option.value.toString())
            )}
            onChange={handleChange}
            isMulti
            isDisabled={disabled}
            styles={customStyles}
            closeMenuOnSelect={false}
            classNamePrefix="react-select"
            className="react-select-container"
            components={{
                Option: ({ children, ...props }) => (
                    <components.Option {...props}>
                        <div>{children}</div>
                    </components.Option>
                ),
            }}
        />
    );
};

export default MultiSelectDropdown;
