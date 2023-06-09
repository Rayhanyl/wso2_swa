@extends('app')
@section('content')


<div class="container">
    <div class="row my-5">
        <div class="col-12 text-center">
            <h1>Detail Backend API Usage</h1>
        </div>
        <div class="col-12 my-4">
            <a class="back-to-application" href="{{ route ('admin.backend.api.usage.page') }}"><i class='bx bx-chevron-left'></i> Back to report</a>
        </div>
        <div class="col-12 mb-5">
            <div class="card card-shadow-app rounded-4">
                <div class="card-header text-end">
                    <a href="{{ route ('admin.detail.backend.api.usage.pdf') }}?year={{ $year }}&month={{ $month }}&api_name={{ $api_name }}&owner={{ $owner }}&api={{ $api }}" class="btn btn-primary mx-2 ">
                        <i style="font-size:18px;" class='bx bx-download'></i>
                        <span class="d-none d-md-inline ml-1">Download</span>
                    </a>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="admin-data-table-detail-backend-api-usage" style="width:100%">
                        <thead class="table-orange">
                            <tr>
                                <th>Resource Path</th>
                                <th>Method</th>
                                <th>Request Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detailapi->data->content as $item)
                                <tr>
                                    <td>{{ $item->apiResourceTemplate }}</td>
                                    <td>{{ $item->apiMethod }}</td>
                                    <td>{{ $item->requestCount }}</td>
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
        $('#admin-data-table-detail-backend-api-usage').DataTable({
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
