import React from "react";
import TextInput from "../../../TextInput";
import SaveButton from "../../../SaveButton";
import BackButton from "../../../BackButton";
import SelectGroup from "../../SelectGroup/SelectGroup";

function AdvisoryServicesSubSettingsForm({
    saveData,
    errors,
    name,
    setName,
    description,
    setDescription,
    generalCategoryId,
    setGeneralCategoryId,
    generalCategories,
    prices,
    setPrices,
    importances,
    paymentCategoryTypes,
    selectedPaymentCategoryType,
    setSelectedPaymentCategoryType,
    minPrice,
    setMinPrice,
    maxPrice,
    setMaxPrice,
}) {
    const addPrice = () => {
        setPrices([...prices, { duration: "", importance_id: "", price: 0 }]);
    };

    const removePrice = (index) => {
        const newPrices = prices.filter((_, i) => i !== index);
        setPrices(newPrices);
    };

    const updatePrice = (index, field, value) => {
        const newPrices = prices.map((price, i) =>
            i === index ? { ...price, [field]: value } : price
        );
        setPrices(newPrices);
    };

    // Compute selected importance IDs
    const selectedImportanceIds = prices.map((p) => p.importance_id.toString());

    // Compute remaining importances
    const remainingImportances = importances.filter(
        (importance) =>
            !selectedImportanceIds.includes(importance.id.toString())
    );

    // Determine if the last price entry is filled
    const lastPrice = prices[prices.length - 1];
    const isLastPriceFilled = lastPrice.duration && lastPrice.importance_id;

    return (
        <div className="grid grid-cols-1 gap-9" style={{ direction: "rtl" }}>
            <div className="flex flex-col gap-9">
                <div className="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div className="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                        <h3 className="font-medium text-black dark:text-white">
                            فئة فرعية
                        </h3>
                    </div>
                    <div className="p-6.5">
                        <div className="mb-4.5">
                            <SelectGroup
                                title="الوسيلة"
                                options={paymentCategoryTypes}
                                selectedOption={selectedPaymentCategoryType}
                                setSelectedOption={
                                    setSelectedPaymentCategoryType
                                }
                            />
                        </div>
                        <div className="mb-4.5">
                            <SelectGroup
                                title="التخصص العام"
                                options={generalCategories.filter(
                                    (g) =>
                                        g.payment_category_type_id ==
                                        selectedPaymentCategoryType
                                )}
                                selectedOption={generalCategoryId}
                                setSelectedOption={setGeneralCategoryId}
                            />
                            {errors.general_category_id && (
                                <p className="text-red-600">
                                    {errors.general_category_id}
                                </p>
                            )}
                        </div>
                        <div className="mb-4.5">
                            <TextInput
                                label="الاسم"
                                type="text"
                                value={name}
                                setValue={setName}
                                error={errors.name}
                                required={true}
                            />
                        </div>
                        <div className="mb-4.5">
                            <TextInput
                                label="شرح الفئة الفرعية"
                                type="textarea"
                                value={description}
                                setValue={setDescription}
                                error={errors.description}
                                required={false}
                            />
                        </div>
                        <div className="mb-4.5">
                            <TextInput
                                label="السعر الأدنى"
                                type="number"
                                value={minPrice}
                                setValue={setMinPrice}
                                error={errors.min_price}
                                required={true}
                            />
                        </div>
                        <div className="mb-4.5">
                            <TextInput
                                label="السعر الأقصى"
                                type="number"
                                value={maxPrice}
                                setValue={setMaxPrice}
                                error={errors.max_price}
                                required={true}
                            />
                        </div>
                        <div className="mb-4.5">
                            <h4>الأسعار</h4>
                            {prices.map((price, index) => {
                                // Get importance_ids selected in other prices
                                const selectedImportanceIds = prices
                                    .filter((_, i) => i !== index)
                                    .map((p) => p.importance_id.toString());
                                // Available importances for this price
                                const availableImportances = importances.filter(
                                    (importance) =>
                                        !selectedImportanceIds.includes(
                                            importance.id.toString()
                                        )
                                );

                                return (
                                    <div
                                        key={index}
                                        className="flex gap-4 mb-2"
                                    >
                                        <div className="w-1/4">
                                            <SelectGroup
                                                title="مستوى الأهمية"
                                                options={availableImportances}
                                                selectedOption={
                                                    price.importance_id
                                                }
                                                setSelectedOption={(value) =>
                                                    updatePrice(
                                                        index,
                                                        "importance_id",
                                                        value
                                                    )
                                                }
                                            />
                                            {errors[
                                                `prices.${index}.importance_id`
                                            ] && (
                                                <p className="text-red-600">
                                                    {
                                                        errors[
                                                            `prices.${index}.importance_id`
                                                        ]
                                                    }
                                                </p>
                                            )}
                                        </div>
                                        <div className="w-1/4">
                                            <TextInput
                                                label="مدة الرد (بالساعات)"
                                                type="number"
                                                value={price.duration}
                                                setValue={(value) =>
                                                    updatePrice(
                                                        index,
                                                        "duration",
                                                        value
                                                    )
                                                }
                                                error={
                                                    errors[
                                                        `prices.${index}.duration`
                                                    ]
                                                }
                                                required={true}
                                            />
                                        </div>
                                        <div className="w-1/4">
                                            <TextInput
                                                label="السعر"
                                                type="number"
                                                value={price.price}
                                                setValue={(value) =>
                                                    updatePrice(
                                                        index,
                                                        "price",
                                                        value
                                                    )
                                                }
                                                error={
                                                    errors[
                                                        `prices.${index}.price`
                                                    ]
                                                }
                                                required={true}
                                            />
                                        </div>
                                        <button
                                            type="button"
                                            onClick={() => removePrice(index)}
                                            className="mt-6 text-red-600"
                                        >
                                            حذف
                                        </button>
                                    </div>
                                );
                            })}

                            {/* Conditionally render the add button */}
                            {remainingImportances.length > 0 && (
                                <button
                                    type="button"
                                    onClick={addPrice}
                                    disabled={!isLastPriceFilled}
                                    className="mt-2 px-4 py-2 bg-green-500 disabled:bg-[#bababa] text-white rounded-md"
                                >
                                    إضافة سعر
                                </button>
                            )}
                        </div>
                    </div>
                </div>
            </div>
            <div className="flex gap-6">
                <SaveButton saveData={saveData} />
                <BackButton path="/newAdmin/settings/advisory-services/sub-categories" />
            </div>
        </div>
    );
}

export default AdvisoryServicesSubSettingsForm;
