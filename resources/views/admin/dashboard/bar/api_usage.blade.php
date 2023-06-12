
<div class="col-12">
    <div class="card card-shadow-app rounded-4">
        <div class="card-body row justify-content-center">
            <div>
                <label for="">Period</label>
                <select class="form-control" name="period_top_10" id="period_top_10">
                    <option value="year">Year</option>
                    <option value="month">Month</option>
                    <option value="today">Today</option>
                </select>
            </div>
            <div>
                <canvas id="bar-chart-top-api-usage"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    var ctx4 = document.getElementById('bar-chart-top-api-usage').getContext('2d');
    const xTime_api_usage = {!! json_encode($x_data_api_usage) !!};
    const dataSet_api_usage = {!! json_encode($datasets_api_usage) !!};
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