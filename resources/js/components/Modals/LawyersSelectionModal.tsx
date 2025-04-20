import { faChevronDown, faChevronUp } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import React, { useEffect, useState } from "react";
import Pagination from "../Pagination";
import Modal, { Styles } from "react-modal";
import TextInput from "../TextInput";

export default function LawyersSelectionModal({
    isOpen,
    onClose,
    onSubmit,
    initialSelectedLawyers = [],
    lawyers,
}) {
    const [selectedLawyers, setSelectedLawyers] = useState<any>([]);
    const [filterText, setFilterText] = useState("");
    const [currentPage, setCurrentPage] = useState(0);
    const [pageSize, setPageSize] = useState("10");
    const [modalWidth, setModalWidth] = useState("50%");

    useEffect(() => {
        setSelectedLawyers(initialSelectedLawyers);
    }, [initialSelectedLawyers]);

    useEffect(() => {
        function handleResize() {
            if (window.innerWidth <= 768) {
                setModalWidth("80%");
            } else {
                setModalWidth("50%");
            }
        }
        handleResize();
        window.addEventListener("resize", handleResize);
        return () => window.removeEventListener("resize", handleResize);
    }, []);

    // Fetch lawyers from advisory committee

    // Filter and paginate lawyers
    const filteredLawyers = lawyers.filter((lawyer) =>
        lawyer.name.toLowerCase().includes(filterText.toLowerCase())
    );

    const currentData = filteredLawyers.slice(
        currentPage * parseInt(pageSize),
        (currentPage + 1) * parseInt(pageSize)
    );

    // Handle selecting all lawyers
    const handleSelectAll = () => {
        if (selectedLawyers.length === currentData.length) {
            setSelectedLawyers([]);
        } else {
            setSelectedLawyers(currentData.map((lawyer) => lawyer.id));
        }
    };

    // Handle selecting individual lawyer
    const handleSelect = (id) => {
        if (selectedLawyers.includes(id)) {
            setSelectedLawyers(
                selectedLawyers.filter((lawyerId) => lawyerId !== id)
            );
        } else {
            setSelectedLawyers([...selectedLawyers, id]);
        }
    };

    // Handle pagination
    const paginate = (pageNumber: number) => setCurrentPage(pageNumber);

    const handleSubmit = () => {
        onSubmit(selectedLawyers);
        onClose();
    };
    const customStyles: Styles = {
        content: {
            top: "50%",
            left: "50%",
            right: "auto",
            bottom: "auto",
            marginRight: "-50%",
            transform: "translate(-50%, -50%)",
            direction: "rtl",
            fontFamily: "Cairo",
            //
            width: modalWidth,
        },
    };
    return (
        <Modal isOpen={isOpen} onRequestClose={onClose} style={customStyles}>
            <h3 className="font-medium text-black dark:text-white mb-4 flex justify-between items-center">
                اختيار المحامين ({selectedLawyers.length})
            </h3>
            <TextInput
                type="text"
                placeholder="ابحث عن محامٍ"
                value={filterText}
                setValue={setFilterText}
                label="ابحث عن محامٍ"
            />

            <Pagination
                data={filteredLawyers}
                pageSize={pageSize}
                paginate={paginate}
                setPageSize={setPageSize}
            />
            <div className="w-full max-w-full overflow-x-auto">
                <table className="w-full table-auto">
                    <thead>
                        <tr>
                            <th className="flex gap-2 justify-center">
                                <input
                                    type="checkbox"
                                    checked={
                                        selectedLawyers.length ===
                                            currentData.length &&
                                        currentData.length > 0
                                    }
                                    onChange={handleSelectAll}
                                />
                                اختيار الكل
                            </th>
                            <th>الاسم</th>
                        </tr>
                    </thead>
                    <tbody>
                        {currentData.map((lawyer) => (
                            <tr key={lawyer.id}>
                                <td className="text-center">
                                    <input
                                        type="checkbox"
                                        checked={selectedLawyers.includes(
                                            lawyer.id
                                        )}
                                        onChange={() => handleSelect(lawyer.id)}
                                    />
                                </td>
                                <td className="text-center">{lawyer.name}</td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
            <Pagination
                data={filteredLawyers}
                pageSize={pageSize}
                paginate={paginate}
                setPageSize={setPageSize}
            />
            <button
                onClick={handleSubmit}
                className="flex w-full justify-center rounded-xl bg-[#ddb662] py-4 font-medium text-gray hover:bg-opacity-90"
            >
                تأكيد
            </button>
        </Modal>
    );
}
