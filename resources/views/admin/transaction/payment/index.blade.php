@extends('app') @section('content') <div class="container">
    <div class="row my-5">
        <div class="col-12 text-center">
            <h1>Payment</h1>
        </div>
        <div class="col-12 my-5">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation"><button class="nav-link active"
                                id="pills-waiting-confirmation" data-bs-toggle="pill" data-bs-target="#pills-waiting"
                                type="button" role="tab" aria-controls="pills-waiting" aria-selected="true">Waiting for
                                confirmation</button></li>
                        <li class="nav-item" role="presentation"><button class="nav-link"
                                id="pills-accepted-confirmation" data-bs-toggle="pill" data-bs-target="#pills-accepted"
                                type="button" role="tab" aria-controls="pills-accepted"
                                aria-selected="false">Accepted</button></li>
                        <li class="nav-item" role="presentation"><button class="nav-link"
                                id="pills-rejected-confirmation" data-bs-toggle="pill" data-bs-target="#pills-rejected"
                                type="button" role="tab" aria-controls="pills-rejected"
                                aria-selected="false">Rejected</button></li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-waiting" role="tabpanel"
                            aria-labelledby="pills-waiting-confirmation" tabindex="0">
                            <div id="waiting">
                            </div>
                            <div id="reload-waiting-history">
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-accepted" role="tabpanel"
                            aria-labelledby="pills-accepted-confirmation" tabindex="0">
                            <div id="accepted">
                            </div>
                            <div id="reload-accepted-history">
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-rejected" role="tabpanel"
                            aria-labelledby="pills-rejected-confirmation" tabindex="0">
                            <div id="rejected">
                            </div>
                            <div id="reload-rejected-history">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal --}}
@include('admin.transaction.payment.modal.modaltrackpayment')
@include('admin.transaction.payment.modal.modalgetdetailinvoice')
{{-- Modal --}}

@push('script')
    <script>
        $(document).ready(function(){
            $('#pills-waiting-confirmation').trigger('click');

            var modalTrack = new bootstrap.Modal(document.getElementById('modal-track-payment'));
            var jqmodalTrack = $('#modal-track-payment');
            var loaderModalTrack = $('#modalLoaderTrackPayment');
            var contentModalTrack = $('#modalContentTrackPayment');

            $(document).on('click', '#btn-track-payment', function () {
                modalTrack.show();
                jqmodalTrack.find('.modal-title').html('Track Payment State');
                var id_payment_track = $(this).data('id');
                $.ajax({
                    type: "GET",
                    url: "{{ route('admin.modal.track.payment') }}",
                    dataType: 'html',
                    data: {
                        _token: "{{ csrf_token() }}",
                        payment_id: id_payment_track,
                    },
                    beforeSend: function () {
                        contentModalTrack.html('');
                        loaderModalTrack.html(
                            '<div class="d-flex justify-content-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>'
                        );
                    },
                    success: function (data) {
                        contentModalTrack.html(data);
                    },
                    complete: function () {
                        loaderModalTrack.html('');
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var pesan = xhr.status + " " + thrownError + "\n" + xhr.responseText;
                        contentModalTrack.html(pesan);
                    },
                });
            });

            var modalGetDetailInvoice = new bootstrap.Modal(document.getElementById('modal-get-detail-invoice'));
            var jqmodalGetDetailInvoice  = $('#modal-get-detail-invoice');
            var loaderGetDetailInvoice  = $('#modalLoadergetdetailinvoice');
            var contentGetDetailInvoice  = $('#modalcontentgetdetailinvoice');

            $(document).on('click', '#btn-get-detail-invoice-data', function (){
                modalGetDetailInvoice.show();
                var id_invoice = $(this).data('id');
                jqmodalGetDetailInvoice.find('.modal-title').html('Detail Invoice');
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

        });

        $(document).on('click', '#pills-waiting-confirmation', function() {
            $.ajax({
                type: "GET",
                url: "{{ route ('admin.history.waiting') }}",
                dataType: 'html',
                data: {
                },
                beforeSend: function() {
                    $('#waiting').html('');
                    $('#reload-waiting-history').html('<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>');
                },
                success: function(data) {
                    $('#waiting').html(data);
                },
                complete: function() {
                    $('#reload-waiting-history').html('');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    var pesan = xhr.status + " " + thrownError + "\n" + xhr.responseText;
                    $('#waiting').html(pesan);
                },
            });
        });

        $(document).on('click', '#pills-accepted-confirmation', function() {
            $.ajax({
                type: "GET",
                url: "{{ route('admin.history.accepted') }}",
                dataType: 'html',
                data: {
                },
                beforeSend: function() {
                    $('#accepted').html('');
                    $('#reload-accepted-history').html('<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>');
                },
                success: function(data) {
                    $('#accepted').html(data);
                },
                complete: function() {
                    $('#reload-accepted-history').html('');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    var pesan = xhr.status + " " + thrownError + "\n" + xhr.responseText;
                    $('#accepted').html(pesan);
                },
            });
        });

        $(document).on('click', '#pills-rejected-confirmation', function() {
            $.ajax({
                type: "GET",
                url: "{{ route('admin.history.rejected') }}",
                dataType: 'html',
                data: {
                },
                beforeSend: function() {
                    $('#rejected').html('');
                    $('#reload-rejected-history').html('<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>');
                },
                success: function(data) {
                    $('#rejected').html(data);
                },
                complete: function() {
                    $('#reload-rejected-history').html('');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    var pesan = xhr.status + " " + thrownError + "\n" + xhr.responseText;
                    $('#rejected').html(pesan);
                },
            });
        });

        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    
    </script>
@endpush
@endsection
