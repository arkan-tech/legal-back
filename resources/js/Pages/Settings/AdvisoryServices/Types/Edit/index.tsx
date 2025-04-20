import React, { useEffect, useRef, useState } from "react";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import toast from "react-hot-toast";
import axios from "axios";
import TypeSettingsForm from "../../../../../components/Forms/Settings/AdvisoryServices/TypeSettingsForm";
import ErrorNotification from "../../../../../components/ErrorNotification";
import SuccessNotification from "../../../../../components/SuccessNotification";

function TypesSettingsEdit({
    type,
    advisoryServices,
    importance,
    sections,
    baseCategories,
    paymentCategories,
}) {
    console.log(type);
    const [errors, setErrors] = useState({});
    const [name, setName] = useState(type.title);
    const [selectedAdvisoryService, setSelectedAdvisoryService] = useState(
        type.advisory_service_id
    );
    const [minPrice, setMinPrice] = useState(type.min_price);
    const [maxPrice, setMaxPrice] = useState(type.max_price);
    const [prices, setPrices] = useState(
        type.advisory_services_prices.map((advisoryServicePrice) => ({
            id: advisoryServicePrice.importance.id,
            name: advisoryServicePrice.importance.title,
            price: advisoryServicePrice.price,
        }))
    );
    const [availableImportance, setAvailableImportance] = useState(
        importance.map((i) => ({
            id: i.id,
            name: i.title,
        }))
    );
    const [selectedSections, setSelectedSections] = useState(
        type.lawyer_sections.map((ls) => ls.id)
    );
    const [selectedBaseCategory, setSelectedBaseCategory] = useState(
        type.advisory_service.payment_category.advisory_services_base.id
    );
    const [paymentCategory, setSelectedPaymentCategory] = useState(
        type.advisory_service.payment_category.id
    );
    advisoryServices = advisoryServices.map((as) => ({
        id: as.id,
        name: as.payment_category_type.name,
        payment_category_id: as.payment_category_id,
    }));
    useEffect(() => {
        setAvailableImportance(
            availableImportance.filter(
                (importance) =>
                    !prices.some((price) => price.id == importance.id)
            )
        );
    }, []);
    const contentRef = useRef<HTMLDivElement>(null);

    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);

    async function saveData() {
        try {
            const res = await axios.post(
                `/admin/advisory-services-types/update`,
                {
                    id: type.id,
                    name: name,
                    advisory_service: selectedAdvisoryService,
                    min_price: minPrice,
                    max_price: maxPrice,
                    importance: prices,
                    section_id: selectedSections,
                }
            );
            if (res.status == 200) {
                setIsSuccess(true);
                contentRef.current?.scrollIntoView({ behavior: "smooth" });
            }
        } catch (err) {
            setIsError(true);
            contentRef.current?.scrollIntoView({ behavior: "smooth" });
            return setErrors(err.response.data.errors);
        }
    }
    return (
        <DefaultLayout>
            {" "}
            <div ref={contentRef}>
                <Breadcrumb pageName="تعديل نوع الأستشارة" />{" "}
                {isSuccess && <SuccessNotification classNames="my-2" />}
                {isError && <ErrorNotification classNames="my-2" />}
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
            </div>
        </DefaultLayout>
    );
}

export default TypesSettingsEdit;
