import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { Package } from "../../../types/package";
import React, { useEffect, useState } from "react";
import {
    faGear,
    faReply,
    faTrash,
    faUserPen,
} from "@fortawesome/free-solid-svg-icons";
import { Link, router } from "@inertiajs/react";
import axios from "axios";
import toast from "react-hot-toast";
import ReactPaginate from "react-paginate";
import Pagination from "../../Pagination";
import Switcher from "../../Switchers/Switcher";
const ServicesSettingsTable = ({
    headers,
    data,
    categories,
    setDeleteModalOpen,
    compact = false,
}: {
    headers: string[];
    data: any[];
    categories: any[];
    setDeleteModalOpen;
    compact: boolean;
}) => {
    const [pageSize, setPageSize] = useState("10");
    const [currentPage, setCurrentPage] = useState(0);
    const [searchQuery, setSearchQuery] = useState("");
    const [selectedCategory, setSelectedCategory] = useState("");
    const [filteredData, setFilteredData] = useState<any[]>([]);
    const [currentData, setCurrentData] = useState<any[]>([]);
    const paginate = (pageNumber: number) => setCurrentPage(pageNumber);
    const [enabledStates, setEnabledStates] = useState(() => {
        // Initialize enabled states based on the data
        const initialStates = {};
        data.forEach((item) => {
            console.log(item);
            initialStates[item.id] = !item.isHidden;
        });
        return initialStates;
    });
    const handleToggle = async (id) => {
        const newEnabledState = !enabledStates[id];
        try {
            const response = await axios.post(
                `/newAdmin/services/${id}/toggle`,
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
            data
                .filter(
                    (service) =>
                        service.name
                            ?.toLowerCase()
                            .includes(searchQuery.toLowerCase()) ||
                        service.id == searchQuery
                )
                .filter(
                    (service) =>
                        service.category?.id == selectedCategory ||
                        selectedCategory === ""
                )
        );
        setCurrentData(
            data
                .filter(
                    (service) =>
                        service.name
                            ?.toLowerCase()
                            .includes(searchQuery.toLowerCase()) ||
                        service.id == searchQuery
                )
                .filter(
                    (service) =>
                        service.category?.id == selectedCategory ||
                        selectedCategory === ""
                )
                .filter((item, index) => {
                    return (
                        index >= currentPage * parseInt(pageSize) &&
                        index < (currentPage + 1) * parseInt(pageSize)
                    );
                })
        );
    }, [currentPage, searchQuery, selectedCategory]);

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
                <div className="col-span-4">
                    <label>القسم الرئيسي</label>
                    <select
                        className="mb-4 px-4 py-2 w-full border rounded-md dark:border-strokedark dark:bg-boxdark"
                        value={selectedCategory}
                        onChange={(e) => setSelectedCategory(e.target.value)}
                    >
                        <option value="">الكل</option>
                        {categories.map((category) => (
                            <option value={category.id}>{category.name}</option>
                        ))}
                    </select>
                </div>

                <div className="col-span-2 flex items-center justify-end">
                    <Link
                        href="/newAdmin/services/create"
                        className="px-4 py-2 bg-purple-500 text-white rounded-xl hover:bg-purple-700"
                    >
                        اضافة خدمة
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
                        {currentData.map((service, key) => (
                            <tr key={key}>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {service.id}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <p className="text-black dark:text-white">
                                        {service.category?.name || "-"}
                                    </p>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {service.name}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <p className="text-blue-700 dark:text-white">
                                        الأدنى: {service.minPrice}
                                    </p>
                                    <p className="text-blue-700 dark:text-white">
                                        الأعلى: {service.maxPrice}
                                    </p>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <p className="text-black dark:text-white">
                                        {service.prices.map((price) => (
                                            <p>
                                                {price.level.title}
                                                {": "}
                                                {price.price}
                                            </p>
                                        ))}
                                    </p>
                                </td>

                                <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <div className="flex items-center gap-5">
                                        <Switcher
                                            enabled={enabledStates[service.id]}
                                            handleToggle={handleToggle}
                                            id={service.id}
                                        />
                                        <Link
                                            href={`/newAdmin/services/${service.id}`}
                                            className="hover:text-primary"
                                        >
                                            <FontAwesomeIcon icon={faUserPen} />
                                        </Link>
                                        {!compact && (
                                            <button
                                                onClick={() =>
                                                    setDeleteModalOpen({
                                                        state: true,
                                                        id: service.id,
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

export default ServicesSettingsTable;
