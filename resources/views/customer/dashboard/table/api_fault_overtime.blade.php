<div class="col-12">
    <div class="card card-shadow-app rounded-4" style="height: 430px;">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="data-table-dashboard-fault-overtime"
                style="width:100%">
                <thead class="table-orange">
                    <tr>
                        <th>Time</th>
                        <th>Application</th>
                        <th>API</th>
                        <th>Count</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < 3; $i++)
                    <tr>
                        <td>10-aug-2023</td>
                        <td>DefaultApplication</td>
                        <td>Pizzahack</td>
                        <td>6</td>
                    </tr>
                    @endfor
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>


@push('script')
    <script>
        
        $(document).ready(function () {
            $('#data-table-dashboard-fault-overtime').DataTable({
                responsive: true,
                lengthMenu: [
                    [5, 25, 50, -1],
                    [10, 25, 50, 'All'],
                ],
            });
        });
    </script>
@endpush