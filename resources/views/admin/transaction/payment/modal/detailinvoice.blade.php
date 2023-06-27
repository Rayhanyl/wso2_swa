<div class="row g-0">
    <div class="col-12 col-lg-6">
        <p><b>Invoice :</b> <span>{{ $invoice->id }}</span></p>
        <p><b>Period :</b> <span>{{ \Carbon\Carbon::parse($invoice->periodStartDate)->format('d M Y') }} -
            {{ \Carbon\Carbon::parse($invoice->periodEndDate)->format('d M Y') }}</span></p>
    </div>
    <div class="col-12 col-lg-6">
        <p><b>Customer :</b> <span class="text-capitalize">{{ $invoice->customerId }}</span></p>
        <p><b>Amount :</b> <span>Rp. {{ number_format($invoice->grandTotal, 0, ',', '.') }}</span></p>
    </div>
    <hr>
    <div class="col-12">
        <div class="row g-3">
            @foreach ($items as $item)
                <div class="col-4">
                    <label class="fw-bold my-2" for="#">API Name</label>
                    <input class="form-control" type="text" value="{{ $item->apiName }}" readonly>
                    {{-- <p>{{ $item->apiName }}</p> --}}
                </div>
                <div class="col-4">
                    <label class="fw-bold  my-2" for="#">Application Name</label>
                    <input class="form-control" type="text" value="{{ $item->applicationName }}" readonly>
                </div>
                <div class="col-4">
                    <label class="fw-bold  my-2" for="#">Business Plan</label>
                    <input class="form-control" type="text" value="{{ $item->tierId }}" readonly>
                </div>
                <div class="col-4">
                    <label class="fw-bold  my-2" for="#">Qty Response</label>
                    <input class="form-control" type="text" value="{{ $item->qty }}" readonly>
                </div>
                <div class="col-4">
                    <label class="fw-bold  my-2" for="#">Response OK</label>
                    <input class="form-control" type="text" value="{{ $item->reqQtyOK }}" readonly>
                </div>
                <div class="col-4">
                    <label class="fw-bold  my-2" for="#">Response NOK</label>
                    <input class="form-control" type="text" value="{{ $item->reqQtyNOK }}" readonly>
                </div>
                <div class="col-3">
                    <label class="fw-bold  my-2" for="#">Price</label>
                    <input class="form-control" type="text" value="Rp. {{ number_format($item->price, 0, ',', '.') }}" readonly>
                </div>
                <div class="col-3">
                    <label class="fw-bold  my-2" for="#">Discount</label>
                    <input class="form-control" type="text" value="{{ $item->discount }} %" readonly>
                </div>
                <div class="col-3">
                    <label class="fw-bold my-2" for="#">Tax</label>
                    <input class="form-control" type="text" value="{{ $item->tax }} %" readonly>
                </div>
                <div class="col-3">
                    <label class="fw-bold my-2" for="#">Amount</label>
                    <input class="form-control" type="text" value="Rp. {{ number_format($item->grandTotal, 0, ',', '.') }}" readonly>
                </div>
            @endforeach
        </div>
        {{-- <table class="table table-striped" id="data-table-detail-invoice" style="width:100%">
            <thead class="table-orange">
                <tr>
                    <th>API Name</th>
                    <th>Application Name</th>
                    <th>Business Plan</th>
                    <th>Qty Response</th>
                    <th>Response OK</th>
                    <th>Response NOK</th>
                    <th>Price</th>
                    <th>Discount</th>
                    <th>Tax</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                <tr>
                    <td>{{ $item->apiName }}</td>
                    <td>{{ $item->applicationName }}</td>
                    <td>{{ $item->tierId }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ $item->reqQtyOK }}</td>
                    <td>{{ $item->reqQtyNOK }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->discount }}</td>
                    <td>{{ $item->tax }}</td>
                    <td>{{ $item->grandTotal }}</td>
                </tr>
                @endforeach
            </tbody>
        </table> --}}
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#data-table-detail-invoice').DataTable({
            responsive: true,
            lengthMenu: [
                [5, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
        });
    });
</script>