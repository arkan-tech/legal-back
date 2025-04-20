import React, { useEffect, useState } from "react";
import { Head, Link, router } from "@inertiajs/react";
import DefaultLayout from "../../../layout/DefaultLayout";
import Breadcrumb from "../../../components/Breadcrumbs/Breadcrumb";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faPlus, faTrash, faUserPen } from "@fortawesome/free-solid-svg-icons";
import Pagination from "../../../components/Pagination";
import DeleteModal from "../../../components/Modals/DeleteModal";
import axios from "axios";
import toast from "react-hot-toast";

interface Category {
    id: number;
    name: string;
}

interface Props {
    categories: Category[];
}

interface DeleteModalState {
    state: boolean;
    id: number | null;
}

export default function Index({ categories }: Props) {
    const [pageSize, setPageSize] = useState("100");
    const [currentPage, setCurrentPage] = useState(0);
    const [filteredData, setFilteredData] = useState<Category[]>([]);
    const [currentData, setCurrentData] = useState<Category[]>([]);
    const [deleteModalOpen, setDeleteModalOpen] = useState<DeleteModalState>({
        state: false,
        id: null,
    });

    const paginate = (pageNumber: number) => setCurrentPage(pageNumber);

    useEffect(() => {
        setFilteredData(categories);
        setCurrentData(
            categories.filter((item, index) => {
                return (
                    index >= currentPage * parseInt(pageSize) &&
                    index < (currentPage + 1) * parseInt(pageSize)
                );
            })
        );
    }, [currentPage, pageSize, categories]);

    const headers = ["#", "اسم الفئة", "الإجراءات"];

    return (
        <>
            <DeleteModal
                isOpen={deleteModalOpen.state}
                setIsOpen={setDeleteModalOpen}
                confirmAction={async () => {
                    try {
                        await axios.delete(
                            `/newAdmin/settings/elite-service-categories/${deleteModalOpen.id}`
                        );
                        toast.success("تم حذف الفئة");
                        setDeleteModalOpen({
                            state: false,
                            id: null,
                        });
                        router.get(
                            "/newAdmin/settings/elite-service-categories"
                        );
                    } catch (err) {
                        toast.error("حدث خطأ");
                    }
                }}
                confirmationText={"هل أنت متأكد من حذف هذه الفئة؟"}
            />
            <DefaultLayout>
                <Head title="فئات الخدمات المميزة" />
                <Breadcrumb pageName="فئات الخدمات المميزة" />

                <div
                    style={{ direction: "rtl" }}
                    className="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1"
                >
                    <div className="grid grid-cols-12 gap-2 mb-2">
                        <div className="col-span-6"></div>
                        <div className="col-span-6 flex items-center justify-end">
                            <Link
                                href="/newAdmin/settings/elite-service-categories/create"
                                className="px-4 py-2 bg-purple-500 text-white rounded-xl hover:bg-purple-700"
                            >
                                إضافة فئة جديدة
                            </Link>
                        </div>
                    </div>

                    <Pagination
                        data={filteredData}
                        pageSize={pageSize}
                        paginate={paginate}
                        setPageSize={setPageSize}
                    />

                    <div className="max-w-full overflow-x-auto">
                        <table className="w-full table-auto">
                            <thead>
                                <tr className="bg-gray-2 text-right dark:bg-meta-4">
                                    {headers.map((header) => (
                                        <th
                                            key={header}
                                            className="min-w-[20px] py-4 px-4 font-medium text-black dark:text-white"
                                        >
                                            {header}
                                        </th>
                                    ))}
                                </tr>
                            </thead>
                            <tbody>
                                {currentData.map((category) => (
                                    <tr key={category.id}>
                                        <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                            <h5 className="font-medium text-black dark:text-white">
                                                {category.id}
                                            </h5>
                                        </td>
                                        <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                            <h5 className="font-medium text-black dark:text-white">
                                                {category.name}
                                            </h5>
                                        </td>
                                        <td className="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                            <div className="flex items-center gap-5">
                                                <Link
                                                    href={`/newAdmin/settings/elite-service-categories/${category.id}`}
                                                    className="hover:text-primary"
                                                >
                                                    <FontAwesomeIcon
                                                        icon={faUserPen}
                                                    />
                                                </Link>
                                                <button
                                                    onClick={() =>
                                                        setDeleteModalOpen({
                                                            state: true,
                                                            id: category.id,
                                                        })
                                                    }
                                                    className="hover:text-primary"
                                                >
                                                    <FontAwesomeIcon
                                                        icon={faTrash}
                                                    />
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>

                    <Pagination
                        data={filteredData}
                        pageSize={pageSize}
                        paginate={paginate}
                        setPageSize={setPageSize}
                    />
                </div>
            </DefaultLayout>
        </>
    );
}
