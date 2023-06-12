
<div class="col-12">
    <div class="card card-shadow-app rounded-4">
        <div class="card-body row justify-content-center">
            <div style="width:100%;height:400px;">
                <canvas id="lineChart2"></canvas>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        var ctx5 = document.getElementById('lineChart2').getContext('2d');
        var chart = new Chart(ctx5, {
            type: 'line',
            data: {
                labels: ['1-mei-2023', '1-june-2023', '1-July-2023', '1-Aug-2023', '1-Sep-2023', '1-Sep-2023', '1-Sep-2023', '1-Sep-2023', '1-Sep-2023', '1-Sep-2023', '1-Sep-2023', '1-Sep-2023', '1-Sep-2023', '1-Sep-2023', '1-Sep-2023', '1-Sep-2023', '1-Sep-2023', '1-Sep-2023', '1-Sep-2023', '1-Sep-2023'],
                datasets: [{
                    label: 'PizzaShack',
                    data: [25, 50, 60,0,0],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 3
                }, {
                    label: 'Calculator',
                    data: [35, 20, 65,0,0],
                    backgroundColor: 'rgba(192, 75, 192, 0.2)',
                    borderColor: 'rgba(192, 75, 192, 1)',
                    borderWidth: 3
                }, {
                    label: 'Jsonplacholder',
                    data: [20, 40, 70, 100, 90],
                    backgroundColor: 'rgba(100, 75, 0, 0.2)',
                    borderColor: 'rgba(100, 75, 0, 1)',
                    borderWidth: 3
                }]
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
@endpush