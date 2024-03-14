import Chart from "chart.js/auto";

document.addEventListener("DOMContentLoaded", function () {
    const startMonthInput = document.getElementById("start_month");
    const endMonthInput = document.getElementById("end_month");
    var ctx = document.getElementById("ratingsChart").getContext("2d");
    var messagesCtx = document.getElementById("messagesChart").getContext("2d");
    var reviewsCtx = document.getElementById("reviewsChart").getContext("2d");

    // Ratings chart
    var ratingsChart = new Chart(ctx, {
        type: "bar",
        data: {
            labels: [],
            datasets: [
                {
                    label: "Ratings Distribution",
                    data: [],
                    backgroundColor: ["rgba(128, 0, 32, 1)"],
                    borderColor: ["rgba(128, 0, 32, 1)"],
                    borderWidth: 1,
                },
            ],
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
        },
    });

    // Messages chart
    var messagesChart = new Chart(messagesCtx, {
        type: "bar",
        data: {
            labels: [],
            datasets: [
                {
                    label: "Monthly Messages",
                    data: [],
                    backgroundColor: "rgba(54, 162, 235, 1)",
                    borderColor: "rgba(54, 162, 235, 1)",
                    borderWidth: 1,
                },
            ],
        },
        options: { scales: { y: { beginAtZero: true } } },
    });

    // Ratings chart
    var reviewsChart = new Chart(reviewsCtx, {
        type: "bar",
        data: {
            labels: [],
            datasets: [
                {
                    label: "Monthly Reviews",
                    data: [],
                    backgroundColor: "rgba(5, 135, 67, 1)",
                    borderColor: "rgba(5, 135, 67, 1)",
                    borderWidth: 1,
                },
            ],
        },
        options: { scales: { y: { beginAtZero: true } } },
    });

    // Set the current month as default for both inputs
    function setCurrentYear() {
        const currentDate = new Date();
        const currentYear = currentDate.getFullYear(); // Get current year
        const startOfYear = `${currentYear}-01`; // January of the current year
        const endOfYear = `${currentYear}-12`; // December of the current year
        startMonthInput.value = startOfYear;
        endMonthInput.value = endOfYear;
    }
    

    // Update the end month minimum
    function updateMonthInputConstraints() {
        if (startMonthInput.value) endMonthInput.min = startMonthInput.value;
    }

    // Adjust end point based on start month
    function adjustEndDateIfNeeded() {
        if (startMonthInput.value > endMonthInput.value) {
            endMonthInput.value = startMonthInput.value;
        }
    }

    setCurrentYear();
    updateMonthInputConstraints();

    function generateMonthLabels(startMonth, endMonth) {
        let start = new Date(startMonth + "-01");
        let end = new Date(endMonth + "-01");
        let labels = [];

        while (start <= end) {
            labels.push(
                new Intl.DateTimeFormat("en", {
                    month: "short",
                    year: "numeric",
                }).format(start)
            );
            start.setMonth(start.getMonth() + 1);
        }

        return labels;
    }

    function fetchStats() {
        if (startMonthInput.value && endMonthInput.value) {
            const baseUrl = `${window.location.protocol}//${
                window.location.hostname
            }${window.location.port ? `:${window.location.port}` : ""}`;
            axios
                .get(
                    `${baseUrl}/stats/count-and-distribution?start_month=${startMonthInput.value}&end_month=${endMonthInput.value}`
                )
                .then(function (response) {
                    const data = response.data;

                    // Prepare Ratings Chart Data
                    // Initialize an object to hold the rating counts, defaulting to 0
                    const ratingsCounts = { 1: 0, 2: 0, 3: 0, 4: 0, 5: 0 };

                    // Fill the object with actual data from the server, if available
                    Object.keys(data.ratingsDistribution).forEach((key) => {
                        const rating = parseInt(key); // Ensure the key is treated as an integer
                        if (rating >= 1 && rating <= 5) {
                            // Only consider valid rating values
                            ratingsCounts[rating] =
                                data.ratingsDistribution[key];
                        }
                    });

                    // Update the ratings chart
                    ratingsChart.data.labels = Object.keys(ratingsCounts).map(
                        (rating) => `${rating}`
                    );
                    
                    ratingsChart.data.datasets[0].data =
                        Object.values(ratingsCounts);

                    // Generate month labels for messages and reviews charts
                    const monthLabels = generateMonthLabels(
                        startMonthInput.value,
                        endMonthInput.value
                    );

                    // Update Messages Chart
                    messagesChart.data.labels = monthLabels;
                    messagesChart.data.datasets[0].data = monthLabels.map(
                        (label) => data.messagesByMonth[label] || 0
                    );

                    // Update Reviews Chart
                    reviewsChart.data.labels = monthLabels;
                    reviewsChart.data.datasets[0].data = monthLabels.map(
                        (label) => data.reviewsByMonth[label] || 0
                    );

                    // Update all charts
                    ratingsChart.update();
                    messagesChart.update();
                    reviewsChart.update();
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    }

    // Event listeners for the month selectors and constraints update
    startMonthInput.addEventListener("change", () => {
        adjustEndDateIfNeeded();
        updateMonthInputConstraints();
        fetchStats();
    });
    endMonthInput.addEventListener("change", () => {
        updateMonthInputConstraints();
        fetchStats();
    });
    fetchStats();
});
