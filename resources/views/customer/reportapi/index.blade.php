@extends('app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-12 my-5 text-center">
            <h1>API Usage Report Summary</h1>
        </div>
        <div class="col-12 mb-5">
            <div class="card card-shadow-app rounded-4">
                <div class="card-body">
                    <div class="row justify-content-center p-3">
                        <div class="col-10">
                            <div class="col-12">
                                <h5>API-M SWAMEDIA</h5>
                            </div>
                            <form class="row g-4" action="{{ route ('customer.monthly.report.summary.page') }}" method="GET">
                                <div class="col-12 col-lg-6">
                                    <label for="year" class="form-label">Year</label>
                                    <select id="year" name="year" class="form-select" required>
                                        @foreach ($years->data as $items)
                                            <option value="{{ $items->year }}" {{ $year == $items->year ? 'selected':'' }}>{{ $items->year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="month" class="form-label">Month</label>
                                    <select id="month-usage" name="month" class="form-select" required>
                                    </select>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="application" class="form-label">Application</label>
                                    <select id="application" name="application" class="form-select">
                                        <option>All</option>
                                        @foreach ($application->list as $items)
                                        <option value="{{ $items->applicationId }}" {{ $app_id == $items->applicationId ? 'selected':'' }}>{{$items->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="api_name" class="form-label">API Name</label>
                                    <select id="api_name" name="api_name" class="form-select">
                                        <option>All</option>
                                    </select>
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary w-50">Generate Report</button>
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
                                        <img class="img-summary"
                                            src="{{ asset ('assets/images/application/icon-create.png') }}"
                                            alt="Picture">
                                    </div>
                                    <div class="col-10">
                                        <p class="text-summary">Total APIs: <span class="text-child-sumary text-primary">&nbsp;{{ $total ?? '0' }}</span> </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3 col-lg-3">
                                <div class="row">
                                    <div class="col-2">
                                        <img class="img-summary"
                                            src="{{ asset ('assets/images/application/icon-create.png') }}"
                                            alt="Picture">
                                    </div>
                                    <div class="col-10">
                                        <p class="text-summary">Request Count: <span class="text-child-sumary text-primary">&nbsp;{{ $count ?? '0' }}</span> </p>
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
                                <a href="{{ route ('customer.monthly.report.summary.pdf')}}?year={{ $year }}&month={{ $month }}&api={{ $api_id }}&app={{ $app_id }}" class="btn btn-primary mx-2 {{ empty($data) ? 'disabled':'' }}">
                                    <i style="font-size:18px;" class='bx bx-download'></i>
                                    <span class="d-none d-md-inline ml-1">Download</span>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="data-table-usage-customer" style="width:100%">
                        <thead class="table-orange">
                            <tr>
                                <th>API Name</th>
                                <th>Version</th>
                                <th>Application Name</th>
                                <th>Application Owner</th>
                                <th>Request Count</th>
                                <th>Logs</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ( $data as $item)
                            <tr>
                                <td>{{ $item->apiName }}</td>
                                <td>{{ $item->apiVersion }}</td>
                                <td>{{ $item->applicationName }}</td>
                                <td>{{ $item->applicationOwner }}</td>
                                <td>{{ $item->requestCount }}</td>
                                <td>
                                    <a href="{{ route ('customer.detail.logs.report',['app'=>$item->applicationId,'api'=>$item->apiId,'year'=>$year,'month'=>$month]) }}" class="btn btn-primary btn-sm" >Details</a>
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
        $('#data-table-usage-customer').DataTable({
            responsive: true,
            lengthMenu: [
                [5, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
        });
        getMonth($('#year').val());
    });
    
    $(document).on('change', '#application', function(e) {
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: "{{ route('customer.result.api.summary.report') }}",
            dataType: 'html',
            data: {
                id_app: $(this).val(),
            },
            beforeSend: function() {
                $('#api_name').html('');
            },
            success: function(data) {

                let api_list = JSON.parse(data);
                api_list = api_list.data.list;
                let apis = '';
                apis += `<option>All</option>`
                api_list.forEach(item => {
                    apis += `<option value='${item.apiId}'>${item.apiInfo.name}</option>`;  
                });
                $('#api_name').html(apis);

            },
            complete: function() {
            },
            error: function(xhr, ajaxOptions, thrownError) {
                var pesan = xhr.status + " " + thrownError + "\n" + xhr.responseText;
                $('#api_name').html(pesan);
            },
        });
    });

    function  getMonth(params) {
        let year = params;
        $.ajax({
            type: "GET",
            url: "{{ route('customer.result.month.summary.usage') }}",
            dataType: 'html',
            data: {
                year,
            },
            beforeSend: function() {
                $('#month-usage').html('');
            },
            success: function(data) {
                let month_list = JSON.parse(data);
                month_list = month_list.data.data;
                let month = '';
                const months = {{ $month ?? 1 }};
                month_list.forEach(item => {
                    const select = months == item.monthNumber ? 'selected':'' ;
                    month += `<option value='${item.monthNumber}' ${select}>${item.monthName}</option>`;  
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

    $(document).on('change', '#year', function(e) {
        e.preventDefault();
        getMonth($(this).val());
    });

</script>
@endpush

@endsection
