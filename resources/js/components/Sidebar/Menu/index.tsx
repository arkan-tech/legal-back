import {
    faChartSimple,
    faCircleUser,
    faContactBook,
    faEnvelope,
    faGavel,
    faPerson,
    faPersonCircleMinus,
    faUser,
    faUserMinus,
    faUsers,
} from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { Link } from "@inertiajs/react";
import React from "react";
import AdvisoryCommitteesSidebar from "./AdvisoryCommitteesSidebar";
import ServiceUsersSidebar from "./ServiceUsersSidebar";
function MenuSidebar({ pathname, sidebarExpanded, setSidebarExpanded }) {
    return (
        <div>
            <h3 className="mb-4 ml-4 text-sm font-semibold text-bodydark2">
                الرئيسية
            </h3>

            <ul className="mb-6 flex flex-col gap-1.5">
                <li>
                    <Link
                        href="/newAdmin/dashboard"
                        className={`group relative flex items-center gap-2.5 rounded-2xl px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 ${
                            (pathname === "/" ||
                                pathname.includes("dashboard")) &&
                            "bg-graydark dark:bg-meta-4"
                        }`}
                    >
                        <FontAwesomeIcon icon={faChartSimple} />
                        الأحصائيات
                    </Link>
                </li>
                <li>
                    <Link
                        href="/newAdmin/clients"
                        className={`group relative flex items-center gap-2.5 rounded-2xl py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 ${
                            pathname == "/newAdmin/clients" &&
                            "bg-graydark dark:bg-meta-4"
                        }`}
                    >
                        <FontAwesomeIcon icon={faUser} />
                        طالبي الخدمة الجدد
                    </Link>
                </li>
                <li>
                    <Link
                        href="/newAdmin/old-clients"
                        className={`group relative flex items-center gap-2.5 rounded-2xl py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 ${
                            pathname == "/newAdmin/old-clients" &&
                            "bg-graydark dark:bg-meta-4"
                        }`}
                    >
                        <FontAwesomeIcon icon={faUserMinus} />
                        طالبي الخدمة القدامى
                    </Link>
                </li>
                <li>
                    <Link
                        href="/newAdmin/lawyers"
                        className={`group relative flex items-center gap-2.5 rounded-2xl py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 ${
                            pathname == "/newAdmin/lawyers" &&
                            "bg-graydark dark:bg-meta-4"
                        }`}
                    >
                        <FontAwesomeIcon icon={faPerson} />
                        مقدمي الخدمة الجدد
                    </Link>
                </li>
                <li>
                    <Link
                        href="/newAdmin/old-lawyers"
                        className={`group relative flex items-center gap-2.5 rounded-2xl py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 ${
                            pathname == "/newAdmin/old-lawyers" &&
                            "bg-graydark dark:bg-meta-4"
                        }`}
                    >
                        <FontAwesomeIcon icon={faPersonCircleMinus} />
                        مقدمي الخدمة القدامى
                    </Link>
                </li>

                <AdvisoryCommitteesSidebar
                    pathname={pathname}
                    sidebarExpanded={sidebarExpanded}
                    setSidebarExpanded={setSidebarExpanded}
                />

                <li>
                    <Link
                        href="/newAdmin/visitors"
                        className={`group relative flex items-center gap-2.5 rounded-2xl py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 ${
                            pathname.includes("visitors") &&
                            "bg-graydark dark:bg-meta-4"
                        }`}
                    >
                        <FontAwesomeIcon icon={faCircleUser} />
                        كشف الزوار
                    </Link>
                </li>
                <li>
                    <Link
                        href="/newAdmin/mailer-accounts"
                        className={`group relative flex items-center gap-2.5 rounded-2xl py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 ${
                            pathname.includes("mailer-accounts") &&
                            "bg-graydark dark:bg-meta-4"
                        }`}
                    >
                        <FontAwesomeIcon icon={faCircleUser} />
                        كشف القائمة البريدية
                    </Link>
                </li>
                <li>
                    <Link
                        href="/newAdmin/contact-us-requests"
                        className={`group relative flex items-center gap-2.5 rounded-2xl py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 ${
                            pathname.includes("contact-us-requests") &&
                            "bg-graydark dark:bg-meta-4"
                        }`}
                    >
                        <FontAwesomeIcon icon={faContactBook} />
                        تواصل معنا
                    </Link>
                </li>
                <li>
                    <Link
                        href="/newAdmin/mailer"
                        className={`group relative flex items-center gap-2.5 rounded-2xl py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 ${
                            pathname.includes("mailer") &&
                            !pathname.includes("mailer-accounts") &&
                            "bg-graydark dark:bg-meta-4"
                        }`}
                    >
                        <FontAwesomeIcon icon={faEnvelope} />
                        القائمة البريدية
                    </Link>
                </li>
                <li>
                    <Link
                        href="/newAdmin/notifications"
                        className={`group relative flex items-center gap-2.5 rounded-2xl py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 ${
                            pathname.includes("notifications") &&
                            "bg-graydark dark:bg-meta-4"
                        }`}
                    >
                        <FontAwesomeIcon icon={faEnvelope} />
                        قائمة الإشعارات
                    </Link>
                </li>
            </ul>
        </div>
    );
}

export default MenuSidebar;
