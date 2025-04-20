import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import React, { useEffect, useState } from "react";
import {
    faEye,
    faReply,
    faTrash,
    faUserPen,
} from "@fortawesome/free-solid-svg-icons";
import { Link, router } from "@inertiajs/react";
import axios from "axios";
import toast from "react-hot-toast";
import ReactPaginate from "react-paginate";
import Pagination from "../Pagination";
const BannersTable = ({
    headers,
    data,
    setDeleteModalOpen,
    newButtonEnabled = false,
    newButtonText,
    newButtonLink,
    editLink,
    nameKeyForFiltration = "name",
    hasDelete = true,
    dataFilter = [],
}: {
    headers: string[];
    data: any[];
    setDeleteModalOpen?: any;
    newButtonEnabled?: boolean;
    newButtonText?: string;
    newButtonLink?: string;
    editLink: string;
    nameKeyForFiltration?: string;
    hasDelete?: boolean;
    dataFilter?: string[];
}) => {
    const [pageSize, setPageSize] = useState("100");
    const [currentPage, setCurrentPage] = useState(0);
    const [searchQuery, setSearchQuery] = useState("");
    const [filteredData, setFilteredData] = useState<any[]>([]);
    const [currentData, setCurrentData] = useState<any[]>([]);
    const paginate = (pageNumber: number) => setCurrentPage(pageNumber);

    useEffect(() => {
        setFilteredData(
            data.filter(
                (category) =>
                    category[nameKeyForFiltration]
                        .toString()
                        .toLowerCase()
                        .includes(searchQuery.toLowerCase()) ||
                    category.id == searchQuery
            )
        );
        setCurrentData(
            data
                .filter(
                    (category) =>
                        category[nameKeyForFiltration]
                            .toString()
                            .toLowerCase()
                            .includes(searchQuery.toLowerCase()) ||
                        category.id == searchQuery
                )
                .filter((item, index) => {
                    return (
                        index >= currentPage * parseInt(pageSize) &&
                        index < (currentPage + 1) * parseInt(pageSize)
                    );
                })
        );
    }, [currentPage, searchQuery]);
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
                        placeholder="ابحث بالأسم او الرقم العريفي..."
                        value={searchQuery}
                        onChange={(e) => setSearchQuery(e.target.value)}
                        className="mb-4 px-4 py-3 w-full border rounded-md dark:border-strokedark dark:bg-boxdark"
                    />
                </div>
                {newButtonEnabled ? (
                    <div className="col-span-6 flex items-center justify-end">
                        <Link
                            href={newButtonLink as string}
                            className="px-4 py-2 bg-purple-500 text-white rounded-xl hover:bg-purple-700"
                        >
                            {newButtonText}
                        </Link>
                    </div>
                ) : null}
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
                        {currentData.map((rowData, index) => (
                            <tr key={index}>
                                {Object.keys(rowData)
                                    .filter((key) => !dataFilter.includes(key))
                                    .map((key, idx) => (
                                        <td
                                            key={idx}
                                            className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11"
                                        >
                                            <h5 className="font-medium text-black dark:text-white">
                                                {rowData[key]}
                                            </h5>
                                        </td>
                                    ))}

                                <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <div className="flex items-center gap-5">
                                        <a
                                            href={rowData.image}
                                            target="_blank"
                                            className="hover:text-primary"
                                        >
                                            <FontAwesomeIcon icon={faEye} />
                                        </a>
                                        <Link
                                            href={`${editLink}/${rowData.id}`}
                                            className="hover:text-primary"
                                        >
                                            <FontAwesomeIcon icon={faUserPen} />
                                        </Link>
                                        {hasDelete ? (
                                            <button
                                                onClick={() =>
                                                    setDeleteModalOpen({
                                                        state: true,
                                                        id: rowData.id,
                                                    })
                                                }
                                                className="hover:text-primary"
                                            >
                                                <FontAwesomeIcon
                                                    icon={faTrash}
                                                />
                                            </button>
                                        ) : null}
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

export default BannersTable;
