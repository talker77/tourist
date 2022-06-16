$(function () {
    "use strict";


    if ($("#current-circle-progress").length) {
        $("#current-circle-progress")
            .circleProgress({
                value: 0.73,
                size: 120,
                startAngle: -1.55,
                fill: chartColors[1]
            })
            .on("circle-animation-progress", function (event, progress, stepValue) {
                $(this)
                    .find(".circle-progress-value")
                    .text(stepValue.toFixed(2).substr(2) + "%");
            });
    }

    if ($("#sales-conversion").length) {
        var BarData = {
            labels: ["2013", "2014", "2014", "2015", "2016", "2017"],
            datasets: [{
                    label: "Profit",
                    data: [10, 19, 3, 5, 12, 3],
                    backgroundColor: chartColors[1]
                },
                {
                    label: "Sales",
                    data: [23, 12, 8, 13, 9, 17],
                    backgroundColor: chartColors[5]
                }
            ]
        };
        var BarOptions = {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                xAxes: [{
                    display: false
                }],
                yAxes: [{
                    display: false
                }]
            },
            legend: {
                display: false
            }
        };
        var SalesConversionChartCanvas = $("#sales-conversion")
            .get(0)
            .getContext("2d");
        var SalesConversionChart = new Chart(SalesConversionChartCanvas, {
            type: "bar",
            data: BarData,
            options: BarOptions
        });
    }
});