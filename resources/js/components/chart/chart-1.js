

export const initChartOne = () => {
    const chartElement = document.querySelector('#chartOne');
    if (!chartElement) return;

    const monthlyIncome = JSON.parse(chartElement.dataset.monthlyIncome);

    const chartOneOptions = {
        series: [
            {
                name: "Valor de reparaciones",
                data: monthlyIncome,
            },
        ],
        colors: ["#465fff"],
        chart: {
            fontFamily: "Outfit, sans-serif",
            type: "bar",
            height: 180,
            toolbar: {
                show: false,
            },
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: "39%",
                borderRadius: 5,
                borderRadiusApplication: "end",
            },
        },
        dataLabels: {
            enabled: false,
        },
        stroke: {
            show: true,
            width: 4,
            colors: ["transparent"],
        },
        xaxis: {
            categories: [
                "Ene",
                "Feb",
                "Mar",
                "Abr",
                "May",
                "Jun",
                "Jul",
                "Ago",
                "Sep",
                "Oct",
                "Nov",
                "Dic",
            ],
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
        },
        legend: {
            show: true,
            position: "top",
            horizontalAlign: "left",
            fontFamily: "Outfit",
            markers: {
                radius: 99,
            },
        },
        yaxis: {
            title: false,
        },
        grid: {
            yaxis: {
                lines: {
                    show: true,
                },
            },
        },
        fill: {
            opacity: 1,
        },

        tooltip: {
            x: {
                show: false,
            },
            y: {
                formatter: function (value) {
                    return new Intl.NumberFormat("es-CO", {
                        style: "currency",
                        currency: "COP",
                        maximumFractionDigits: 0,
                    }).format(value);
                },
            },
        },
    };

    const chart = new ApexCharts(chartElement, chartOneOptions);
    chart.render();

    return chart;
};

export default initChartOne;
