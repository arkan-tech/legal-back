import React, { useState } from "react";
import DefaultLayout from "../../../layout/DefaultLayout";
import Breadcrumb from "../../../components/Breadcrumbs/Breadcrumb";
import { router, Link } from "@inertiajs/react";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faTrash, faEdit } from "@fortawesome/free-solid-svg-icons";
import toast from "react-hot-toast";
import Switcher from "../../../components/Switchers/Switcher";

interface Lawyer {
    id: number;
    name: string;
}

interface CommitteeMember {
    id: number;
    account: {
        id: number;
        name: string;
    };
    is_active: boolean;
    statistics: {
        total: number;
        pending: number;
        completed: number;
    };
}

const EliteServicePricingCommittee = ({
    committee,
    lawyers,
}: {
    committee: CommitteeMember[];
    lawyers: Lawyer[];
}) => {
    const [selectedLawyer, setSelectedLawyer] = useState("");

    const addMember = () => {
        if (!selectedLawyer) {
            toast.error("الرجاء اختيار محامي");
            return;
        }

        router.post("/newAdmin/settings/elite-service-pricing-committee", {
            account_id: selectedLawyer,
        });
    };

    const removeMember = (accountId: number) => {
        router.delete(
            `/newAdmin/settings/elite-service-pricing-committee/${accountId}`
        );
    };

    const toggleActive = (accountId: number) => {
        router.post(
            `/newAdmin/settings/elite-service-pricing-committee/${accountId}/toggle-active`
        );
    };

    return (
        <DefaultLayout>
            <Breadcrumb pageName="لجنة تسعير الخدمات المميزة" />
            <div className="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
                <div className="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <h2 className="text-title-md2 font-semibold text-black dark:text-white">
                        أعضاء اللجنة
                    </h2>
                    <div
                        className="flex items-center gap-3"
                        style={{ direction: "rtl" }}
                    >
                        <select
                            value={selectedLawyer}
                            onChange={(e) => setSelectedLawyer(e.target.value)}
                            className="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input"
                            style={{ direction: "rtl" }}
                        >
                            <option value="">اختر محامي</option>
                            {lawyers.map((lawyer) => (
                                <option key={lawyer.id} value={lawyer.id}>
                                    {lawyer.name}
                                </option>
                            ))}
                        </select>
                        <button
                            onClick={addMember}
                            className="inline-flex items-center justify-center rounded-md bg-primary py-3 px-10 text-center font-medium text-white hover:bg-opacity-90 lg:px-8 xl:px-10"
                        >
                            إضافة
                        </button>
                    </div>
                </div>

                <div className="max-w-full overflow-x-auto">
                    <table
                        className="w-full table-auto"
                        style={{ direction: "rtl" }}
                    >
                        <thead>
                            <tr className="bg-gray-2 text-right dark:bg-meta-4">
                                <th className="py-4 px-4 font-medium text-black dark:text-white">
                                    اسم المحامي
                                </th>
                                <th className="py-4 px-4 font-medium text-black dark:text-white">
                                    إجمالي الطلبات
                                </th>
                                <th className="py-4 px-4 font-medium text-black dark:text-white">
                                    الطلبات المعلقة
                                </th>
                                <th className="py-4 px-4 font-medium text-black dark:text-white">
                                    الطلبات المكتملة
                                </th>
                                <th className="py-4 px-4 font-medium text-black dark:text-white">
                                    الحالة
                                </th>
                                <th className="py-4 px-4 font-medium text-black dark:text-white">
                                    العمليات
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            {committee.map((member) => (
                                <tr key={member.id}>
                                    <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                        <Link
                                            href={`/newAdmin/lawyers/${member.account.id}/edit`}
                                            className="text-black hover:text-primary dark:text-white"
                                        >
                                            {member.account.name}
                                        </Link>
                                    </td>
                                    <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                        <p className="text-black dark:text-white">
                                            {member.statistics.total}
                                        </p>
                                    </td>
                                    <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                        <p className="text-black dark:text-white">
                                            {member.statistics.pending}
                                        </p>
                                    </td>
                                    <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                        <p className="text-black dark:text-white">
                                            {member.statistics.completed}
                                        </p>
                                    </td>
                                    <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                        <Switcher
                                            enabled={member.is_active}
                                            id={`member-${member.account.id}`}
                                            handleToggle={() =>
                                                toggleActive(member.account.id)
                                            }
                                        />
                                    </td>
                                    <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                        <div className="flex items-center gap-3">
                                            <Link
                                                href={`/newAdmin/lawyers/${member.account.id}/edit`}
                                                className="hover:text-primary"
                                            >
                                                <FontAwesomeIcon
                                                    icon={faEdit}
                                                />
                                            </Link>
                                            <button
                                                onClick={() =>
                                                    removeMember(
                                                        member.account.id
                                                    )
                                                }
                                                className="hover:text-red-500"
                                            >
                                                <FontAwesomeIcon
                                                    icon={faTrash}
                                                />
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>
        </DefaultLayout>
    );
};

export default EliteServicePricingCommittee;
