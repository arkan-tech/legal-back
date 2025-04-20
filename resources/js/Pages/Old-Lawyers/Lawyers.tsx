import { router } from "@inertiajs/react";
import Breadcrumb from "../../components/Breadcrumbs/Breadcrumb";
import DeleteModal from "../../components/Modals/DeleteModal";
import LawyersTable from "../../components/Tables/LawyersTable";
import DefaultLayout from "../../layout/DefaultLayout";
import React, { useState } from "react";
import toast from "react-hot-toast";

const Lawyers = ({ lawyers, countries, cities, regions }) => {
    const headers = [
        "الاسم",
        "الايميل",
        "الموبايل",
        "مقدمة الدولة",
        "المنطقة",
        "الحالة",
        "تاريخ التسجيل",
        "العمليات",
    ];
    const [deleteModalOpen, setDeleteModalOpen] = useState({
        state: false,
        id: null,
    });
    lawyers = lawyers.map((lawyer) => ({
        id: lawyer.id,
        name: lawyer.name,
        email: lawyer.email,
        phone: lawyer.phone.replace(lawyer.phone_code, ""),
        phone_code: lawyer.phone_code,
        status: lawyer.accepted_text,
        statusCode: lawyer.accepted,
        country_id: lawyer.country_id,
        city_id: lawyer.city,
        region_id: lawyer.region,
        created_at: lawyer.created_at,
    }));
    return (
        <>
            <DeleteModal
                isOpen={deleteModalOpen.state}
                setIsOpen={setDeleteModalOpen}
                confirmAction={() => {
                    router.delete(
                        `/newAdmin/old-lawyers/${deleteModalOpen.id}`,
                        {
                            onSuccess: () => {
                                toast.success("تم حذف الملف");
                                router.get("/newAdmin/old-lawyers");
                            },
                            onError: () => {
                                toast.error("حدث خطأ");
                            },
                        }
                    );
                }}
                confirmationText={"هل انت متأكد من حذف هذا الملف؟"}
            />
            <DefaultLayout>
                <Breadcrumb pageName="مقدمي الخدمه القدامى" />

                <LawyersTable
                    headers={headers}
                    data={lawyers}
                    countries={countries}
                    cities={cities}
                    regions={regions}
                    setDeleteModalOpen={setDeleteModalOpen}
                    old={true}
                />
            </DefaultLayout>
        </>
    );
};

export default Lawyers;
