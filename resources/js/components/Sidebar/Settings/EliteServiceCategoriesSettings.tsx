import React from "react";
import SidebarLinkGroup from "../SidebarLinkGroup";
import { Link } from "@inertiajs/react";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faLayerGroup, faUsers } from "@fortawesome/free-solid-svg-icons";

interface Props {
    pathname: string;
    sidebarExpanded: boolean;
    setSidebarExpanded: (expanded: boolean) => void;
}

const EliteServiceCategoriesSettings = ({
    pathname,
    sidebarExpanded,
    setSidebarExpanded,
}: Props) => {
    return (
        <SidebarLinkGroup activeCondition={pathname.includes("elite-service")}>
            {(handleClick, open) => {
                return (
                    <React.Fragment>
                        <Link
                            href="#"
                            className={`group relative flex items-center gap-2.5 rounded-2xl py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 ${
                                pathname.includes("elite-service") &&
                                "bg-graydark dark:bg-meta-4"
                            }`}
                            onClick={(e) => {
                                e.preventDefault();
                                sidebarExpanded
                                    ? handleClick()
                                    : setSidebarExpanded(true);
                            }}
                        >
                            <FontAwesomeIcon icon={faLayerGroup} />
                            اعدادات النخبة
                            <svg
                                className={`absolute left-4 top-1/2 -translate-y-1/2 fill-current ${
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
                            <ul className="mt-4 mb-5.5 flex flex-col gap-2.5 pr-6">
                                <li>
                                    <Link
                                        href="/newAdmin/settings/elite-service-categories"
                                        className={`group relative flex items-center gap-2.5 rounded-2xl py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 ${
                                            pathname.includes(
                                                "elite-service-categories"
                                            ) && "bg-graydark dark:bg-meta-4"
                                        }`}
                                    >
                                        الفئات
                                    </Link>
                                </li>
                                <li>
                                    <Link
                                        href="/newAdmin/settings/elite-service-pricing-committee"
                                        className={`group relative flex items-center gap-2.5 rounded-2xl py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 ${
                                            pathname.includes(
                                                "elite-service-pricing-committee"
                                            ) && "bg-graydark dark:bg-meta-4"
                                        }`}
                                    >
                                        لجنة التسعير
                                    </Link>
                                </li>
                                <li>
                                    <Link
                                        href="/newAdmin/elite-service-requests"
                                        className={`group relative flex items-center gap-2.5 rounded-2xl py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 ${
                                            pathname.includes(
                                                "elite-service-requests"
                                            ) && "bg-graydark dark:bg-meta-4"
                                        }`}
                                    >
                                        الطلبات
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    </React.Fragment>
                );
            }}
        </SidebarLinkGroup>
    );
};

export default EliteServiceCategoriesSettings;
