import React from "react";
import ReservationTypesSettingsTable from "../../../../components/Tables/Settings/Reservations/ReservationTypesSettingsTable";
import DefaultLayout from "../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import AvailableReservationsSettingsTable from "../../../../components/Tables/Settings/Reservations/AvailableReservationsSettingsTable";

const AvailableReservations = ({ availableReservations }) => {
    console.log(availableReservations);
    const headers = [
        "#",
        "نوع الموعد",
        "سعر الموعد",
        "مستوى الموعد",
        "اليوم",
        "من",
        "الى",
        // "العمليات",
    ];
    availableReservations = availableReservations.map((reservation) => ({
        id: reservation.id,
        name: reservation.reservation_type_importance.reservation_type.name,
        type: reservation.reservation_type_importance.reservation_importance
            .name,
        price: reservation.reservation_type_importance.price,
        day: reservation.available_date_time.day,
        from: reservation.available_date_time.from,
        to: reservation.available_date_time.to,
    }));
    return (
        <DefaultLayout>
            <Breadcrumb pageName="اعدادات المواعيد المتاحة" />
            <AvailableReservationsSettingsTable
                headers={headers}
                data={availableReservations}
            />
        </DefaultLayout>
    );
};

export default AvailableReservations;
