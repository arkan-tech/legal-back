// ...existing imports...
import DefaultLayout from "../../../layout/DefaultLayout";
import React, { useState } from "react";
import Breadcrumb from "../../../components/Breadcrumbs/Breadcrumb";
import LawyersSelectionModal from "../../../components/Modals/LawyersSelectionModal";
import LeaderSelectionModal from "../../../components/Modals/LeaderSelectionModal";
import axios from "axios";
import { faChevronDown, faChevronUp } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import toast from "react-hot-toast";
import SuccessNotification from "../../../components/SuccessNotification";
import ErrorNotification from "../../../components/ErrorNotification";

export const DAYSMAPPING = {
    0: "الأحد",
    1: "الاثنين",
    2: "الثلاثاء",
    3: "الأربعاء",
    4: "الخميس",
    5: "الجمعة",
    6: "السبت",
};
export default function YmtazSlots({ slots: initialSlots, lawyers }) {
    const [slots, setSlots] = useState(initialSlots);
    const [openAccordion, setOpenAccordion] = useState(null);
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [selectedSlotId, setSelectedSlotId] = useState(null);
    const [selectedLawyers, setSelectedLawyers] = useState([]);
    const [isSuccess, setIsSuccess] = useState(false);
    const [isError, setIsError] = useState(false);
    const [progress, setProgress] = useState(0);
    const [isLeaderModalOpen, setIsLeaderModalOpen] = useState(false);
    const [selectedLeaderId, setSelectedLeaderId] = useState(null);

    const handleAccordionToggle = (slotId) => {
        setOpenAccordion(openAccordion === slotId ? null : slotId);
    };

    const openLawyerSelectionModal = (slotId, currentAssignees) => {
        setSelectedSlotId(slotId);
        setSelectedLawyers(
            currentAssignees.map((assignee) => assignee.assignee_id)
        );
        setIsModalOpen(true);
    };

    const openLeaderSelectionModal = (slotId, currentLeaderId) => {
        setSelectedSlotId(slotId);
        setSelectedLeaderId(currentLeaderId);
        setIsLeaderModalOpen(true);
    };

    const handleSubmitSelectedLawyers = (lawyerIds) => {
        const slot = slots.find((slot) => slot.id === selectedSlotId);
        axios
            .post(
                `/newAdmin/ymtaz-slots/${selectedSlotId}/update`,
                {
                    assignee_ids: lawyerIds,
                    leader_id: slot.leader ? slot.leader.id : null,
                },
                {
                    onUploadProgress: (event) => {
                        const percent = Math.floor(
                            //@ts-ignore
                            (event.loaded * 100) / event.total
                        );
                        setProgress(percent);
                    },
                }
            )
            .then((response) => {
                console.log(response);
                setSlots((prevSlots) =>
                    prevSlots.map((slot) =>
                        slot.id === selectedSlotId
                            ? {
                                  ...slot,
                                  assignees: response.data.slot.assignees,
                              }
                            : slot
                    )
                );
                setIsSuccess(true);
            })
            .catch((error) => {
                setIsError(true);
            })
            .finally(() => {
                setProgress(0);
                setIsModalOpen(false);
            });
    };

    const handleSubmitSelectedLeader = (leaderId) => {
        const slot = slots.find((slot) => slot.id === selectedSlotId);
        axios
            .post(
                `/newAdmin/ymtaz-slots/${selectedSlotId}/update`,
                {
                    leader_id: leaderId,
                    assignee_ids: slot.assignees.map(
                        (assignee) => assignee.assignee_id
                    ),
                },
                {
                    onUploadProgress: (event) => {
                        const percent = Math.floor(
                            //@ts-ignore
                            (event.loaded * 100) / event.total
                        );
                        setProgress(percent);
                    },
                }
            )
            .then((response) => {
                setSlots((prevSlots) =>
                    prevSlots.map((slot) =>
                        slot.id === selectedSlotId
                            ? {
                                  ...slot,
                                  leader: response.data.slot.leader,
                              }
                            : slot
                    )
                );
                setIsSuccess(true);
            })
            .catch((error) => {
                setIsError(true);
            })
            .finally(() => {
                setProgress(0);
                setIsLeaderModalOpen(false);
            });
    };

    return (
        <DefaultLayout>
            <Breadcrumb pageName="إدارة المناوبات" />
            {isSuccess && <SuccessNotification classNames="my-2" />}
            {isError && <ErrorNotification classNames="my-2" />}
            {progress > 0 && (
                <div className="my-4">
                    <div className="bg-gray-200 rounded-full">
                        <div
                            className="bg-blue-500 text-xs font-medium text-center text-white rounded-full"
                            style={{ width: `${progress}%` }}
                        >
                            {progress}%
                        </div>
                    </div>
                </div>
            )}
            <div style={{ direction: "rtl" }}>
                {slots.map((slot) => (
                    <div className="rounded-sm w-full border border-stroke bg-white px-5 py-4 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5">
                        <h3
                            className="flex justify-between cursor-pointer items-center"
                            onClick={() => handleAccordionToggle(slot.id)}
                        >
                            <p>{DAYSMAPPING[slot.day]}</p>
                            <FontAwesomeIcon
                                icon={
                                    openAccordion === slot.id
                                        ? faChevronUp
                                        : faChevronDown
                                }
                                className="transition-transform duration-300"
                            />
                            <button
                                className="px-4 py-2 bg-[#ddb662] text-white rounded-xl hover:bg-[#aa8b4b]"
                                onClick={() =>
                                    openLeaderSelectionModal(
                                        slot.id,
                                        slot.leader ? slot.leader.id : null
                                    )
                                }
                            >
                                تعديل النائب
                            </button>
                        </h3>
                        <div
                            className={`transition-max-height duration-500 ease-in-out overflow-hidden ${
                                openAccordion === slot.id
                                    ? "max-h-[2000px]"
                                    : "max-h-0"
                            }`}
                        >
                            {openAccordion === slot.id && (
                                <>
                                    <div className="w-full max-w-full overflow-x-auto">
                                        <table className="w-full table-auto">
                                            <thead>
                                                <tr className="bg-gray-2 text-right dark:bg-meta-4">
                                                    <th className="flex justify-between items-center">
                                                        <p>المحامون المعينون</p>
                                                        <button
                                                            className="px-4 py-2 bg-[#ddb662] text-white rounded-xl hover:bg-[#aa8b4b]"
                                                            onClick={() =>
                                                                openLawyerSelectionModal(
                                                                    slot.id,
                                                                    slot.assignees
                                                                )
                                                            }
                                                        >
                                                            تعديل المحامين
                                                        </button>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                                        <strong>القائد:</strong>{" "}
                                                        {slot.leader
                                                            ? slot.leader.name
                                                            : "لم يتم التعيين"}
                                                    </td>
                                                </tr>
                                                {slot.assignees.map(
                                                    (assignee) => (
                                                        <tr key={assignee.id}>
                                                            <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                                                {
                                                                    assignee
                                                                        .assignee
                                                                        .name
                                                                }
                                                            </td>
                                                        </tr>
                                                    )
                                                )}
                                            </tbody>
                                        </table>
                                    </div>
                                </>
                            )}
                        </div>
                    </div>
                ))}
            </div>
            {isModalOpen && (
                <LawyersSelectionModal
                    isOpen={isModalOpen}
                    onClose={() => setIsModalOpen(false)}
                    onSubmit={handleSubmitSelectedLawyers}
                    initialSelectedLawyers={selectedLawyers}
                    lawyers={lawyers}
                />
            )}
            {isLeaderModalOpen && (
                <LeaderSelectionModal
                    isOpen={isLeaderModalOpen}
                    onClose={() => setIsLeaderModalOpen(false)}
                    onSubmit={handleSubmitSelectedLeader}
                    initialSelectedLeaderId={selectedLeaderId}
                    lawyers={lawyers}
                />
            )}
        </DefaultLayout>
    );
}
