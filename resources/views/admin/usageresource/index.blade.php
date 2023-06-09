@extends('app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-12 my-5 text-center">
            <h1>API Resource Usage Summary</h1>
        </div>
        <div class="col-12 mb-5">
            <div class="card card-shadow-app rounded-4">
                <div class="card-body">
                    <div class="row justify-content-center p-3">
                        <div class="col-10">
                            <form class="row g-4" action="{{ route ('admin.api.resource.usage.summary.page') }}" method="GET">
                                <div class="col-12 col-lg-6">
                                    <label for="year" class="form-label">Year</label>
                                    <select id="year" name="year" class="form-select" required>
                                        @foreach ($years->data as $item)
                                            <option value="{{ $item->year }}">{{ $item->year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="month" class="form-label">Month</label>
                                    <select id="month-usage" name="month" class="form-select" required>
                                    </select>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="api" class="form-label">API Name</label>
                                    <select id="api-usage-resource" name="api" class="form-select">
                                        <option value="All">All</option>
                                        @foreach ($apis->list as $items)
                                        <option value="{{ $items->id }}">{{$items->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="resources" class="form-label">Resources</label>
                                    <select id="resources" name="resources" class="form-select">
                                        <option>All</option>
                                    </select>
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary w-50">Generate</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mb-5">
            <div class="card card-shadow-app rounded-4">
                <div class="card-header">
                    <div class="row g-0 ">
                        <div class="row py-3">
                            <div class="col-3 col-lg-3">
                                <div class="row">
                                    <div class="col-2">
                                        <img class="img-usage"
                                            src="{{ asset ('assets/images/application/icon-create.png') }}"
                                            alt="Picture">
                                    </div>
                                    <div class="col-10">
                                        <p class="text-summary">Total APIs: <span class="text-child-sumary text-primary">&nbsp;{{ $total }}</span> </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3 col-lg-3">
                                <div class="row">
                                    <div class="col-2">
                                        <img class="img-usage"
                                            src="{{ asset ('assets/images/application/icon-create.png') }}"
                                            alt="Picture">
                                    </div>
                                    <div class="col-10">
                                        <p class="text-usage">Request Count: <span class="text-child-usage text-primary">&nbsp;{{ $count }}</span> </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-6 text-end">
                                @if (empty($data))
                                <a href="#" class="btn btn-primary mx-2 disabled">
                                    <i style="font-size:18px;" class='bx bx-download'></i>
                                    <span class="d-none d-md-inline ml-1">Download</span>
                                </a>
                                @else
                                <a href="{{ route ('admin.api.resource.usage.summary.pdf',['year'=>$year,'month'=>$month,'resources'=>$resources,'api_id'=>$api_id]) }}" class="btn btn-primary mx-2 {{ empty($data) ? 'disabled':'' }}">
                                    <i style="font-size:18px;" class='bx bx-download'></i>
                                    <span class="d-none d-md-inline ml-1">Download</span>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="data-table-api-usage-admin" style="width:100%">
                        <thead class="table-orange">
                            <tr>
                                <th>API Name</th>
                                <th>Version</th>
                                <th>Resource Path</th>
                                <th>API Method</th>
                                <th>Request Count</th>
                                <th>Logs</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ( $data as $item)
                            <tr>
                                <td>{{ $item->apiName }}</td>
                                <td>{{ $item->apiVersion }}</td>
                                <td>{{ $item->resource }}</td>
                                <td>{{ $item->apiMethod }}</td>
                                <td>{{ $item->requestCount }}</td>
                                <td>
                                    <a href="{{ route ('admin.detail.logs.usage') }}?api_id={{ $item->apiId }}&resource={{ $item->resource }}&year={{ $year }}&month={{ $month }}" class="btn btn-primary btn-sm" >Details</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @endforelse
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
            
            $('#data-table-api-usage-admin').DataTable({
                responsive: true,
                lengthMenu: [
                    [5, 25, 50, -1],
                    [10, 25, 50, 'All'],
                ],
            });

            getResource($('#api-usage-resource').val());
            getMonth($('#year').val());
            
        });

        function getResource(params) {
            let api_id = params;
            $.ajax({
                type: "GET",
                url: "{{ route('admin.result.resource.summary.usage') }}",
                dataType: 'html',
                data: {
                    api_id,
                },
                beforeSend: function() {
                    $('#resources').html('');
                },
                success: function(data) {

                    let resource_list = JSON.parse(data);
                    resource_list = resource_list.data.data;
                    let resources = '';
                    resources += `<option value="All">All</option>`
                    resource_list.forEach(item => {
                        resources += `<option value='${item.resource}'>${item.resource}</option>`;  
                    });
                    $('#resources').html(resources);

                },
                complete: function() {
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    var pesan = xhr.status + " " + thrownError + "\n" + xhr.responseText;
                    $('#resources').html(pesan);
                },
            });
        }

        function  getMonth(params) {
            let year = params;
            $.ajax({
                type: "GET",
                url: "{{ route('admin.result.month.summary.usage') }}",
                dataType: 'html',
                data: {
                    year,
                },
                beforeSend: function() {
                    $('#month-usage').html('');
                },
                success: function(data) {
                    let month_list = JSON.parse(data);
                    console.log(month_list);
                    month_list = month_list.data.data;
                    let month = '';
                    // month += `<option>All</option>`
                    month_list.forEach(item => {
                        month += `<option value='${item.monthNumber}'>${item.monthName}</option>`;  
                    });
                    $('#month-usage').html(month);
                },
                complete: function() {
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    var pesan = xhr.status + " " + thrownError + "\n" + xhr.responseText;
                    $('#month-usage').html(pesan);
                },
            });
        }

        
        $(document).on('change', '#api-usage-resource', function(e) {
            e.preventDefault();
            getResource($(this).val());
        });

        $(document).on('change', '#year', function(e) {
            e.preventDefault();
            getMonth($(this).val());
        });

    </script>
@endpush

@endsection
