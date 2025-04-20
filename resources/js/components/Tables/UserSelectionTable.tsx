import React, { useEffect, useState, useRef } from "react";
import Pagination from "../Pagination";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faChevronDown, faChevronUp } from "@fortawesome/free-solid-svg-icons";
import SelectGroup from "../Forms/SelectGroup/SelectGroup";

const UserSelectionTable = ({
    users,
    selectedUsers,
    setSelectedUsers,
    lawyer_sections = null,
    hasName = true,
}) => {
    const [pageSize, setPageSize] = useState("10");
    const [currentPage, setCurrentPage] = useState(0);
    const [currentData, setCurrentData] = useState<any[]>([]);
    const [filteredData, setFilteredData] = useState<any[]>([]);
    const [isAccordionOpen, setIsAccordionOpen] = useState(false);
    const [searchQuery, setSearchQuery] = useState("");
    const accordionRef = useRef(null);
    const [selectedSection, setSelectedSection] = useState("");
    const paginate = (pageNumber: number) => setCurrentPage(pageNumber);

    const toggleProductSelection = (userId) => {
        setSelectedUsers((prevSelected) => {
            if (prevSelected.includes(userId)) {
                return prevSelected.filter((id) => id !== userId);
            } else {
                // Add product to the selected list
                return [...prevSelected, userId];
            }
        });
    };

    const toggleSelectAll = () => {
        if (selectedUsers.length === filteredData.length) {
            setSelectedUsers([]);
        } else {
            setSelectedUsers(filteredData.map((user) => user.id));
        }
    };

    useEffect(() => {
        let filtered;
        if (hasName) {
            filtered = users.filter(
                (user) =>
                    user.name
                        .toLowerCase()
                        .includes(searchQuery.toLowerCase()) ||
                    user.email
                        .toLowerCase()
                        .includes(searchQuery.toLowerCase()) ||
                    user.id == searchQuery
            );
        } else {
            filtered = users.filter(
                (user) =>
                    user.email
                        .toLowerCase()
                        .includes(searchQuery.toLowerCase()) ||
                    user.id == searchQuery
            );
        }
        if (selectedSection) {
            filtered = filtered.filter((user) =>
                user.sections.some((section) => section.id == selectedSection)
            );
        }
        setFilteredData(filtered);
        let current;
        if (hasName) {
            current = users.filter(
                (user) =>
                    user.name
                        .toLowerCase()
                        .includes(searchQuery.toLowerCase()) ||
                    user.email
                        .toLowerCase()
                        .includes(searchQuery.toLowerCase()) ||
                    user.id == searchQuery
            );
        } else {
            current = users.filter(
                (user) =>
                    user.email
                        .toLowerCase()
                        .includes(searchQuery.toLowerCase()) ||
                    user.id == searchQuery
            );
        }

        if (selectedSection) {
            current = current.filter((user) =>
                user.sections.some((section) => section.id == selectedSection)
            );
        }
        current = current.filter((item, index) => {
            return (
                index >= currentPage * parseInt(pageSize) &&
                index < (currentPage + 1) * parseInt(pageSize)
            );
        });
        setCurrentData(current);
    }, [currentPage, searchQuery, users, pageSize, selectedSection]);

    useEffect(() => {
        if (accordionRef.current) {
            accordionRef.current.style.maxHeight = isAccordionOpen
                ? `${accordionRef.current.scrollHeight}px`
                : "0";
        }
    }, [isAccordionOpen, pageSize, filteredData]);

    return (
        <div className="rounded-sm w-full border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
            <h3
                className="font-medium text-black dark:text-white mb-4 cursor-pointer flex justify-between items-center"
                onClick={() => setIsAccordionOpen(!isAccordionOpen)}
            >
                تحديد حسابات ({selectedUsers.length}/{users.length})
                <FontAwesomeIcon
                    icon={isAccordionOpen ? faChevronUp : faChevronDown}
                    className="transition-transform duration-300"
                />
            </h3>
            {isAccordionOpen && (
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
                    {lawyer_sections != null && (
                        <div className="col-span-6">
                            <SelectGroup
                                options={lawyer_sections as any}
                                selectedOption={selectedSection}
                                setSelectedOption={setSelectedSection}
                                title="المهنة"
                                firstOptionDisabled={false}
                                firstOptionName="الكل"
                            />
                        </div>
                    )}
                </div>
            )}
            <div
                ref={accordionRef}
                className={`transition-max-height duration-500 ease-in-out overflow-hidden`}
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
                                                    selectedUsers.length ===
                                                    filteredData.length
                                                }
                                                onChange={toggleSelectAll}
                                            />
                                            اختيار الكل
                                        </th>
                                        {hasName && (
                                            <th className="min-w-[20px] py-4 px-4 font-medium text-black dark:text-white ">
                                                الأسم
                                            </th>
                                        )}
                                        <th className="min-w-[20px] py-4 px-4 font-medium text-black dark:text-white ">
                                            الأيميل
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {currentData.map((user) => (
                                        <tr key={user.id}>
                                            <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                                <input
                                                    type="checkbox"
                                                    checked={selectedUsers.includes(
                                                        user.id
                                                    )}
                                                    onChange={() =>
                                                        toggleProductSelection(
                                                            user.id
                                                        )
                                                    }
                                                />
                                            </td>
                                            {hasName && (
                                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                                    {user.name}
                                                </td>
                                            )}
                                            <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                                {user.email}
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
};

export default UserSelectionTable;
