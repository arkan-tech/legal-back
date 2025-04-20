import React, { useEffect, useState } from "react";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import ReservationsTypesForm from "../../../../../components/Forms/Settings/Reservations/ReservationsTypesForm";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";

function ReservationsTypesSettingsEdit({ reservationImportances }) {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState();
    const [minPrice, setMinPrice] = useState();
    const [maxPrice, setMaxPrice] = useState();
    const [prices, setPrices] = useState([]);
    const [availableImportance, setAvailableImportances] = useState([]);
    useEffect(() => {
        setAvailableImportances(reservationImportances);
    }, []);
    async function saveData() {
        router.post(
            "/newAdmin/settings/reservations/types/create",
            {
                name,
                minPrice,
                maxPrice,
                prices,
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
            <Breadcrumb pageName="انشاء نوع موعد" />
            <ReservationsTypesForm
                errors={errors}
                saveData={saveData}
                name={name}
                setName={setName}
                minPrice={minPrice}
                setMinPrice={setMinPrice}
                maxPrice={maxPrice}
                setMaxPrice={setMaxPrice}
                availableImportances={availableImportance}
                setAvailableImportances={setAvailableImportances}
                prices={prices}
                setPrices={setPrices}
            />
        </DefaultLayout>
    );
}

export default ReservationsTypesSettingsEdit;
