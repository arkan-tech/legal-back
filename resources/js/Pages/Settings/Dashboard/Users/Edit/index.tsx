import React, { useRef, useState } from "react";

import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import MainSettingsForm from "../../../../../components/Forms/Settings/AdvisoryServices/MainSettingsFrom";
import DashboardUsersForm from "../../../../../components/Forms/Settings/Dashboard/DashboardUsersForm";
import SuccessNotification from "../../../../../components/SuccessNotification";
import ErrorNotification from "../../../../../components/ErrorNotification";
import { findTranslation } from "../../../../../hooks/translate";

function DashboardUsersEdit({ userData, roles, permissions }) {
    roles = roles.map((role) => ({
        ...role,
        name: findTranslation(role.name),
    }));
    permissions = permissions.map((permission) => ({
        ...permission,
        name: findTranslation(permission.name),
    }));
    const [errors, setErrors] = useState({});
    const [name, setName] = useState(userData.name);
    const [email, setEmail] = useState(userData.email);
    const [selectedRoles, setSelectedRoles] = useState(
        roles
            .filter((role) => userData.roles.some((udr) => udr.id == role.id))
            .map((role) => role.id)
    );
    const [selectedPermissions, setSelectedPermissions] = useState(
        permissions
            .filter((perm) =>
                userData.permissions.some((udp) => udp.id == perm.id)
            )
            .map((perm) => perm.id)
    );
    const contentRef = useRef<HTMLDivElement>(null);

    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);

    async function saveData() {
        try {
            const res = await axios.post(
                `/newAdmin/settings/dashboard/users/${userData.id}`,
                {
                    name: name,
                    email: email,
                    roles: selectedRoles,
                    permissions: selectedPermissions,
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
            {" "}
            <div ref={contentRef}>
                <Breadcrumb pageName="تعديل حساب المستخدم" />{" "}
                {isSuccess && <SuccessNotification classNames="my-2" />}
                {isError && <ErrorNotification classNames="my-2" />}
                <DashboardUsersForm
                    errors={errors}
                    saveData={saveData}
                    name={name}
                    setName={setName}
                    roles={roles}
                    permissions={permissions}
                    email={email}
                    setEmail={setEmail}
                    setSelectedRoles={setSelectedRoles}
                    setSelectedPermissions={setSelectedPermissions}
                    selectedRoles={selectedRoles}
                    selectedPermissions={selectedPermissions}
                />
            </div>
        </DefaultLayout>
    );
}

export default DashboardUsersEdit;
