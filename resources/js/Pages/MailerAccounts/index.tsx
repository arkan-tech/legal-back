import Breadcrumb from "../../components/Breadcrumbs/Breadcrumb";
import MailerAccountsTable from "../../components/Tables/MailerAccountsTable";
import VisitorsTable from "../../components/Tables/VisitorsTable";
import DefaultLayout from "../../layout/DefaultLayout";
import React from "react";

const MailerAccounts = ({ mailer }) => {
    const headers = ["#", "الايميل", "الحالة", "العمليات"];

    mailer = mailer.map((visitor) => ({
        id: visitor.id,
        email: visitor.email,
        status: visitor.is_subscribed,
    }));
    return (
        <DefaultLayout>
            <Breadcrumb pageName="القائمة البريدية" />
            <MailerAccountsTable headers={headers} data={mailer} />
        </DefaultLayout>
    );
};

export default MailerAccounts;
