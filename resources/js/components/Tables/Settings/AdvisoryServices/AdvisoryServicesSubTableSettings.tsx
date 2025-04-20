import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import React, { useEffect, useState } from "react";
import { faTrash, faUserPen } from "@fortawesome/free-solid-svg-icons";
import { Link, router } from "@inertiajs/react";
import Pagination from "../../../Pagination";
import Switcher from "../../../Switchers/Switcher";
import toast from "react-hot-toast";
import axios from "axios";

const AdvisoryServicesSubTableSettings = ({
    headers,
    data,
    setDeleteModalOpen,
    compact = false,
}) => {
    const [pageSize, setPageSize] = useState("10");
    const [currentPage, setCurrentPage] = useState(0);
    const [searchQuery, setSearchQuery] = useState("");
    const [filteredData, setFilteredData] = useState([]);
    const [currentData, setCurrentData] = useState([]);
    const [enabledStates, setEnabledStates] = useState(() => {
        // Initialize enabled states based on the data
        const initialStates = {};
        data.forEach((item) => {
            initialStates[item.id] = !item.is_hidden;
        });
        return initialStates;
    });

    const handleToggle = async (id) => {
        try {
            const response = await axios.post(
                `/newAdmin/settings/advisory-services/sub-categories/${id}/toggle-visibility`
            );
            if (response.data.status) {
                setEnabledStates((prev) => ({
                    ...prev,
                    [id]: !response.data.is_hidden,
                }));
                toast.success(response.data.message);
            }
        } catch (error) {
            console.error(error);
            toast.error("حدث خطأ في تحديث حالة الظهور");
        }
    };

    const paginate = (pageNumber) => setCurrentPage(pageNumber);

    useEffect(() => {
        setFilteredData(
            data.filter(
                (item) =>
                    item.name
                        .toLowerCase()
                        .includes(searchQuery.toLowerCase()) ||
                    item.id == searchQuery
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
    }, [currentPage, searchQuery, data]);

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
                        href="/newAdmin/settings/advisory-services/sub-categories/create"
                        className="px-4 py-2 bg-purple-500 text-white rounded-xl hover:bg-purple-700"
                    >
                        اضافة التخصص الدقيق
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
                            {headers.map((header, idx) => (
                                <th
                                    key={idx}
                                    className="min-w-[20px] py-4 px-4 font-medium text-black dark:text-white "
                                >
                                    {header}
                                </th>
                            ))}
                        </tr>
                    </thead>
                    <tbody>
                        {currentData.map((subCategory: any, key) => (
                            <tr key={key}>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {subCategory.id}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {subCategory.name}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {subCategory.general_category.name}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    {subCategory.prices.map((price, idx) => (
                                        <div
                                            key={idx}
                                            className="flex items-center gap-2"
                                        >
                                            <span>
                                                {price.importance.title} |{" "}
                                                {price.duration} ساعة |{" "}
                                                {price.price}
                                                {" ر.س"}
                                            </span>
                                        </div>
                                    ))}
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <div className="flex items-center gap-5">
                                        <Switcher
                                            enabled={
                                                enabledStates[subCategory.id]
                                            }
                                            handleToggle={handleToggle}
                                            id={subCategory.id}
                                        />
                                        <Link
                                            href={`/newAdmin/settings/advisory-services/sub-categories/${subCategory.id}/edit`}
                                            className="hover:text-primary"
                                        >
                                            <FontAwesomeIcon icon={faUserPen} />
                                        </Link>
                                        {!compact && (
                                            <button
                                                onClick={() =>
                                                    setDeleteModalOpen({
                                                        state: true,
                                                        id: subCategory.id,
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

export default AdvisoryServicesSubTableSettings;
