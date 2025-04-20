import React, { useRef, useState } from "react";

import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import DefaultLayout from "../../../layout/DefaultLayout";
import Breadcrumb from "../../../components/Breadcrumbs/Breadcrumb";
import VisitorForm from "../../../components/Forms/Visitor/VisitorForm";
import SuccessNotification from "../../../components/SuccessNotification";
import ErrorNotification from "../../../components/ErrorNotification";
import MailerAccountsForm from "../../../components/Forms/MailerAccountsForm";

function MailerAccountSettings({ mailer }) {
    console.log(mailer);
    const [errors, setErrors] = useState({});
    const [email, setEmail] = useState(mailer.email);
    const [status, setStatus] = useState(mailer.is_subscribed);
    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);
    const contentRef = useRef<HTMLDivElement>(null);
    async function saveData() {
        try {
            const res = await axios.post(
                `/newAdmin/mailer-accounts/${mailer.id}/update`,
                {
                    email,
                    status,
                }
            );
            if (res.status == 200) {
                setIsSuccess(true);
                contentRef.current?.scrollIntoView({ behavior: "smooth" });
            }
        } catch (err) {
            console.log(err.response.data.errors);
            setErrors(err.response.data.errors);
            setIsError(true);
            contentRef.current?.scrollIntoView({ behavior: "smooth" });
        }
    }
    return (
        <DefaultLayout>
            <div ref={contentRef}>
                <Breadcrumb pageName="تعديل حساب القائمة البريدية" />
                {isSuccess && <SuccessNotification classNames="my-2" />}
                {isError && <ErrorNotification classNames="my-2" />}
                <MailerAccountsForm
                    saveData={saveData}
                    email={email}
                    setEmail={setEmail}
                    status={status}
                    setStatus={setStatus}
                    errors={errors}
                />
            </div>
        </DefaultLayout>
    );
}

export default MailerAccountSettings;
