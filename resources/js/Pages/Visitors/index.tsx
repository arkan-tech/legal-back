import Breadcrumb from "../../components/Breadcrumbs/Breadcrumb";
import VisitorsTable from "../../components/Tables/VisitorsTable";
import DefaultLayout from "../../layout/DefaultLayout";
import React from "react";

const Visitors = ({ visitors }) => {
    const headers = ["#", "الاسم", "الايميل", "الموبايل", "الحالة", "العمليات"];

    visitors = visitors.map((visitor) => ({
        id: visitor.id,
        name: visitor.name,
        email: visitor.email,
        phone: visitor.mobile,
        status: visitor.status,
    }));
    return (
        <DefaultLayout>
            <Breadcrumb pageName="الزوار" />
            <VisitorsTable headers={headers} data={visitors} />
        </DefaultLayout>
    );
};

export default Visitors;
