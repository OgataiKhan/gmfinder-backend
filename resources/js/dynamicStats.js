import Chart from "chart.js/auto";

document.addEventListener("DOMContentLoaded", function () {
    const startMonthInput = document.getElementById("start_month");
    const endMonthInput = document.getElementById("end_month");
    const reviewsCount = document.getElementById("reviews_count");
    const messagesCount = document.getElementById("messages_count");
    var ctx = document.getElementById("ratingsChart").getContext("2d");
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

    // Function to update the min or max attributes
    function updateMonthInputConstraints() {
        if (startMonthInput.value) endMonthInput.min = startMonthInput.value;
        if (endMonthInput.value) startMonthInput.max = endMonthInput.value;
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
                    reviewsCount.textContent = `Reviews: ${data.reviewsCount}`;
                    messagesCount.textContent = `Messages: ${data.messagesCount}`;

                    // Update Chart.js Data
                    ratingsChart.data.labels = Object.keys(
                        data.ratingsDistribution
                    );
                    ratingsChart.data.datasets.forEach((dataset) => {
                        dataset.data = Object.values(data.ratingsDistribution);
                    });
                    ratingsChart.update();
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    }

    // Event listeners for the month selectors and constraints update
    startMonthInput.addEventListener("change", () => {
        updateMonthInputConstraints();
        fetchStats();
    });
    endMonthInput.addEventListener("change", () => {
        updateMonthInputConstraints();
        fetchStats();
    });
});
