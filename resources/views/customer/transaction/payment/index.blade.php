@extends('app')
@section('content')

<div class="container">
    <form action="{{ route ('customer.create.payment') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="notify" value="{{ $payment->data->invoice->notifyList }}">
        <div class="row my-5">

            <div class="col-12">
                <h1>Payment</h1>
                <a class="back-to-application my-5" href="{{ route ('customer.invoice.page') }}"><i
                        class='bx bx-chevron-left'></i> Back to list invoice</a>
            </div>

            <div class="col-12 my-3">
                <div class="card">
                    <div class="card-body row">
                        {{-- <div class="col-12">
                                    <label class="fw-bold my-2" for="">Payment</label>
                                    <input class="form-control" type="text" name="" id="" value="PAY-20230512-XYZ" disabled>
                                </div> --}}
                        <div class="col-12 col-lg-6">
                            <label class="fw-bold my-2" for="#">Invoice</label>
                            <input class="form-control" type="text" value="{{ $payment->data->invoice->id }}" readonly>
                            <input type="hidden" name="invoice_id" value="{{ $payment->data->invoice->id }}">
                        </div>
                        <div class="col-12 col-lg-6">
                            <label class="fw-bold my-2" for="#">Period</label>
                            <input class="form-control" type="text" name="" id=""
                                value="{{ \Carbon\Carbon::parse($payment->data->invoice->periodStartDate)->format('d F Y') }} - {{ \Carbon\Carbon::parse($payment->data->invoice->periodEndDate)->format('d F Y') }}" readonly>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label class="fw-bold my-2" for="#">Customer</label>
                            <input class="form-control text-capitalize" type="text" name="customer"
                                value="{{ $payment->data->invoice->customerId}}" readonly>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label class="fw-bold my-2" for="#">Due Date</label>
                            <input class="form-control" type="text" name="due_date"
                                value="{{ \Carbon\Carbon::parse($payment->data->invoice->dueDate)->format('d F Y') }}" readonly>
                                
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 my-3">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped" id="customer-table-payment" style="width:100%">
                            <thead class="table-orange">
                                <tr>
                                    <th>API Name</th>
                                    <th>Business Plan</th>
                                    <th>QTY Req</th>
                                    <th>QTY Resp OK</th>
                                    <th>QTY Resp NOK</th>
                                    <th>Price</th>
                                    <th>Discount</th>
                                    <th>TAX</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payment->data->invoiceItems as $item)
                                <tr>
                                    <td>
                                        {{ $item->apiName }}
                                    </td>
                                    <td>{{ $item->tierId }}</td>
                                    <td>{{ $item->reqQty }}</td>
                                    <td>{{ $item->reqQtyOK }}</td>
                                    <td>0</td>
                                    <td>{{ $item->price }}</td>
                                    <td>{{ $item->discount }}</td>
                                    <td>{{ $item->tax }}%</td>
                                    <td>{{ $item->grandTotal }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row g-3">
                    <div class="col-12 text-end">
                        <p class="fw-bold">Sub total :<span class="text-primary fw-bold">&nbsp; Rp.{{ number_format($payment->data->invoice->grandTotal, 0, ',', '.') }}</span></p>
                    </div>
                    <div class="col-12 col-lg-5">
                        <label class="fw-bold my-2" for="attachement_payment_slip">Attachment payment slip</label>
                        <input type="file" class="form-control @error('attachement_payment_slip') is-invalid @enderror" id="attachement_payment_slip" name="attachement_payment_slip">
                        @error('attachement_payment_slip')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="col-12 col-lg-5">
                        <label class="fw-bold my-2" for="">Berita acara</label>
                        <input type="text" class="form-control" name="berita_acara">
                    </div>
                    <div class="col-12 col-lg-2">
                        <div class="text-white mb-3">.</div>
                        <button class="btn btn-primary w-100" type="submit">Simpan</button>
                    </div>
                </div>
            </div>

        </div>

    </form>
</div>


@push('script')
<script>
    $(document).ready(function () {
        $('#customer-table-payment').DataTable({
            responsive: true,
            lengthMenu: [
                [5, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
        });
    });

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

</script>
@endpush

@endsection
