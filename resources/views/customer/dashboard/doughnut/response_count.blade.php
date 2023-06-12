<div class="col-4">
    <div class="card card-shadow-app rounded-4">
        <div class="card-body row justify-content-center">
            <div class="col-12">
                <h5>Respons Count</h5>
                <hr>
            </div>
            <div class="col-12" style="width:400px;">
                <canvas id="myChart2"></canvas>
            </div>
            <div class="col-12 card-legend-chart">
                <hr>
                <div class="row g-1">
                    @foreach ($response_name as $idx => $item)
                    <div class="col-6">
                        <i class='bx bxs-circle' style="color:{{ $color[$idx] }};" ></i> {{ $item }}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>


@push('script')
    <script>
        const ctx2 = document.getElementById('myChart2').getContext('2d');
        const responseNames = {!! json_encode($response_name) !!};
        const responseCount = {!! json_encode($response_count) !!};
        var data = {
            labels: responseNames,
            datasets: [{
                label: 'Count',
                data: responseCount,
                backgroundColor: colors,
                hoverOffset: 4
            }]
        };
        new Chart(ctx2, {
            type: 'doughnut',
            data: data,
            options: {
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                const index = context.dataIndex;
                                const data = context.dataset.data;
                                const lbl = context.dataset.label;
                                let total = 0;
                                data.forEach(el => {
                                    total += el
                                });
                                let avg = context.dataset.data[index] / total * 100;
                                const labelTooltips = lbl + ' : ' + data[index] + ' (' + avg.toFixed(0) + ')%';
                                return labelTooltips;
                            }
                        }
                    },
                    legend: {
                    display: false,
                    position: 'right',
                    }
                }
            },
            responsive: true,
        });
    </script>
@endpush