import React, { useState } from "react";
import ServicesSettingsTable from "../../../../components/Tables/Services/ServicesSettingsTable";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import DefaultLayout from "../../../../layout/DefaultLayout";
import DeleteModal from "../../../../components/Modals/DeleteModal";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import TypesSettingsTable from "../../../../components/Tables/Settings/AdvisoryServices/TypesSettingsTable";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faGear } from "@fortawesome/free-solid-svg-icons";
import BaseTableSettings from "../../../../components/Tables/Settings/AdvisoryServices/BaseTableSettings";
import PaymentCategoriesSettingsTable from "../../../../components/Tables/Settings/AdvisoryServices/PaymentCategoriesSettingsTable";
import PaymentCategoriesTypesTable from "../../../../components/Tables/Settings/AdvisoryServices/PaymentCategoriesTypesTable";
import MainSettingsTable from "../../../../components/Tables/Settings/AdvisoryServices/MainSettingsTable";
import { HeaderGear } from "..";
import AdvisoryServicesMainTableSettings from "../../../../components/Tables/Settings/AdvisoryServices/AdvisoryServicesMainTableSettings";
import AdvisoryServicesSubTableSettings from "../../../../components/Tables/Settings/AdvisoryServices/AdvisoryServicesSubTableSettings";

const AdvisoryServicesProducts = ({
    generalCategories,
    subCategories,
    paymentCategoriesTypes,
}) => {
    const [deleteModalOpen, setDeleteModalOpen] = useState({
        state: false,
        id: null,
    });
    const paymentCategoryHeaders = ["#", "الاسم", "تحتاج لموعد", "العمليات"];

    const generalCategoriesHeaders = ["#", "الاسم", "الوسيلة", "العمليات"];
    const subHeaders = ["#", "الاسم", "التخصص العام", "المستويات", "العمليات"];

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
                <Breadcrumb pageName="لوحة التخصيص للاستشارات" />
                <div className="flex flex-col gap-8">
                    <hr />
                    <div className="flex flex-col gap-4 ">
                        <HeaderGear
                            title="انواع الوسائل"
                            link="/newAdmin/settings/advisory-services/payment-categories-types"
                        />
                        <PaymentCategoriesTypesTable
                            headers={paymentCategoryHeaders}
                            data={paymentCategoriesTypes}
                        />
                    </div>
                    <hr />
                    <div className="flex flex-col gap-4 ">
                        <HeaderGear
                            title="التخصصات العامة"
                            link="/newAdmin/settings/advisory-services/general-categories"
                        />
                        <AdvisoryServicesMainTableSettings
                            headers={generalCategoriesHeaders}
                            data={generalCategories}
                            setDeleteModalOpen={setDeleteModalOpen}
                        />
                    </div>
                    <hr />
                    <div className="flex flex-col gap-4 ">
                        <HeaderGear
                            title="التخصصات الدقيقة"
                            link="/newAdmin/settings/advisory-services/payment-categories-types"
                        />
                        <AdvisoryServicesSubTableSettings
                            headers={subHeaders}
                            data={subCategories}
                            setDeleteModalOpen={setDeleteModalOpen}
                        />
                    </div>
                    {/*<hr />
                    <div className="flex flex-col gap-4 ">
                        <HeaderGear
                            title="وسائل الأستشارات"
                            link="/newAdmin/settings/advisory-services"
                        />
                        <MainSettingsTable
                            headers={mainHeaders}
                            data={advisoryServices}
                            categories={paymentCategories}
                            setDeleteModalOpen={setDeleteModalOpen}
                            compact={true}
                        />
                    </div>

                    <hr />

                    <div className="flex flex-col gap-4 ">
                        <HeaderGear
                            title="انواع الأستشارات"
                            link="/newAdmin/settings/advisory-services"
                        />
                        <TypesSettingsTable
                            headers={typesHeaders}
                            data={types}
                            advisoryServices={advisoryServicesForTypes}
                            setDeleteModalOpen={setDeleteModalOpen}
                            compact={true}
                        />
                    </div> */}
                </div>
            </DefaultLayout>
        </>
    );
};
export default AdvisoryServicesProducts;
