import React, { useState } from "react";
import ServicesCategoriesSettingsForm from "../../../../../components/Forms/Settings/Services/Categories/ServicesCategoriesSettingsForm";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import BaseSettingsForm from "../../../../../components/Forms/Settings/AdvisoryServices/BaseSettingsForm";
import PaymentCategoriesSettingsForm from "../../../../../components/Forms/Settings/AdvisoryServices/PaymentCategoriesSettingsForm";
import TypeSettingsForm from "../../../../../components/Forms/Settings/AdvisoryServices/TypeSettingsForm";

function TypeSettingsCreate({
    advisoryServices,
    importance,
    sections,
    baseCategories,
    paymentCategories,
}) {
    console.log(importance);
    const [errors, setErrors] = useState({});
    const [name, setName] = useState("");
    const [selectedAdvisoryService, setSelectedAdvisoryService] = useState("");
    const [minPrice, setMinPrice] = useState(0);
    const [maxPrice, setMaxPrice] = useState(0);
    const [prices, setPrices] = useState([]);
    const [selectedSections, setSelectedSections] = useState([]);

    const [selectedBaseCategory, setSelectedBaseCategory] = useState("");
    const [paymentCategory, setSelectedPaymentCategory] = useState("");
    const [availableImportance, setAvailableImportance] = useState(
        importance.map((i) => ({
            id: i.id,
            name: i.title,
        }))
    );
    advisoryServices = advisoryServices.map((as) => ({
        id: as.id,
        name: as.payment_category_type.name,
        payment_category_id: as.payment_category_id,
    }));
    async function saveData() {
        router.post(
            "/admin/advisory-services-types/store",
            {
                name,
                advisory_service: selectedAdvisoryService,
                min_price: minPrice,
                max_price: maxPrice,
                importance: prices,
                section_id: selectedSections,
            },
            {
                onError: (err) => {
                    console.log(err);
                    setErrors(err);
                },
            }
        );
    }
    return (
        <DefaultLayout>
            <Breadcrumb pageName="انشاء نوع الأستشارة" />
            <TypeSettingsForm
                errors={errors}
                saveData={saveData}
                advisoryServices={advisoryServices}
                maxPrice={maxPrice}
                minPrice={minPrice}
                setMaxPrice={setMaxPrice}
                setMinPrice={setMinPrice}
                prices={prices}
                setPrices={setPrices}
                selectedAdvisoryService={selectedAdvisoryService}
                setSelectedAdvisoryService={setSelectedAdvisoryService}
                typeName={name}
                setTypeName={setName}
                availableImportance={availableImportance}
                setAvailableImportance={setAvailableImportance}
                sections={sections}
                selectedOptions={selectedSections}
                setSelectedOptions={setSelectedSections}
                baseCategories={baseCategories}
                paymentCategories={paymentCategories}
                selectedBaseCategory={selectedBaseCategory}
                setSelectedBaseCategory={setSelectedBaseCategory}
                paymentCategory={paymentCategory}
                setSelectedPaymentCategory={setSelectedPaymentCategory}
            />
        </DefaultLayout>
    );
}

export default TypeSettingsCreate;
