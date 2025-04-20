import { Link, router } from "@inertiajs/react";
import React, { useState } from "react";
function LawyerPayoutForm({
    saveData,
    errors,
    lawyerPayout,
}: {
    saveData: any;
    errors: any;
    lawyerPayout;
}) {
    console.log(lawyerPayout);
    const [formData, setFormData] = useState(
        {
            comment: lawyerPayout?.comment,
        } || {}
    );
    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData((prevData) => ({
            ...prevData,
            [name]: value,
        }));
    };

    const handleSubmit = (status) => {
        saveData({
            comment: formData.comment,
            status,
        });
    };
    return (
        <>
            <div
                className="grid grid-cols-1 gap-9"
                style={{ direction: "rtl" }}
            >
                <form className="flex flex-col gap-9">
                    <div className="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                        <div className="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                            <h3 className="font-medium text-black dark:text-white">
                                طلب التحويل
                            </h3>
                        </div>
                        <div className="p-6.5">
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        اسم مقدم الخدمة
                                    </label>
                                    <input
                                        type="text"
                                        placeholder="الاسم"
                                        name="title"
                                        disabled={true}
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={lawyerPayout.lawyer.name}
                                    />
                                </div>
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        اجمالي الرصيد المطلوب تحويله
                                    </label>
                                    <input
                                        type="number"
                                        placeholder="السعر"
                                        name="price"
                                        disabled={true}
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={lawyerPayout.payments.reduce(
                                            (acc, payment) =>
                                                acc +
                                                payment.product.price * 0.75,
                                            0
                                        )}
                                    />
                                </div>
                            </div>
                            <div className="mb-4.5 flex w-full">
                                <table>
                                    <thead>
                                        <tr className="bg-gray-2 text-right dark:bg-meta-4">
                                            <th className="min-w-[20px] py-4 px-4 font-medium text-black dark:text-white ">
                                                نوع المنتج
                                            </th>
                                            <th className="min-w-[20px] py-4 px-4 font-medium text-black dark:text-white ">
                                                سعر المنتج
                                            </th>
                                            <th className="min-w-[20px] py-4 px-4 font-medium text-black dark:text-white ">
                                                سعر المنتج بعد الضريبة
                                            </th>
                                            <th className="min-w-[20px] py-4 px-4 font-medium text-black dark:text-white ">
                                                حالة الطلب
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {lawyerPayout.payments.map(
                                            (payment, index) => (
                                                <tr key={index}>
                                                    <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                                        {payment.product_type ==
                                                        "service" ? (
                                                            <Link
                                                                className="text-blue-500 underline"
                                                                href={`/newAdmin/services-requests/for-lawyer/${payment.requester_type}/${payment.product.id}`}
                                                            >
                                                                خدمة
                                                            </Link>
                                                        ) : payment.product_type ==
                                                          "advisory-service" ? (
                                                            <Link
                                                                className="text-blue-500 underline"
                                                                href={`/newAdmin/advisory-services-requests/for-lawyer/${payment.requester_type}/${payment.product.id}`}
                                                            >
                                                                استشارة
                                                            </Link>
                                                        ) : (
                                                            <Link
                                                                className="text-blue-500 underline"
                                                                href={`/newAdmin/appointment-requests/for-lawyer/${payment.requester_type}/${payment.product.id}`}
                                                            >
                                                                موعد
                                                            </Link>
                                                        )}
                                                    </td>
                                                    <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                                        {payment.product.price}
                                                    </td>
                                                    <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                                        {payment.product.price *
                                                            0.75}
                                                    </td>
                                                    <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                                        {(payment.product
                                                            .reservation_status &&
                                                            (payment.product
                                                                .reservation_status ==
                                                            5
                                                                ? "تم"
                                                                : "لم يتم")) ||
                                                            (payment.product
                                                                .reservationEnded &&
                                                                (payment.product
                                                                    .reservation_ended ==
                                                                1
                                                                    ? "تم"
                                                                    : "لم يتم")) ||
                                                            (payment.product
                                                                .request_status &&
                                                                (payment.product
                                                                    .request_status ==
                                                                5
                                                                    ? "تم"
                                                                    : "لم يتم"))}
                                                    </td>
                                                </tr>
                                            )
                                        )}
                                    </tbody>
                                </table>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        التعليق
                                    </label>
                                    <textarea
                                        placeholder="التعليق"
                                        name="comment"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={formData.comment}
                                        disabled={lawyerPayout.status != 1}
                                        onChange={handleChange}
                                    />
                                    {errors.comment && (
                                        <p className="text-red-600">
                                            {errors.comment}
                                        </p>
                                    )}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="flex gap-6">
                        {lawyerPayout.status == 1 && (
                            <>
                                <button
                                    type="button"
                                    onClick={() => handleSubmit(2)}
                                    className="flex w-full justify-center rounded bg-green-500 p-3 font-medium text-gray hover:bg-opacity-90"
                                >
                                    قبول الطلب
                                </button>
                                <button
                                    type="submit"
                                    onClick={() => handleSubmit(3)}
                                    className="flex w-full justify-center rounded bg-danger p-3 font-medium text-gray hover:bg-opacity-90"
                                >
                                    رفض الطلب
                                </button>
                            </>
                        )}
                    </div>
                </form>
            </div>
        </>
    );
}

export default LawyerPayoutForm;
