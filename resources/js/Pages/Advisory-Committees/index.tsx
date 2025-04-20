import React from "react";
import Breadcrumb from "../../components/Breadcrumbs/Breadcrumb";
import DefaultLayout from "../../layout/DefaultLayout";
import AdvisoryCommitteesTable from "../../components/Tables/AdvisoryCommittees/AdvisoryCommitteesTable";

const AdvisoryCommittees = ({ advisoryCommittees }) => {
    const headers = ["#", "الاسم", "العمليات"];
    advisoryCommittees = advisoryCommittees.map((advisoryCommittee) => ({
        id: advisoryCommittee.id,
        name: advisoryCommittee.title,
    }));
    return (
        <DefaultLayout>
            <Breadcrumb pageName="الهيئات الأستشارية" />
            <AdvisoryCommitteesTable
                headers={headers}
                data={advisoryCommittees}
            />
        </DefaultLayout>
    );
};

export default AdvisoryCommittees;
