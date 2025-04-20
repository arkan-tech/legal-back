import { router } from "@inertiajs/react";
import axios from "axios";
import React, { useEffect, useState } from "react";
import toast from "react-hot-toast";
function ContactUsRequestsForm({
    replySubject,
    replyDescription,
    setReplySubject,
    setReplyDescription,
    request,
    types,
    saveData,
}) {
    const [isDisabled, setIsDisabled] = useState(true);
    useEffect(() => {
        if (replySubject != "" && replyDescription != "") {
            setIsDisabled(false);
        } else {
            setIsDisabled(true);
        }
    }, [replySubject, replyDescription]);

    return (
        <>
            <div
                className="grid grid-cols-1 gap-9"
                style={{ direction: "rtl" }}
            >
                <div className="flex flex-col gap-9">
                    <div className="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                        <div className="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                            <h3 className="font-medium text-black dark:text-white">
                                الشكوى
                            </h3>
                        </div>
                        <div className="p-6.5">
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        اسم مقدم الشكوى
                                    </label>
                                    <input
                                        type="text"
                                        placeholder="الاسم"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={
                                            request.account?.name ||
                                            request.name
                                        }
                                        disabled
                                    />
                                </div>
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        نوع الحساب
                                    </label>
                                    <input
                                        type="text"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={
                                            request.account?.accountType ==
                                            "lawyer"
                                                ? "مقدم خدمة"
                                                : request.account
                                                      ?.accountType == "client"
                                                ? "عميل"
                                                : "زائر"
                                        }
                                        disabled
                                    />
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        الموضوع{" "}
                                    </label>
                                    <input
                                        type="text"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={request.subject}
                                        disabled
                                    />
                                </div>
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        نوع الشكوى{" "}
                                    </label>
                                    <input
                                        type="text"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={
                                            types.find(
                                                (type) =>
                                                    type.id == request.type
                                            ).name
                                        }
                                        disabled
                                    />
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full xl:w-1/2">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        الوصف
                                    </label>
                                    <textarea
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={request.details}
                                        disabled
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                        <div className="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                            <h3 className="font-medium text-black dark:text-white">
                                الرد على الشكوى
                            </h3>
                        </div>
                        <div className="p-6.5">
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        الموضوع
                                    </label>
                                    <input
                                        type="text"
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={replySubject}
                                        onChange={(e) =>
                                            setReplySubject(e.target.value)
                                        }
                                    />
                                </div>
                            </div>
                            <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div className="w-full">
                                    <label className="mb-2.5 block text-black dark:text-white">
                                        الوصف
                                    </label>
                                    <textarea
                                        className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                        value={replyDescription}
                                        onChange={(e) =>
                                            setReplyDescription(e.target.value)
                                        }
                                    />
                                </div>
                            </div>
                            {request.reply_user_id != null && (
                                <div className="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                    <div className="w-full">
                                        <label className="mb-2.5 block text-black dark:text-white">
                                            اسم المستخدم الذي رد
                                        </label>
                                        <input
                                            type="text"
                                            className="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                            value={request.user.name}
                                            disabled
                                        />
                                    </div>
                                </div>
                            )}
                        </div>
                    </div>
                </div>
                <div className="flex gap-6">
                    <button
                        onClick={saveData}
                        className={`flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90 disabled:bg-slate-500 disabled:bg-opacity-100 ${
                            request.reply_subject && "hidden"
                        }`}
                        disabled={isDisabled}
                    >
                        الرد على الخدمة{" "}
                    </button>
                    <button
                        onClick={() =>
                            router.get("/newAdmin/contact-us-requests")
                        }
                        className="flex w-full justify-center rounded bg-danger p-3 font-medium text-gray hover:bg-opacity-90"
                    >
                        الرجوع للقائمة
                    </button>
                </div>
            </div>
        </>
    );
}

export default ContactUsRequestsForm;
