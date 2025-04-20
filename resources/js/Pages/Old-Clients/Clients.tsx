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
        "#",
        "الاسم",
        "الايميل",
        "الدولة",
        "المنطقة",
        "الموبايل",
        "الصفة",
        "الحالة",
        "تاريخ التسجيل",
        "العمليات",
    ];

    clients = clients
        .filter((c) => c.id != 1749)
        .map((client) => ({
            id: client.id,
            name: client.myname,
            email: client.email,
            country_name: client.country?.name || "-",
            region_name: client.region?.name || "-",
            phone: client.mobil.replace(client.phone_code, ""),
            phone_code: client.phone_code,
            type: client.type_text,
            status: client.accepted_text,
            statusCode: client.accepted,
            created_at: client.created_at,
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
                        `/admin/clients/delete-old/${deleteModalOpen.id}`,
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
                    old={true}
                />
            </DefaultLayout>
        </>
    );
};

export default Clients;
