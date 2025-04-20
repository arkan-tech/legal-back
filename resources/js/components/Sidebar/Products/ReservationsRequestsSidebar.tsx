import { Link } from "@inertiajs/react";
import SidebarLinkGroup from "../SidebarLinkGroup";
import React from "react";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faDocker } from "@fortawesome/free-brands-svg-icons";
import { faClock, faComment, faFile } from "@fortawesome/free-solid-svg-icons";
function ReservationsRequestsSidebar({
    pathname,
    sidebarExpanded,
    setSidebarExpanded,
}) {
    return (
        <SidebarLinkGroup
            activeCondition={pathname.includes("reservations-requests")}
        >
            {(handleClick, open) => {
                return (
                    <React.Fragment>
                        <Link
                            preserveScroll
                            href="#"
                            className={`group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 ${
                                pathname.includes("reservations-requests") &&
                                "bg-graydark dark:bg-meta-4"
                            }`}
                            onClick={(e) => {
                                e.preventDefault();
                                sidebarExpanded
                                    ? handleClick()
                                    : setSidebarExpanded(true);
                            }}
                        >
                            <FontAwesomeIcon icon={faClock} />
                            المواعيد
                            <svg
                                className={`absolute left-0 top-1/2 -translate-y-1/2 fill-current ${
                                    open && "rotate-180"
                                }`}
                                width="20"
                                height="20"
                                viewBox="0 0 20 20"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    fillRule="evenodd"
                                    clipRule="evenodd"
                                    d="M4.41107 6.9107C4.73651 6.58527 5.26414 6.58527 5.58958 6.9107L10.0003 11.3214L14.4111 6.91071C14.7365 6.58527 15.2641 6.58527 15.5896 6.91071C15.915 7.23614 15.915 7.76378 15.5896 8.08922L10.5896 13.0892C10.2641 13.4147 9.73651 13.4147 9.41107 13.0892L4.41107 8.08922C4.08563 7.76378 4.08563 7.23614 4.41107 6.9107Z"
                                    fill=""
                                />
                            </svg>
                        </Link>
                        <div
                            className={`translate transform overflow-hidden ${
                                !open && "hidden"
                            }`}
                        >
                            <ul className="mt-4 mb-5.5 flex flex-col gap-2.5 pl-6">
                                {/* <li>
                                    <Link
                                        href="/newAdmin/reservations-requests/client"
                                        className={`group relative flex items-center gap-2.5 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white
                                    ${
                                        pathname ==
                                            "/newAdmin/reservations-requests/client" &&
                                        "!text-white"
                                    }`}
                                    >
                                        وارد مواعيد العملاء
                                    </Link>
                                </li>
                                <li>
                                    <Link
                                        href="/newAdmin/reservations-requests/lawyer"
                                        className={`group relative flex items-center gap-2.5 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white
                                            ${
                                                pathname ==
                                                    "/newAdmin/reservations-requests/lawyer" &&
                                                "!text-white"
                                            }`}
                                    >
                                        وارد مواعيد مقدمي الخدمة
                                    </Link>
                                </li> */}
                                <li>
                                    <Link
                                        href="/newAdmin/reservations-requests/for-lawyer/client"
                                        className={`group relative flex items-center gap-2.5 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white
                                            ${
                                                pathname ==
                                                    "/newAdmin/reservations-requests/for-lawyer/client" &&
                                                "!text-white"
                                            }`}
                                    >
                                        وارد مواعيد العملاء لمقدمي الخدمة
                                    </Link>
                                </li>
                                <li>
                                    <Link
                                        href="/newAdmin/reservations-requests/for-lawyer/lawyer"
                                        className={`group relative flex items-center gap-2.5 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white
                                            ${
                                                pathname ==
                                                    "/newAdmin/reservations-requests/for-lawyer/lawyer" &&
                                                "!text-white"
                                            }`}
                                    >
                                        وارد مواعيد مقدمي الحدمة لمقدمي الخدمة
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    </React.Fragment>
                );
            }}
        </SidebarLinkGroup>
    );
}

export default ReservationsRequestsSidebar;
