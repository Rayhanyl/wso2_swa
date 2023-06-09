@extends('app')
@section('content')

<div class="container">

    <div class="row">
        <div class="col-12 my-5 text-center">
            <h1>Log Detail</h1>
        </div>
        <div class="col-12 my-2">
            <a class="back-to-application" href="{{ route ('admin.monthly.report.summary.page') }}"><i class='bx bx-chevron-left'></i> Back to report</a>
        </div>
        <div class="col-12 col-lg-4 my-3">
            <p>Customer: <span class="text-primary text-capitalize fw-bold">{{ $organization }}</span></p>
            <p>API: <span class="text-primary text-capitalize fw-bold">{{ $api }}</span></p>
            <p>Application: <span class="text-primary text-capitalize fw-bold">{{ $app }}</span></p>
        </div>
        <div class="col-12 col-lg-8 my-3">
            <div class="row">
                <div class="col-12 col-lg-4">
                    <div class="card card-shadow-app rounded-4">
                        <div class="card-body">
                            <p class="fw-bold">Request Count: <span class="text-primary fs-3">&nbsp;{{ $request_count }}</span></p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="card card-shadow-app rounded-4">
                        <div class="card-body">
                            <p class="fw-bold">Response OK Count: <span class="text-primary fs-3">&nbsp;{{ $request_ok }}</span></p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="card card-shadow-app rounded-4">
                        <div class="card-body">
                            <p class="fw-bold">Response NOK Count: <span class="text-primary fs-3">&nbsp;{{ $request_nok }}</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mb-5">
            <div class="card card-shadow-app rounded-4">
                <div class="card-header">
                    <div class="row"> 
                        <div class="col-12 col-lg-12 text-end my-auto">
                            <a href="{{ route ('admin.detail.logs.report.pdf',['app_id'=>$app_id,'api_id'=>$api_id,'month'=>$month,'year'=>$year]) }}" class="btn btn-primary mx-2 ">
                                <i style="font-size:18px;" class='bx bx-download'></i>
                                <span class="d-none d-md-inline ml-1">Download</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="data-table-log-detail-admin" style="width:100%">
                        <thead class="table-orange">
                            <tr>
                                <th>Date Time</th>
                                <th>Resource</th>
                                <th>Response Code</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                            <tr>
                                <td>{{ $item->requestTimestamp }}</td>
                                <td>{{ $item->resource }}</td>
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
        $('#data-table-log-detail-admin').DataTable({
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
