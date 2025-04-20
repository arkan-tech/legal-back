import React, { useRef, useState } from "react";

import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import DefaultLayout from "../../../layout/DefaultLayout";
import Breadcrumb from "../../../components/Breadcrumbs/Breadcrumb";
import VisitorForm from "../../../components/Forms/Visitor/VisitorForm";
import ContactUsRequestsForm from "../../../components/Forms/ContactUsRequests/ContactUsRequestsForm";
import SuccessNotification from "../../../components/SuccessNotification";
import ErrorNotification from "../../../components/ErrorNotification";

function ContactUsRequestsShow({ request, types }) {
    const [requestData, setRequestData] = useState(request);
    const [replySubject, setReplySubject] = useState(
        request.reply_subject || ""
    );
    const [replyDescription, setReplyDescription] = useState(
        request.reply_description || ""
    );
    const contentRef = useRef<HTMLDivElement>(null);

    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);

    async function saveData() {
        const response = await axios.post(
            `/newAdmin/contact-us-requests/${request.id}/update`,
            {
                reply_subject: replySubject,
                reply_description: replyDescription,
            }
        );
        if (response.status == 200) {
            setRequestData(response.data.data);
            setIsSuccess(true);
            contentRef.current?.scrollIntoView({ behavior: "smooth" });
        } else {
            setIsError(true);
            contentRef.current?.scrollIntoView({ behavior: "smooth" });
        }
    }
    return (
        <DefaultLayout>
            <div ref={contentRef}>
                <Breadcrumb pageName="تفاصيل الطلب" />
                {isSuccess && <SuccessNotification classNames="my-2" />}
                {isError && <ErrorNotification classNames="my-2" />}
                <ContactUsRequestsForm
                    replyDescription={replyDescription}
                    replySubject={replySubject}
                    setReplyDescription={setReplyDescription}
                    setReplySubject={setReplySubject}
                    saveData={saveData}
                    request={requestData}
                    types={types}
                />
            </div>
        </DefaultLayout>
    );
}

export default ContactUsRequestsShow;
