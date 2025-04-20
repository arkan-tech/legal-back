import { faClock, faComment, faFile } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { Link } from "@inertiajs/react";
import React from "react";
import ServicesRequestsSidebar from "./ServicesRequestsSidebar";
import AdvisoryServicesRequestsSidebar from "./AdvisoryServicesRequestsSidebar";
import ReservationsRequestsSidebar from "./ReservationsRequestsSidebar";
function ProductsSidebar({ pathname, sidebarExpanded, setSidebarExpanded }) {
    return (
        <div>
            <h3 className="mb-4 ml-4 text-sm font-semibold text-bodydark2">
                طلبات المنتجات
            </h3>
            <ul className="mb-6 flex flex-col gap-1.5">
                <ServicesRequestsSidebar
                    pathname={pathname}
                    sidebarExpanded={sidebarExpanded}
                    setSidebarExpanded={setSidebarExpanded}
                />
                <AdvisoryServicesRequestsSidebar
                    pathname={pathname}
                    sidebarExpanded={sidebarExpanded}
                    setSidebarExpanded={setSidebarExpanded}
                />
                <ReservationsRequestsSidebar
                    pathname={pathname}
                    sidebarExpanded={sidebarExpanded}
                    setSidebarExpanded={setSidebarExpanded}
                />
            </ul>
        </div>
    );
}

export default ProductsSidebar;
