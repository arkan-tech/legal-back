import React, { useEffect, useState } from "react";
import Modal, { Styles } from "react-modal";
import TextInput from "../TextInput";

export default function LeaderSelectionModal({
    isOpen,
    onClose,
    onSubmit,
    initialSelectedLeaderId = null,
    lawyers,
}) {
    const [selectedLeaderId, setSelectedLeaderId] = useState(null);
    const [filterText, setFilterText] = useState("");
    const [modalWidth, setModalWidth] = useState("50%");

    useEffect(() => {
        setSelectedLeaderId(initialSelectedLeaderId);
    }, [initialSelectedLeaderId]);

    useEffect(() => {
        function handleResize() {
            setModalWidth(window.innerWidth <= 768 ? "80%" : "50%");
        }
        handleResize();
        window.addEventListener("resize", handleResize);
        return () => window.removeEventListener("resize", handleResize);
    }, []);

    const filteredLawyers = lawyers.filter((lawyer) =>
        lawyer.name.toLowerCase().includes(filterText.toLowerCase())
    );

    const handleSubmit = () => {
        onSubmit(selectedLeaderId);
        onClose();
    };

    const customStyles: Styles = {
        content: {
            // ...existing styles...
            width: modalWidth,
        },
    };

    return (
        <Modal isOpen={isOpen} onRequestClose={onClose} style={customStyles}>
            <h3 className="font-medium text-black dark:text-white mb-4">
                اختيار القائد
            </h3>
            <TextInput
                type="text"
                placeholder="ابحث عن محامٍ"
                value={filterText}
                setValue={setFilterText}
                label="ابحث عن محامٍ"
            />
            <div className="w-full max-w-full overflow-x-auto">
                <table className="w-full table-auto">
                    <thead>
                        <tr>
                            <th>اختيار</th>
                            <th>الاسم</th>
                        </tr>
                    </thead>
                    <tbody>
                        {filteredLawyers.map((lawyer) => (
                            <tr key={lawyer.id}>
                                <td className="text-center">
                                    <input
                                        type="radio"
                                        name="leader"
                                        checked={selectedLeaderId === lawyer.id}
                                        onChange={() =>
                                            setSelectedLeaderId(lawyer.id)
                                        }
                                    />
                                </td>
                                <td className="text-center">{lawyer.name}</td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
            <button
                onClick={handleSubmit}
                className="flex w-full justify-center rounded-xl bg-[#ddb662] py-4 font-medium text-gray hover:bg-opacity-90"
            >
                تأكيد
            </button>
        </Modal>
    );
}
