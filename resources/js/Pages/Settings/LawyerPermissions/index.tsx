import React from "react";
import { Link, usePage } from "@inertiajs/react";
import DefaultLayout from "../../../layout/DefaultLayout";
import Breadcrumb from "../../../components/Breadcrumbs/Breadcrumb";
import LawyerPermissionsSettingsTable from "../../../components/Tables/LawyerPermissionsSettingsTable";

export default function LawyerPermissionsIndex({ permissions }) {
    const headers = ["الاسم", "العمليات"];
    return (
        <DefaultLayout>
            <Breadcrumb pageName="صلاحيات المحامين" />
            <LawyerPermissionsSettingsTable
                headers={headers}
                data={permissions}
            />
        </DefaultLayout>
    );
}
