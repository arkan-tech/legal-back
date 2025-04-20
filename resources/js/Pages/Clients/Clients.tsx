import Breadcrumb from "../../components/Breadcrumbs/Breadcrumb";
import TableOne from "../../components/Tables/TableOne";
import ClientsTable from "../../components/Tables/ClientsTable";
import TableTwo from "../../components/Tables/TableTwo";
import DefaultLayout from "../../layout/DefaultLayout";
import React, { useState } from "react";
import toast from "react-hot-toast";
import DeleteModal from "../../components/Modals/DeleteModal";
import { router } from "@inertiajs/react";

const Clients = ({ clients }) => {
    const headers = [
        "الاسم",
        "الايميل",
        // "المنطقة",
        "الموبايل",
        // "الصفة",
        "الحالة",
        "تاريخ التسجيل",
        "حساب قديم",
        "مستكمل حسابه",
        "العمليات",
    ];

    clients = clients
        .filter((c) => c.id != 1749)
        .map((client) => ({
            id: client.id,
            name: client.name,
            email: client.email,
            country_name: client.country?.name || "-",
            region_name: client.region?.name || "-",
            phone: client.phone,
            phone_code: client.phone_code,
            type: client.type_text,
            status: client.accepted_text,
            statusCode: client.status,
            created_at: client.created_at,
            is_old_user: client.is_old_user,
            profile_complete: client.profile_complete,
        }));
    const [deleteModalOpen, setDeleteModalOpen] = useState({
        state: false,
        id: null,
    });
    return (
        <>
            <DeleteModal
                isOpen={deleteModalOpen.state}
                setIsOpen={setDeleteModalOpen}
                confirmAction={() => {
                    router.get(
                        `/admin/clients/delete/${deleteModalOpen.id}`,
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
                <Breadcrumb pageName="طالب الخدمة" />

                <ClientsTable
                    headers={headers}
                    data={clients}
                    setDeleteModalOpen={setDeleteModalOpen}
                />
            </DefaultLayout>
        </>
    );
};

export default Clients;
