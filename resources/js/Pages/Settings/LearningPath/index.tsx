import React, { useState } from "react";
import Breadcrumb from "../../../components/Breadcrumbs/Breadcrumb";
import DefaultLayout from "../../../layout/DefaultLayout";
import DeleteModal from "../../../components/Modals/DeleteModal";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import axios from "axios";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import {
    faPenToSquare,
    faTrash,
    faGripVertical,
} from "@fortawesome/free-solid-svg-icons";
import { Link } from "@inertiajs/react";
import Pagination from "../../../components/Pagination";
import { DragDropContext, Droppable, Draggable } from "react-beautiful-dnd";

interface LearningPathItem {
    id: number;
    item_type: string;
    item_id: number;
    name: string;
    order: number;
    mandatory: boolean;
    main_category: string;
    sub_category: string;
}

interface LearningPath {
    id: number;
    title: string;
    items: number;
    order: number;
}

interface Props {
    learningPaths: LearningPath[];
}

const Index: React.FC<Props> = ({ learningPaths }) => {
    const [deleteModalOpen, setDeleteModalOpen] = useState<{
        state: boolean;
        id: number | null;
    }>({
        state: false,
        id: null,
    });
    const [paths, setPaths] = useState<LearningPath[]>(learningPaths || []);
    const [pageSize, setPageSize] = useState("100");
    const [currentPage, setCurrentPage] = useState(0);
    const [searchQuery, setSearchQuery] = useState("");
    const [filteredData, setFilteredData] = useState<LearningPath[]>(paths);
    const [currentData, setCurrentData] = useState<LearningPath[]>(paths);
    const paginate = (pageNumber: number) => setCurrentPage(pageNumber);

    React.useEffect(() => {
        if (!paths) return;

        const filtered = paths.filter(
            (path) =>
                path.title.toLowerCase().includes(searchQuery.toLowerCase()) ||
                path.id.toString() === searchQuery
        );
        setFilteredData(filtered);

        const startIndex = currentPage * parseInt(pageSize);
        const endIndex = startIndex + parseInt(pageSize);
        setCurrentData(filtered.slice(startIndex, endIndex));
    }, [currentPage, searchQuery, pageSize, paths]);

    const handleDelete = async () => {
        try {
            await axios.delete(
                `/newAdmin/settings/learning-path/${deleteModalOpen.id}`
            );
            toast.success("تم حذف المسار التعليمي بنجاح");
            router.visit("/newAdmin/settings/learning-path", { method: "get" });
        } catch (error) {
            toast.error("حدث خطأ أثناء حذف المسار التعليمي");
        }
        setDeleteModalOpen({ state: false, id: null });
    };

    const onDragEnd = async (result: any) => {
        if (!result.destination) return;

        const items = Array.from(paths);
        const [reorderedItem] = items.splice(result.source.index, 1);
        items.splice(result.destination.index, 0, reorderedItem);

        // Update the order property for each item
        const updatedItems = items.map((item, index) => ({
            ...item,
            order: index + 1,
        }));

        setPaths(updatedItems);
        setFilteredData(updatedItems);

        try {
            await axios.put("/newAdmin/settings/learning-path/order/update", {
                paths: updatedItems.map((path) => ({
                    id: path.id,
                    order: path.order,
                })),
            });
            toast.success("تم تحديث ترتيب المسارات بنجاح");
        } catch (error) {
            toast.error("حدث خطأ أثناء تحديث ترتيب المسارات");
            // Revert the changes if the API call fails
            setPaths(learningPaths);
            setFilteredData(learningPaths);
        }
    };

    return (
        <DefaultLayout>
            <div
                className="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10"
                style={{ direction: "rtl" }}
            >
                <div className="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <h2 className="text-2xl font-bold text-black dark:text-white">
                        مسارات القراءة
                    </h2>
                    <Link
                        href="/newAdmin/settings/learning-path/create"
                        className="inline-flex items-center justify-center rounded-md bg-primary px-4 py-2 text-center font-medium text-white hover:bg-opacity-90"
                    >
                        إضافة مسار جديد
                    </Link>
                </div>

                <div className="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
                    <div className="mb-4">
                        <input
                            type="text"
                            placeholder="ابحث بالعنوان او الرقم التعريفي..."
                            value={searchQuery}
                            onChange={(e) => setSearchQuery(e.target.value)}
                            className="w-full px-4 py-3 border rounded-md dark:border-strokedark dark:bg-boxdark text-right"
                        />
                    </div>

                    <div className="max-w-full overflow-x-auto">
                        <DragDropContext onDragEnd={onDragEnd}>
                            <Droppable droppableId="learning-paths">
                                {(provided) => (
                                    <table
                                        className="w-full table-auto"
                                        {...provided.droppableProps}
                                        ref={provided.innerRef}
                                    >
                                        <thead>
                                            <tr className="bg-gray-2 text-right dark:bg-meta-4">
                                                <th className="px-4 py-4 font-medium text-black dark:text-white text-right">
                                                    الترتيب
                                                </th>
                                                <th className="px-4 py-4 font-medium text-black dark:text-white text-right">
                                                    #
                                                </th>
                                                <th className="px-4 py-4 font-medium text-black dark:text-white text-right">
                                                    العنوان
                                                </th>
                                                <th className="px-4 py-4 font-medium text-black dark:text-white text-right">
                                                    عدد العناصر
                                                </th>
                                                <th className="px-4 py-4 font-medium text-black dark:text-white text-right">
                                                    الإجراءات
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {currentData.map((path, index) => (
                                                <Draggable
                                                    key={path.id.toString()}
                                                    draggableId={path.id.toString()}
                                                    index={index}
                                                >
                                                    {(provided) => (
                                                        <tr
                                                            ref={
                                                                provided.innerRef
                                                            }
                                                            {...provided.draggableProps}
                                                        >
                                                            <td className="border-b border-[#eee] px-4 py-5 dark:border-strokedark text-right">
                                                                <div
                                                                    {...provided.dragHandleProps}
                                                                    className="cursor-move"
                                                                >
                                                                    <FontAwesomeIcon
                                                                        icon={
                                                                            faGripVertical
                                                                        }
                                                                    />
                                                                </div>
                                                            </td>
                                                            <td className="border-b border-[#eee] px-4 py-5 dark:border-strokedark text-right">
                                                                <p className="text-black dark:text-white">
                                                                    {path.id}
                                                                </p>
                                                            </td>
                                                            <td className="border-b border-[#eee] px-4 py-5 dark:border-strokedark text-right">
                                                                <p className="text-black dark:text-white">
                                                                    {path.title}
                                                                </p>
                                                            </td>
                                                            <td className="border-b border-[#eee] px-4 py-5 dark:border-strokedark text-right">
                                                                <p className="text-black dark:text-white">
                                                                    {path.items}
                                                                </p>
                                                            </td>
                                                            <td className="border-b border-[#eee] px-4 py-5 dark:border-strokedark text-right">
                                                                <div className="flex items-center gap-3.5">
                                                                    <Link
                                                                        className="hover:text-primary text-lg"
                                                                        href={`/newAdmin/settings/learning-path/${path.id}/edit`}
                                                                        title="تعديل"
                                                                    >
                                                                        <FontAwesomeIcon
                                                                            icon={
                                                                                faPenToSquare
                                                                            }
                                                                        />
                                                                    </Link>
                                                                    <button
                                                                        className="hover:text-danger text-lg"
                                                                        onClick={() =>
                                                                            setDeleteModalOpen(
                                                                                {
                                                                                    state: true,
                                                                                    id: path.id,
                                                                                }
                                                                            )
                                                                        }
                                                                        title="حذف"
                                                                    >
                                                                        <FontAwesomeIcon
                                                                            icon={
                                                                                faTrash
                                                                            }
                                                                        />
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    )}
                                                </Draggable>
                                            ))}
                                            {provided.placeholder}
                                        </tbody>
                                    </table>
                                )}
                            </Droppable>
                        </DragDropContext>
                    </div>

                    <div className="mt-4">
                        <Pagination
                            data={filteredData}
                            pageSize={pageSize}
                            paginate={paginate}
                            setPageSize={setPageSize}
                        />
                    </div>
                </div>
            </div>

            <DeleteModal
                isOpen={deleteModalOpen.state}
                setIsOpen={setDeleteModalOpen}
                confirmAction={handleDelete}
                confirmationText="هل أنت متأكد من حذف هذا المسار التعليمي؟"
            />
        </DefaultLayout>
    );
};

export default Index;
