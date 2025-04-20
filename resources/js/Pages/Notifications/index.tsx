import axios from "axios";
import { useRef, useState } from "react";
import toast from "react-hot-toast";
import DefaultLayout from "../../layout/DefaultLayout";
import React from "react";
import Breadcrumb from "../../components/Breadcrumbs/Breadcrumb";
import NotificationForm from "../../components/Forms/NotificationForm/NotificationForm";
import SuccessNotification from "../../components/SuccessNotification";
import ErrorNotification from "../../components/ErrorNotification";
function Mailer({ clients, lawyers, visitors, lawyer_sections }) {
    console.log(lawyers);
    const [errors, setErrors] = useState("");
    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);
    const contentRef = useRef<HTMLDivElement>(null);

    async function saveData(formData) {
        if (formData.type == "") {
            formData.type = 7;
        }
        try {
            const res = await axios.post(
                "/newAdmin/notifications/send-notification",
                formData
            );
            if (res.status == 200) {
                setIsSuccess(true);
                contentRef.current?.scrollIntoView({ behavior: "smooth" });
            }
        } catch (err) {
            setIsError(true);
            contentRef.current?.scrollIntoView({ behavior: "smooth" });
            setErrors(err.response.data.errors);
        }
    }
    clients = clients.map((user) => ({
        id: user.id,
        name: `${user.name}`,
        email: user.email,
    }));
    console.log(lawyers);
    lawyers = lawyers.map((user) => ({
        id: user.id,
        name: `${user.name}`,
        email: user.email,
        sections: user.lawyer_details.sections_rel.map((section) => ({
            id: section.id,
            name: section.title,
        })),
    }));
    lawyer_sections = lawyer_sections.map((section) => ({
        id: section.id,
        name: section.title,
    }));

    visitors = visitors.map((user) => ({
        id: user.id,
        name: `${user.name}`,
        email: user.email,
    }));
    return (
        <DefaultLayout>
            <div ref={contentRef}>
                <Breadcrumb pageName="قائمة الإشعارات" />
                {isSuccess && <SuccessNotification classNames="my-2" />}
                {isError && <ErrorNotification classNames="my-2" />}
                <NotificationForm
                    errors={errors}
                    saveData={saveData}
                    users={clients}
                    lawyers={lawyers}
                    visitors={visitors}
                    lawyer_sections={lawyer_sections}
                />{" "}
            </div>
        </DefaultLayout>
    );
}
export default Mailer;
