import React, { useState } from "react";
import DefaultLayout from "../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import ServicesSettingsForm from "../../../../components/Forms/Settings/Services/ServicesSettingsForm";

function ServicesSettingsCreate({
    categories,
    sections,
    request_levels: reqLevels,
}) {
    const [errors, setErrors] = useState({});
    const [serviceName, setServiceName] = useState("");
    const [categoryId, setCategoryId] = useState("");
    const [about, setAbout] = useState("");
    const [minPrice, setMinPrice] = useState(null);
    const [maxPrice, setMaxPrice] = useState(null);
    const [image, setImage] = useState(null);
    const [requestLevels, setRequestLevels] = useState([]);
    const [selectedOptions, setSelectedOptions] = useState([]);
    const [request_levels, setRequest_Levels] = useState(reqLevels);
    const [need_appointment, setNeedAppointment] = useState(false);

    async function saveData() {
        router.post(
            "/admin/services/store",
            {
                name: serviceName,
                intro: about,
                min_price: minPrice,
                max_price: maxPrice,
                category_id: categoryId,
                section_id: selectedOptions,
                levels: requestLevels.map((rl) => {
                    return {
                        level_id: rl.id,
                        price: rl.price,
                        duration: rl.duration,
                    };
                }),
                need_appointment,
            },
            {
                onError: (res) => {
                    console.log(res);
                    setErrors(res);
                },
            }
        );
    }
    return (
        <DefaultLayout>
            <Breadcrumb pageName="انشاء مسمى الخدمة" />
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
            />
        </DefaultLayout>
    );
}

export default ServicesSettingsCreate;
