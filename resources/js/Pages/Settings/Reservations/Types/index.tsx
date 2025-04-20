import React from "react";
import ReservationTypesSettingsTable from "../../../../components/Tables/Settings/Reservations/ReservationTypesSettingsTable";
import DefaultLayout from "../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";

const ReservationsTypes = ({ reservationTypes }) => {
    const headers = [
        "#",
        "نوع الموعد",
        "السعر الأدنى",
        "السعر الأقصى",
        "العمليات",
    ];
    console.log(reservationTypes);
    reservationTypes = reservationTypes.map((reservation) => ({
        id: reservation.id,
        name: reservation.name,
        minPrice: reservation.minPrice,
        maxPrice: reservation.maxPrice,
        isHidden: reservation.isHidden,
        prices: reservation.types_importance.map((price) => ({
            price: price.price,
            title: price.reservation_importance.name,
        })),
    }));
    return (
        <DefaultLayout>
            <Breadcrumb pageName="اعدادات انواع المواعيد" />
            <ReservationTypesSettingsTable
                headers={headers}
                data={reservationTypes}
            />
        </DefaultLayout>
    );
};

export default ReservationsTypes;
