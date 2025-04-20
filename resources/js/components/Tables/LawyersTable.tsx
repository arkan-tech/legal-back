import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { Package } from "../../types/package";
import React, { useEffect, useState } from "react";
import { faReply, faTrash, faUserPen } from "@fortawesome/free-solid-svg-icons";
import { Link, router } from "@inertiajs/react";
import toast from "react-hot-toast";
import ReactPaginate from "react-paginate";
import Pagination from "../Pagination";
import { GetArabicDate, GetArabicDateTime } from "../../helpers/DateFunctions";

const LawyersTable = ({
    headers,
    data,
    countries,
    cities,
    regions,
    setDeleteModalOpen,
    old = false,
}: {
    headers: string[];
    data: any[];
    countries: any[];
    cities: any[];
    regions;
    setDeleteModalOpen: any;
    old?: boolean;
}) => {
    const [pageSize, setPageSize] = useState("100");
    const [currentPage, setCurrentPage] = useState(0);
    const [searchQuery, setSearchQuery] = useState("");
    const [selectedStatus, setSelectedStatus] = useState("");
    const [filteredData, setFilteredData] = useState<any[]>([]);
    const [currentData, setCurrentData] = useState<any[]>([]);
    const [selectedCountry, setSelectedCountry] = useState("");
    const [selectedCity, setSelectedCity] = useState("");
    const paginate = (pageNumber: number) => setCurrentPage(pageNumber);
    console.log(data.filter((lawyer) => lawyer.email == null));
    useEffect(() => {
        setFilteredData(
            data
                .filter(
                    (lawyer) =>
                        lawyer?.name
                            .trim()
                            .toLowerCase()
                            .includes(searchQuery.toLowerCase()) ||
                        lawyer?.email
                            .toLowerCase()
                            .includes(searchQuery.toLowerCase()) ||
                        lawyer.phone.includes(searchQuery) ||
                        lawyer.id == searchQuery
                )
                .filter(
                    (lawyer) =>
                        lawyer?.status === selectedStatus ||
                        selectedStatus === ""
                )
                .filter(
                    (lawyer) =>
                        lawyer?.country_id == selectedCountry ||
                        selectedCountry === ""
                )
                .filter(
                    (lawyer) =>
                        lawyer?.city_id == selectedCity || selectedCity === ""
                )
        );
        setCurrentData(
            data
                .filter(
                    (lawyer) =>
                        lawyer?.name
                            .toLowerCase()
                            .includes(searchQuery.toLowerCase()) ||
                        lawyer?.email
                            .toLowerCase()
                            .includes(searchQuery.toLowerCase()) ||
                        lawyer.phone.includes(searchQuery) ||
                        lawyer.id == searchQuery
                )
                .filter(
                    (lawyer) =>
                        lawyer?.status === selectedStatus ||
                        selectedStatus === ""
                )
                .filter(
                    (lawyer) =>
                        lawyer.country_id == selectedCountry ||
                        selectedCountry === ""
                )
                .filter(
                    (lawyer) =>
                        lawyer.city_id == selectedCity || selectedCity === ""
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
        selectedStatus,
        selectedCity,
        selectedCountry,
        pageSize,
    ]);
    console.log(cities, countries);
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
                <div className="col-span-2">
                    <label>الحالة</label>
                    <select
                        className="mb-4 px-4 py-2 w-full border rounded-md dark:border-strokedark dark:bg-boxdark"
                        value={selectedStatus}
                        onChange={(e) => setSelectedStatus(e.target.value)}
                    >
                        <option value="">الكل</option>
                        {[...new Set(data.map((client) => client.status))].map(
                            (status) => (
                                <option value={status}>{status}</option>
                            )
                        )}
                    </select>
                </div>
                <div className="col-span-2">
                    <label>الدولة</label>
                    <select
                        className="mb-4 px-4 py-2 w-full border rounded-md col-span-2 dark:border-strokedark dark:bg-boxdark"
                        value={selectedCountry}
                        onChange={(e) => setSelectedCountry(e.target.value)}
                    >
                        <option value="">الكل</option>
                        {countries.map((country) => (
                            <option value={country.id}>{country.name}</option>
                        ))}
                    </select>
                </div>
                <div className="col-span-2">
                    <label>المدينة</label>
                    <select
                        className="mb-4 px-4 py-2 w-full border rounded-md col-span-2 dark:border-strokedark dark:bg-boxdark"
                        value={selectedCity}
                        onChange={(e) => setSelectedCity(e.target.value)}
                    >
                        <option value="">الكل</option>
                        {cities
                            .filter((c) => c.country_id == selectedCountry)
                            .map((city) => (
                                <option value={city.id}>{city.title}</option>
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
            <div className="max-w-full overflow-x-auto">
                {/* <div className="transform scale-[82%] 2xl:scale-[98%] origin-top-right"> */}
                <table
                    className="w-full table-auto"
                    style={{ direction: "rtl" }}
                >
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
                        {currentData.map((lawyer, key) => (
                            <tr key={key}>
                                {/* <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                        <h5 className="font-medium text-black dark:text-white">
                                            {lawyer.id}
                                        </h5>
                                    </td> */}
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {lawyer.name}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <p className="text-black dark:text-white">
                                        {lawyer.email}
                                    </p>
                                </td>

                                <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <p className="text-black dark:text-white">
                                        {lawyer.phone}
                                    </p>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <p className="text-black dark:text-white">
                                        {lawyer.phone_code}
                                    </p>
                                </td>
                                {/* <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                        <p className="text-black dark:text-white">
                                            {countries.find(
                                                (c) => c.id == lawyer.country_id
                                            )?.name || "-"}
                                        </p>
                                    </td> */}
                                <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <p className="text-black dark:text-white">
                                        {regions.find(
                                            (r) => r.id == lawyer.region_id
                                        )?.name || "-"}
                                    </p>
                                </td>

                                <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <p
                                        className={`inline-flex rounded-full py-1 px-3 text-sm font-medium ${
                                            old
                                                ? lawyer.statusCode == 1
                                                    ? "bg-success text-white"
                                                    : lawyer.statusCode == 0
                                                    ? "bg-danger text-white"
                                                    : null
                                                : lawyer.statusCode == 1
                                                ? "bg-purple-600 text-white"
                                                : lawyer.statusCode == 2
                                                ? "bg-success text-white"
                                                : lawyer.statusCode == 3
                                                ? "bg-warning text-white"
                                                : "bg-danger text-white"
                                        }`}
                                    >
                                        {lawyer.status}
                                    </p>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <p className="text-black dark:text-white">
                                        {GetArabicDate(lawyer.created_at)}
                                    </p>
                                </td>
                                {!old ? (
                                    <>
                                        <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                            <p className="text-black dark:text-white">
                                                {lawyer.is_old_user
                                                    ? "✅"
                                                    : "❌"}
                                            </p>
                                        </td>
                                        <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                            <p className="text-black dark:text-white">
                                                {lawyer.profile_complete
                                                    ? "✅"
                                                    : "❌"}
                                            </p>
                                        </td>
                                    </>
                                ) : (
                                    <></>
                                )}
                                <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <div className="flex items-center gap-5">
                                        <Link
                                            href={`${
                                                old ? "old-" : ""
                                            }lawyers/${lawyer.id}/edit`}
                                            className="hover:text-primary"
                                        >
                                            <FontAwesomeIcon icon={faUserPen} />
                                        </Link>
                                        <button
                                            onClick={() =>
                                                setDeleteModalOpen({
                                                    state: true,
                                                    id: lawyer.id,
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
                {/* </div> */}
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

export default LawyersTable;
