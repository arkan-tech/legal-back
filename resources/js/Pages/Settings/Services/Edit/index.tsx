import React, { useEffect, useRef, useState } from "react";
import DefaultLayout from "../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import ServicesSettingsForm from "../../../../components/Forms/Settings/Services/ServicesSettingsForm";
import SuccessNotification from "../../../../components/SuccessNotification";
import ErrorNotification from "../../../../components/ErrorNotification";

function ServicesSettingsEdit({
    service,
    categories,
    sections_ids,
    sections,
    request_levels: reqLevels,
}) {
    const [errors, setErrors] = useState({});
    const [serviceName, setServiceName] = useState(service.title);
    const [categoryId, setCategoryId] = useState(service.category_id);
    const [about, setAbout] = useState(service.intro);
    const [minPrice, setMinPrice] = useState(service.min_price);
    const [maxPrice, setMaxPrice] = useState(service.max_price);
    const [image, setImage] = useState(null);
    const [requestLevels, setRequestLevels] = useState([]);
    const [selectedOptions, setSelectedOptions] = useState([]);
    const [request_levels, setRequest_Levels] = useState(reqLevels);
    const [need_appointment, setNeedAppointment] = useState(
        service.need_appointment
    );
    const contentRef = useRef<HTMLDivElement>(null);

    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);
    useEffect(() => {
        setSelectedOptions(sections_ids.map((id) => id.toString()));
        setRequestLevels(
            service.ymtaz_levels_prices.map((level) => {
                return {
                    id: level.id,
                    name: level.level?.title,
                    price: level.price,
                    duration: level.duration,
                    levelId: level.level?.id,
                };
            })
        );
        const ids = service.ymtaz_levels_prices.map((ylp) => ylp.level?.id);
        const filteredLevels = request_levels.filter(
            (rl) => !ids.includes(rl.id)
        );
        setRequest_Levels(filteredLevels);
    }, []);
    async function saveData() {
        try {
            const res = await axios.post("/admin/services/update", {
                id: service.id,
                name: serviceName,
                intro: about,
                min_price: minPrice,
                max_price: maxPrice,
                category_id: categoryId,
                section_id: selectedOptions,
                levels: requestLevels.map((rl) => {
                    return {
                        level_id: rl.levelId,
                        price: rl.price,
                        duration: rl.duration,
                    };
                }),
                need_appointment,
            });
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
                <Breadcrumb pageName="تعديل مسمى الخدمة" />{" "}
                {isSuccess && <SuccessNotification classNames="my-2" />}
                {isError && <ErrorNotification classNames="my-2" />}
                <ServicesSettingsForm
                    errors={errors}
                    saveData={saveData}
                    serviceName={serviceName}
                    setServiceName={setServiceName}
                    categoryId={categoryId}
                    setCategoryId={setCategoryId}
                    about={about}
                    setAbout={setAbout}
                    minPrice={minPrice}
                    setMinPrice={setMinPrice}
                    maxPrice={maxPrice}
                    setMaxPrice={setMaxPrice}
                    image={image}
                    setImage={setImage}
                    categories={categories}
                    sections={sections}
                    selectedOptions={selectedOptions}
                    setSelectedOptions={setSelectedOptions}
                    requestLevels={requestLevels}
                    setRequestLevels={setRequestLevels}
                    request_levels={request_levels}
                    setRequest_Levels={setRequest_Levels}
                    needAppointment={need_appointment}
                    setNeedAppointment={setNeedAppointment}
                />{" "}
            </div>
        </DefaultLayout>
    );
}

export default ServicesSettingsEdit;
