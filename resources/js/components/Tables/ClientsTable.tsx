import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { Package } from "../../types/package";
import React, { useEffect, useState } from "react";
import { faReply, faTrash, faUserPen } from "@fortawesome/free-solid-svg-icons";
import { Link, router } from "@inertiajs/react";
import axios from "axios";
import toast from "react-hot-toast";
import ReactPaginate from "react-paginate";
import Pagination from "../Pagination";
import { GetArabicDate } from "../../helpers/DateFunctions";

const ClientsTable = ({
    headers,
    data,
    setDeleteModalOpen,
    old = false,
}: {
    headers: string[];
    data: any[];
    setDeleteModalOpen: any;
    old?: boolean;
}) => {
    const [pageSize, setPageSize] = useState("100");
    const [currentPage, setCurrentPage] = useState(0);
    const [searchQuery, setSearchQuery] = useState("");
    const [selectedStatus, setSelectedStatus] = useState("");
    const [selectedCountry, setSelectedCountry] = useState("");
    const [selectedType, setSelectedType] = useState("");
    const [filteredData, setFilteredData] = useState<any[]>([]);
    const [currentData, setCurrentData] = useState<any[]>([]);
    const paginate = (pageNumber: number) => setCurrentPage(pageNumber);
    useEffect(() => {
        setFilteredData(
            data
                .filter(
                    (client) =>
                        client.name
                            .toLowerCase()
                            .includes(searchQuery.toLowerCase()) ||
                        client.email
                            .toLowerCase()
                            .includes(searchQuery.toLowerCase()) ||
                        client.phone.includes(searchQuery) ||
                        client.id == searchQuery
                )
                .filter(
                    (client) =>
                        client.status === selectedStatus ||
                        selectedStatus === ""
                )
                .filter(
                    (client) =>
                        client.type === selectedType || selectedType === ""
                )
                .filter(
                    (client) =>
                        client.country_name === selectedCountry ||
                        selectedCountry === ""
                )
        );
        setCurrentData(
            data
                .filter(
                    (client) =>
                        client.name
                            .toLowerCase()
                            .includes(searchQuery.toLowerCase()) ||
                        client.email
                            .toLowerCase()
                            .includes(searchQuery.toLowerCase()) ||
                        client.phone.includes(searchQuery) ||
                        client.id == searchQuery
                )
                .filter(
                    (client) =>
                        client.status === selectedStatus ||
                        selectedStatus === ""
                )
                .filter(
                    (client) =>
                        client.type === selectedType || selectedType === ""
                )
                .filter(
                    (client) =>
                        client.country_name === selectedCountry ||
                        selectedCountry === ""
                )
                .filter((item, index) => {
                    return (
                        index >= currentPage * parseInt(pageSize) &&
                        index < (currentPage + 1) * parseInt(pageSize)
                    );
                })
        );
    }, [
        currentPage,
        searchQuery,
        selectedCountry,
        selectedStatus,
        selectedType,
        pageSize,
    ]);
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
                <div className="col-span-2">
                    <label>الحالة</label>
                    <select
                        className="mb-4 px-4 py-2 w-full border rounded-md dark:border-strokedark dark:bg-boxdark"
                        value={selectedStatus}
                        onChange={(e) => setSelectedStatus(e.target.value)}
                    >
                        <option value="">الكل</option>
                        {[...new Set(data.map((client) => client.status))].map(
                            (status) => (
                                <option value={status}>{status}</option>
                            )
                        )}
                    </select>
                </div>

                <div className="col-span-2">
                    <label>الدولة</label>
                    <select
                        className="mb-4 px-4 py-2 w-full border rounded-md col-span-2 dark:border-strokedark dark:bg-boxdark"
                        value={selectedCountry}
                        onChange={(e) => setSelectedCountry(e.target.value)}
                    >
                        <option value="">الكل</option>
                        {[
                            ...new Set(
                                data.map((client) => client.country_name)
                            ),
                        ].map((status) => (
                            <option value={status}>{status}</option>
                        ))}
                    </select>
                </div>
                <div className="col-span-2">
                    <label>الصفة</label>
                    <select
                        className="mb-4 px-4 py-2 w-full border rounded-md col-span-2 dark:border-strokedark dark:bg-boxdark"
                        value={selectedType}
                        onChange={(e) => setSelectedType(e.target.value)}
                    >
                        <option value="">الكل</option>
                        {[...new Set(data.map((client) => client.type))].map(
                            (status) => (
                                <option value={status}>{status}</option>
                            )
                        )}
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
                        {currentData.map((client, key) => (
                            <tr key={key}>
                                {/* <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {client.id}
                                    </h5>
                                </td> */}
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {client.name}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <p className="text-black dark:text-white">
                                        {client.email}
                                    </p>
                                </td>
                                {/* <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <p className="text-black dark:text-white">
                                        {client.country_name}
                                    </p>
                                </td> */}
                                {/* <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <p className="text-black dark:text-white">
                                        {client.region_name}
                                    </p>
                                </td> */}
                                <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <p className="text-black dark:text-white">
                                        {client.phone}
                                    </p>
                                </td>

                                {/* <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <p className="text-black dark:text-white">
                                        {client.type}
                                    </p>
                                </td> */}
                                <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <p
                                        className={`inline-flex rounded-full py-1 px-3 text-sm font-medium ${
                                            old
                                                ? client.statusCode == 1
                                                    ? "bg-success text-white"
                                                    : client.statusCode == 0
                                                    ? "bg-danger text-white"
                                                    : null
                                                : client.statusCode == 1
                                                ? "bg-purple-600 text-white"
                                                : client.statusCode == 2
                                                ? "bg-success text-white"
                                                : client.statusCode == 3
                                                ? "bg-warning text-white"
                                                : "bg-danger text-white"
                                        }`}
                                    >
                                        {client.status}
                                    </p>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <p className="text-black dark:text-white">
                                        {GetArabicDate(client.created_at)}
                                    </p>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <p className="text-black dark:text-white">
                                        {client.is_old_user ? "✅" : "❌"}
                                    </p>
                                </td>
                                {!old ? (
                                    <>
                                        <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                            <p className="text-black dark:text-white">
                                                {client.profile_complete
                                                    ? "✅"
                                                    : "❌"}
                                            </p>
                                        </td>
                                    </>
                                ) : (
                                    <></>
                                )}
                                <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <div className="flex items-center gap-5">
                                        <Link
                                            href={`${
                                                old ? "old-" : ""
                                            }clients/${client.id}/edit`}
                                            className="hover:text-primary"
                                        >
                                            <FontAwesomeIcon icon={faUserPen} />
                                        </Link>
                                        <button
                                            onClick={() =>
                                                setDeleteModalOpen({
                                                    state: true,
                                                    id: client.id,
                                                })
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

export default ClientsTable;
