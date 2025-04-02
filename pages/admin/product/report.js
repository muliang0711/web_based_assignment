// File: /assets/js/report.js

// 0. When DOM is fully loaded:
document.addEventListener("DOMContentLoaded", () => {

    // 1. Fetch data from form submit:
    const form = document.querySelector('.filter-form');
    const fromInput = document.getElementById('fromDate');
    const toInput = document.getElementById('toDate');

    // 1.1 bind event to form
    form.addEventListener('submit', async (e) => {

        // 1.2 prevent default form submit
        e.preventDefault();

        // 1.3 fetch values from input
        const from = fromInput.value;
        const to = toInput.value;

        // 1.4 simple validation
        if (!from || !to) {
            alert("Please select both From and To dates.");
            return;
        }

        // 1.5 execute report logic
        try {
            const data = await fetchTop5ProductSales(from, to); // 1.5.1 fetch API
            renderChartPreview(data); // 1.5.2 pass data to chart rendering
        } catch (error) {
            showChartMessage(`❌ ${error.message}`); // 1.5.3 handle error
        }
    });
});


// 2. Function prepare: fetchTop5ProductSales()
async function fetchTop5ProductSales(from, to) {

    // 2.1 target backend file (API URL)
    const url = `/controller/api/report.php?from=${from}&end=${to}`;

    // 2.2 fetch request with await
    const res = await fetch(url);

    // 2.3 convert to JSON
    const json = await res.json();

    // 2.4 validation response from backend
    if (!res.ok || !json.success) {
        throw new Error(json.error || 'Server Error');
    }

    // 2.5 return extracted data to render
    return json.data;
}


// 3. Function renderChartPreview()
function renderChartPreview(data) {

    // 3.1 locate chart preview container
    const chartBox = $(".preview:contains('chart Report Preview')");

    // 3.2 replace preview content with canvas
    chartBox.html(`
        <h3>📊 Top 5 Product Sales</h3>
        <canvas id="topSalesChart" style="max-height: 300px;"></canvas>
    `);

    // 3.3 prepare chart data
    const ctx = document.getElementById('topSalesChart').getContext('2d');
    const labels = data.map(item => item.productName);
    const values = data.map(item => item.total_sold);

    // 3.4 destroy old chart if exists (global instance)
    if (window.topSalesChartInstance) {
        window.topSalesChartInstance.destroy();
    }

    // 3.5 render bar chart using Chart.js
    window.topSalesChartInstance = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Units Sold',
                data: values,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });
}


// 4. Function showChartMessage() - when no data / error
function showChartMessage(message) {

    // 4.1 locate chart preview container
    const chartBox = $(".preview:contains('chart Report Preview')");

    // 4.2 show fallback message
    chartBox.html(`
        <h3>📊 Top 5 Product Sales</h3>
        <p>${message}</p>
    `);
}
