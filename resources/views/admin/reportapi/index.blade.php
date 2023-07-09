@extends('app')
@section('content')

<div class="container">
    <div class="row">
        @if ($years->data == [])
        <div class="col-12 my-5 p-5" style="min-height:310px;">
            <div class="card card-shadow-app rounded-4">
                <div class="card-body">
                    <h1>Data belum tersedia</h1>
                </div>
            </div>
        </div>
        @else
        <div class="col-12 my-5 text-center">
            <h1>Monthly Report Summary</h1>
        </div>
        <div class="col-12 mb-5">
            <div class="card card-shadow-app rounded-4">
                <div class="card-body">
                    <div class="row justify-content-center p-3">
                        <div class="col-10">
                            <form class="row g-4" action="{{ route ('admin.monthly.report.summary.page') }}" method="GET">
                                <div class="col-12 col-lg-6">
                                    <label for="year" class="form-label">Year</label>
                                    <select id="year" name="year" class="form-select" required>
                                        @foreach ($years->data as $item)
                                            <option value="{{ $item->year }}" {{ $year == $item->year ? 'selected':'' }}>{{ $item->year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="month" class="form-label">Month</label>
                                    <select id="month-usage" name="month" class="form-select" required>
                                    </select>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="customer" class="form-label">Customer</label>
                                    <select id="customer" name="customer" class="form-select">
                                            <option value="All">All</option>
                                        @foreach ($customers->data->content as $item)
                                            <option value="{{ $item->organizationName }}" {{ $customer == $item->organizationName ? 'selected':'' }}>{{ $item->organizationName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="api_name" class="form-label">API Name</label>
                                    <select id="api_name" name="api_name" class="form-select">
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
                                        <p class="text-summary">Total Customer: <span class="text-child-sumary text-primary">&nbsp;{{ $customercount ?? '0' }}</span> </p>
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
                            <div class="col-3 col-lg-3 text-end">
                                @if (empty($data))
                                <a href="#" class="btn btn-primary mx-2 disabled">
                                    <i style="font-size:18px;" class='bx bx-download'></i>
                                    <span class="d-none d-md-inline ml-1">Download</span>
                                </a>
                                @else
                                <a href="{{ route ('admin.monthly.report.summary.pdf',['year'=>$year,'month'=>$month,'customer'=>$customer,'api_name'=>$api_name]) }}" class="btn btn-primary mx-2 {{ empty($data) ? 'disabled':'' }}">
                                    <i style="font-size:18px;" class='bx bx-download'></i>
                                    <span class="d-none d-md-inline ml-1">Download</span>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="data-table-usage-admin" style="width:100%">
                        <thead class="table-orange">
                            <tr>
                                <th>Application Owner</th>
                                <th>Customer</th>
                                <th>API Name</th>
                                <th>Version</th>
                                <th>Application Name</th>
                                <th>Request Count</th>
                                <th>Logs</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                            <tr>
                                <td class="text-capitalize">{{ $item->applicationOwner }}</td>
                                <td class="text-capitalize">{{ $item->organization }}</td>
                                <td class="text-capitalize">{{ $item->apiName }}</td>
                                <td class="text-capitalize">{{ $item->apiVersion }}</td>
                                <td class="text-capitalize">{{ $item->applicationName }}</td>
                                <td>{{ $item->requestCount }}</td>
                                <td>
                                    <a href="{{ route ('admin.detail.logs.report',['app'=>$item->applicationId,'api'=>$item->apiId,'month'=>$month,'year'=>$year]) }}" class="btn btn-primary btn-sm" >Details</a>
                                </td>
                            </tr>        
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@push('script')
    <script>
        $(document).ready(function () {
            $('#data-table-usage-admin').DataTable({
                responsive: true,
                lengthMenu: [
                    [5, 25, 50, -1],
                    [10, 25, 50, 'All'],
                ],
            });
            getApiName($('#customer').val());
            getMonth($('#year').val());
        });

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

        function  getApiName(params) {
            let organization = params;
            $.ajax({
                type: "GET",
                url: "{{ route('admin.api.name.report.summary') }}",
                dataType: 'html',
                data: {
                    organization,
                },
                beforeSend: function() {
                    $('#api_name').html('');
                },
                success: function(data) {
                    let api_list = JSON.parse(data);
                    api_list = api_list.data.data;
                    let api = '';
                    api += `<option value="All">All</option>`
                    api_list.forEach(item => {
                        api += `<option value='${item.apiUUID}'>${item.apiName}</option>`;  
                    });
                    $('#api_name').html(api);
                },
                complete: function() {
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    var pesan = xhr.status + " " + thrownError + "\n" + xhr.responseText;
                    $('#api_name').html(pesan);
                },
            });
        }

        $(document).on('change', '#year', function(e) {
            e.preventDefault();
            getMonth($(this).val());
        });

        $(document).on('change', '#customer', function(e) {
            e.preventDefault();
            getApiName($(this).val());
        });
    </script>
@endpush

@endsection
