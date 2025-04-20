import ReactPaginate from "react-paginate";
import React, { useState } from "react";
import SelectGroup from "../Forms/SelectGroup/SelectGroup";
export default function Pagination({ data, paginate, pageSize, setPageSize }) {
    return (
        <div className="flex justify-between my-4 items-center">
            <SelectGroup
                options={[
                    {
                        id: "10",
                        name: "10",
                    },
                    { id: "50", name: "50" },
                    {
                        id: "100",
                        name: "100",
                    },
                    {
                        id: "200",
                        name: "200",
                    },
                ]}
                selectedOption={pageSize}
                setSelectedOption={setPageSize}
                title="العدد"
            />
            <div>المجموع: {data.length}</div>
            <ReactPaginate
                containerClassName="flex gap-4 px-4 py-2 h-1/2 bg-gray dark:bg-meta-4 rounded-full"
                pageClassName="b px-2 rounded-full"
                onPageChange={(event) => paginate(event.selected)}
                activeClassName="bg-purple-500 text-white"
                pageCount={Math.ceil(data.length / parseInt(pageSize))}
                breakLabel="..."
                previousLabel="السابق"
                nextLabel="القادم"
            />
        </div>
    );
}
