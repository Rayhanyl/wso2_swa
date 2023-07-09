@extends('app')
@section('content')


<div class="container">
    <div class="row my-5">
        <div class="col-12 text-center">
            <h1>Error Summary</h1>
        </div>
        <div class="col-12 my-5">
            <div class="card card-shadow-app rounded-4">
                <div class="card-body">
                    <div class="row p-3">
                        <div class="col-12 d-flex justify-content-center">
                            <form class="row g-4" action="{{ route ('admin.error.summary.page') }}">
                                <div class="col-12">
                                    <label class="fw-bold my-2" for="api_name">API Name</label>
                                    <select id="api_name" name="api_name" class="form-select" required>
                                        <option value="All">All</option>
                                        @foreach ($apis->data as $item)
                                        <option value="{{ $item->apiUUID }}"  {{ $api_name == $item->apiUUID ? 'selected':'' }}>{{ $item->apiName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="fw-bold my-2" for="view_type">View Type</label>
                                    <select id="view_type" name="view_type" class="form-select" required>
                                        <option value="true" {{ $view_type == 'true' ? 'selected':'' }}>Percent</option>
                                        <option value="false" {{ $view_type == 'false' ? 'selected':'' }}>Count</option>
                                    </select>
                                </div>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary" type="submit">Generate Report</button>
                                  </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card card-shadow-app rounded-4">
                <div class="card-header text-end">
                    @if (empty($data))
                    <a href="#" class="btn btn-primary mx-2 disabled">
                        <i style="font-size:18px;" class='bx bx-download'></i>
                        <span class="d-none d-md-inline ml-1">Download</span>
                    </a>
                    @else
                    <a href="{{ route ('admin.error.summary.pdf') }}?api_name={{ $api_name }}&view_type={{ $view_type }}" class="btn btn-primary mx-2 {{ empty($data) ? 'disabled':'' }}">
                        <i style="font-size:18px;" class='bx bx-download'></i>
                        <span class="d-none d-md-inline ml-1">Download</span>
                    </a>
                    @endif
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="admin-data-table-error-summary" style="width:100%">
                        <thead class="table-orange">
                            <tr>
                                <th rowspan="2" style="vertical-align:middle;">API Name</th>
                                <th rowspan="2" style="vertical-align:middle;">Resource</th>
                                <th colspan="5" style="text-align:center;">Response Code</th>
                                <th rowspan="2" style="vertical-align:middle;">Total Request</th>
                            </tr>
                            <tr>
                                <th>1xx</th>
                                <th>2xx</th>
                                <th>3xx</th>
                                <th>4xx</th>
                                <th>5xx</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                            <tr>
                                <td>{{ $item->apiName }}</td>
                                <td>{{ $item->apiResourceTemplate }} &nbsp; [{{ $item->apiMethod }}]</td>
                                <td>{{ round($item->count1xx) ?? '0' }}{{ $view_type == 'true' ? '%':'' }}</td>
                                <td>{{ round($item->count2xx) ?? '0' }}{{ $view_type == 'true' ? '%':'' }}</td>
                                <td>{{ round($item->count3xx) ?? '0' }}{{ $view_type == 'true' ? '%':'' }}</td>
                                <td>{{ round($item->count4xx) ?? '0' }}{{ $view_type == 'true' ? '%':'' }}</td>
                                <td>{{ round($item->count5xx) ?? '0' }}{{ $view_type == 'true' ? '%':'' }}</td>
                                <td>{{ $item->totalCount }}</td>
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
        $('#admin-data-table-error-summary').DataTable({
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
