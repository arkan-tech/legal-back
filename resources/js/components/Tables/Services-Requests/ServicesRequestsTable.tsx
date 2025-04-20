import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { Package } from "../../../types/package";
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
import { Request } from "../../../Pages/Service-Requests/client";
import { ProductRequestStatus } from "../../ProductRequestStatus";
import Pagination from "../../Pagination";
const ServiceRequestsTable = ({
    headers,
    data,
    reserverType = "client",
}: {
    headers: string[];
    data: Request[];
    reserverType?;
}) => {
    const [pageSize, setPageSize] = useState("100");
    const [currentPage, setCurrentPage] = useState(0);
    const [searchQuery, setSearchQuery] = useState("");
    const [filteredData, setFilteredData] = useState<any[]>([]);
    const [currentData, setCurrentData] = useState<Request[]>([]);
    const paginate = (pageNumber: number) => setCurrentPage(pageNumber);
    useEffect(() => {
        setFilteredData(data);
        setCurrentData(
            data.filter((item, index) => {
                return (
                    index >= currentPage * parseInt(pageSize) &&
                    index < (currentPage + 1) * parseInt(pageSize)
                );
            })
        );
    }, [currentPage, pageSize]);
    console.log(data);
    return (
        <div
            style={{ direction: "rtl" }}
            className="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1"
        >
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
                        {currentData.map((request, key) => (
                            <tr key={key}>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {request.id}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    {request.deleted ? (
                                        <del className={`text-red-500`}>
                                            {request.clientName}
                                        </del>
                                    ) : (
                                        <p
                                            className={`text-black dark:text-white`}
                                        >
                                            {request.clientName}
                                        </p>
                                    )}
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {request.serviceName}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {request.lawyerName}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-2 dark:border-strokedark">
                                    <ProductRequestStatus
                                        status={request.requestStatus}
                                        statusText={request.requestStatusText}
                                    />
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <p className="text-black dark:text-white">
                                        {request.importance}
                                    </p>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <p className="text-black dark:text-white">
                                        {request.replyStatus}
                                    </p>
                                </td>
                                {/* <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <p className="text-black dark:text-white">
                                        {request.referralStatus}
                                    </p>
                                </td> */}
                                <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <p className="text-black dark:text-white">
                                        {request.transactionStatus}
                                    </p>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {request.createdAt != null
                                            ? request.createdAt
                                                  .split(" ")
                                                  .splice(0, 3)
                                                  .join(" ")
                                            : "-"}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {request.createdAt != null
                                            ? request.createdAt.split(" ")[
                                                  request.createdAt.split(" ")
                                                      .length - 1
                                              ]
                                            : "-"}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {request.transferTime || "-"}
                                    </h5>
                                </td>

                                <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <div className="flex items-center gap-5">
                                        <Link
                                            href={`${reserverType}/${request.id}`}
                                            className="hover:text-primary"
                                        >
                                            <FontAwesomeIcon icon={faEye} />
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

export default ServiceRequestsTable;
