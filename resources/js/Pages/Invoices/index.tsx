import React, { useState } from "react";
import DefaultLayout from "../../layout/DefaultLayout";
import Breadcrumb from "../../components/Breadcrumbs/Breadcrumb";
import InvoicesTable from "../../components/Tables/InvoicesTable";

const parseArabicDate = (arabicDate) => {
    const months = {
        يناير: "01",
        فبراير: "02",
        مارس: "03",
        أبريل: "04",
        مايو: "05",
        يونيو: "06",
        يوليو: "07",
        أغسطس: "08",
        سبتمبر: "09",
        أكتوبر: "10",
        نوفمبر: "11",
        ديسمبر: "12",
    };

    const parts = arabicDate.split(" ");
    const day = parts[0].padStart(2, "0");
    const month = months[parts[1]];
    const year = parts[2];
    const time = parts[3] || "00:00";

    const formattedDate = `${year}-${month}-${day}T${time}`;
    return new Date(formattedDate);
};

const Page = ({ invoices }) => {
    const [filterRange, setFilterRange] = useState("month");

    const headers = [
        "#",
        "رقم الفاتورة",
        "اسم العميل",
        "الخدمة",
        "إجمالي المبلغ",
        "حالة الفاتورة",
        "تاريخ الفاتورة",
    ];

    const mappedInvoices = invoices.map((invoice) => {
        return {
            id: invoice.id,
            invoiceNumber: invoice.transaction_id,
            customerName: invoice.user_name,
            totalAmount: invoice.amount,
            service: invoice.serviceCate,
            description: invoice.description,
            status: invoice.status,
            statusText:
                invoice.status === "1"
                    ? "معلقة"
                    : invoice.status === "paid"
                    ? "مدفوعة"
                    : "مرفوضة",
            createdAt: invoice.created_at,
        };
    });

    // 🧠 فلترة الإحصائيات فقط بناءً على التاريخ
    const now = new Date();
    const getDateRange = () => {
        const start = new Date();
        if (filterRange === "week") {
            const day = start.getDay();
            start.setDate(start.getDate() - day);
        } else if (filterRange === "month") {
            start.setDate(1);
        } else if (filterRange === "year") {
            start.setMonth(0);
            start.setDate(1);
        }
        return [start, now];
    };

    const [startDate, endDate] = getDateRange();

    const filteredInvoices = mappedInvoices.filter((inv) => {
        const created = parseArabicDate(inv.createdAt);
        return created >= startDate && created <= endDate;
    });

    const paidCount = filteredInvoices.filter(
        (inv) => inv.status === "paid"
    ).length;
    const pendingCount = filteredInvoices.filter(
        (inv) => inv.status === "1"
    ).length;
    const rejectedCount = filteredInvoices.filter(
        (inv) => inv.status !== "paid" && inv.status !== "1"
    ).length;

    return (
        <DefaultLayout>
            <Breadcrumb pageName="الفواتير" />

            {/* 🔝 اختيار الفلترة */}
            <div className="flex justify-end mb-4">
                <select
                    className="border border-gray-300 rounded-lg px-4 py-2"
                    value={filterRange}
                    onChange={(e) => setFilterRange(e.target.value)}
                >
                    <option value="week">هذا الأسبوع</option>
                    <option value="month">هذا الشهر</option>
                    <option value="year">هذه السنة</option>
                </select>
            </div>

            {/* 🔢 كروت الإحصائيات */}
            <div className="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
                {/* كارت مدفوعة */}
                <div className="bg-gradient-to-tr from-green-100 to-green-50 border border-green-200 p-5 rounded-xl shadow-sm hover:shadow-md transition duration-300 text-center">
                    <div className="flex items-center justify-center mb-3">
                        <svg
                            className="w-8 h-8 text-green-500"
                            fill="none"
                            stroke="currentColor"
                            strokeWidth="2"
                            viewBox="0 0 24 24"
                        >
                            <path
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                d="M5 13l4 4L19 7"
                            />
                        </svg>
                    </div>
                    <h3 className="text-md font-semibold text-green-700 mb-1">
                        مدفوعة
                    </h3>
                    <p className="text-3xl font-bold text-green-600">
                        {paidCount}
                    </p>
                </div>

                {/* كارت قيد الانتظار */}
                <div className="bg-gradient-to-tr from-yellow-100 to-yellow-50 border border-yellow-200 p-5 rounded-xl shadow-sm hover:shadow-md transition duration-300 text-center">
                    <div className="flex items-center justify-center mb-3">
                        <svg
                            className="w-8 h-8 text-yellow-500"
                            fill="none"
                            stroke="currentColor"
                            strokeWidth="2"
                            viewBox="0 0 24 24"
                        >
                            <path
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>
                    </div>
                    <h3 className="text-md font-semibold text-yellow-700 mb-1">
                        قيد الانتظار
                    </h3>
                    <p className="text-3xl font-bold text-yellow-600">
                        {pendingCount}
                    </p>
                </div>

                {/* كارت مرفوضة */}
                <div className="bg-gradient-to-tr from-red-100 to-red-50 border border-red-200 p-5 rounded-xl shadow-sm hover:shadow-md transition duration-300 text-center">
                    <div className="flex items-center justify-center mb-3">
                        <svg
                            className="w-8 h-8 text-red-500"
                            fill="none"
                            stroke="currentColor"
                            strokeWidth="2"
                            viewBox="0 0 24 24"
                        >
                            <path
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </div>
                    <h3 className="text-md font-semibold text-red-700 mb-1">
                        مرفوضة
                    </h3>
                    <p className="text-3xl font-bold text-red-600">
                        {rejectedCount}
                    </p>
                </div>
            </div>

            {/* 📋 جدول الفواتير - استخدم البيانات الأصلية */}
            <InvoicesTable headers={headers} data={mappedInvoices} />
        </DefaultLayout>
    );
};

export default Page;
