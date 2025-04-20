import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { Package } from "../../types/package";
import React, { useEffect, useState } from "react";
import { faReply, faTrash, faUserPen } from "@fortawesome/free-solid-svg-icons";
import { Link, router } from "@inertiajs/react";
import axios from "axios";
import toast from "react-hot-toast";
import ReactPaginate from "react-paginate";
import Pagination from "../Pagination";

export const MailerAccountsStatusOptions = [
    {
        id: 0,
        title: "غير مشترك",
    },
    {
        id: 1,
        title: "مشترك",
    },
];
const MailerAccountsTable = ({
    headers,
    data,
}: {
    headers: string[];
    data: any[];
}) => {
    const [pageSize, setPageSize] = useState("100");
    const [currentPage, setCurrentPage] = useState(0);
    const [searchQuery, setSearchQuery] = useState("");
    const [selectedStatus, setSelectedStatus] = useState("");
    const [filteredData, setFilteredData] = useState<any[]>([]);
    const [currentData, setCurrentData] = useState<any[]>([]);
    const paginate = (pageNumber: number) => setCurrentPage(pageNumber);
    useEffect(() => {
        setFilteredData(
            data
                .filter(
                    (client) =>
                        client.email
                            .toLowerCase()
                            .includes(searchQuery.toLowerCase()) ||
                        client.id == searchQuery
                )
                .filter(
                    (client) =>
                        client.status == selectedStatus || selectedStatus === ""
                )
        );
        setCurrentData(
            data
                .filter(
                    (client) =>
                        client.email
                            .toLowerCase()
                            .includes(searchQuery.toLowerCase()) ||
                        client.id == searchQuery
                )
                .filter(
                    (client) =>
                        client.status == selectedStatus || selectedStatus === ""
                )
                .filter((item, index) => {
                    return (
                        index >= currentPage * parseInt(pageSize) &&
                        index < (currentPage + 1) * parseInt(pageSize)
                    );
                })
        );
    }, [currentPage, searchQuery, selectedStatus]);
    return (
        <div
            style={{ direction: "rtl" }}
            className="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1"
        >
            <div className="grid grid-cols-12 gap-2">
                <div className="col-span-6">
                    <label>البحث</label>

                    <input
                        type="text"
                        placeholder="ابحث بالأسم او الايميل او الموبايل او الرقم العريفي..."
                        value={searchQuery}
                        onChange={(e) => setSearchQuery(e.target.value)}
                        className="mb-4 px-4 py-3 w-full border rounded-md dark:border-strokedark dark:bg-boxdark"
                    />
                </div>
                <div className="col-span-6">
                    <label>الحالة</label>
                    <select
                        className="mb-4 px-4 py-2 w-full border rounded-md dark:border-strokedark dark:bg-boxdark"
                        value={selectedStatus}
                        onChange={(e) => setSelectedStatus(e.target.value)}
                    >
                        <option value="">الكل</option>
                        {MailerAccountsStatusOptions.map((status) => (
                            <option value={status.id}>{status.title}</option>
                        ))}
                    </select>
                </div>
            </div>
            <Pagination
                data={filteredData}
                pageSize={pageSize}
                paginate={paginate}
                setPageSize={setPageSize}
            />
            <div className="max-w-full overflow-x-auto">
                <table className="w-full table-auto">
                    <thead>
                        <tr className="bg-gray-2 text-right dark:bg-meta-4">
                            {headers.map((header) => (
                                <th className="min-w-[20px] py-4 px-4 font-medium text-black dark:text-white ">
                                    {header}
                                </th>
                            ))}
                        </tr>
                    </thead>
                    <tbody>
                        {currentData.map((mailerAccount, key) => (
                            <tr key={key}>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {mailerAccount.id}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <p className="text-black dark:text-white">
                                        {mailerAccount.email}
                                    </p>
                                </td>

                                <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <p
                                        className={`inline-flex rounded-full py-1 px-3 text-sm font-medium ${
                                            mailerAccount.status == 1
                                                ? "bg-success text-white"
                                                : "bg-danger text-white"
                                        }`}
                                    >
                                        {
                                            MailerAccountsStatusOptions.find(
                                                (v) =>
                                                    v.id == mailerAccount.status
                                            )?.title
                                        }
                                    </p>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <div className="flex items-center gap-5">
                                        <Link
                                            href={`mailer-accounts/${mailerAccount.id}`}
                                            className="hover:text-primary"
                                        >
                                            <FontAwesomeIcon icon={faUserPen} />
                                        </Link>
                                        <button
                                            onClick={() =>
                                                router.get(
                                                    `/newAdmin/mailer-accounts/${mailerAccount.id}/delete`,
                                                    {},
                                                    {
                                                        onSuccess: () => {
                                                            toast.success(
                                                                "تم حذف الملف"
                                                            );
                                                        },
                                                        onError: () => {
                                                            toast.error(
                                                                "حدث خطأ"
                                                            );
                                                        },
                                                    }
                                                )
                                            }
                                            className="hover:text-primary"
                                        >
                                            <FontAwesomeIcon icon={faTrash} />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
            <Pagination
                data={filteredData}
                pageSize={pageSize}
                paginate={paginate}
                setPageSize={setPageSize}
            />
        </div>
    );
};

export default MailerAccountsTable;
