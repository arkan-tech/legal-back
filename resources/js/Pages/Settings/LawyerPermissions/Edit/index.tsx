import React, { useState } from "react";
import { usePage, router } from "@inertiajs/react";
import DefaultLayout from "../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import SuccessNotification from "../../../../components/SuccessNotification";
import ErrorNotification from "../../../../components/ErrorNotification";
import axios from "axios";
import LawyerPermissionsForm from "../../../../components/Forms/Settings/LawyerPermissionsForm";

export default function EditLawyerPermission({ permission }) {
    const [name, setName] = useState(permission.name);
    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);
    const [errors, setErrors] = useState<any>({});
    const [description, setDescription] = useState(permission.description);
    const saveData = async () => {
        try {
            setIsError(false);
            setIsSuccess(false);
            setErrors({});

            const res = await axios.post(
                `/newAdmin/settings/lawyer-permissions/${permission.id}`,
                { name, description }
            );

            if (res.status == 200) {
                setIsSuccess(true);
            }
        } catch (err) {
            setErrors(err.response.data.errors);
            setIsError(true);
        }
    };

    return (
        <DefaultLayout>
            <Breadcrumb pageName="تعديل صلاحية المحامي" />
            {isSuccess && <SuccessNotification classNames="my-2" />}
            {isError && <ErrorNotification classNames="my-2" />}
            <LawyerPermissionsForm
                saveData={saveData}
                errors={errors}
                name={name}
                setName={setName}
                description={description}
                setDescription={setDescription}
            />
        </DefaultLayout>
    );
}
