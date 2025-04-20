import React, { useState } from "react";
import { Head, Link } from "@inertiajs/react";
import DefaultLayout from "../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faArrowRight } from "@fortawesome/free-solid-svg-icons";
import axios from "axios";
import toast from "react-hot-toast";
import TextInput from "../../../../components/TextInput";
import SaveButton from "../../../../components/SaveButton";
import BackButton from "../../../../components/BackButton";

export default function Create() {
    const [errors, setErrors] = useState<any>({});
    const [name, setName] = useState("");

    async function saveData() {
        try {
            const res = await axios.post(
                "/newAdmin/settings/elite-service-categories/create",
                {
                    name: name,
                }
            );
            if (res.status === 200) {
                toast.success("تم انشاء الفئة بنجاح");
                window.location.href =
                    "/newAdmin/settings/elite-service-categories";
            }
        } catch (err) {
            setErrors(err.response.data.errors);
        }
    }

    return (
        <DefaultLayout>
            <Head title="إضافة فئة جديدة" />
            <Breadcrumb pageName="إضافة فئة جديدة" />

            <div
                className="grid grid-cols-1 gap-9"
                style={{ direction: "rtl" }}
            >
                <div className="flex flex-col gap-9">
                    <div className="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                        <div className="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                            <h3 className="font-medium text-black dark:text-white">
                                إضافة فئة جديدة
                            </h3>
                        </div>
                        <div className="p-6.5">
                            <div className="mb-4.5">
                                <TextInput
                                    type="text"
                                    label="اسم الفئة"
                                    value={name}
                                    setValue={setName}
                                    error={errors?.name}
                                    required={true}
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div className="flex gap-6">
                    <SaveButton saveData={saveData} />
                    <BackButton path="/newAdmin/settings/elite-service-categories" />
                </div>
            </div>
        </DefaultLayout>
    );
}
