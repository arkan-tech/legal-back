import { ApexOptions } from "apexcharts";
import React, { useState } from "react";
import ReactApexChart from "react-apexcharts";

const options: ApexOptions = {
    colors: ["#3C50E0", "#80CAEE", "#FF5733"],
    chart: {
        fontFamily: "Cairo, sans-serif",
        type: "bar",
        height: 335,
        stacked: true,
        toolbar: {
            show: false,
        },
        zoom: {
            enabled: false,
        },
    },
    responsive: [
        {
            breakpoint: 1536,
            options: {
                plotOptions: {
                    bar: {
                        borderRadius: 0,
                        barHeight: "25%",
                    },
                },
            },
        },
    ],
    plotOptions: {
        bar: {
            horizontal: true,
            borderRadius: 0,
            barHeight: "25%",
            borderRadiusApplication: "end",
            borderRadiusWhenStacked: "last",
        },
    },
    dataLabels: {
        enabled: false,
    },
    xaxis: {
        categories: ["استشارات", "خدمات", "مواعيد"],
    },
    legend: {
        position: "top",
        horizontalAlign: "right",
        fontFamily: "Cairo",
        fontWeight: 500,
        fontSize: "14px",
        markers: {
            radius: 99,
        },
    },
    fill: {
        opacity: 1,
    },
};

interface ChartHorizontalBarState {
    series: {
        name: string;
        data: number[];
    }[];
}

const ChartHorizontalBar = ({
    data,
}: {
    data: {
        advisoryServices: { total: number }[];
        services: { total: number }[];
        appointments: { total: number }[];
    };
}) => {
    const [state, setState] = useState<ChartHorizontalBarState>(() => {
        return {
            series: [
                {
                    name: "استشارات",
                    data: data.advisoryServices.map((item) => item.total),
                },
                {
                    name: "خدمات",
                    data: data.services.map((item) => item.total),
                },
                {
                    name: "مواعيد",
                    data: data.appointments.map((item) => item.total),
                },
            ],
        };
    });

    return (
        <div className="col-span-12 rounded-sm border border-stroke bg-white p-7.5 shadow-default dark:border-strokedark dark:bg-boxdark">
            <div
                style={{ direction: "rtl" }}
                className="mb-4 justify-between gap-4 sm:flex"
            >
                <div>
                    <h4 className="text-xl font-semibold text-black dark:text-white">
                        المنتجات الأكثر طلبا
                    </h4>
                </div>
            </div>

            <div>
                <div id="chartHorizontalBar" className="-ml-5 -mb-9">
                    <ReactApexChart
                        options={options}
                        series={state.series}
                        type="bar"
                        height={350}
                    />
                </div>
            </div>
        </div>
    );
};

export default ChartHorizontalBar;
