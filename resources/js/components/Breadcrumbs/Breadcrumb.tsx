import { Link, router, usePage } from "@inertiajs/react";
import React from "react";
interface BreadcrumbProps {
    pageName: string;
}
const Breadcrumb = ({ pageName }: BreadcrumbProps) => {
    const { url } = usePage();
    console.log(url.match(new RegExp(/\//, "g"))?.length);
    const isSettingsPage =
        (url.startsWith("/newAdmin/settings") &&
            url.match(new RegExp(/\//, "g"))?.length >= 3 &&
            !url.includes("create")) ||
        (url.startsWith("/newAdmin") &&
            url.match(new RegExp(/\//, "g"))?.length == 2);
    // const isFormPage =
    //     (url.startsWith("/newAdmin/settings") &&
    //         url.match(new RegExp(/\//, "g"))?.length == 4) ||
    //     (url.startsWith("/newAdmin") &&
    //         url.match(new RegExp(/\//, "g"))?.length == 3);

    return (
        <div
            style={{ direction: "rtl" }}
            className="mb-6 flex flex-col px-3 gap-3 sm:flex-row sm:items-center sm:justify-between"
        >
            <h2 className="text-title-md2 font-semibold text-black dark:text-white">
                {pageName}
            </h2>

            <nav>
                <ol className="flex items-center gap-2">
                    <li className="text-[#bababa]">
                        {isSettingsPage ? (
                            <Link
                                className="font-medium"
                                href="/newAdmin/dashboard"
                            >
                                الرئيسية /
                            </Link>
                        ) : (
                            <p
                                className="font-medium hover:cursor-pointer"
                                onClick={() => window.history.back()}
                            >
                                القائمة /
                            </p>
                        )}
                    </li>
                    <li className="font-medium text-[#ddb662]">{pageName}</li>
                </ol>
            </nav>
        </div>
    );
};

export default Breadcrumb;
