import Chart from 'chart.js/auto'

// Function to create a chart
export function createChart(chartId, chartData, chartOptions) {
    const ctx = document.getElementById(chartId).getContext('2d');
    new Chart(ctx, {
        type: 'line', // or 'line', 'pie', etc.
        data: chartData,
        options: chartOptions
    });
}

// Make the function available globally
