import Modal, { Styles } from "react-modal";
import React from "react";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faX } from "@fortawesome/free-solid-svg-icons";
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
    },
};
function DeleteModal({ isOpen, setIsOpen, confirmAction, confirmationText }) {
    return (
        <Modal
            isOpen={isOpen}
            contentLabel="Test"
            style={customStyles}
            ariaHideApp={false}
        >
            <div className="flex flex-col gap-4">
                <div className="flex gap-4">
                    <button
                        onClick={() =>
                            setIsOpen({ state: !isOpen, baseId: null })
                        }
                    >
                        <FontAwesomeIcon icon={faX} />
                    </button>
                    <p>هل انت متأكد من عملية الحذف</p>
                </div>
                <div>{confirmationText}</div>
                <div className="flex gap-8">
                    <button
                        onClick={confirmAction}
                        className="bg-red-500 text-white p-2 rounded-lg"
                    >
                        حذف
                    </button>
                    <button
                        onClick={() =>
                            setIsOpen({ state: !isOpen, baseId: null })
                        }
                        className="bg-body text-white p-2 rounded-lg"
                    >
                        الغاء
                    </button>
                </div>
            </div>
        </Modal>
    );
}

export default DeleteModal;
