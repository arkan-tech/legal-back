import { router } from "@inertiajs/react";
import Breadcrumb from "../../components/Breadcrumbs/Breadcrumb";
import DeleteModal from "../../components/Modals/DeleteModal";
import LawyersTable from "../../components/Tables/LawyersTable";
import DefaultLayout from "../../layout/DefaultLayout";
import React, { useState } from "react";
import toast from "react-hot-toast";

const Lawyers = ({ lawyers, countries, cities, regions }) => {
    const headers = [
        // "#",
        "الاسم",
        "الايميل",
        "الموبايل",
        "مقدمة الدولة",
        // "الدولة",
        "المنطقة",
        "الحالة",
        "تاريخ التسجيل",
        "حساب قديم",
        "مستكمل حسابه",
        "العمليات",
    ];
    console.log(lawyers);
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
        statusCode: lawyer.status,
        country_id: lawyer.country_id,
        city_id: lawyer.city_id,
        region_id: lawyer.region_id,
        created_at: lawyer.created_at,
        is_old_user: lawyer.is_old_user,
        profile_complete: lawyer.profile_complete,
    }));
    console.log(lawyers);
    return (
        <>
            <DeleteModal
                isOpen={deleteModalOpen.state}
                setIsOpen={setDeleteModalOpen}
                confirmAction={() => {
                    router.get(
                        `/admin/digital-guide/delete/${deleteModalOpen.id}`,
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
                confirmationText={"هل انت متأكد من حذف هذا الملف؟"}
            />
            <DefaultLayout>
                <Breadcrumb pageName="مقدمي الخدمه" />

                <LawyersTable
                    headers={headers}
                    data={lawyers}
                    countries={countries}
                    cities={cities}
                    regions={regions}
                    setDeleteModalOpen={setDeleteModalOpen}
                />
            </DefaultLayout>
        </>
    );
};

export default Lawyers;
