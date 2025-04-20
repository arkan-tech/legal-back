import React, { useState } from "react";
import Breadcrumb from "../../../../components/Breadcrumbs/Breadcrumb";
import DefaultLayout from "../../../../layout/DefaultLayout";
import DeleteModal from "../../../../components/Modals/DeleteModal";
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
import { DragDropContext, Droppable, Draggable } from "react-beautiful-dnd";

interface SubCategory {
    id: number;
    name: string;
    mainCategory: string;
    mainCategoryId: number;
    lawsCount: number;
    order: number;
}

interface Props {
    subCategories: SubCategory[];
    mainCategories: any[];
}

const SubTable: React.FC<Props> = ({
    subCategories: initialSubCategories,
    mainCategories,
}) => {
    const [subCategories, setSubCategories] = useState<SubCategory[]>(
        initialSubCategories.sort((a, b) => (a.order || 0) - (b.order || 0))
    );
    const [deleteModalOpen, setDeleteModalOpen] = useState({
        state: false,
        id: null,
    });

    const onDragEnd = async (result: any) => {
        if (!result.destination) return;

        try {
            const items = Array.from(subCategories);
            const [reorderedItem] = items.splice(result.source.index, 1);
            items.splice(result.destination.index, 0, reorderedItem);

            // Update the order property for each item
            const updatedItems = items.map((item, index) => ({
                ...item,
                order: index + 1,
            }));

            // Optimistically update the UI
            setSubCategories(updatedItems);

            // Make the API call
            const response = await axios.put(
                "/newAdmin/settings/law-guide/sub/order/update",
                {
                    guides: updatedItems.map((guide) => ({
                        id: guide.id,
                        order: guide.order,
                    })),
                }
            );

            if (response.data.status) {
                toast.success("تم تحديث ترتيب الأنظمة بنجاح");
            } else {
                throw new Error(
                    response.data.message || "Failed to update order"
                );
            }
        } catch (error) {
            console.error("Error updating order:", error);
            toast.error("حدث خطأ أثناء تحديث ترتيب الأنظمة");
            // Revert the changes if the API call fails
            setSubCategories(initialSubCategories);
        }
    };

    return (
        <>
            <DeleteModal
                isOpen={deleteModalOpen.state}
                setIsOpen={setDeleteModalOpen}
                confirmAction={() => {
                    try {
                        axios.delete(
                            `/newAdmin/settings/law-guide/sub/${deleteModalOpen.id}`
                        );
                        toast.success("تم حذف الملف");
                        setDeleteModalOpen({
                            state: false,
                            id: null,
                        });
                        router.get("/newAdmin/settings/law-guide/sub");
                    } catch (err) {
                        toast.error("حدث خطأ");
                    }
                }}
                confirmationText={
                    "عند حذف النظام, سيتم حذف كل المواد المندرجة تحتها"
                }
            />
            <DefaultLayout>
                <div
                    className="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10"
                    dir="rtl"
                >
                    <Breadcrumb pageName="اعدادات الأنظمة و المواد" />
                    <div className="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
                        <div className="mb-6 flex justify-between items-center">
                            <h2 className="text-title-md2 font-bold text-black dark:text-white">
                                الأنظمة
                            </h2>
                            <Link
                                href="/newAdmin/settings/law-guide/sub/create"
                                className="inline-flex items-center justify-center rounded-md bg-primary px-4 py-2 text-center font-medium text-white hover:bg-opacity-90"
                            >
                                إضافة نظام
                            </Link>
                        </div>

                        <div className="max-w-full overflow-x-auto">
                            <DragDropContext onDragEnd={onDragEnd}>
                                <Droppable droppableId="sub-categories">
                                    {(provided) => (
                                        <table
                                            className="w-full table-auto"
                                            {...provided.droppableProps}
                                            ref={provided.innerRef}
                                        >
                                            <thead>
                                                <tr className="bg-gray-2 text-right dark:bg-meta-4">
                                                    <th className="px-4 py-4 font-medium text-black dark:text-white text-right">
                                                        ترتيب
                                                    </th>
                                                    <th className="px-4 py-4 font-medium text-black dark:text-white text-center">
                                                        #
                                                    </th>
                                                    <th className="px-4 py-4 font-medium text-black dark:text-white text-right">
                                                        القسم الرئيسي
                                                    </th>
                                                    <th className="px-4 py-4 font-medium text-black dark:text-white text-right">
                                                        الاسم
                                                    </th>
                                                    <th className="px-4 py-4 font-medium text-black dark:text-white text-right">
                                                        عدد المواد
                                                    </th>
                                                    <th className="px-4 py-4 font-medium text-black dark:text-white text-right">
                                                        العمليات
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {subCategories.map(
                                                    (category, index) => (
                                                        <Draggable
                                                            key={category.id.toString()}
                                                            draggableId={category.id.toString()}
                                                            index={index}
                                                        >
                                                            {(provided) => (
                                                                <tr
                                                                    ref={
                                                                        provided.innerRef
                                                                    }
                                                                    {...provided.draggableProps}
                                                                    className="hover:bg-gray-50 dark:hover:bg-meta-4"
                                                                >
                                                                    <td className="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                                                        <div
                                                                            {...provided.dragHandleProps}
                                                                            className="cursor-move inline-flex"
                                                                            title="اسحب لتغيير الترتيب"
                                                                        >
                                                                            <FontAwesomeIcon
                                                                                icon={
                                                                                    faGripVertical
                                                                                }
                                                                                className="text-gray-500"
                                                                            />
                                                                        </div>
                                                                    </td>
                                                                    <td className="border-b border-[#eee] px-4 py-5 dark:border-strokedark text-center">
                                                                        <p className="text-black dark:text-white">
                                                                            {
                                                                                category.id
                                                                            }
                                                                        </p>
                                                                    </td>
                                                                    <td className="border-b border-[#eee] px-4 py-5 dark:border-strokedark text-right">
                                                                        <p className="text-black dark:text-white">
                                                                            {
                                                                                category.mainCategory
                                                                            }
                                                                        </p>
                                                                    </td>
                                                                    <td className="border-b border-[#eee] px-4 py-5 dark:border-strokedark text-right">
                                                                        <p className="text-black dark:text-white">
                                                                            {
                                                                                category.name
                                                                            }
                                                                        </p>
                                                                    </td>
                                                                    <td className="border-b border-[#eee] px-4 py-5 dark:border-strokedark text-right">
                                                                        <p className="text-black dark:text-white">
                                                                            {
                                                                                category.lawsCount
                                                                            }
                                                                        </p>
                                                                    </td>
                                                                    <td className="border-b border-[#eee] px-4 py-5 dark:border-strokedark text-right">
                                                                        <div className="flex items-center gap-3.5">
                                                                            <Link
                                                                                className="hover:text-primary text-lg"
                                                                                href={`/newAdmin/settings/law-guide/sub/${category.id}`}
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
                                                                                            id: category.id,
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
                                                    )
                                                )}
                                                {provided.placeholder}
                                            </tbody>
                                        </table>
                                    )}
                                </Droppable>
                            </DragDropContext>
                        </div>
                    </div>
                </div>
            </DefaultLayout>
        </>
    );
};

export default SubTable;
