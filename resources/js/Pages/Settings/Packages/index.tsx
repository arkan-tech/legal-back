import React, { useState } from "react";

import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import DeleteModal from "../../../components/Modals/DeleteModal";
import DefaultLayout from "../../../layout/DefaultLayout";
import Breadcrumb from "../../../components/Breadcrumbs/Breadcrumb";
import MainTableSettings from "../../../components/Tables/Settings/JudicialGuide/MainTableSettings";
import PackagesTable from "../../../components/Tables/Settings/PackagesTable";
export const PACKAGETYPES = [
    { id: 1, name: "طالب خدمة" },
    { id: 2, name: "مقدم خدمة" },
];
export const DURATIONTYPES = [
    {
        id: "1",
        name: "يوم",
    },
    {
        id: "2",
        name: "أسبوع",
    },
    {
        id: "3",
        name: "شهر",
    },
    {
        id: "4",
        name: "سنة",
    },
];

const Packages = ({ packages, types }) => {
    const headers = [
        "الاسم",
        "السعر قبل الخصم",
        "السعر بعد الخصم",
        "المدة",
        "النوع",
        "الفئة المستهدفة",
        "عدد الخدمات",
        "عدد الأستشارات",
        "عدد المواعيد",
        "العمليات",
    ];
    const [deleteModalOpen, setDeleteModalOpen] = useState({
        state: false,
        id: null,
    });
    console.log(packages);
    return (
        <>
            <DeleteModal
                isOpen={deleteModalOpen.state}
                setIsOpen={setDeleteModalOpen}
                confirmAction={async () => {
                    try {
                        axios.delete(
                            `/newAdmin/settings/packages/${deleteModalOpen.id}`
                        );
                        toast.success("تم حذف الملف");
                        setDeleteModalOpen({
                            state: false,
                            id: null,
                        });
                        router.get("/newAdmin/settings/packages");
                    } catch (err) {
                        toast.error("حدث خطأ");
                    }
                }}
                confirmationText={"هل انت متأكد من حذف الباقة؟"}
            />
            <DefaultLayout>
                <Breadcrumb pageName="اعدادات الباقات" />
                <PackagesTable
                    headers={headers}
                    data={packages}
                    setDeleteModalOpen={setDeleteModalOpen}
                    types={types}
                />
            </DefaultLayout>
        </>
    );
};

export default Packages;
