import { faChevronDown, faChevronUp } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import React, { useEffect, useState } from "react";
import Pagination from "../Pagination";

export default function LawyerPermissionsTable({
    selectedPermissions,
    setSelectedPermissions,
    permissions,
}) {
    const [isAccordionOpen, setIsAccordionOpen] = useState(false);
    const [pageSize, setPageSize] = useState("10");

    const [currentPage, setCurrentPage] = useState(0);

    const [currentData, setCurrentData] = useState<any[]>([]);
    const [filteredData, setFilteredData] = useState<any[]>([]);
    const paginate = (pageNumber: number) => setCurrentPage(pageNumber);
    const toggleSelectAll = () => {
        if (selectedPermissions.length === filteredData.length) {
            setSelectedPermissions([]);
        } else {
            setSelectedPermissions(filteredData.map((product) => product.id));
        }
    };
    const handleSelect = (id) => {
        if (selectedPermissions.includes(id)) {
            setSelectedPermissions(
                selectedPermissions.filter((permId) => permId !== id)
            );
        } else {
            setSelectedPermissions([...selectedPermissions, id]);
        }
    };
    useEffect(() => {
        setFilteredData(permissions);
        setCurrentData(
            permissions.filter((item, index) => {
                return (
                    index >= currentPage * parseInt(pageSize) &&
                    index < (currentPage + 1) * parseInt(pageSize)
                );
            })
        );
    }, [currentPage, permissions, pageSize]);

    const handleCheckboxChange = (id) => {
        if (selectedPermissions.includes(id)) {
            setSelectedPermissions(
                selectedPermissions.filter(
                    (permissionId) => permissionId !== id
                )
            );
        } else {
            setSelectedPermissions([...selectedPermissions, id]);
        }
    };

    return (
        <div className="rounded-sm w-full border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
            <h3
                className="font-medium text-black dark:text-white mb-4 cursor-pointer flex justify-between items-center"
                onClick={() => setIsAccordionOpen(!isAccordionOpen)}
            >
                تحديد مزايا مقدم الخدمة ({selectedPermissions.length})
                <FontAwesomeIcon
                    icon={isAccordionOpen ? faChevronUp : faChevronDown}
                    className="transition-transform duration-300"
                />
            </h3>
            <div
                className={`transition-max-height duration-500 ease-in-out overflow-hidden ${
                    isAccordionOpen ? "max-h-[2000px]" : "max-h-0"
                }`}
            >
                {isAccordionOpen && (
                    <>
                        <Pagination
                            data={filteredData}
                            pageSize={pageSize}
                            paginate={paginate}
                            setPageSize={setPageSize}
                        />
                        <div className="w-full max-w-full overflow-x-auto">
                            <table
                                className="w-full table-auto"
                                style={{ direction: "rtl" }}
                            >
                                <thead>
                                    <tr className="bg-gray-2 text-right dark:bg-meta-4">
                                        <th className="min-w-[20px] py-4 px-4 font-medium text-black dark:text-white ">
                                            <input
                                                type="checkbox"
                                                checked={
                                                    selectedPermissions.length ===
                                                    filteredData.length
                                                }
                                                onChange={toggleSelectAll}
                                            />
                                            اختيار الكل
                                        </th>
                                        <th className="min-w-[20px] py-4 px-4 font-medium text-black dark:text-white ">
                                            المزيا
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {currentData.map((permission) => (
                                        <tr key={permission.id}>
                                            <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                                <input
                                                    type="checkbox"
                                                    checked={selectedPermissions.includes(
                                                        permission.id.toString()
                                                    )}
                                                    onChange={() =>
                                                        handleCheckboxChange(
                                                            permission.id.toString()
                                                        )
                                                    }
                                                />
                                            </td>
                                            <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                                {permission.name}
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
                    </>
                )}
            </div>
        </div>
    );
}
