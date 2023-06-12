
<div class="col-12">
    <div class="table-responsive">
        <table class="table table-striped" id="data-table-dashboard-fault-overtime"
        style="width:100%">
        <thead class="table-orange">
            <h5 class="mb-4">
                Table API Fault Overtime
            </h5>
            <tr>
                <th>Time</th>
                <th>Application</th>
                <th>API</th>
                <th>Count</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($fault_table->data->content as $item)
                <tr>
                    <td>{{ $item->time }}</td>
                    <td>{{ $item->applicationName }} ({{ $item->organization }} - {{ $item->applicationOwner }})</td>
                    <td>{{ $item->apiName }}</td>
                    <td>{{ $item->totalUsage }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>

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