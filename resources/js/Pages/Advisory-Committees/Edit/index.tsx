import React, { useRef, useState } from "react";

import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import AdvisoryCommitteesForm from "../../../components/Forms/AdvisoryCommittees/AdvisoryCommitteesForm";
import DefaultLayout from "../../../layout/DefaultLayout";
import Breadcrumb from "../../../components/Breadcrumbs/Breadcrumb";
import SuccessNotification from "../../../components/SuccessNotification";
import ErrorNotification from "../../../components/ErrorNotification";

function AdvisoryCommitteesEdit({ advisoryCommittee, success }) {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState(advisoryCommittee?.title || "");
    const contentRef = useRef<HTMLDivElement>(null);
    const [isSuccess, setIsSuccess] = useState(success);
    const [isError, setIsError] = useState(false);
    async function saveData() {
        try {
            const res = await axios.post(`/admin/advisory-committees/update`, {
                id: advisoryCommittee.id,
                name,
            });
            if (res.status == 200) {
                // toast.success("done");
                setIsSuccess(true);
                contentRef.current?.scrollIntoView({ behavior: "smooth" });
            }
        } catch (err) {
            setErrors(err.response.data.errors);
            setIsError(true);
            contentRef.current?.scrollIntoView({ behavior: "smooth" });
        }
    }
    return (
        <DefaultLayout>
            <div ref={contentRef}>
                <Breadcrumb pageName="تعديل الهيئة الأستشارية" />
                {isSuccess &&
                    (isSuccess == true ? (
                        <SuccessNotification classNames="my-2" />
                    ) : (
                        <SuccessNotification
                            message={isSuccess}
                            classNames="my-2"
                        />
                    ))}
                {isError && <ErrorNotification classNames="my-2" />}
                <AdvisoryCommitteesForm
                    errors={errors}
                    saveData={saveData}
                    name={name}
                    setName={setName}
                />
            </div>
        </DefaultLayout>
    );
}

export default AdvisoryCommitteesEdit;
