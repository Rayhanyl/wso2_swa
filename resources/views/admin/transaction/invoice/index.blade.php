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
                                {{-- <th>Created</th> --}}
                                <th>Period</th>
                                <th>Amount</th>
                                <th>Status</th>
                                {{-- <th>Due Date</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices->data->content as $item)
                            <tr>
                                <td>
                                    <a class="text-primary" type="button" data-id="{{ $item->id }}" id="btn-get-detail-invoice-data">
                                        {{ $item->id }}
                                    </a>
                                </td>
                                <td class="text-capitalize">{{ $item->customerId }}</td>
                                {{-- <td>{{ $item->createdDate }}</td> --}}
                                <td>{{ \Carbon\Carbon::parse($item->periodStartDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($item->periodEndDate)->format('d M Y') }}</td>
                                <td>Rp. {{ number_format($item->totalAmount, 0, ',', '.') }}</td>
                                <td>
                                    @if ($item->paid == 'true')
                                        <span class="fw-bold text-success">Paid</span>
                                    @else
                                    <span class="fw-bold text-warning">Unpaid</span>
                                    @endif
                                </td>
                                {{-- <td class="text-primary">{{ $item->dueDate }}</td> --}}
                                <td>
                                    @if($item->paid == 'true')
                                    <a class="btn btn-outline-primary btn-sm text-success" href=""><i class='bx bx-play'></i></a>
                                    @else
                                    <a class="btn btn-outline-primary btn-sm text-danger" href=""><i class='bx bx-stop-circle' ></i></a>
                                    @endif
                                    <a type="button" class="btn btn-primary btn-sm" data-id="{{ $item->id }}" id="btn-download-pdf-invoice"><i class='bx bx-download'></i></a>
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

{{-- Modal --}}
@include('admin.transaction.payment.modal.modalgetdetailinvoice')
{{-- Modal --}}

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

        $(document).on('click', '#btn-download-pdf-invoice', function() {
            var id_invoice = $(this).data('id');
            $.ajax({
                type: "GET",
                url: "{{ route ('download.pdf.invoice') }}",
                dataType: 'html',
                data: {
                    invoiceId : id_invoice,
                },
                beforeSend: function() {
                },
                success: function(data) {
                },
                complete: function() {
                },
                error: function(xhr, ajaxOptions, thrownError) {
                },
            });
        });

        var modalGetDetailInvoice = new bootstrap.Modal(document.getElementById('modal-get-detail-invoice'));
        var jqmodalGetDetailInvoice  = $('#modal-get-detail-invoice');
        var loaderGetDetailInvoice  = $('#modalLoadergetdetailinvoice');
        var contentGetDetailInvoice  = $('#modalcontentgetdetailinvoice');
        $(document).on('click', '#btn-get-detail-invoice-data', function (){
            modalGetDetailInvoice.show();
            jqmodalGetDetailInvoice.find('.modal-title').html('Detail Invoice');
            var id_invoice = $(this).data('id');
            $.ajax({
                type: "GET",
                url: "{{ route('admin.modal.detail.invoice') }}",
                dataType: 'html',
                data: {
                    invoice_id: id_invoice,
                },
                beforeSend: function () {
                    contentGetDetailInvoice.html('');
                    loaderGetDetailInvoice.html(
                        '<div class="d-flex justify-content-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>'
                    );
                },
                success: function (data) {
                    contentGetDetailInvoice.html(data);
                },
                complete: function () {
                    loaderGetDetailInvoice.html('');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var pesan = xhr.status + " " + thrownError + "\n" + xhr.responseText;
                    contentGetDetailInvoice.html(pesan);
                },
            });
        });
    </script>
@endpush

@endsection
