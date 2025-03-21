// currency format
function currencyFormat(amount, type = "icon", decimals = 2) {
    let symbol = $('#currency_symbol').val();
    let position = $('#currency_position').val();
    let code = $('#currency_code').val();

    let formatted_amount = formattedAmount(amount, decimals);

    // Apply currency format based on the position and type
    if (type === "icon" || type === "symbol") {
        if (position === "right") {
            return formatted_amount + symbol;
        } else {
            return symbol + formatted_amount;
        }
    } else {
        if (position === "right") {
            return formatted_amount + ' ' + code;
        } else {
            return code + ' ' + formatted_amount;
        }
    }
}
// Format the amount
function formattedAmount(amount, decimals){
    return  Number.isInteger(+amount) ? parseInt(amount) : (+amount).toFixed(decimals);
}

$(document).ready(function () {
    getYearlySubscriptions();
    bestPlanSubscribes();
});

$(".overview-year").on("change", function () {
    let year = $(this).val();
    bestPlanSubscribes(year);
});

$(".yearly-statistics").on("change", function () {
    let year = $(this).val();
    getYearlySubscriptions(year);
});

function getYearlySubscriptions(year = new Date().getFullYear()) {
    var url = $("#yearly-subscriptions-url").val();
    $.ajax({
        type: "GET",
        url: url + "?year=" + year,
        dataType: "json",
        success: function (res) {
            var subscriptions = [];
            let totalAmount = 0;

            for (var i = 0; i <= 11; i++) {
                var monthName = getMonthNameFromIndex(i);
                var subscriptionsData = res.find((item) => {
                    return item.month === monthName;
                });

                subscriptions[i] = subscriptionsData
                    ? subscriptionsData.total_amount
                    : 0;

                totalAmount += subscriptions[i]; // Add to total amount

            }

            subscriptionChart(subscriptions);
            $(".income-value").text(currencyFormat(totalAmount));
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.error("Response:", xhr.responseText);
        },
    });
}

let userOverView = false;

// Function to update the User Overview chart
function bestPlanSubscribes(year = new Date().getFullYear()) {
    if (userOverView) {
        userOverView.destroy();
    }

    Chart.defaults.datasets.doughnut.cutout = "65%";
    let url = $("#get-plans-overview").val();
    $.ajax({
        url: (url += "?year=" + year),
        type: "GET",
        dataType: "json",
        success: function (res) {
            var labels = [];
            var data = [];

            $.each(res, function (index, planData) {
                var label =
                    planData.plan.subscriptionName + ": " + planData.plan_count;
                labels.push(label);
                data.push(planData.plan_count);
            });

            var roundedCornersFor = {
                start: Array.from({ length: data.length }, (_, i) => i),
            };
            Chart.defaults.elements.arc.roundedCornersFor = roundedCornersFor;

            let inMonths = $("#plans-chart");
            userOverView = new Chart(inMonths, {
                type: "doughnut",
                data: {
                    labels: labels.length ? labels : [0, 0],
                    datasets: [
                        {
                            label: "Total Users",
                            borderWidth: 0,
                            data: data.length ? data : [0.0001, 0.0001],
                            backgroundColor: [
                                "#2CE78D",
                                "#0a7cc2",
                                "#C52127",
                                "#2DB0F6",
                            ],
                            borderColor: [
                                "#2CE78D",
                                "#0a7cc2",
                                "#2CE78D",
                                "#2DB0F6",
                            ],
                        },
                    ],
                },
                plugins: [
                    {
                        afterUpdate: function (chart) {
                            if (
                                chart.options.elements.arc.roundedCornersFor !==
                                undefined
                            ) {
                                var arcValues = Object.values(
                                    chart.options.elements.arc.roundedCornersFor
                                );

                                arcValues.forEach(function (arcs) {
                                    arcs = Array.isArray(arcs) ? arcs : [arcs];
                                    arcs.forEach(function (i) {
                                        var arc =
                                            chart.getDatasetMeta(0).data[i];
                                        arc.round = {
                                            x:
                                                (chart.chartArea.left +
                                                    chart.chartArea.right) /
                                                2,
                                            y:
                                                (chart.chartArea.top +
                                                    chart.chartArea.bottom) /
                                                2,
                                            radius:
                                                (arc.outerRadius +
                                                    arc.innerRadius) /
                                                2,
                                            thickness:
                                                (arc.outerRadius -
                                                    arc.innerRadius) /
                                                2,
                                            backgroundColor:
                                                arc.options.backgroundColor,
                                        };
                                    });
                                });
                            }
                        },
                        afterDraw: (chart) => {
                            if (
                                chart.options.elements.arc.roundedCornersFor !==
                                undefined
                            ) {
                                var { ctx, canvas } = chart;
                                var arc,
                                    roundedCornersFor =
                                        chart.options.elements.arc
                                            .roundedCornersFor;
                                for (var position in roundedCornersFor) {
                                    var values = Array.isArray(
                                        roundedCornersFor[position]
                                    )
                                        ? roundedCornersFor[position]
                                        : [roundedCornersFor[position]];
                                    values.forEach((p) => {
                                        arc = chart.getDatasetMeta(0).data[p];
                                        var startAngle =
                                            Math.PI / 2 - arc.startAngle;
                                        var endAngle =
                                            Math.PI / 2 - arc.endAngle;
                                        ctx.save();
                                        ctx.translate(arc.round.x, arc.round.y);
                                        ctx.fillStyle =
                                            arc.options.backgroundColor;
                                        ctx.beginPath();
                                        if (position == "start") {
                                            ctx.arc(
                                                arc.round.radius *
                                                    Math.sin(startAngle),
                                                arc.round.radius *
                                                    Math.cos(startAngle),
                                                arc.round.thickness,
                                                0,
                                                2 * Math.PI
                                            );
                                        } else {
                                            ctx.arc(
                                                arc.round.radius *
                                                    Math.sin(endAngle),
                                                arc.round.radius *
                                                    Math.cos(endAngle),
                                                arc.round.thickness,
                                                0,
                                                2 * Math.PI
                                            );
                                        }
                                        ctx.closePath();
                                        ctx.fill();
                                        ctx.restore();
                                    });
                                }
                            }
                        },
                    },
                ],
                options: {
                    responsive: true,
                    tooltips: {
                        displayColors: true,
                        zIndex: 999999,
                    },
                    plugins: {
                        legend: {
                            position: "top",
                            labels: {
                                usePointStyle: true,
                                padding: 10,
                            },
                        },
                    },
                    scales: {
                        x: {
                            display: false,
                            stacked: true,
                        },
                        y: {
                            display: false,
                            stacked: true,
                        },
                    },
                },
            });
        },
        error: function (xhr, textStatus, errorThrown) {
            console.log("Error fetching user overview data: " + textStatus);
        },
    });
}

// PRINT TOP DATA
getDashboardData();
function getDashboardData() {
    var url = $("#get-dashboard").val();
    $.ajax({
        type: "GET",
        url: url,
        dataType: "json",
        success: function (res) {
            $("#total_businesses").text(res.total_businesses);
            $("#expired_businesses").text(res.expired_businesses);
            $("#plan_subscribes").text(res.plan_subscribes);
            $("#business_categories").text(res.business_categories);
            $("#total_plans").text(res.total_plans);
            $("#total_staffs").text(res.total_staffs);
        },
    });
}

// Function to convert month index to month name
function getMonthNameFromIndex(index) {
    const monthNames = [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];
    return monthNames[index];
}

let statiSticsValu = false;

function subscriptionChart(subscriptions) {
    if (statiSticsValu) {
        statiSticsValu.destroy();
    }

    var ctx = document.getElementById("monthly-statistics").getContext("2d");
    var gradient = ctx.createLinearGradient(0, 100, 10, 280);
    gradient.addColorStop(0, "#f2d5d8");
    gradient.addColorStop(1, "#BC212800");

    var totals = subscriptions.reduce(function (accumulator, currentValue) {
        return accumulator + currentValue;
    }, 0);

    statiSticsValu = new Chart(ctx, {
        type: "line",
        data: {
            labels: [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "Jun",
                "Jul",
                "Aug",
                "Sep",
                "Oct",
                "Nov",
                "Dec",
            ],
            datasets: [
                {
                    backgroundColor: gradient,
                    label: "Total Subscription Amount: " + totals,
                    fill: true,
                    borderWidth: 1,
                    borderColor: "#C52127",
                    data: subscriptions,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            tension: 0.4,
            plugins: {
                legend: {
                    display: false,
                },
                tooltip: {
                    displayColors: true,
                    backgroundColor: "#FFFFFF",
                    titleColor: "#000000",
                    bodyColor: "#000000",
                    borderColor: "rgba(0, 0, 0, 0.1)",
                    borderWidth: 1,
                    padding: 10,
                },
            },
            scales: {
                x: {
                    display: true,
                    grid: {
                        display: false,
                    },
                },
                y: {
                    display: true,
                    beginAtZero: true,
                    grid: {
                        color: "#D3D8DD",
                        borderDash: [5, 5],
                        borderDashOffset: 2,
                    },
                },
            },
            layout: {
                padding: {
                    top: 10,
                    bottom: 10,
                    left: 10,
                    right: 10,
                },
            },
        },
    });
}

window.addEventListener("resize", function () {
    if (statiSticsValu) {
        statiSticsValu.resize();
    }
});
