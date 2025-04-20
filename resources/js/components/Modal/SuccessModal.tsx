import React from "react";
function SuccessModal({ text }) {
    return (
        <div className="absolute top-0 w-screen h-screen">
            <div className="flex w-full h-full bg-black opacity-30"></div>
            <p>{text}</p>
        </div>
    );
}

export default SuccessModal;
