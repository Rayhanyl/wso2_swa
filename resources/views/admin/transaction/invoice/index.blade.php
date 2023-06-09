@extends('app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-12 my-5 text-center">
            <h1>Invoice Administrator</h1>
        </div>
        <div class="col-12 mb-5" style="min-height: 160px">
            <div class="card card-shadow-app rounded-4">
                <div class="card-header text-end">
                    <a href="{{ route ('admin.create.invoice.page') }}" class="btn btn-warning text-white fw-bold">Create Invoice</a>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="data-table-invoice-admin" style="width:100%">
                        <thead class="table-orange">
                            <tr>
                                <th>Invoice Number</th>
                                <th>Customer Name</th>
                                <th>Created</th>
                                <th>Period</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Due Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices->data->content as $item)
                            <tr>
                                <td class="text-primary">{{ $item->id }}</td>
                                <td class="text-capitalize">{{ $item->customerId }}</td>
                                <td>{{ $item->createdDate }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->periodStartDate)->format('d F') }} - {{ \Carbon\Carbon::parse($item->periodEndDate)->format('d F') }}</td>
                                <td>Rp. {{ number_format($item->totalAmount, 0, ',', '.') }}</td>
                                <td>
                                    @if ($item->paid == 'true')
                                        <span class="fw-bold text-success">Paid</span>
                                    @else
                                    <span class="fw-bold text-warning">Unpaid</span>
                                    @endif
                                </td>
                                <td class="text-primary">{{ $item->dueDate }}</td>
                                <td>
                                    @if($item->paid == 'true')
                                    <a class="btn btn-outline-primary btn-sm text-success" href=""><i class='bx bx-play'></i></a>
                                    @else
                                    <a class="btn btn-outline-primary btn-sm text-danger" href=""><i class='bx bx-stop-circle' ></i></a>
                                    @endif
                                    <a class="btn btn-primary btn-sm mx-1" href=""><i class='bx bx-list-ul'></i></a>
                                    @if($item->paid == 'true')
                                    <a class="btn btn-primary btn-sm mx-1" href=""><i class='bx bx-link'></i></a>
                                    @else
                                    <a class="btn btn-primary btn-sm mx-1 disabled"><i class='bx bx-link'></i></a>
                                    @endif
                                    <a class="btn btn-primary btn-sm" href=""><i class='bx bx-download'></i></a>
                                </td>
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
            
            $('#data-table-invoice-admin').DataTable({
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
