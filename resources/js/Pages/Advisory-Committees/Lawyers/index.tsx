import React from "react";
import AdvisoryCommitteesLawyersTable from "../../../components/Tables/AdvisoryCommittees/Lawyers/AdvisoryCommitteesLawyersTable";
import DefaultLayout from "../../../layout/DefaultLayout";
import Breadcrumb from "../../../components/Breadcrumbs/Breadcrumb";

const AdvisoryCommitteesLawyers = ({ advisoryCommitteesLawyers }) => {
    const headers = ["#", "الاسم", "الحالة"];
    advisoryCommitteesLawyers = advisoryCommitteesLawyers.map(
        (advisoryCommitteeLawyer) => ({
            id: advisoryCommitteeLawyer.id,
            name: advisoryCommitteeLawyer.name,
            status: advisoryCommitteeLawyer.accepted_text,
            statusCode: advisoryCommitteeLawyer.accepted,
        })
    );
    return (
        <DefaultLayout>
            <Breadcrumb pageName="اعضاء هيئة المستشارين" />
            <AdvisoryCommitteesLawyersTable
                headers={headers}
                data={advisoryCommitteesLawyers}
            />
        </DefaultLayout>
    );
};

export default AdvisoryCommitteesLawyers;
