import axios from "axios";
import { useRef, useState } from "react";
import toast from "react-hot-toast";
import DefaultLayout from "../../layout/DefaultLayout";
import React from "react";
import Breadcrumb from "../../components/Breadcrumbs/Breadcrumb";
import MailerForm from "../../components/Forms/MailerForm/MailerForm";
import SuccessNotification from "../../components/SuccessNotification";
import ErrorNotification from "../../components/ErrorNotification";
function Mailer({
    clients,
    lawyers,
    old_clients,
    old_lawyers,
    lawyer_sections,
    mailer,
}) {
    const [errors, setErrors] = useState("");
    const contentRef = useRef<HTMLDivElement>(null);

    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);

    async function saveData(formData) {
        if (formData.type == "") {
            formData.type = 5;
        }
        try {
            const res = await axios.post(
                "/newAdmin/mailer/send-mail",
                formData
            );
            if (res.status == 200) {
                setIsSuccess(true);
                contentRef.current?.scrollIntoView({ behavior: "smooth" });
                return true;
                // document.querySelector('form').reset(); // Reset the form
            }
        } catch (err) {
            setIsError(true);
            contentRef.current?.scrollIntoView({ behavior: "smooth" });
            setErrors(err.response.data.errors);
            return false;
        }
    }
    clients = clients.map((user) => ({
        id: user.id,
        name: `${user.name}`,
        email: user.email,
    }));
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
    old_clients = old_clients.map((user) => ({
        id: user.id,
        name: `${user.myname})`,
        email: user.email,
    }));
    old_lawyers = old_lawyers.map((user) => ({
        id: user.id,
        name: `${user.name}`,
        email: user.email,
    }));
    return (
        <DefaultLayout>
            <div ref={contentRef}>
                <Breadcrumb pageName="القائمة البريدية" />
                {isSuccess && (
                    <SuccessNotification
                        classNames="my-2"
                        message="تم الأرسال بنجاح"
                    />
                )}
                {isError && <ErrorNotification classNames="my-2" />}
                <MailerForm
                    errors={errors}
                    saveData={saveData}
                    users={clients}
                    lawyers={lawyers}
                    oldClients={old_clients}
                    oldLawyers={old_lawyers}
                    lawyer_sections={lawyer_sections}
                    mailer={mailer}
                />
            </div>
        </DefaultLayout>
    );
}
export default Mailer;
