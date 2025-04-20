import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import React, { useEffect, useState } from "react";
import { faReply, faTrash, faUserPen } from "@fortawesome/free-solid-svg-icons";
import { Link, router } from "@inertiajs/react";
import axios from "axios";
import toast from "react-hot-toast";
import ReactPaginate from "react-paginate";
import Pagination from "../Pagination";

const LawyerPayoutsTable = ({
    headers,
    data,
}: {
    headers: string[];
    data: any[];
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
                (lawyerPayout) =>
                    lawyerPayout.lawyer.name
                        .toLowerCase()
                        .includes(searchQuery.toLowerCase()) ||
                    lawyerPayout.id == searchQuery
            )
        );
        setCurrentData(
            data
                .filter(
                    (lawyerPayout) =>
                        lawyerPayout.lawyer.name
                            .toLowerCase()
                            .includes(searchQuery.toLowerCase()) ||
                        lawyerPayout.id == searchQuery
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
                        placeholder="ابحث بأسم مقدم الخدمة او الرقم العريفي لطلب التحويل..."
                        value={searchQuery}
                        onChange={(e) => setSearchQuery(e.target.value)}
                        className="mb-4 px-4 py-3 w-full border rounded-md dark:border-strokedark dark:bg-boxdark"
                    />
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
                        {currentData.map((lawyerPayout, key) => (
                            <tr key={key}>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {lawyerPayout.id}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {lawyerPayout.lawyerName}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <p className="text-black dark:text-white">
                                        {lawyerPayout.productsCount}
                                    </p>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <p className="text-black dark:text-white">
                                        {lawyerPayout.productsPrice}
                                    </p>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <span
                                        className={`flex rounded-full justify-center items-center py-1 px-3 text-sm font-medium ${
                                            lawyerPayout.status == 1
                                                ? "bg-sky-500 text-white"
                                                : lawyerPayout.status == "3"
                                                ? "bg-red-500 text-white"
                                                : "bg-green-500 text-white"
                                        }`}
                                    >
                                        {lawyerPayout.statusText}
                                    </span>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {lawyerPayout.createdAt
                                            .split(" ")
                                            .splice(0, 3)
                                            .join(" ")}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {
                                            lawyerPayout.createdAt.split(" ")[
                                                lawyerPayout.createdAt.split(
                                                    " "
                                                ).length - 1
                                            ]
                                        }
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <div className="flex items-center gap-5">
                                        <Link
                                            href={`payouts/${lawyerPayout.id}`}
                                            className="hover:text-primary"
                                        >
                                            <FontAwesomeIcon icon={faUserPen} />
                                        </Link>
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

export default LawyerPayoutsTable;
