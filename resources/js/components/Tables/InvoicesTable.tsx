import React, { useState } from "react";

const InvoicesTable = ({ headers, data }) => {
    const [statusFilter, setStatusFilter] = useState("all");
    const [searchQuery, setSearchQuery] = useState("");
    const filteredData = data.filter((invoice) => {
        const matchesStatus =
            statusFilter === "all" || invoice.statusText === statusFilter;

        const query = searchQuery.toLowerCase();
        const matchesSearch =
            (invoice.customerName || "").toLowerCase().includes(query) ||
            (invoice.invoiceNumber || "").toLowerCase().includes(query) ||
            (invoice.id?.toString() || "").includes(query);

        return matchesStatus && matchesSearch;
    });

    return (
        <div
            className="overflow-x-auto bg-white rounded-lg shadow-md p-4"
            dir="rtl"
        >
            <div className="mb-4 flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between">
                <input
                    type="text"
                    placeholder="بحث باسم العميل أو الرقم المرجعي أو رقم  ID"
                    value={searchQuery}
                    onChange={(e) => setSearchQuery(e.target.value)}
                    className="border border-gray-300 rounded-lg px-4 py-2 w-full sm:w-1/2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                />

                <select
                    value={statusFilter}
                    onChange={(e) => setStatusFilter(e.target.value)}
                    className="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >
                    <option value="all">الكل</option>
                    <option value="قيد الانتظار">قيد الانتظار</option>
                    <option value="مدفوعة">مدفوعة</option>
                    <option value="مرفوضة">مرفوضة</option>
                </select>
            </div>

            <table className="min-w-full table-auto border-collapse bg-white  rounded-lg">
                <thead>
                    <tr className="bg-gray-100 text-gray-700">
                        {headers.map((header, index) => (
                            <th
                                key={index}
                                className="px-6 py-3 text-right font-semibold text-sm uppercase border-b border-gray-200"
                            >
                                {header}
                            </th>
                        ))}
                    </tr>
                </thead>
                <tbody>
                    {filteredData.length > 0 ? (
                        filteredData.map((invoice) => (
                            <tr
                                key={invoice.id}
                                className="hover:bg-gray-50 transition-all duration-300 ease-in-out"
                            >
                                <td className="px-6 py-4 text-right">
                                    {invoice.id}
                                </td>
                                <td className="px-6 py-4 text-right">
                                    {invoice.invoiceNumber}
                                </td>
                                <td className="px-6 py-4 text-right">
                                    {invoice.customerName}
                                </td>
                                <td className="px-6 py-4 text-right">
                                    {invoice.service}
                                </td>
                                <td className="px-6 py-4 text-right">
                                    {invoice.totalAmount}
                                    <img
                                        src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSx34eO8RbZlsetN1iAQtxuOLnLOlyJbJmU7Q&s"
                                        className="inline-block ml-2"
                                        style={{
                                            width: "20px",
                                            height: "20px",
                                            transform: "scale(0.8)",
                                        }}
                                    />
                                </td>
                                <td className="px-6 py-4 text-right">
                                    <span
                                        className={`${
                                            invoice.statusText === "مدفوعة"
                                                ? "text-green-500"
                                                : invoice.statusText ===
                                                  "مرفوضة"
                                                ? "text-red-500"
                                                : invoice.statusText === "معلقة"
                                                ? "text-orange-500"
                                                : ""
                                        }`}
                                    >
                                        {invoice.statusText}
                                    </span>
                                </td>
                                <td className="px-6 py-4 text-right">
                                    {invoice.createdAt}
                                </td>
                            </tr>
                        ))
                    ) : (
                        <tr>
                            <td
                                colSpan={headers.length}
                                className="text-center py-4 text-gray-500"
                            >
                                لا توجد نتائج مطابقة
                            </td>
                        </tr>
                    )}
                </tbody>
            </table>
        </div>
    );
};

export default InvoicesTable;
