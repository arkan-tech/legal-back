import React, { useRef, useState } from "react";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import axios from "axios";
import SuccessNotification from "../../../../../components/SuccessNotification";
import ErrorNotification from "../../../../../components/ErrorNotification";
import AdvisoryServicesSubSettingsForm from "../../../../../components/Forms/Settings/AdvisoryServices/AdvisoryServicesSubSettingsForm";

function AdvisoryServicesSubSettingsEdit({
    subCategory,
    generalCategories,
    importances,
    paymentCategoryTypes,
}) {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState(subCategory.name || "");
    const [description, setDescription] = useState(
        subCategory.description || ""
    );
    const [generalCategoryId, setGeneralCategoryId] = useState(
        subCategory.general_category_id || ""
    );
    const [prices, setPrices] = useState(
        subCategory.prices.map((price) => ({
            duration: price.duration,
            importance_id: price.importance_id,
            price: price.price,
        })) || [{ duration: "", importance_id: "", price: 0 }]
    );
    const [selectedPaymentCategoryType, setSelectedPaymentCategoryType] =
        useState(subCategory.general_category.payment_category_type_id || "");
    const contentRef = useRef<HTMLDivElement>(null);

    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);
    const [minPrice, setMinPrice] = useState(subCategory.min_price || 0);
    const [maxPrice, setMaxPrice] = useState(subCategory.max_price || 0);
    async function saveData() {
        const filteredPrices = prices.filter((price) => price.importance_id);
        try {
            const res = await axios.post(
                `/newAdmin/settings/advisory-services/sub-categories/${subCategory.id}/update`,
                {
                    name,
                    description,
                    general_category_id: generalCategoryId,
                    prices: filteredPrices,
                    min_price: minPrice,
                    max_price: maxPrice,
                }
            );
            if (res.status == 200) {
                setIsSuccess(true);
                contentRef.current?.scroll({ top: 0, behavior: "smooth" });
            }
        } catch (err) {
            setIsError(true);
            contentRef.current?.scroll({ top: 0, behavior: "smooth" });
            return setErrors(err.response.data.errors);
        }
    }

    return (
        <DefaultLayout ref={contentRef}>
            <Breadcrumb pageName="تعديل تخصص دقيق للأستشارات" />
            {isSuccess && <SuccessNotification classNames="my-2" />}
            {isError && <ErrorNotification classNames="my-2" />}
            <AdvisoryServicesSubSettingsForm
                errors={errors}
                saveData={saveData}
                name={name}
                setName={setName}
                description={description}
                setDescription={setDescription}
                generalCategoryId={generalCategoryId}
                setGeneralCategoryId={setGeneralCategoryId}
                generalCategories={generalCategories}
                prices={prices}
                setPrices={setPrices}
                importances={importances}
                paymentCategoryTypes={paymentCategoryTypes}
                selectedPaymentCategoryType={selectedPaymentCategoryType}
                setSelectedPaymentCategoryType={setSelectedPaymentCategoryType}
                minPrice={minPrice}
                setMinPrice={setMinPrice}
                maxPrice={maxPrice}
                setMaxPrice={setMaxPrice}
            />
        </DefaultLayout>
    );
}

export default AdvisoryServicesSubSettingsEdit;
