import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import React, { useEffect, useState } from "react";
import { faReply, faTrash, faUserPen } from "@fortawesome/free-solid-svg-icons";
import { Link, router } from "@inertiajs/react";
import axios from "axios";
import toast from "react-hot-toast";
import ReactPaginate from "react-paginate";
import Pagination from "../../../Pagination";
const BooksSettingsTable = ({
    headers,
    data,
    mainCategories,
    subCategories,
    setDeleteModalOpen,
}: {
    headers: string[];
    data: any[];
    mainCategories: any[];
    subCategories: any[];
    setDeleteModalOpen: any;
}) => {
    const [pageSize, setPageSize] = useState("100");
    const [currentPage, setCurrentPage] = useState(0);
    const [searchQuery, setSearchQuery] = useState("");

    const [selectedSubCategory, setSelectedSubCategory] = useState("");
    const [selectedMainCategory, setSelectedMainCategory] = useState("");

    const [filteredData, setFilteredData] = useState<any[]>([]);
    const [currentData, setCurrentData] = useState<any[]>([]);
    const paginate = (pageNumber: number) => setCurrentPage(pageNumber);
    const [availableSub, setAvailableSub] = useState(subCategories);

    useEffect(() => {
        if (selectedMainCategory == "") {
            setAvailableSub(subCategories);
        } else {
            setAvailableSub(
                subCategories.filter(
                    (subCat) => subCat.main_category.id == selectedMainCategory
                )
            );
        }
    }, [selectedMainCategory]);
    useEffect(() => {
        setFilteredData(
            data
                .filter(
                    (category) =>
                        category.name
                            .toLowerCase()
                            .includes(searchQuery.toLowerCase()) ||
                        category.id == searchQuery
                )
                .filter(
                    (category) =>
                        category.mainCategory.id == selectedMainCategory ||
                        selectedMainCategory === ""
                )
                .filter(
                    (category) =>
                        category.subCategory.id == selectedSubCategory ||
                        selectedSubCategory === ""
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
                .filter(
                    (category) =>
                        category.mainCategory.id == selectedMainCategory ||
                        selectedMainCategory === ""
                )
                .filter(
                    (category) =>
                        category.subCategory.id == selectedSubCategory ||
                        selectedSubCategory === ""
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
                <div className="col-span-4">
                    <label>البحث</label>
                    <input
                        type="text"
                        placeholder="ابحث بالأسم او الرقم العريفي..."
                        value={searchQuery}
                        onChange={(e) => setSearchQuery(e.target.value)}
                        className="mb-4 px-4 py-3 w-full border rounded-md dark:border-strokedark dark:bg-boxdark"
                    />
                </div>
                <div className="col-span-3">
                    <label>القسم الرئيسي</label>
                    <select
                        className="mb-4 px-4 py-2 w-full border rounded-md dark:border-strokedark dark:bg-boxdark"
                        value={selectedMainCategory}
                        onChange={(e) =>
                            setSelectedMainCategory(e.target.value)
                        }
                    >
                        <option value="">الكل</option>
                        {mainCategories.map((category) => (
                            <option value={category.id}>{category.name}</option>
                        ))}
                    </select>
                </div>
                <div className="col-span-3">
                    <label>القسم الفرعي</label>
                    <select
                        className="mb-4 px-4 py-2 w-full border rounded-md dark:border-strokedark dark:bg-boxdark"
                        value={selectedSubCategory}
                        onChange={(e) => setSelectedSubCategory(e.target.value)}
                    >
                        <option value="">الكل</option>
                        {availableSub.map((category) => (
                            <option value={category.id}>{category.name}</option>
                        ))}
                    </select>
                </div>
                <div className="col-span-2 flex items-center justify-end">
                    <Link
                        href="/newAdmin/settings/books/create"
                        className="px-4 py-2 bg-purple-500 text-white rounded-xl hover:bg-purple-700"
                    >
                        اضافة كتاب
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
                        {currentData.map((book, key) => (
                            <tr key={key}>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {book.id}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {book.mainCategory.name}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {book.subCategory.name}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {book.name}
                                    </h5>
                                </td>

                                <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <div className="flex items-center gap-5">
                                        <Link
                                            href={`/newAdmin/settings/books/${book.id}`}
                                            className="hover:text-primary"
                                        >
                                            <FontAwesomeIcon icon={faUserPen} />
                                        </Link>
                                        <button
                                            onClick={() =>
                                                setDeleteModalOpen({
                                                    state: true,
                                                    id: book.id,
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

export default BooksSettingsTable;
