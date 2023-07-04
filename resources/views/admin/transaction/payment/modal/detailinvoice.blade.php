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
        <table class="table">
            @foreach ($items as $item)
            <tr>
                <th class="table-secondary">API Name</th>
                <td class="table-light">{{ $item->apiName }}</td>
                <th class="table-secondary">Qty Response</th>
                <td class="table-light">{{ $item->qty }}</td>
            </tr>
            <tr>
                <th class="table-secondary">Application Name</th>
                <td class="table-light">{{ $item->applicationName }}</td>
                <th class="table-secondary">Response OK</th>
                <td class="table-light">{{ $item->reqQtyOK }}</td>
            </tr>
            <tr>
                <th class="table-secondary">Business Plan</th>
                <td class="table-light">{{ $item->tierId }}</td>
                <th class="table-secondary">Response NOK</th>
                <td class="table-light">{{ $item->reqQtyNOK }}</td>
            </tr>
            <tr>
                <th class="table-secondary">Price</th>
                <td class="table-light">Rp. {{ number_format($item->price, 0, ',', '.') }}</td>
                <th class="table-secondary">Discount</th>
                <td class="table-light">{{ $item->discount }} %</td> 
            </tr>
            <tr>
                <th class="table-secondary">Tax</th>
                <td class="table-light">{{ $item->tax }} %</td>
                <th class="table-secondary">Total Amount</th>
                <td class="table-light">Rp. {{ number_format($item->grandTotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </table>
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