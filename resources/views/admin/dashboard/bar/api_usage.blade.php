
<div class="col-12">
    <div class="card card-shadow-app rounded-4">
        <div class="card-body row justify-content-center">
            <div>
                <canvas id="lineChart1"></canvas>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        var ctx4 = document.getElementById('lineChart1').getContext('2d');
        const colorBorder = {!! json_encode($bordercolor) !!};
        var chart = new Chart(ctx4, {
            type: 'line',
            data: {
                labels: ['1-mei-2023', '1-june-2023', '1-July-2023', '1-Aug-2023', '1-Sep-2023', '1-Okt-2023', '1-Nov-2023', '1-Dec-2023'],
                datasets: [
                {
                    label: 'PizzaShack',
                    data: [25, 50, 60],
                    backgroundColor: colorBorder[0],
                    borderColor: colors[0],
                    borderWidth: 3
                },{
                    label: 'Calculator',
                    data: [90, 35, 100],
                    backgroundColor: colorBorder[1],
                    borderColor: colors[1],
                    borderWidth: 3
                }
            ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'TOP 10 API USAGE DURING PAST 30 DAYS'
                    }
                }
            }
        });
    </script>
@endpush