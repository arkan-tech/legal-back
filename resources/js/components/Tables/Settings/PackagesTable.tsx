import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import React, { useEffect, useState } from "react";
import { faReply, faTrash, faUserPen } from "@fortawesome/free-solid-svg-icons";
import { Link, router } from "@inertiajs/react";
import axios from "axios";
import toast from "react-hot-toast";
import ReactPaginate from "react-paginate";
import Pagination from "../../Pagination";
import { DURATIONTYPES, PACKAGETYPES } from "../../../Pages/Settings/Packages";
const PackagesTable = ({
    headers,
    data,
    setDeleteModalOpen,
    route = "judicial-guide",
    compact = false,
    types,
}: {
    headers: string[];
    data: any[];
    setDeleteModalOpen: any;
    route?: string;
    compact?: boolean;
    types: { id: number; name: string }[];
}) => {
    const [pageSize, setPageSize] = useState("10");
    const [currentPage, setCurrentPage] = useState(0);
    const [filteredData, setFilteredData] = useState<any[]>([]);
    const [currentData, setCurrentData] = useState<any[]>([]);

    const paginate = (pageNumber: number) => setCurrentPage(pageNumber);

    useEffect(() => {
        let filteredData = data;

        setFilteredData(filteredData);
        setCurrentData(
            filteredData.filter((item, index) => {
                return (
                    index >= currentPage * parseInt(pageSize) &&
                    index < (currentPage + 1) * parseInt(pageSize)
                );
            })
        );
    }, [currentPage]);
    return (
        <div
            style={{ direction: "rtl" }}
            className="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1"
        >
            <div className="grid grid-cols-12 gap-2">
                <div className="col-span-12 flex items-end justify-end">
                    <Link
                        href={`/newAdmin/settings/packages/create`}
                        className="px-4 py-2 bg-purple-500 text-white rounded-xl hover:bg-purple-700"
                    >
                        اضافة باقة
                    </Link>
                </div>
            </div>
            <Pagination
                data={filteredData}
                pageSize={pageSize}
                paginate={paginate}
                setPageSize={setPageSize}
            />
            <div className={`max-w-full overflow-x-auto`}>
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
                        {currentData.map((item, key) => (
                            <tr key={key}>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {item.name}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {item.priceBeforeDiscount}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {item.priceAfterDiscount}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {item.duration}{" "}
                                        {
                                            DURATIONTYPES.find(
                                                (t) =>
                                                    t.id == item.duration_type
                                            )?.name
                                        }
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {
                                            PACKAGETYPES.find(
                                                (p) => p.id == item.package_type
                                            )?.name
                                        }
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {
                                            types.find(
                                                (p) => p.id == item.targetedType
                                            )?.name
                                        }
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {item.number_of_services}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {item.number_of_advisory_services}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {item.number_of_reservations}
                                    </h5>
                                </td>

                                <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <div className="flex items-center gap-5">
                                        <Link
                                            href={`/newAdmin/settings/packages/${item.id}`}
                                            className="hover:text-primary"
                                        >
                                            <FontAwesomeIcon icon={faUserPen} />
                                        </Link>
                                        {!compact && (
                                            <button
                                                onClick={() =>
                                                    setDeleteModalOpen({
                                                        state: true,
                                                        id: item.id,
                                                    })
                                                }
                                                className="hover:text-primary"
                                            >
                                                <FontAwesomeIcon
                                                    icon={faTrash}
                                                />
                                            </button>
                                        )}
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

export default PackagesTable;
