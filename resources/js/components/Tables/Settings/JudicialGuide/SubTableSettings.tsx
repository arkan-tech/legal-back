import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import React, { useEffect, useState } from "react";
import { faReply, faTrash, faUserPen } from "@fortawesome/free-solid-svg-icons";
import { Link, router } from "@inertiajs/react";
import axios from "axios";
import toast from "react-hot-toast";
import ReactPaginate from "react-paginate";
import Pagination from "../../../Pagination";
const SubTableSettings = ({
    headers,
    data,
    mainCategories,
    countries,
    regions,
    cities,
    setDeleteModalOpen,
    compact = false,
}: {
    headers: string[];
    data: any[];
    mainCategories: any[];
    setDeleteModalOpen;
    countries;
    regions;
    cities;
    compact?: boolean;
}) => {
    const [pageSize, setPageSize] = useState("10");
    const [currentPage, setCurrentPage] = useState(0);
    const [searchQuery, setSearchQuery] = useState("");
    const [selectedCategory, setSelectedCategory] = useState("");
    const [selectedCountry, setSelectedCountry] = useState("");
    const [selectedRegion, setSelectedRegion] = useState("");
    const [selectedCity, setSelectedCity] = useState("");
    const [filteredData, setFilteredData] = useState<any[]>([]);
    const [currentData, setCurrentData] = useState<any[]>([]);
    const paginate = (pageNumber: number) => setCurrentPage(pageNumber);

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
                        category.mainCategoryId == selectedCategory ||
                        selectedCategory === ""
                )
                .filter(
                    (category) =>
                        category.regionId == selectedRegion ||
                        selectedRegion === ""
                )
                .filter(
                    (category) =>
                        category.cityId == selectedCity || selectedCity === ""
                )
                .filter(
                    (category) =>
                        category.countryId == selectedCountry ||
                        selectedCountry === ""
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
                        category.mainCategoryId == selectedCategory ||
                        selectedCategory === ""
                )
                .filter(
                    (category) =>
                        category.regionId == selectedRegion ||
                        selectedRegion === ""
                )
                .filter(
                    (category) =>
                        category.cityId == selectedCity || selectedCity === ""
                )
                .filter(
                    (category) =>
                        category.countryId == selectedCountry ||
                        selectedCountry === ""
                )
                .filter((item, index) => {
                    return (
                        index >= currentPage * parseInt(pageSize) &&
                        index < (currentPage + 1) * parseInt(pageSize)
                    );
                })
        );
    }, [
        currentPage,
        searchQuery,
        selectedCategory,
        selectedCity,
        selectedCountry,
        selectedRegion,
    ]);
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
                <div className="col-span-4">
                    <label>القسم الرئيسي</label>
                    <select
                        className="mb-4 px-4 py-2 w-full border rounded-md dark:border-strokedark dark:bg-boxdark"
                        value={selectedCategory}
                        onChange={(e) => setSelectedCategory(e.target.value)}
                    >
                        <option value="">الكل</option>
                        {mainCategories.map((category) => (
                            <option value={category.id}>{category.name}</option>
                        ))}
                    </select>
                </div>

                <div className="col-span-2 flex items-center justify-end">
                    <Link
                        href="/newAdmin/settings/judicial-guide/sub/create"
                        className="px-4 py-2 bg-purple-500 text-white rounded-xl hover:bg-purple-700"
                    >
                        اضافة محكمة
                    </Link>
                </div>
            </div>
            <div className="grid grid-cols-12 gap-2">
                <div className="col-span-4">
                    <label>الدولة</label>
                    <select
                        className="mb-4 px-4 py-2 w-full border rounded-md dark:border-strokedark dark:bg-boxdark"
                        value={selectedCountry}
                        onChange={(e) => setSelectedCountry(e.target.value)}
                    >
                        <option value="">الكل</option>
                        {countries.map((country) => (
                            <option value={country.id}>{country.name}</option>
                        ))}
                    </select>
                </div>
                <div className="col-span-4">
                    <label>المنطقة</label>
                    <select
                        className="mb-4 px-4 py-2 w-full border rounded-md dark:border-strokedark dark:bg-boxdark"
                        value={selectedRegion}
                        onChange={(e) => setSelectedRegion(e.target.value)}
                    >
                        <option value="">الكل</option>
                        {regions
                            .filter((r) => r.country_id == selectedCountry)
                            .map((category) => (
                                <option value={category.id}>
                                    {category.name}
                                </option>
                            ))}
                    </select>
                </div>
                <div className="col-span-4">
                    <label>المدينة</label>
                    <select
                        className="mb-4 px-4 py-2 w-full border rounded-md dark:border-strokedark dark:bg-boxdark"
                        value={selectedCity}
                        onChange={(e) => setSelectedCity(e.target.value)}
                    >
                        <option value="">الكل</option>
                        {cities
                            .filter(
                                (c) =>
                                    c.country_id == selectedCountry &&
                                    c.region_id == selectedRegion
                            )
                            .map((category) => (
                                <option value={category.id}>
                                    {category.title}
                                </option>
                            ))}
                    </select>
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
                        {currentData.map((category, key) => (
                            <tr key={key}>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {category.id}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {category.mainCategory}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {category.name}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {category.region}
                                    </h5>
                                </td>

                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {category.numberOfCircuits}
                                    </h5>
                                </td>

                                <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <div className="flex items-center gap-5">
                                        <Link
                                            href={`/newAdmin/settings/judicial-guide/sub/${category.id}`}
                                            className="hover:text-primary"
                                        >
                                            <FontAwesomeIcon icon={faUserPen} />
                                        </Link>
                                        {!compact && (
                                            <button
                                                onClick={() =>
                                                    setDeleteModalOpen({
                                                        state: true,
                                                        id: category.id,
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

export default SubTableSettings;
