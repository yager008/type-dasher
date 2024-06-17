{{--<div class="chart-container" style="position: relative; height:40vh; width:80vw">--}}
{{--    <canvas id="myChart"></canvas>--}}
{{--</div>--}}

<div class="container-fluid ">
    All Typing results
    <div class="chart-container" style="position: relative; height: 40vh;">
        <canvas id="myChart" style="width: 500vh; height: 100vh; padding-left: 40px"></canvas>
    </div>
</div>

<div class="container-fluid ">
    Daily Typing results
    <div class="chart-container" style="position: relative; height: 40vh;">
        <canvas id="dailyChart" style="width: 500vh; height: 100vh; padding-left: 40px"></canvas>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const data = {!! json_encode($resultsArray) !!}; // Convert PHP array to JavaScript object
        console.log("amogus");

        const myData = {
            labels: data.map(row => row.updated_at),
            datasets: [{
                label: 'all typing results',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                hoverBackgroundColor: 'rgba(255, 99, 132, 0.4)',
                hoverBorderColor: 'rgba(255, 99, 132, 1)',
                data: data.map(row => row.result)
            },
            {
                label: 'number of mistakes',
                backgroundColor: 'rgba(172,255,99,0.2)',
                borderColor: 'rgb(0,255,12)',
                borderWidth: 1,
                hoverBackgroundColor: 'rgba(255, 99, 132, 0.4)',
                hoverBorderColor: 'rgba(255, 99, 132, 1)',
                data: data.map(row => row.number_of_mistakes)
            }
            ]
        };

        const chartOptions = {
            responsive: true,
            scales: {
                x: {
                    beginAtZero: true,
                },
                y: {
                    beginAtZero: true,
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            },
            animations: {
                tension: {
                    duration: 1000,
                    easing: 'linear',
                    from: 1,
                    to: 0,
                    loop: true
                }
            },

        };
        // Call the createChart function
        window.createChart('myChart', myData, chartOptions);
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const data = {!! json_encode($resultsArray) !!}; // Convert PHP array to JavaScript object

        data.forEach(row => {
            row.updated_at = row.updated_at.split(' ')[0]; // only dates
            console.log(row.updated_at)
        });

        console.log(data);

        let newData = {};
        let mistakesData = {};

        data.forEach(row => {
            const { updated_at, result } = row;

            if (!newData[updated_at]) {
                newData[updated_at] = {
                    sum: 0,
                    count: 0,
                    mean: 0
                };
            }

            // Accumulate sum and count
            newData[updated_at].sum += result;
            newData[updated_at].count++;
        });

        data.forEach(row => {
            const { updated_at, number_of_mistakes } = row;

            if (![updated_at]) {
                newData[updated_at] = {
                    sum: 0,
                    count: 0,
                    mean: 0
                };
            }

            // Accumulate sum and count
            newData[updated_at].sum += number_of_mistakes;
            newData[updated_at].count++;
        });

// Calculate arithmetic mean for each day
        Object.keys(newData).forEach(date => {
            newData[date].mean = newData[date].sum / newData[date].count;
        });

        console.log(newData);


        const myData = {
            labels: Object.keys(newData), // Extract dates as labels
            datasets: [{
                label: 'Daily Arithmetic Mean Typing Speed',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                hoverBackgroundColor: 'rgba(255, 99, 132, 0.4)',
                hoverBorderColor: 'rgba(255, 99, 132, 1)',
                data: Object.values(newData).map(dayData => dayData.mean.toFixed(2)) // Extract mean speeds as data
            }]
        };

        const chartOptions = {
            responsive: true,
            scales: {
                x: {
                    beginAtZero: true,
                },
                y: {
                    beginAtZero: true,
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        };
        // Call the createChart function
        window.createChart('dailyChart', myData, chartOptions);
    });
</script>
