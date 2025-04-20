import React, { useState } from "react";
import DefaultLayout from "../../layout/DefaultLayout";
import Breadcrumb from "../../components/Breadcrumbs/Breadcrumb";
import DeleteModal from "../../components/Modals/DeleteModal";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import DigitalGuidePackagesTable from "../../components/Tables/DigitalGuidePackages/DigitalGuidePackagesTable";

const PackageSettings = ({ packages }) => {
    const [deleteModalOpen, setDeleteModalOpen] = useState({
        state: false,
        id: null,
    });
    const headers = ["#", "اسم الباقة", "سعر الباقة", "المدة", "العمليات"];
    packages = packages.map((packageDetails) => {
        return {
            ...packageDetails,
            name: packageDetails.title,
        };
    });
    return (
        <>
            <DeleteModal
                isOpen={deleteModalOpen.state}
                setIsOpen={setDeleteModalOpen}
                confirmAction={() => {
                    router.get(
                        `/admin/digital-guide/packages/delete/${deleteModalOpen.id}`,
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
                confirmationText={
                    "عند حذف الباقة سيظل المشتركين بها عليها حتى انتها مدتهم"
                }
            />
            <DefaultLayout>
                <Breadcrumb pageName="الباقات" />
                <DigitalGuidePackagesTable
                    headers={headers}
                    data={packages}
                    setDeleteModalOpen={setDeleteModalOpen}
                />
            </DefaultLayout>
        </>
    );
};

export default PackageSettings;
