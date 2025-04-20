import React, { useState } from "react";
import { router } from "@inertiajs/react";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import AdvisoryServicesSubSettingsForm from "../../../../../components/Forms/Settings/AdvisoryServices/AdvisoryServicesSubSettingsForm";

function AdvisoryServicesSubSettingsCreate({
    generalCategories,
    importances,
    paymentCategoryTypes,
}) {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState("");
    const [description, setDescription] = useState("");
    const [generalCategoryId, setGeneralCategoryId] = useState("");
    const [prices, setPrices] = useState([
        { duration: "", importance_id: "", price: 0 },
    ]);
    const [minPrice, setMinPrice] = useState(0);
    const [maxPrice, setMaxPrice] = useState(0);
    const [selectedPaymentCategoryType, setSelectedPaymentCategoryType] =
        useState("");
    async function saveData() {
        const filteredPrices = prices.filter((price) => price.importance_id);
        router.post(
            "/newAdmin/settings/advisory-services/sub-categories/store",
            {
                name,
                description,
                general_category_id: generalCategoryId,
                prices: filteredPrices,
                min_price: minPrice,
                max_price: maxPrice,
            },
            {
                onError: (err) => {
                    setErrors(err);
                },
            }
        );
    }

    return (
        <DefaultLayout>
            <Breadcrumb pageName="اضافة تخصص دقيق للأستشارات" />
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

export default AdvisoryServicesSubSettingsCreate;
