import React, { useState } from "react";
import ServicesSettingsTable from "../../../components/Tables/Services/ServicesSettingsTable";
import Breadcrumb from "../../../components/Breadcrumbs/Breadcrumb";
import DefaultLayout from "../../../layout/DefaultLayout";
import DeleteModal from "../../../components/Modals/DeleteModal";
import { Link, router } from "@inertiajs/react";
import toast from "react-hot-toast";
import TypesSettingsTable from "../../../components/Tables/Settings/AdvisoryServices/TypesSettingsTable";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faGear } from "@fortawesome/free-solid-svg-icons";
import ServicesCategoriesSettingsTable from "../../../components/Tables/Services/ServicesCategoriesSettingsTable";
import ReservationTypesSettingsTable from "../../../components/Tables/Settings/Reservations/ReservationTypesSettingsTable";
import AdvisoryServicesSubTableSettings from "../../../components/Tables/Settings/AdvisoryServices/AdvisoryServicesSubTableSettings";

const Products = ({
    services,
    categories,
    subCategories,
    reservationTypes,
}) => {
    const [deleteModalOpen, setDeleteModalOpen] = useState({
        state: false,
        id: null,
    });
    const servicesHeaders = [
        "#",
        "القسم الرئيسي",
        "اسم الخدمة",
        "حد السعر",
        "اسعار المستويات",
        "العمليات",
    ];
    services = services.map((service) => ({
        id: service.id,
        name: service.title,
        category: service.category,
        minPrice: service.min_price,
        maxPrice: service.max_price,
        isHidden: service.isHidden,
        prices: service.ymtaz_levels_prices,
    }));
    const typesHeaders = [
        "#",
        "الاسم",
        "التخصص العام",
        "المستويات",
        "العمليات",
    ];

    const reservationTypesHeaders = [
        "#",
        "نوع الموعد",
        "حد السعر",
        "اسعار المستويات",
        "العمليات",
    ];
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
    console.log(reservationTypes);
    return (
        <>
            <DefaultLayout>
                <Breadcrumb pageName="لوحة التخصيص" />
                <div className="flex flex-col gap-8">
                    <hr />
                    <div className="flex flex-col gap-4 ">
                        <HeaderGear
                            title="الخدمات"
                            link="/newAdmin/settings/products/services"
                        />
                        <ServicesSettingsTable
                            headers={servicesHeaders}
                            data={services}
                            categories={categories}
                            setDeleteModalOpen={setDeleteModalOpen}
                            compact={true}
                        />
                    </div>
                    <hr />
                    <div className="flex flex-col gap-4 ">
                        <HeaderGear
                            title="انواع الأستشارات"
                            link="/newAdmin/settings/products/advisory-services"
                        />
                        <AdvisoryServicesSubTableSettings
                            headers={typesHeaders}
                            data={subCategories}
                            setDeleteModalOpen={setDeleteModalOpen}
                            compact={true}
                        />
                    </div>
                    <hr />
                    <div className="flex flex-col gap-4 ">
                        <HeaderGear
                            title="انواع المواعيد"
                            link="/newAdmin/settings/reservations/types"
                        />
                        <ReservationTypesSettingsTable
                            headers={reservationTypesHeaders}
                            data={reservationTypes}
                            compact={true}
                        />
                    </div>
                </div>
            </DefaultLayout>
        </>
    );
};

export function HeaderGear({ title, link }) {
    return (
        <div
            className="flex w-full justify-between"
            style={{ direction: "rtl" }}
        >
            <p className="font-bold text-2xl">{title}</p>
            <Link href={link}>
                <FontAwesomeIcon icon={faGear} />
            </Link>
        </div>
    );
}
export default Products;
