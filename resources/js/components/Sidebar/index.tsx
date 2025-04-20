import React, { useEffect, useRef, useState } from "react";
// import { Link } from "@inertiajs/inertia-react";
import SidebarLinkGroup from "./SidebarLinkGroup";
import Logo from "../../images/logo/logo.svg";
import { usePage, Link } from "@inertiajs/react";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { useRoute } from "ziggy-js";
import {
    faArrowTurnUp,
    faArrowUp,
    faCaretUp,
    faChartSimple,
    faCircleUser,
    faClock,
    faComment,
    faDollarSign,
    faEnvelope,
    faFile,
    faFileInvoiceDollar,
    faFileText,
    faGavel,
    faLayerGroup,
    faLevelDown,
    faPassport,
    faRectangleAd,
    faSackDollar,
    faStar,
    faUser,
    faUsers,
    faWallet,
} from "@fortawesome/free-solid-svg-icons";
import ServicesSettings from "./Settings/ServicesSettings";
import AdvisoryServicesSettings from "./Settings/AdvisoryServicesSettings";
import ProductsSidebar from "./Products";
import MenuSidebar from "./Menu";
import SignupSettings from "./Settings/SignupSettings";
import ReservationsSettings from "./Settings/ReservationsSettings";
import DashboardSettings from "./Settings/DashboardSettings";
import JudicialGuideSettings from "./Settings/JudicialGuideSettings";
import LawGuideSettings from "./Settings/LawGuideSettings";
import BooksSettings from "./Settings/BooksSettings";
import GamificationSettings from "./Settings/GamificationSettings";
import LandingPageSettings from "./Settings/LandingPageSettings";
import BookGuideSettings from "./Settings/BookGuideSettings";
import EliteServiceCategoriesSettings from "./Settings/EliteServiceCategoriesSettings";

export interface PageProps {
    user: User;
    [key: string]: string | User;
}
interface User {
    roles: string[];
    permissions: string[];
}
interface SidebarProps {
    sidebarOpen: boolean;
    setSidebarOpen: (arg: boolean) => void;
}
const Sidebar = ({ sidebarOpen, setSidebarOpen }: SidebarProps) => {
    const route = useRoute();
    const { url, props } = usePage<PageProps>();
    const pathname = url;
    const trigger = useRef<any>(null);
    const sidebar = useRef<HTMLDivElement>(null);
    const aside = useRef<any>(null);
    const storedSidebarExpanded = localStorage.getItem("sidebar-expanded");
    const [sidebarExpanded, setSidebarExpanded] = useState(
        storedSidebarExpanded === null
            ? false
            : storedSidebarExpanded === "true"
    );
    console.log(storedSidebarExpanded);
    // close on click outside
    useEffect(() => {
        const clickHandler = ({ target }: MouseEvent) => {
            if (!sidebar.current || !trigger.current) return;
            if (
                !sidebarOpen ||
                aside.current?.contains(target) ||
                trigger.current.contains(target)
            )
                return;
            setSidebarOpen(false);
        };
        document.addEventListener("click", clickHandler);
        return () => document.removeEventListener("click", clickHandler);
    });

    // close if the esc key is pressed

    useEffect(() => {
        localStorage.setItem("sidebar-expanded", sidebarExpanded.toString());
        if (sidebarExpanded) {
            document.querySelector("body")?.classList.add("sidebar-expanded");
        } else {
            document
                .querySelector("body")
                ?.classList.remove("sidebar-expanded");
        }
    }, [sidebarExpanded]);
    const [scrollPosition, setScrollPosition] = useState(0);

    useEffect(() => {
        const handleScroll = () => {
            if (sidebar.current) {
                setScrollPosition(sidebar.current.scrollTop);
                localStorage.setItem(
                    "sidebarScrollPosition",
                    sidebar.current?.scrollTop.toString()
                );
            }
        };
        if (sidebar.current != null) {
            sidebar.current.addEventListener("scroll", handleScroll);
        }

        return () => {
            if (sidebar.current != null) {
                sidebar.current.removeEventListener("scroll", handleScroll);
            }
        };
    }, [sidebar]);

    useEffect(() => {
        const storedScrollPosition = localStorage.getItem(
            "sidebarScrollPosition"
        );
        if (storedScrollPosition) {
            if (sidebar.current) {
                sidebar.current.scrollTop = parseInt(storedScrollPosition);
            }
        }
    }, [sidebar]);
    return (
        <aside
            ref={aside}
            className={`absolute right-0 top-0 z-9999 flex h-screen w-60 flex-col overflow-y-hidden bg-[#00262f] duration-300 ease-linear dark:bg-[#00262f] lg:static lg:-translate-x-0 ${
                sidebarOpen
                    ? "-translate-x-0"
                    : "translate-x-full hidden sm:flex"
            }`}
            style={{ direction: "rtl" }}
        >
            <div className="flex items-center justify-center gap-2 px-6 py-5.5 lg:py-6.5">
                <Link href="/newAdmin" className="flex items-center gap-4">
                    <img src={Logo} alt="Logo" />
                </Link>

                <button
                    ref={trigger}
                    onClick={() => setSidebarOpen(!sidebarOpen)}
                    aria-controls="sidebar"
                    aria-expanded={sidebarOpen}
                    className="block lg:hidden"
                >
                    <svg
                        className="fill-current"
                        width="20"
                        height="18"
                        viewBox="0 0 20 18"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M19 8.175H2.98748L9.36248 1.6875C9.69998 1.35 9.69998 0.825 9.36248 0.4875C9.02498 0.15 8.49998 0.15 8.16248 0.4875L0.399976 8.3625C0.0624756 8.7 0.0624756 9.225 0.399976 9.5625L8.16248 17.4375C8.31248 17.5875 8.53748 17.7 8.76248 17.7C8.98748 17.7 9.17498 17.625 9.36248 17.475C9.69998 17.1375 9.69998 16.6125 9.36248 16.275L3.02498 9.8625H19C19.45 9.8625 19.825 9.4875 19.825 9.0375C19.825 8.55 19.45 8.175 19 8.175Z"
                            fill=""
                        />
                    </svg>
                </button>
            </div>

            <div
                ref={sidebar}
                className="no-scrollbar flex flex-col overflow-y-auto duration-300 ease-linear"
            >
                <nav className="mt-5 py-4 px-4 lg:mt-9 lg:px-6">
                    {props.user.roles.includes("super-admin") && (
                        <MenuSidebar
                            pathname={pathname}
                            sidebarExpanded={sidebarExpanded}
                            setSidebarExpanded={setSidebarExpanded}
                        />
                    )}
                    {props.user.roles.includes("super-admin") && (
                        <ProductsSidebar
                            pathname={pathname}
                            sidebarExpanded={sidebarExpanded}
                            setSidebarExpanded={setSidebarExpanded}
                        />
                    )}
                    {props.user.roles.includes("super-admin") && (
                        <div>
                            <h3 className="mb-4 ml-4 text-sm font-semibold text-bodydark2">
                                منافذ البيع
                            </h3>
                            <ul className="mb-6 flex flex-col gap-1.5">
                                <li>
                                    <Link
                                        href="#"
                                        className={`group relative flex items-center gap-2.5 rounded-2xl py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 ${
                                            pathname.includes("digital-de7k") &&
                                            "bg-graydark dark:bg-meta-4"
                                        }`}
                                    >
                                        <FontAwesomeIcon icon={faGavel} />
                                        مكتب المحامي
                                    </Link>
                                </li>
                                <li>
                                    <Link
                                        href="/newAdmin/settings/packages"
                                        className={`group relative flex items-center gap-2.5 rounded-2xl py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 ${
                                            pathname.includes("packages") &&
                                            "bg-graydark dark:bg-meta-4"
                                        }`}
                                    >
                                        <FontAwesomeIcon icon={faDollarSign} />
                                        الباقات
                                    </Link>
                                </li>
                                <li>
                                    <Link
                                        href="#"
                                        className={`group relative flex items-center gap-2.5 rounded-2xl py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 ${
                                            pathname.includes("subs") &&
                                            "bg-graydark dark:bg-meta-4"
                                        }`}
                                    >
                                        <FontAwesomeIcon icon={faSackDollar} />
                                        الاشتركات
                                    </Link>
                                </li>
                                <li>
                                    <Link
                                        href="/newAdmin/invoices"
                                        className={`group relative flex items-center gap-2.5 rounded-2xl py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 ${
                                            pathname.includes("invoices") &&
                                            "bg-graydark dark:bg-meta-4"
                                        }`}
                                    >
                                        <FontAwesomeIcon icon={faFileInvoiceDollar} />
                                        الفواتير
                                    </Link>
                                </li>
                                <li>
                                    <Link
                                        href="#"
                                        className={`group relative flex items-center gap-2.5 rounded-2xl py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 ${
                                            pathname.includes("points") &&
                                            "bg-graydark dark:bg-meta-4"
                                        }`}
                                    >
                                        <FontAwesomeIcon icon={faStar} />
                                        النقاط
                                    </Link>
                                </li>
                                <li>
                                    <Link
                                        href="/newAdmin/payouts"
                                        className={`group relative flex items-center gap-2.5 rounded-2xl py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 ${
                                            pathname.includes("payouts") &&
                                            "bg-graydark dark:bg-meta-4"
                                        }`}
                                    >
                                        <FontAwesomeIcon icon={faWallet} />
                                        طلبات تحويل الرصيد
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    )}
                    {props.user.roles.includes("super-admin") && (
                        <div>
                            <h3 className="mb-4 ml-4 text-sm font-semibold text-bodydark2">
                                اعدادات الأنظمة المساندة
                            </h3>
                            <ul className="mb-6 flex flex-col gap-1.5">
                                {(props.user.roles.includes("super-admin") ||
                                    props.user.roles.includes(
                                        "manage-judicial-guide"
                                    )) && (
                                    <JudicialGuideSettings
                                        pathname={pathname}
                                        setSidebarExpanded={setSidebarExpanded}
                                        sidebarExpanded={sidebarExpanded}
                                    />
                                )}
                                {(props.user.roles.includes("super-admin") ||
                                    props.user.roles.includes(
                                        "manage-books"
                                    )) && (
                                    <BooksSettings
                                        pathname={pathname}
                                        setSidebarExpanded={setSidebarExpanded}
                                        sidebarExpanded={sidebarExpanded}
                                    />
                                )}
                                {(props.user.roles.includes("super-admin") ||
                                    props.user.roles.includes(
                                        "manage-law-guide"
                                    )) && (
                                    <>
                                        <LawGuideSettings
                                            pathname={pathname}
                                            setSidebarExpanded={
                                                setSidebarExpanded
                                            }
                                            sidebarExpanded={sidebarExpanded}
                                        />
                                        <BookGuideSettings
                                            pathname={pathname}
                                            setSidebarExpanded={
                                                setSidebarExpanded
                                            }
                                            sidebarExpanded={sidebarExpanded}
                                        />
                                        <li>
                                            <Link
                                                href="/newAdmin/settings/learning-path"
                                                className={`group relative flex items-center gap-2.5 rounded-2xl py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 ${
                                                    pathname.includes(
                                                        "learning-path"
                                                    ) &&
                                                    "bg-graydark dark:bg-meta-4"
                                                }`}
                                            >
                                                <FontAwesomeIcon
                                                    icon={faArrowTurnUp}
                                                />
                                                مسار القراءة
                                            </Link>
                                        </li>
                                    </>
                                )}
                            </ul>
                        </div>
                    )}
                    {props.user.roles.includes("super-admin") && (
                        <div>
                            <h3 className="mb-4 ml-4 text-sm font-semibold text-bodydark2">
                                اعدادات المنتجات
                            </h3>
                            <ul className="mb-6 flex flex-col gap-1.5">
                                <li>
                                    <Link
                                        href="/newAdmin/settings/products"
                                        className={`group relative flex items-center gap-2.5 rounded-2xl py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 ${
                                            pathname.includes("products") &&
                                            "bg-graydark dark:bg-meta-4"
                                        }`}
                                    >
                                        <FontAwesomeIcon icon={faLayerGroup} />
                                        لوحة تخصيص المنتجات
                                    </Link>
                                </li>
                                <li>
                                    <Link
                                        href="/newAdmin/settings/importance"
                                        className={`group relative flex items-center gap-2.5 rounded-2xl py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 ${
                                            pathname.includes("importance") &&
                                            "bg-graydark dark:bg-meta-4"
                                        }`}
                                    >
                                        <FontAwesomeIcon icon={faLayerGroup} />
                                        اعدادات المستويات
                                    </Link>
                                </li>
                                {/* <li>
                                    <Link
                                        href="/newAdmin/settings/working-hours"
                                        className={`group relative flex items-center gap-2.5 rounded-2xl py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 ${
                                            pathname.includes(
                                                "working-hours"
                                            ) && "bg-graydark dark:bg-meta-4"
                                        }`}
                                    >
                                        <FontAwesomeIcon icon={faClock} />
                                        مواعيد العمل
                                    </Link>
                                </li> */}
                                <AdvisoryServicesSettings
                                    pathname={pathname}
                                    setSidebarExpanded={setSidebarExpanded}
                                    sidebarExpanded={sidebarExpanded}
                                />
                                <ReservationsSettings
                                    pathname={pathname}
                                    sidebarExpanded={sidebarExpanded}
                                    setSidebarExpanded={setSidebarExpanded}
                                />

                                <ServicesSettings
                                    pathname={pathname}
                                    setSidebarExpanded={setSidebarExpanded}
                                    sidebarExpanded={sidebarExpanded}
                                />
                                <EliteServiceCategoriesSettings
                                    pathname={pathname}
                                    setSidebarExpanded={setSidebarExpanded}
                                    sidebarExpanded={sidebarExpanded}
                                />
                            </ul>
                        </div>
                    )}
                    <div>
                        <h3 className="mb-4 ml-4 text-sm font-semibold text-bodydark2">
                            الاعدادات
                        </h3>

                        <ul className="mb-6 flex flex-col gap-1.5">
                            <li>
                                <Link
                                    href="/newAdmin/settings/lawyer-permissions"
                                    className={`group relative flex items-center gap-2.5 rounded-2xl py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 ${
                                        pathname.includes(
                                            "lawyer-permissions"
                                        ) && "bg-graydark dark:bg-meta-4"
                                    }`}
                                >
                                    <FontAwesomeIcon icon={faGavel} />
                                    اعدادات صلاحيات المحامين
                                </Link>
                            </li>
                            {props.user.roles.includes("super-admin") && (
                                <li>
                                    <Link
                                        href="/newAdmin/settings/banners"
                                        className={`group relative flex items-center gap-2.5 rounded-2xl py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 ${
                                            pathname.includes("banners") &&
                                            "bg-graydark dark:bg-meta-4"
                                        }`}
                                    >
                                        <FontAwesomeIcon icon={faRectangleAd} />
                                        اعدادات البانرات
                                    </Link>
                                </li>
                            )}
                            {props.user.roles.includes("super-admin") && (
                                <li>
                                    <Link
                                        href="/newAdmin/settings/identity"
                                        className={`group relative flex items-center gap-2.5 rounded-2xl py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 ${
                                            pathname.includes("identity") &&
                                            "bg-graydark dark:bg-meta-4"
                                        }`}
                                    >
                                        <FontAwesomeIcon icon={faPassport} />
                                        اعدادات الهوية
                                    </Link>
                                </li>
                            )}
                            {props.user.roles.includes("super-admin") && (
                                <li>
                                    <Link
                                        href="/newAdmin/settings/app-texts"
                                        className={`group relative flex items-center gap-2.5 rounded-2xl py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 ${
                                            pathname.includes("app-texts") &&
                                            "bg-graydark dark:bg-meta-4"
                                        }`}
                                    >
                                        <FontAwesomeIcon icon={faFileText} />
                                        اعدادات النصوص
                                    </Link>
                                </li>
                            )}
                            {props.user.roles.includes("super-admin") && (
                                <LandingPageSettings
                                    pathname={pathname}
                                    sidebarExpanded={sidebarExpanded}
                                    setSidebarExpanded={setSidebarExpanded}
                                />
                            )}
                            {props.user.roles.includes("super-admin") && (
                                <SignupSettings
                                    pathname={pathname}
                                    sidebarExpanded={sidebarExpanded}
                                    setSidebarExpanded={setSidebarExpanded}
                                />
                            )}

                            {(props.user.roles.includes("super-admin") ||
                                props.user.roles.includes("manage-users")) && (
                                <DashboardSettings
                                    pathname={pathname}
                                    setSidebarExpanded={setSidebarExpanded}
                                    sidebarExpanded={sidebarExpanded}
                                />
                            )}
                            {(props.user.roles.includes("super-admin") ||
                                props.user.roles.includes("manage-users")) && (
                                <GamificationSettings
                                    pathname={pathname}
                                    setSidebarExpanded={setSidebarExpanded}
                                    sidebarExpanded={sidebarExpanded}
                                />
                            )}
                        </ul>
                    </div>
                </nav>
            </div>
        </aside>
    );
};

export default Sidebar;
