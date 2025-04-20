import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import React, { useEffect, useState } from "react";
import { faReply, faTrash, faUserPen } from "@fortawesome/free-solid-svg-icons";
import { Link, router } from "@inertiajs/react";
import axios from "axios";
import toast from "react-hot-toast";
import ReactPaginate from "react-paginate";
import Pagination from "../../../Pagination";
import Switcher from "../../../Switchers/Switcher";
const ReservationTypesSettingsTable = ({
    headers,
    data,
    compact = false,
}: {
    headers: string[];
    data: any[];
    compact?: boolean;
}) => {
    const [pageSize, setPageSize] = useState("10");
    const [currentPage, setCurrentPage] = useState(0);
    const [searchQuery, setSearchQuery] = useState("");
    const [filteredData, setFilteredData] = useState<any[]>([]);
    const [currentData, setCurrentData] = useState<any[]>([]);
    const paginate = (pageNumber: number) => setCurrentPage(pageNumber);
    const [enabledStates, setEnabledStates] = useState(() => {
        // Initialize enabled states based on the data
        const initialStates = {};
        data.forEach((item) => {
            initialStates[item.id] = !item.isHidden;
        });
        return initialStates;
    });
    const handleToggle = async (id) => {
        const newEnabledState = !enabledStates[id];
        try {
            const response = await axios.post(
                `/newAdmin/settings/reservations/types/${id}/toggle`,
                {
                    enabled: newEnabledState,
                }
            );
            if (response.status === 200) {
                setEnabledStates({
                    ...enabledStates,
                    [id]: newEnabledState,
                });
            } else {
                toast.error("حدث خطأ في التحديث");
            }
        } catch (error) {
            toast.error("حدث خطأ في التحديث");
        }
    };

    useEffect(() => {
        setFilteredData(
            data.filter(
                (category) =>
                    category.name
                        .toLowerCase()
                        .includes(searchQuery.toLowerCase()) ||
                    category.id == searchQuery
            )
        );
        setCurrentData(
            data
                .filter(
                    (category) =>
                        category.name
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
                <div className="col-span-6 flex items-center justify-end">
                    <Link
                        href="/newAdmin/settings/reservations/types/create"
                        className="px-4 py-2 bg-purple-500 text-white rounded-xl hover:bg-purple-700"
                    >
                        اضافة نوع موعد
                    </Link>
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
                        {currentData.map((reservationType, key) => (
                            <tr key={key}>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {reservationType.id}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {reservationType.name}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <p className="text-blue-700 dark:text-white">
                                        الأدنى: {reservationType.minPrice}
                                    </p>
                                    <p className="text-blue-700 dark:text-white">
                                        الأعلى: {reservationType.maxPrice}
                                    </p>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {reservationType.prices.map((price) => (
                                            <p>
                                                {price.title}: {price.price}
                                            </p>
                                        ))}
                                    </h5>
                                </td>

                                <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <div className="flex items-center gap-5">
                                        <Switcher
                                            enabled={
                                                enabledStates[
                                                    reservationType.id
                                                ]
                                            }
                                            handleToggle={handleToggle}
                                            id={reservationType.id}
                                        />
                                        <Link
                                            href={`/newAdmin/settings/reservations/types/${reservationType.id}`}
                                            className="hover:text-primary"
                                        >
                                            <FontAwesomeIcon icon={faUserPen} />
                                        </Link>
                                        <button
                                            onClick={() =>
                                                router.get(
                                                    `/newAdmin/reservations/types/${reservationType.id}/delete`,
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

export default ReservationTypesSettingsTable;
