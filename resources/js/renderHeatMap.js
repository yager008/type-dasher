import {CalHeatmap} from 'cal-heatmap'

// Your other imports and JavaScript code...

export function createSimpleHeatMap() {
        const cal = new CalHeatmap();
        cal.init({});
}

export function renderHeatMap() {
    const cal = new CalHeatmap();
    cal.paint({
        data: {
            // Replace with your data source URL or function
                source: "https://example.com/api/heatmap-data",
                // Or use a function returning data
                // source: () => fetch("https://example.com/api/heatmap-data").then(res => res.json()),
            },
            date: {
                start: new Date(2023, 0, 1), // Start date: January 1, 2023
            },
            range: 12, // Display 12 months
            domain: {
                type: "month", // The domain is a month
                label: {
                    position: "top",
                    format: (date) => date.toLocaleString('default', {month: 'short'}),
                },
            },
            subDomain: {
                type: "day", // The subdomain is a day
                label: (date) => date.getDate(), // Show the day number
            },
            legend: [2, 4, 6, 8, 10], // Example legend steps
            itemSelector: "#cal-heatmap", // The selector for the element where the calendar will be rendered
        }).then(r => {});
}
