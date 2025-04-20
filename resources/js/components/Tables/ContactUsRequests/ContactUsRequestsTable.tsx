import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import React, { useEffect, useState } from "react";
import {
    faEye,
    faReply,
    faTrash,
    faUserPen,
} from "@fortawesome/free-solid-svg-icons";
import { Link, router } from "@inertiajs/react";
import axios from "axios";
import toast from "react-hot-toast";
import ReactPaginate from "react-paginate";
import SelectGroup from "../../Forms/SelectGroup/SelectGroup";
import Switcher from "../../Switchers/Switcher";
import Pagination from "../../Pagination";
const ContactUsRequestsTable = ({
    headers,
    data,
    requestTypes,
}: {
    headers: string[];
    data: any[];
    requestTypes;
}) => {
    const [pageSize, setPageSize] = useState("100");
    const [currentPage, setCurrentPage] = useState(0);
    const [searchQuery, setSearchQuery] = useState("");
    const [filteredData, setFilteredData] = useState<any[]>([]);
    const [currentData, setCurrentData] = useState<any[]>([]);
    const [requestType, setRequestType] = useState("");
    const [userType, setUserType] = useState("");
    const [showDone, setShowDone] = useState(false);
    const paginate = (pageNumber: number) => setCurrentPage(pageNumber);

    useEffect(() => {
        console.log(userType);
        console.log(data);
        setFilteredData(
            data
                .filter(
                    (request) =>
                        request.name
                            .toLowerCase()
                            .includes(searchQuery.toLowerCase()) ||
                        request.id == searchQuery
                )
                .filter((request) =>
                    requestType != ""
                        ? request.requestTypeId.toString() == requestType
                        : true
                )
                .filter((request) =>
                    userType != "" ? request.reserverType == userType : true
                )
                .filter((request) =>
                    showDone == false
                        ? request.status == "لم يتم الرد بعد"
                        : true
                )
        );
        setCurrentData(
            data
                .filter(
                    (request) =>
                        request.subject
                            .toLowerCase()
                            .includes(searchQuery.toLowerCase()) ||
                        request.id == searchQuery
                )
                .filter((request) =>
                    requestType != ""
                        ? request.requestTypeId.toString() == requestType
                        : true
                )
                .filter((request) =>
                    userType != "" ? request.reserverType == userType : true
                )
                .filter((request) =>
                    showDone == false
                        ? request.status == "لم يتم الرد بعد"
                        : true
                )
                .filter((item, index) => {
                    return (
                        index >= currentPage * parseInt(pageSize) &&
                        index < (currentPage + 1) * parseInt(pageSize)
                    );
                })
        );
    }, [currentPage, searchQuery, requestType, userType, showDone]);
    return (
        <div
            style={{ direction: "rtl" }}
            className="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1"
        >
            <div className="grid grid-cols-12 gap-2">
                <div className="col-span-3 flex flex-col h-full justify-between py-1 gap-1.5">
                    <label className="text-white">البحث</label>
                    <input
                        type="text"
                        placeholder="ابحث بالموضوع او بالرقم التعريفي..."
                        value={searchQuery}
                        onChange={(e) => setSearchQuery(e.target.value)}
                        className="mb-4 px-4 py-3 w-full border rounded-md dark:border-strokedark dark:bg-boxdark"
                    />
                </div>
                <div className="col-span-3">
                    <SelectGroup
                        title="نوع الحساب"
                        options={[
                            {
                                id: "lawyer",
                                name: "مقدم خدمة",
                            },
                            {
                                id: "client",
                                name: "عميل",
                            },
                            {
                                id: "visitor",
                                name: "زائر",
                            },
                        ]}
                        selectedOption={userType}
                        setSelectedOption={setUserType}
                        firstOptionDisabled={false}
                        firstOptionName="الكل"
                    />
                </div>
                <div className="col-span-3">
                    <SelectGroup
                        title="نوع الشكوى"
                        options={requestTypes}
                        selectedOption={requestType}
                        setSelectedOption={setRequestType}
                        firstOptionDisabled={false}
                        firstOptionName="الكل"
                    />
                </div>
                <div className="col-span-3 flex h-full gap-2 items-center">
                    <label>اظهار الطلبات التي تم الرد عليها</label>
                    <Switcher
                        enabled={showDone}
                        setEnabled={setShowDone}
                        id="showDone"
                    />
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
                        {currentData.map((request, key) => (
                            <tr key={key}>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {request.id}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {request.name}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {request.type}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {request.subject}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {request.requestType}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {request.status}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {request.createdAt
                                            .split(" ")
                                            .splice(0, 3)
                                            .join(" ")}
                                    </h5>
                                </td>
                                <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 className="font-medium text-black dark:text-white">
                                        {
                                            request.createdAt.split(" ")[
                                                request.createdAt.split(" ")
                                                    .length - 1
                                            ]
                                        }
                                    </h5>
                                </td>

                                <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <div className="flex items-center gap-5">
                                        <Link
                                            href={`/newAdmin/contact-us-requests/${request.id}`}
                                            className="hover:text-primary"
                                        >
                                            <FontAwesomeIcon icon={faEye} />
                                        </Link>
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

export default ContactUsRequestsTable;
