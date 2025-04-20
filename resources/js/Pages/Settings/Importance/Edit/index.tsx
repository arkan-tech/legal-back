import React, { useRef, useState } from "react";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import DefaultLayout from "../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import ImportanceSettingsForm from "../../../../components/Forms/Settings/Importance/ImportanceSettingsForm";
import ErrorNotification from "../../../../components/ErrorNotification";
import SuccessNotification from "../../../../components/SuccessNotification";

function ImportanceSettingsEdit({ importance }) {
    const [errors, setErrors] = useState({});
    const [name, setName] = useState(importance?.title || "");
    const contentRef = useRef<HTMLDivElement>(null);

    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);
    async function saveData() {
        try {
            const res = await axios.post(
                `/newAdmin/settings/importance/${importance.id}/update`,
                {
                    title: name,
                }
            );
            if (res.status == 200) {
                setIsSuccess(true);
                contentRef.current?.scrollIntoView({ behavior: "smooth" });
            }
        } catch (err) {
            setIsError(true);
            contentRef.current?.scrollIntoView({ behavior: "smooth" });
            return setErrors(err.response.data.errors);
        }
    }
    return (
        <DefaultLayout>
            <div ref={contentRef}>
                <Breadcrumb pageName="تعديل المستوى" />
                {isSuccess && <SuccessNotification classNames="my-2" />}
                {isError && <ErrorNotification classNames="my-2" />}
                <ImportanceSettingsForm
                    errors={errors}
                    saveData={saveData}
                    name={name}
                    setName={setName}
                />
            </div>
        </DefaultLayout>
    );
}

export default ImportanceSettingsEdit;
