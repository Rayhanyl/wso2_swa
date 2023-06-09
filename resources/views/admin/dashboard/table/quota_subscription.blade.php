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
                        <th>Customer</th>
                        <th>Subscription</th>
                        <th>Type</th>
                        <th>Quota</th>
                        <th>Remaining</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($quota_subs->data->content as $item)
                    <tr>
                        <td>Swamedia</td>
                        <td>Pizzahack</td>
                        <td>Period Monthly</td>
                        <td>30 days</td>
                        <td>
                            @if ($item->typeSubscription == 'quota')
                            <div class="progress" dir="rtl">
                                <div class="progress-bar bg-danger" role="progressbar" aria-label="Example with label" style="width: 50%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">50-</div>
                            </div>
                            @else
                            <div class="progress" dir="rtl">
                                <div class="progress-bar bg-danger" role="progressbar" aria-label="Example with label" style="width: 50%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">50 Days</div>
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

@push('script')
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
@endpush