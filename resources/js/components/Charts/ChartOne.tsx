import { ApexOptions } from "apexcharts";
import React, { useState } from "react";
import ReactApexChart from "react-apexcharts";

interface ChartOneState {
    series: {
        name: string;
        data: number[];
    }[];
}

const ChartOne = ({
    signupsByMonth,
    startDate,
    endDate,
    max,
}: {
    signupsByMonth;
    startDate;
    endDate;
    max;
}) => {
    startDate = new Date(startDate);
    endDate = new Date(endDate);
    signupsByMonth = Object.values(signupsByMonth);
    const [state, setState] = useState<ChartOneState>({
        series: [
            {
                name: "Signups",
                data: signupsByMonth,
            },
        ],
    });

    const options: ApexOptions = {
        legend: {
            show: true,
            position: "top",
            horizontalAlign: "left",
        },
        colors: ["#3C50E0", "#80CAEE"],
        chart: {
            fontFamily: "Cairo, sans-serif",
            height: 335,
            type: "area",
            dropShadow: {
                enabled: true,
                color: "#623CEA14",
                top: 10,
                blur: 4,
                left: 0,
                opacity: 0.1,
            },
            toolbar: {
                show: false,
            },
        },
        responsive: [
            {
                breakpoint: 1024,
                options: {
                    chart: {
                        height: 300,
                    },
                },
            },
            {
                breakpoint: 1366,
                options: {
                    chart: {
                        height: 350,
                    },
                },
            },
        ],
        stroke: {
            width: [2, 2],
            curve: "straight",
        },
        grid: {
            xaxis: {
                lines: {
                    show: true,
                },
            },
            yaxis: {
                lines: {
                    show: true,
                },
            },
        },
        dataLabels: {
            enabled: false,
        },
        markers: {
            size: 4,
            colors: "#fff",
            strokeColors: ["#3056D3", "#80CAEE"],
            strokeWidth: 3,
            strokeOpacity: 0.9,
            strokeDashArray: 0,
            fillOpacity: 1,
            discrete: [],
            hover: {
                size: undefined,
                sizeOffset: 5,
            },
        },
        xaxis: {
            type: "category",
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
            min: 1,
            max: signupsByMonth.length,
        },
        yaxis: {
            title: {
                style: {
                    fontSize: "0px",
                },
            },
            min: 0,
            max: max,
            floating: false,
        },
    };
    const handleReset = () => {
        setState((prevState) => ({
            ...prevState,
        }));
    };

    return (
        <div className="col-span-12 rounded-sm border border-stroke bg-white px-5 pt-7.5 pb-5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:col-span-6">
            <div
                style={{ direction: "rtl" }}
                className="flex flex-wrap items-start justify-between gap-3 sm:flex-nowrap"
            >
                <div className="flex w-full flex-wrap gap-3 sm:gap-5">
                    <div className="flex min-w-75">
                        <span className="mt-1 mr-2 flex h-4 w-full max-w-4 items-center justify-center rounded-full border border-primary">
                            <span className="block h-2.5 w-full max-w-2.5 rounded-full bg-primary"></span>
                        </span>
                        <div className="w-full">
                            <p className="font-semibold text-primary">
                                مجموع تسجيلات العملاء
                            </p>
                            <p className="text-sm font-medium">
                                من{" "}
                                {`${startDate.getDate()}-${
                                    startDate.getMonth() + 1
                                }-${startDate.getFullYear()}`}{" "}
                                حتى{" "}
                                {`${endDate.getDate()}-${
                                    endDate.getMonth() + 1
                                }-${endDate.getFullYear()}`}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div id="chartOne" className="-ml-5">
                    <ReactApexChart
                        options={options}
                        series={state.series}
                        type="area"
                        height={350}
                    />
                </div>
            </div>
        </div>
    );
};

export default ChartOne;
