<div class="col-12">
    <div class="card card-shadow-app rounded-4">
        <div class="card-header">
            <h4>Quota Subscription</h4>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="data-table-dashboard-quota-subscription"
                style="width:100%">
                <thead class="table-orange">
                    <tr>
                        <th>Subscription</th>
                        <th>Type</th>
                        <th>Quota</th>
                        <th>Remaining</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($quota_subs->data->content as $item)
                    <tr>
                        <td class="text-capitalize">{{ $item->apiName }}</td>
                        <td>
                            @if ($item->typeSubscription == 'quota')
                                Quota
                            @else
                                Time
                            @endif
                        </td>
                        <td>
                            @if ($item->typeSubscription == 'quota')
                                {{ $item->quota }} Hit
                            @else
                                {{ $item->quota }} Days
                            @endif
                        </td>
                        <td>
                            @if ($item->typeSubscription == 'quota')
                            <div class="progress" dir="rtl">
                                <div class="progress-bar {{ $item->remaining < 1 ? 'bg-danger':'bg-primary' }} fw-bold" role="progressbar" aria-label="Example with label" style="width: {{ $item->percentage }}%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">{{ $item->remaining < 0 ? '0':$item->remaining }}</div>
                            </div>
                            @else
                            <div class="progress" dir="rtl">
                                <div class="progress-bar {{ $item->remaining < 1 ? 'bg-danger':'bg-primary' }} fw-bold" dir="ltr" role="progressbar" aria-label="Example with label" style="width: {{ $item->percentage }}%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">{{ $item->remaining }} Days</div>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#data-table-dashboard-quota-subscription').DataTable({
            responsive: true,
            lengthMenu: [
                [5, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
        });
    });
</script>