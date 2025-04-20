import React, { useRef, useState } from "react";

import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import DefaultLayout from "../../../layout/DefaultLayout";
import Breadcrumb from "../../../components/Breadcrumbs/Breadcrumb";
import VisitorForm from "../../../components/Forms/Visitor/VisitorForm";
import SuccessNotification from "../../../components/SuccessNotification";
import ErrorNotification from "../../../components/ErrorNotification";

function MainSettingsEdit({ visitor }) {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState(visitor.name);
    const [email, setEmail] = useState(visitor.email);
    const [mobile, setMobile] = useState(visitor.mobile);
    const [status, setStatus] = useState(visitor.status);
    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);
    const contentRef = useRef<HTMLDivElement>(null);
    async function saveData() {
        try {
            const res = await axios.post(
                `/newAdmin/visitors/${visitor.id}/update`,
                {
                    name,
                    email,
                    mobile,
                    status,
                }
            );
            if (res.status == 200) {
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
                <Breadcrumb pageName="تعديل الزائر" />
                {isSuccess && <SuccessNotification classNames="my-2" />}
                {isError && <ErrorNotification classNames="my-2" />}
                <VisitorForm
                    saveData={saveData}
                    name={name}
                    setName={setName}
                    email={email}
                    setEmail={setEmail}
                    phone={mobile}
                    setPhone={setMobile}
                    status={status}
                    setStatus={setStatus}
                    errors={errors}
                />
            </div>
        </DefaultLayout>
    );
}

export default MainSettingsEdit;
