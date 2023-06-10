@extends('app')
@section('content')

<div class="container">
    <div class="row my-5">
        @if ($years->data == [])
        <div class="col-12 my-5 p-5" style="min-height:310px;">
            <div class="card card-shadow-app rounded-4">
                <div class="card-body">
                    <h1>Data belum tersedia</h1>
                </div>
            </div>
        </div>
        @else
        <div class="col-12 text-center">
            <h1>Backend API Uage Summary</h1>
        </div>
        <div class="col-12 my-5">
            <div class="card card-shadow-app rounded-4">
                <div class="card-body">
                    <div class="row justify-content-center p-3">
                        <div class="col-10">
                            <form class="row g-4" action="{{ route ('admin.backend.api.usage.page') }}" method="GET">
                                <div class="col-12 col-lg-6">
                                    <label for="year" class="form-label">Year</label>
                                    <select id="year" name="year" class="form-select" required>
                                        @foreach ($years->data as $item)
                                            <option value="{{ $item->year }}"  {{ $year == $item->year ? 'selected':'' }}>{{ $item->year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="month" class="form-label">Month</label>
                                    <select id="month-usage" name="month" class="form-select" required>
                                    </select>
                                </div>
                                <div class="col-12 col-lg-12">
                                    <label for="api_name" class="form-label">API Name</label>
                                    <select id="api_name" name="api_name" class="form-select">
                                        <option value="All">All</option>
                                        @foreach ($apis->data as $item)
                                        <option value="{{ $item->apiUUID }}"  {{ $api_name == $item->apiUUID ? 'selected':'' }}>{{ $item->apiName }}</option>
                                        @endforeach
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
        <div class="col-12">
            <div class="card card-shadow-app rounded-4">
                <div class="card-header text-end">
                    @if (empty($data))
                    <a href="#" class="btn btn-primary mx-2 disabled">
                        <i style="font-size:18px;" class='bx bx-download'></i>
                        <span class="d-none d-md-inline ml-1">Download</span>
                    </a>
                    @else
                    <a href="{{ route ('admin.backend.api.usage.pdf')}}?year={{ $year }}&month={{ $month }}&api_name={{ $api_name }}" class="btn btn-primary mx-2 {{ empty($data) ? 'disabled':'' }}">
                        <i style="font-size:18px;" class='bx bx-download'></i>
                        <span class="d-none d-md-inline ml-1">Download</span>
                    </a>
                    @endif
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="data-table-backend-api-usage-admin" style="width:100%">
                        <thead class="table-orange">
                            <tr>
                                <th>API Name</th>
                                <th>Version</th>
                                <th>Context</th>
                                <th>Application Owner</th>
                                <th>Hits</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                            <tr>
                                <td class="text-capitalize">{{ $item->apiName }}</td>
                                <td>{{ $item->apiVersion }}</td>
                                <td>{{ $item->context }}</td>
                                <td class="text-capitalize">{{ $item->applicationOwner }}</td>
                                <td>{{ $item->requestCount }}</td>
                                <td>
                                    <a href="{{ route ('admin.detail.backend.api.usage.page',$item->apiId)}}?owner={{ $item->applicationOwner }}&api_name={{ $item->apiName }}&year={{ $year }}&month={{ $month }}" class="btn btn-primary">Details</a>
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
            $('#data-table-backend-api-usage-admin').DataTable({
                responsive: true,
                lengthMenu: [
                    [5, 25, 50, -1],
                    [10, 25, 50, 'All'],
                ],
            });
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


        $(document).on('change', '#year', function(e) {
            e.preventDefault();
            getMonth($(this).val());
        });

    </script>
@endpush

@endsection
