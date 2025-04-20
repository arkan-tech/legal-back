import { ApexOptions } from "apexcharts";
import React, { useState } from "react";
import ReactApexChart from "react-apexcharts";

const options: ApexOptions = {
    colors: ["#3C50E0", "#80CAEE"],
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
                        columnWidth: "25%",
                    },
                },
            },
        },
    ],
    plotOptions: {
        bar: {
            horizontal: false,
            borderRadius: 0,
            columnWidth: "25%",
            borderRadiusApplication: "end",
            borderRadiusWhenStacked: "last",
        },
    },
    dataLabels: {
        enabled: false,
    },

    xaxis: {
        categories: [
            "السبت",
            "الجمعة",
            "الخميس",
            "الاربعاء",
            "الثلثاء",
            "الأثنين",
            "الأحد",
        ],
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

interface ChartTwoState {
    series: {
        name: string;
        data: number[];
    }[];
}

const ChartTwo = ({
    data,
}: {
    data: {
        day: Date;
        day_name: string;
        total: number;
        responded: number;
        not_responded: number;
    }[];
}) => {
    const [state, setState] = useState<ChartTwoState>(() => {
        data = data.reverse();
        return {
            series: [
                {
                    name: "تم الرد",
                    data: data.map((date) => date.responded),
                },
                {
                    name: "لم يتم الرد",
                    data: data.map((date) => date.not_responded),
                },
            ],
        };
    });

    return (
        <div className="col-span-12 rounded-sm border border-stroke bg-white p-7.5 shadow-default dark:border-strokedark dark:bg-boxdark xl:col-span-6">
            <div
                style={{ direction: "rtl" }}
                className="mb-4 justify-between gap-4 sm:flex"
            >
                <div>
                    <h4 className="text-xl font-semibold text-black dark:text-white">
                        الاستشارات هذا الأسبوع
                    </h4>
                </div>
            </div>

            <div>
                <div id="chartTwo" className="-ml-5 -mb-9">
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

export default ChartTwo;
