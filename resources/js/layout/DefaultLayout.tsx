import React, { useState, ReactNode, forwardRef } from "react";
import Header from "../components/Header/index";
import Sidebar from "../components/Sidebar/index";
import "../../css/app.css";
import { Head, usePage } from "@inertiajs/react";
import { Toaster } from "react-hot-toast";
const DefaultLayout = forwardRef(({ children }: any, ref) => {
    const [sidebarOpen, setSidebarOpen] = useState(false);
    const { props } = usePage();
    return (
        <>
            <Head>
                <title>Ymtaz Admin Panel</title>

                <link rel="icon" type="image/svg+xml" href="/logo.svg" />
            </Head>
            <div className="dark:bg-boxdark-2 dark:text-bodydark font-cairo">
                <Toaster
                    toastOptions={{
                        className: "w-[300px] h-[150px]",
                        style: { direction: "rtl", padding: "20px" },
                        duration: 10000,
                    }}
                />
                {/* <!-- ===== Page Wrapper Start ===== --> */}
                <div className="flex h-screen overflow-hidden">
                    {/* <!-- ===== Content Area Start ===== --> */}
                    <div
                        className="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden no-scrollbar"
                        //@ts-ignore
                        ref={ref}
                    >
                        {/* <!-- ===== Header Start ===== --> */}
                        {props.auth == true ? (
                            <Header
                                sidebarOpen={sidebarOpen}
                                setSidebarOpen={setSidebarOpen}
                            />
                        ) : null}

                        {/* <!-- ===== Header End ===== --> */}

                        {/* <!-- ===== Main Content Start ===== --> */}
                        <main>
                            <div className="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
                                {children}
                            </div>
                        </main>
                        {/* <!-- ===== Main Content End ===== --> */}
                    </div>
                    {/* <!-- ===== Content Area End ===== --> */}
                    {/* <!-- ===== Sidebar Start ===== --> */}
                    {props.auth == true ? (
                        <Sidebar
                            sidebarOpen={sidebarOpen}
                            setSidebarOpen={setSidebarOpen}
                        />
                    ) : null}
                    {/* <!-- ===== Sidebar End ===== --> */}
                </div>
                {/* <!-- ===== Page Wrapper End ===== --> */}
            </div>
        </>
    );
});

export default DefaultLayout;
