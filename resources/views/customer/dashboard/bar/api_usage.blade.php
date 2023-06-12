<div>
    <canvas id="bar-chart-top-api-usage"></canvas>
</div>

<script>
    var ctx4 = document.getElementById('bar-chart-top-api-usage').getContext('2d');
    var xTime_api_usage = {!! json_encode($x_data_api_usage) !!};
    var dataSet_api_usage = {!! json_encode($datasets_api_usage) !!};
    var chart = new Chart(ctx4, {
        type: 'line',
        data: {
            labels: xTime_api_usage,
            datasets: dataSet_api_usage,
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'TOP 10 API USAGE'
                }
            }
        }
    });
</script>
