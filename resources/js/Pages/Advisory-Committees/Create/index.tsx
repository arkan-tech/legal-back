import React, { useRef, useState } from "react";

import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import AdvisoryCommitteesForm from "../../../components/Forms/AdvisoryCommittees/AdvisoryCommitteesForm";
import DefaultLayout from "../../../layout/DefaultLayout";
import Breadcrumb from "../../../components/Breadcrumbs/Breadcrumb";
import SuccessNotification from "../../../components/SuccessNotification";
import ErrorNotification from "../../../components/ErrorNotification";

function AdvisoryCommitteesCreate() {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState("");
    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);
    const contentRef = useRef<HTMLDivElement>(null);

    async function saveData() {
        router.post(
            "/admin/advisory-committees/store",
            {
                name,
            },
            {
                onSuccess: () => {
                    setIsSuccess(true);
                    contentRef.current?.scrollIntoView({ behavior: "smooth" });
                },
                onError: (err) => {
                    setErrors(err);
                    setIsError(true);
                    contentRef.current?.scrollIntoView({ behavior: "smooth" });
                },
            }
        );
    }
    return (
        <DefaultLayout>
            <div ref={contentRef}>
                <Breadcrumb pageName="اضافة هيئة استشارية" />
                {isSuccess && <SuccessNotification classNames="my-2" />}
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

export default AdvisoryCommitteesCreate;
