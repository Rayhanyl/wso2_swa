<table class="table table-striped" id="data-table-waiting-history" style="width:100%">
    <thead class="table-orange">
        <tr>
            <th>Payment No</th>
            <th>Invoice No</th>
            <th>Paid</th>
            <th>Period</th>
            <th>Amount</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($waiting->data->content as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>
                <a class="text-primary" type="button" data-id="{{ $item->invoiceId }}" id="btn-get-detail-invoice-data">
                    {{ $item->invoiceId }}</td>
                </a>
            </td>
            <td>
                @if ($item->paid == 'true')
                    <span class="fw-bold text-success">Paid</span>
                @else
                <span class="fw-bold text-warning">Unpaid</span>
                @endif
            </td>
            <td>Rp. {{ number_format($item->totalAmount, 0, ',', '.') }}</td>
            <td class="text-primary">{{ \Carbon\Carbon::parse($item->periodStartDate)->format('d F') }} - {{ \Carbon\Carbon::parse($item->periodEndDate)->format('d F') }}</td>
            <td>
                <a type="button" class="btn btn-primary btn-sm" data-id="{{ $item->id }}" id="btn-track-payment"><i class='bx bxs-edit-location'></i></a>
                <a type="button" class="btn btn-primary btn-sm" href="http://103.164.54.199:8088/payments/files?paymentId={{ $item->id }}"><i class='bx bx-download'></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
    $(document).ready(function () {
        $('#data-table-waiting-history').DataTable({
            responsive: true,
            lengthMenu: [
                [5, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
        });
    });
</script>