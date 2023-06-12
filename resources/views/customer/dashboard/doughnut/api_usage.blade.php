<div class="col-4">
    <div class="card card-shadow-app rounded-4">
        <div class="card-body row justify-content-center">
            <div class="col-12">
                <h5>API Usage</h5>
                <hr>
            </div>
            <div class="col-12" style="width:400px;">
                <canvas id="myChart1"></canvas>
            </div>
            <div class="col-12 card-legend-chart">
                <hr>
                <div class="row g-1">
                    @foreach ($apiname as $idx => $item)
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
        const ctx1 = document.getElementById('myChart1').getContext('2d');
        const apiNames = {!! json_encode($apiname) !!};
        const usageCount = {!! json_encode($usage_count) !!};
        const colors = {!! json_encode($color) !!};
        var data = {
            labels: apiNames,
            datasets: [{
                label: 'Usage',
                data: usageCount,
                backgroundColor: colors,
                hoverOffset: 4
            }]
        };
        new Chart(ctx1, {
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