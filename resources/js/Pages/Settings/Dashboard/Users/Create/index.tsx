import React, { useState } from "react";

import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import DefaultLayout from "../../../../../layout/DefaultLayout";
import Breadcrumb from "../../../../../components/Breadcrumbs/Breadcrumb";
import MainSettingsForm from "../../../../../components/Forms/Settings/AdvisoryServices/MainSettingsFrom";
import DashboardUsersForm from "../../../../../components/Forms/Settings/Dashboard/DashboardUsersForm";
import { findTranslation } from "../../../../../hooks/translate";

function DashboardUsersCreate({ roles, permissions }) {
    roles = roles.map((role) => ({
        ...role,
        name: findTranslation(role.name),
    }));
    permissions = permissions.map((permission) => ({
        ...permission,
        name: findTranslation(permission.name),
    }));
    const [errors, setErrors] = useState({});
    const [name, setName] = useState("");
    const [email, setEmail] = useState("");
    const [selectedRoles, setSelectedRoles] = useState([]);
    const [selectedPermissions, setSelectedPermissions] = useState([]);
    async function saveData() {
        try {
            const res = await axios.post(
                "/newAdmin/settings/dashboard/users/create",
                {
                    name: name,
                    email: email,
                    roles: selectedRoles,
                    permissions: selectedPermissions,
                }
            );
            if (res.status == 200) {
                toast.success("تم انشاء الملف بنجاح");
                router.get(
                    `/newAdmin/settings/dashboard/users/${res.data.item.id}`
                );
            }
        } catch (err) {
            setErrors(err.response.data.errors);
        }
    }
    return (
        <DefaultLayout>
            <Breadcrumb pageName="اضافة مستخدم جديد" />
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
        </DefaultLayout>
    );
}

export default DashboardUsersCreate;
