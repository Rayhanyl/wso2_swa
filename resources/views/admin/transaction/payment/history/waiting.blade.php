<table class="table table-striped" id="data-table-waiting-history" style="width:100%">
    <thead class="table-orange">
        <tr>
            <th>Payment No</th>
            <th>Invoice No</th>
            <th>Status</th>
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
            <td>
                @if ($item->paid == 'true')
                    <span class="fw-bold text-success">Paid</span>
                @else
                <span class="fw-bold text-warning">Unpaid</span>
                @endif
            </td>
            <td class="text-primary">{{ \Carbon\Carbon::parse($item->periodStartDate)->format('d F') }} - {{ \Carbon\Carbon::parse($item->periodEndDate)->format('d F') }}</td>
            <td>Rp. {{ number_format($item->totalAmount, 0, ',', '.') }}</td>
            <td>
                <a type="button" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Approval" data-id="{{ $item->id }}" id="btn-confirmation-payment">
                    <i class='bx bxs-pen'></i>
                </a>
                <a type="button" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Tracking" data-id="{{ $item->id }}" id="btn-track-payment"><i class='bx bxs-edit-location'></i></a>
                <a type="button" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Proof of Payment" href="http://103.164.54.199:8088/payments/files?paymentId={{ $item->id }}"><i class='bx bx-download'></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal -->
@include('admin.transaction.payment.modal.modalconfirmation')
<!-- Modal -->

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

    var modal = new bootstrap.Modal(document.getElementById('modal-confirmation-payment'));
    var jqmodal = $('#modal-confirmation-payment');
    var loaderModal = $('#modalLoader');
    var contentModal = $('#modalContent');

    $(document).on('click', '#btn-confirmation-payment', function () {
        modal.show();
        jqmodal.find('.modal-title').html('Approval Verification');
        var id_payment = $(this).data('id');
        $.ajax({
            type: "GET",
            url: "{{ route('admin.modal.confirmation.payment') }}",
            dataType: 'html',
            data: {
                _token: "{{ csrf_token() }}",
                payment_id: id_payment,
            },
            beforeSend: function () {
                contentModal.html('');
                loaderModal.html(
                    '<div class="d-flex justify-content-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>'
                );
            },
            success: function (data) {
                contentModal.html(data);
            },
            complete: function () {
                loaderModal.html('');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                var pesan = xhr.status + " " + thrownError + "\n" + xhr.responseText;
                contentModal.html(pesan);
            },
        });
    });
</script>