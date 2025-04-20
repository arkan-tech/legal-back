import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import React, { useEffect, useState } from "react";
import { faReply, faTrash, faUserPen } from "@fortawesome/free-solid-svg-icons";
import { Link, router } from "@inertiajs/react";
import axios from "axios";
import toast from "react-hot-toast";
import ReactPaginate from "react-paginate";
import Pagination from "../../../Pagination";
const JudicialGuideSettingsTable = ({
    headers,
    data,
    mainCategories,
    subCategories,
    setDeleteModalOpen,
    compact = false,
    countries,
    regions,
    cities,
}: {
    headers: string[];
    data: any[];
    mainCategories: any[];
    subCategories: any[];
    setDeleteModalOpen: any;
    compact?: boolean;
    countries;
    regions;
    cities;
}) => {
    const [pageSize, setPageSize] = useState("100");
    const [currentPage, setCurrentPage] = useState(0);
    const [searchQuery, setSearchQuery] = useState("");
    const [selectedCountry, setSelectedCountry] = useState("");
    const [selectedSubCategory, setSelectedSubCategory] = useState("");
    const [selectedMainCategory, setSelectedMainCategory] = useState("");
    const [selectedRegion, setSelectedRegion] = useState("");
    const [selectedCity, setSelectedCity] = useState("");
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
                        category.mainCategory.id == selectedMainCategory ||
                        selectedMainCategory === ""
                )
                .filter(
                    (category) =>
                        category.subCategory.id == selectedSubCategory ||
                        selectedSubCategory === ""
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
        selectedCountry,
        selectedSubCategory,
        selectedMainCategory,
        selectedRegion,
        selectedCity,
    ]);
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
                        href="/newAdmin/settings/judicial-guide/create"
                        className="px-4 py-2 bg-purple-500 text-white rounded-xl hover:bg-purple-700"
                    >
                        اضافة دائرة
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
                        {currentData.map((judicialGuide, key) => (
                            <tr key={key}>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {judicialGuide.id}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {judicialGuide.mainCategory.name}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {judicialGuide.subCategory.name}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {judicialGuide.name}
                                    </h5>
                                </td>

                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {judicialGuide.city}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <div className="flex items-center gap-5">
                                        <Link
                                            href={`/newAdmin/settings/judicial-guide/${judicialGuide.id}`}
                                            className="hover:text-primary"
                                        >
                                            <FontAwesomeIcon icon={faUserPen} />
                                        </Link>
                                        {!compact && (
                                            <button
                                                onClick={() =>
                                                    setDeleteModalOpen({
                                                        state: true,
                                                        id: judicialGuide.id,
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

export default JudicialGuideSettingsTable;
