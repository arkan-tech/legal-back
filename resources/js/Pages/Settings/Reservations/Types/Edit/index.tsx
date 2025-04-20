import React, { useEffect, useRef, useState } from "react";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import ReservationsTypesForm from "../../../../../components/Forms/Settings/Reservations/ReservationsTypesForm";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import SuccessNotification from "../../../../../components/SuccessNotification";
import ErrorNotification from "../../../../../components/ErrorNotification";

function ReservationsTypesSettingsEdit({
    reservationType,
    reservationImportances,
}) {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState(reservationType.name);
    const [minPrice, setMinPrice] = useState(reservationType.minPrice);
    const [maxPrice, setMaxPrice] = useState(reservationType.maxPrice);
    const [prices, setPrices] = useState([]);
    const [availableImportance, setAvailableImportances] = useState(
        reservationImportances
    );
    useEffect(() => {
        setPrices(
            reservationType.types_importance.map((level) => {
                return {
                    id: level.reservation_importance.id,
                    name: level.reservation_importance.name,
                    price: level.price,
                };
            })
        );
        const ids = reservationType.types_importance.map(
            (ti) => ti.reservation_importance?.id
        );
        const filteredLevels = availableImportance.filter(
            (rl) => !ids.includes(rl.id)
        );
        setAvailableImportances(filteredLevels);
    }, []);
    const contentRef = useRef<HTMLDivElement>(null);

    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);
    async function saveData() {
        try {
            const res = await axios.post(
                `/newAdmin/settings/reservations/types/${reservationType.id}/update`,
                {
                    name,
                    minPrice,
                    maxPrice,
                    prices,
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
                <Breadcrumb pageName="تعديل نوع الموعد" />
                {isSuccess && <SuccessNotification classNames="my-2" />}
                {isError && <ErrorNotification classNames="my-2" />}
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
                />{" "}
            </div>
        </DefaultLayout>
    );
}

export default ReservationsTypesSettingsEdit;
