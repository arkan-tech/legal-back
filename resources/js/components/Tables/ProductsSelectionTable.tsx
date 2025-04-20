import React, { useEffect, useState } from "react";
import Pagination from "../Pagination";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faChevronDown, faChevronUp } from "@fortawesome/free-solid-svg-icons";

const ServicesSelectionTable = ({
    products,
    selectedProducts,
    setSelectedProducts,
    title,
    error,
}) => {
    const [pageSize, setPageSize] = useState("10");
    const [currentPage, setCurrentPage] = useState(0);
    const [currentData, setCurrentData] = useState<any[]>([]);
    const [filteredData, setFilteredData] = useState<any[]>([]);
    const [isAccordionOpen, setIsAccordionOpen] = useState(false);

    const paginate = (pageNumber: number) => setCurrentPage(pageNumber);

    const toggleProductSelection = (productId) => {
        setSelectedProducts((prevSelected) => {
            if (prevSelected.some((item) => item.id === productId)) {
                // Remove product if it's already selected
                return prevSelected.filter((item) => item.id !== productId);
            } else {
                // Add product to the selected list
                return [
                    ...prevSelected,
                    { id: productId, number_of_bookings: 1 },
                ];
            }
        });
    };

    const updateNumberOfBookings = (productId, numberOfBookings) => {
        setSelectedProducts((prevSelected) =>
            prevSelected.map((item) =>
                item.id === productId
                    ? { ...item, number_of_bookings: numberOfBookings }
                    : item
            )
        );
    };

    const toggleSelectAll = () => {
        if (selectedProducts.length === filteredData.length) {
            setSelectedProducts([]);
        } else {
            setSelectedProducts(
                filteredData.map((product) => ({
                    id: product.id,
                    number_of_bookings: 1,
                }))
            );
        }
    };

    useEffect(() => {
        setFilteredData(products);
        setCurrentData(
            products.filter((item, index) => {
                return (
                    index >= currentPage * parseInt(pageSize) &&
                    index < (currentPage + 1) * parseInt(pageSize)
                );
            })
        );
    }, [currentPage, products, pageSize]);

    return (
        <div className="rounded-sm w-full border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
            <h3
                className="font-medium text-black dark:text-white mb-4 cursor-pointer flex justify-between items-center"
                onClick={() => setIsAccordionOpen(!isAccordionOpen)}
            >
                تحديد {title} المتاحة ({selectedProducts.length})
                <FontAwesomeIcon
                    icon={isAccordionOpen ? faChevronUp : faChevronDown}
                    className="transition-transform duration-300"
                />
            </h3>
            <div
                className={`transition-max-height duration-500 ease-in-out overflow-hidden ${
                    isAccordionOpen ? "max-h-[2000px]" : "max-h-0"
                }`}
            >
                {isAccordionOpen && (
                    <>
                        <Pagination
                            data={filteredData}
                            pageSize={pageSize}
                            paginate={paginate}
                            setPageSize={setPageSize}
                        />
                        <div className="w-full max-w-full overflow-x-auto">
                            <table
                                className="w-full table-auto"
                                style={{ direction: "rtl" }}
                            >
                                <thead>
                                    <tr className="bg-gray-2 text-right dark:bg-meta-4">
                                        <th className="min-w-[20px] py-4 px-4 font-medium text-black dark:text-white ">
                                            <input
                                                type="checkbox"
                                                checked={
                                                    selectedProducts.length ===
                                                    filteredData.length
                                                }
                                                onChange={toggleSelectAll}
                                            />
                                            اختيار الكل
                                        </th>
                                        <th className="min-w-[20px] py-4 px-4 font-medium text-black dark:text-white ">
                                            اسم المنتج
                                        </th>
                                        <th className="min-w-[20px] py-4 px-4 font-medium text-black dark:text-white ">
                                            اسعار المستويات
                                        </th>
                                        <th className="min-w-[20px] py-4 px-4 font-medium text-black dark:text-white ">
                                            عدد الحجوزات
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {currentData.map((product) => (
                                        <tr key={product.id}>
                                            <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                                <input
                                                    type="checkbox"
                                                    checked={selectedProducts.some(
                                                        (item) =>
                                                            item.id ===
                                                            product.id
                                                    )}
                                                    onChange={() =>
                                                        toggleProductSelection(
                                                            product.id
                                                        )
                                                    }
                                                />
                                            </td>
                                            <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                                {product.title}
                                            </td>
                                            <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                                <p className="text-black dark:text-white">
                                                    {product.prices.map(
                                                        (price) => (
                                                            <p
                                                                key={
                                                                    price.title
                                                                }
                                                            >
                                                                {price.title}
                                                                {": "}
                                                                {price.price}
                                                            </p>
                                                        )
                                                    )}
                                                </p>
                                            </td>
                                            <td className="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                                <input
                                                    type="number"
                                                    min="0"
                                                    value={
                                                        selectedProducts.find(
                                                            (item) =>
                                                                item.id ===
                                                                product.id
                                                        )?.number_of_bookings ||
                                                        0
                                                    }
                                                    onChange={(e) =>
                                                        updateNumberOfBookings(
                                                            product.id,
                                                            Number(
                                                                e.target.value
                                                            )
                                                        )
                                                    }
                                                    disabled={
                                                        !selectedProducts.some(
                                                            (item) =>
                                                                item.id ===
                                                                product.id
                                                        )
                                                    }
                                                />
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
                    </>
                )}
            </div>
            {error && <p className="text-red-600">{error}</p>}
        </div>
    );
};

export default ServicesSelectionTable;
