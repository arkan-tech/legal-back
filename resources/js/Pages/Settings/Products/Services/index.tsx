import React, { useState } from "react";
import ServicesSettingsTable from "../../../../components/Tables/Services/ServicesSettingsTable";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import DefaultLayout from "../../../../layout/DefaultLayout";
import DeleteModal from "../../../../components/Modals/DeleteModal";
import { Link, router } from "@inertiajs/react";
import toast from "react-hot-toast";
import TypesSettingsTable from "../../../../components/Tables/Settings/AdvisoryServices/TypesSettingsTable";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faGear } from "@fortawesome/free-solid-svg-icons";
import { HeaderGear } from "..";
import ServicesCategoriesSettingsTable from "../../../../components/Tables/Services/ServicesCategoriesSettingsTable";

const ServicesProducts = ({ services, categories }) => {
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

    const serviceCategoriesHeaders = ["#", "الاسم", "العمليات"];
    categories = categories.map((service) => ({
        id: service.id,
        name: service.name,
    }));
    return (
        <>
            <DeleteModal
                isOpen={deleteModalOpen.state}
                setIsOpen={setDeleteModalOpen}
                confirmAction={() => {
                    router.get(
                        `/admin/services/delete/${deleteModalOpen.id}`,
                        {},
                        {
                            onSuccess: () => {
                                toast.success("تم حذف الملف");
                            },
                            onError: () => {
                                toast.error("حدث خطأ");
                            },
                        }
                    );
                }}
                confirmationText={"عند حذف مسمى الخدمة, سيتم حذف كل ملحقاتها"}
            />
            <DefaultLayout>
                <Breadcrumb pageName="لوحة التخصيص للخدمات" />
                <div className="flex flex-col gap-8">
                    <hr />
                    <div className="flex flex-col gap-4 ">
                        <HeaderGear
                            title="اقسام الخدمات"
                            link="/newAdmin/services/categories"
                        />
                        <ServicesCategoriesSettingsTable
                            headers={serviceCategoriesHeaders}
                            data={categories}
                            setDeleteModalOpen={setDeleteModalOpen}
                            compact={true}
                        />
                    </div>
                    <hr />
                    <div className="flex flex-col gap-4 ">
                        <HeaderGear
                            title="مسميات الخدمات"
                            link="/newAdmin/services"
                        />
                        <ServicesSettingsTable
                            headers={servicesHeaders}
                            data={services}
                            categories={categories}
                            setDeleteModalOpen={setDeleteModalOpen}
                            compact={true}
                        />
                    </div>
                </div>
            </DefaultLayout>
        </>
    );
};

export default ServicesProducts;
