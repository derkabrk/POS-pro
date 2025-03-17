// currency format
function currencyFormat(amount, type = "icon", decimals = 2) {
    let symbol = $("#currency_symbol").val();
    let position = $("#currency_position").val();
    let code = $("#currency_code").val();

    let formattedAmount = formatNumber(amount, decimals); // Abbreviate number

    // Apply currency format based on the position and type
    if (type === "icon" || type === "symbol") {
        return position === "right" ? formattedAmount + symbol : symbol + formattedAmount;
    } else {
        return position === "right" ? formattedAmount + " " + code : code + " " + formattedAmount;
    }
}
// Update design when a single business content exists
document.addEventListener("DOMContentLoaded", function () {
    // Select the container, ensure it exists
    const container = document.querySelector(".business-stat");
    if (container) {
        const businessContents = container.querySelectorAll(".business-content");
        const customImageBg = document.querySelector(".custom-image-bg");

        // Dynamically set column class based on the number of business content elements
        container.classList.add(`columns-${businessContents.length}`);

        if (businessContents.length === 1) {
            businessContents[0].style.padding = "3% 2%";
            if (customImageBg) {
                customImageBg.style.padding = "2%";
            }
            businessContents[0].style.borderRadius = "0";
        }
    }
});

getDashboardData();

function getDashboardData() {
    var url = $("#get-dashboard").val();
    $.ajax({
        type: "GET",
        url: url,
        dataType: "json",
        success: function (res) {
            $("#total_sales").text(res.total_sales);
            $("#this_month_total_sales").text(res.this_month_total_sales);
            $("#total_purchase").text(res.total_purchase);
            $("#this_month_total_purchase").text(res.this_month_total_purchase);
            $("#total_income").text(res.total_income);
            $("#this_month_total_income").text(res.this_month_total_income);
            $("#total_expense").text(res.total_expense);
            $("#this_month_total_expense").text(res.this_month_total_expense);
            $("#total_customer").text(res.total_customer);
            $("#this_month_total_customer").text(res.this_month_total_customer);
            $("#total_supplier").text(res.total_supplier);
            $("#this_month_total_supplier").text(res.this_month_total_supplier);
            $("#total_sales_return").text(res.total_sales_return);
            $("#this_month_total_sale_return").text(
                res.this_month_total_sale_return
            );
            $("#total_purchase_return").text(res.total_purchase_return);
            $("#this_month_total_purchase_return").text(
                res.this_month_total_purchase_return
            );
        },
    });
}

// Function to abbreviate numbers (K, M, B)
function formatNumber(number, decimals = 2) {
    if (number >= 1e9) {
        return removeTrailingZeros((number / 1e9).toFixed(decimals)) + "B";
    } else if (number >= 1e6) {
        return removeTrailingZeros((number / 1e6).toFixed(decimals)) + "M";
    } else if (number >= 1e3) {
        return removeTrailingZeros((number / 1e3).toFixed(decimals)) + "K";
    } else {
        return removeTrailingZeros(number.toFixed(decimals));
    }
}

function removeTrailingZeros(value) {
    return parseFloat(value).toString();
}

// Revenue chart----------------->
let revenueChart;
const ctxRevenue = document.getElementById("revenueChart").getContext("2d");
function totalEarningExpenseChart(total_loss, total_profit) {
    if (revenueChart) {
        revenueChart.destroy();
    }

    revenueChart = new Chart(ctxRevenue, {
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
                    label: "Profit",
                    data: total_profit,
                    borderColor: "#A507FF",
                    borderWidth: 4,
                    fill: false,
                    pointRadius: 1,
                    pointHoverRadius: 6,
                    tension: 0.4,
                },
                {
                    label: "Loss",
                    data: total_loss,
                    borderColor: "#FF3B30",
                    borderWidth: 4,
                    fill: false,
                    pointRadius: 1,
                    pointHoverRadius: 6,
                    tension: 0.4,
                },
            ],
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    enabled: true,
                    backgroundColor: "white",
                    borderColor: "#ddd",
                    borderWidth: 1,
                    titleColor: "#000",
                    bodyColor: "#000",
                    callbacks: {
                        title: function (context) {
                            const month = context[0].label;
                            return `${month}`;
                        },
                        label: function (context) {
                            const value = context.raw;
                            const label = context.dataset.label;
                            return `${label}: ${Math.abs(
                                value
                            ).toLocaleString()}`;
                        },
                    },
                    padding: 8,
                    displayColors: false,
                },
                legend: {
                    display: false,
                },
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                    },
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function (value) {
                            return `${value}`;
                        },
                    },
                },
            },
            layout: {
                padding: {
                    left: 10,
                    right: 10,
                    top: 10,
                    bottom: 10,
                },
            },
            hover: {
                mode: "nearest",
                intersect: true,
            },
        },
    });
}

// Function to get yearly statistics and update the chart
function getYearlyStatistics(year = new Date().getFullYear()) {
    const url = $("#revenue-statistic").val() + "?year=" + year;

    $.ajax({
        type: "GET",
        url: url,
        dataType: "json",
        success: function (res) {
            const loss = res.loss;
            const profit = res.profit;
            const total_loss = [];
            const total_profit = [];

            for (let i = 1; i <= 12; i++) {
                const monthName = getMonthNameFromIndex(i);

                const lossData = loss.find((item) => item.month === monthName);
                total_loss[i - 1] = lossData ? lossData.total : 0;

                const profitData = profit.find(
                    (item) => item.month === monthName
                );
                total_profit[i - 1] = profitData ? profitData.total : 0;
            }

            // Update chart with the new data
            totalEarningExpenseChart(total_loss, total_profit);

            const loss_value = total_loss.reduce(
                (sum, value) => sum + value,
                0
            );
            const profit_value = total_profit.reduce(
                (sum, value) => sum + value,
                0
            );

            document.querySelector(
                ".loss-value"
            ).textContent = `${currencyFormat(loss_value)}`;
            document.querySelector(
                ".profit-value"
            ).textContent = `${currencyFormat(profit_value)}`;
        },
        error: function (err) {
            console.error("Error fetching data:", err);
        },
    });
}

// Function to convert month index to month name
function getMonthNameFromIndex(index) {
    const months = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
    ];
    return months[index - 1];
}

// Initial chart load with the current year data
getYearlyStatistics();

// Handle year change event
$(".revenue-year").on("change", function () {
    const year = $(this).val();
    getYearlyStatistics(year);
});

// Overall Reports ----------------------->
const canvas = document.getElementById("Overallreports");
const ctxOverallReports = canvas.getContext("2d");

const gradientSales = ctxOverallReports.createLinearGradient(
    0,
    0,
    0,
    canvas.height
);
gradientSales.addColorStop(0, "#8554FF");
gradientSales.addColorStop(1, "#B8A1FF");

const gradientPurchase = ctxOverallReports.createLinearGradient(
    0,
    0,
    0,
    canvas.height
);
gradientPurchase.addColorStop(0, "#FD8D00");
gradientPurchase.addColorStop(1, "#FFC694");

const gradientExpense = ctxOverallReports.createLinearGradient(
    0,
    0,
    0,
    canvas.height
);
gradientExpense.addColorStop(0, "#FF8983");
gradientExpense.addColorStop(1, "#FF3B30");

const gradientIncome = ctxOverallReports.createLinearGradient(
    0,
    0,
    0,
    canvas.height
);
gradientIncome.addColorStop(0, "#05C535");
gradientIncome.addColorStop(1, "#36F165");

// Data for the chart
const data = {
    labels: ["Purchase", "Sales", "Income", "Expense"],
    datasets: [
        {
            backgroundColor: [
                gradientPurchase,
                gradientSales,
                gradientIncome,
                gradientExpense,
            ],
            hoverOffset: 5,
        },
    ],
};

const config = {
    type: "pie",
    data: data,
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false,
            },
            tooltip: {
                enabled: true,
                backgroundColor: "#FFFFFF",
                titleColor: "#000000",
                bodyColor: "#000000",
                // borderColor: "#CCCCCC",
                borderWidth: 1,
                displayColors: false,
            },
        },
    },
};

const Overallreports = new Chart(ctxOverallReports, config);

window.addEventListener("resize", function () {
    Overallreports.resize();
});

function fetchTaskData(year = new Date().getFullYear()) {
    const url = $("#get-overall-report").val() + "?year=" + year;
    $.ajax({
        url: url,
        method: "GET",
        success: function (response) {
            Overallreports.data.datasets[0].data = [
                response.overall_purchase || 0.000001,
                response.overall_sale || 0.000001,
                response.overall_income || 0.000001,
                response.overall_expense || 0.000001,
            ];
            Overallreports.update();

            $("#overall_purchase").text(currencyFormat(response.overall_purchase));
            $("#overall_sale").text(currencyFormat(response.overall_sale));
            $("#overall_income").text(currencyFormat(response.overall_income));
            $("#overall_expense").text(currencyFormat(response.overall_expense));
        },
        error: function (error) {
            console.error("Error fetching data:", error);
        },
    });
}

fetchTaskData();

$(".overview-year").on("change", function () {
    const year = $(this).val();
    fetchTaskData(year);
});


