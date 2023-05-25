@extends('app')
@section('content')

<div class="container">

    <div class="row">
        <div class="col-12 my-5 text-center">
            <h1>Log Detail</h1>
        </div>
        <div class="col-12 my-2">
            <a class="back-to-application" href="{{ route ('customer.monthly.report.summary.page') }}"><i class='bx bx-chevron-left'></i> Back to report</a>
        </div>
        <div class="col-12 mb-5">
            <div class="card card-shadow-app rounded-4">
                <div class="card-header">
                    <div class="row"> 
                        <div class="col-12 col-lg-6">
                            <p>API: <span class="text-primary">{{ $api }}</span></p>
                            <p>Application: <span class="text-primary">{{ $app }}</span></p>
                        </div>
                        <div class="col-12 col-lg-6 text-end my-auto">
                            <button class="btn btn-primary mx-2 ">
                                <i style="font-size:18px;" class='bx bx-download'></i>
                                <span class="d-none d-md-inline ml-1">Download</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="data-table-log-detail-resource-customer" style="width:100%">
                        <thead class="table-orange">
                            <tr>
                                <th>Date Time</th>
                                <th>Application</th>
                                <th>Request Count</th>
                                <th>Response OK</th>
                                <th>Response NOK</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                            <tr>
                                <td>{{ $item->requestTimestamp }}</td>
                                <td>{{ $item->resource }}</td>
                                <td>{{ $item->proxyResponseCode }}</td>
                                <td>{{ $item->proxyResponseCode }}</td>
                                <td>{{ $item->proxyResponseCode }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
<script>
    $(document).ready(function () {
        $('#data-table-log-detail-resource-customer').DataTable({
            responsive: true,
            lengthMenu: [
                [5, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
        });
    });

</script>
@endpush

@endsection
