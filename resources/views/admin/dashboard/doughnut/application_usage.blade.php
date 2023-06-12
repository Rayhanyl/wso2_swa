<div class="card card-shadow-app rounded-4">
    <div class="card-body row justify-content-center">
        <div class="col-12">
            <h5>Application Usage</h5>
            <hr>
        </div>
        <div class="col-12" style="width:400px;">
            <canvas id="doughnut-chart-application-usage"></canvas>
        </div>
        <div class="col-12 card-legend-chart">
            <hr>
            <div class="row g-1">
                @foreach ($application_name as $idx => $item)
                <div class="col-6">
                    <i class='bx bxs-circle' style="color:{{ $color[$idx] }};" ></i> {{ $item }}
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    const ctx3 = document.getElementById('doughnut-chart-application-usage').getContext('2d');
    const applicationNames = {!! json_encode($application_name) !!};
    const applicationCount = {!! json_encode($application_count) !!};
    const colors3 = {!! json_encode($color) !!};
    var data = {
        labels: applicationNames,
        datasets: [{
            label: 'Usage',
            data: applicationCount,
            backgroundColor: colors3,
            hoverOffset: 4
        }]
    };
    new Chart(ctx3, {
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
