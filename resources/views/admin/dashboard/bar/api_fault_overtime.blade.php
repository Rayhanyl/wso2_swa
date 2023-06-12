
<div class="col-12">
    <div class="justify-content-center">
        <div>
            <canvas id="bar-chart-fault-overtime"></canvas>
        </div>
    </div>
</div>

<script>
    var ctx5 = document.getElementById('bar-chart-fault-overtime').getContext('2d');
    const xTime_fault_overtime = {!! json_encode($x_data_fault_overtime) !!};
    const dataSet_fault_overtime = {!! json_encode($datasets_fault_overtime) !!};
    var chart = new Chart(ctx5, {
        type: 'line',
        data: {
            labels: xTime_fault_overtime,
            datasets: dataSet_fault_overtime,
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'API Fault Overtime'
                }
            }
        }
    });
</script>