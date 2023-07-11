@extends('app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-12 my-4">
            <div class="font-head-subs">Subscription</div>
            <div class="font-appname-subs my-2">{{ $application->name }}</div>
        </div>
        <div class="col-12">
            <a class="back-to-application" href="{{ route ('application.page') }}"><i class='bx bxs-chevron-left'></i>
                Back To Application</a>
        </div>
        <div class="col-12 row mt-5">
            <div class="col-12 col-lg-3">
                <div class="card card-shadow-app rounded-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 d-flex align-items-center justify-content-center">
                                <img width="65" height="50"
                                    src="{{ asset ('assets/images/application/application-icon.png') }}" alt="">
                            </div>
                            <div class="col-8 text-center">
                                <div class="fw-bold" style="font-size: 18px;">
                                    Subscription
                                </div>
                                <div class="fw-bold text-center" style="font-size: 24px;">
                                    {{ $subscription->count }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="card card-shadow-app rounded-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 d-flex align-items-center justify-content-center">
                                <img width="50" height="50"
                                    src="{{ asset ('assets/images/application/icon-approved.png') }}" alt="">
                            </div>
                            <div class="col-8 text-center">
                                <div class="fw-bold" style="font-size: 18px;">
                                    Approved
                                </div>
                                <div class="fw-bold text-center" style="font-size: 24px;">
                                    {{ $approved_count }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="card card-shadow-app rounded-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 d-flex align-items-center justify-content-center">
                                <img width="50" height="50"
                                    src="{{ asset ('assets/images/application/icon-hold.png') }}" alt="">
                            </div>
                            <div class="col-8 text-center">
                                <div class="fw-bold" style="font-size: 18px;">
                                    On Hold
                                </div>
                                <div class="fw-bold text-center" style="font-size: 24px;">
                                    {{ $total_count }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="card card-shadow-app rounded-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 d-flex align-items-center justify-content-center">
                                <img width="50" height="50"
                                    src="{{ asset ('assets/images/application/icon-rejected.png') }}" alt="">
                            </div>
                            <div class="col-8 text-center">
                                <div class="fw-bold" style="font-size: 18px;">
                                    Rejected
                                </div>
                                <div class="fw-bold text-center" style="font-size: 24px;">
                                    {{ $rejected_count }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 my-5">
            @if ($subscription->list == null)
            <div class="">
                <h4 class="fw-bold text-warning">No subscriptions are available for this Application <i
                        class="bi bi-exclamation-diamond"></i></h4>
                <a type="button" class="btn-add-subs" id="btn-add-subs"
                    data-app-id="{{ $application->applicationId }}">Click here to start subscribing API <i
                        class='bx bxs-hand-up'></i></a>
            </div>
            @else
            <div class="my-4">
                <button class="btn btn-primary rounded-3" id="btn-add-subs"
                    data-app-id="{{ $application->applicationId }}">Add Subscription <span class="icon-position"> <img
                            width="13" height="9" src="{{ asset ('assets/images/icon/plus-icon.png') }}" alt="">
                    </span></button>
            </div>
            <div class="card rounded-4 card-shadow-app">
                <div class="card-body row">
                    <div class="col-12 row my-3">
                        <div class="col-6">
                            <p class="font-list-subscription">
                                List Subscription
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div class="col-12">
                        <table class="table text-center table-striped" id="listsubscribe">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">API</th>
                                    <th class="text-center">Lifecycle State</th>
                                    <th class="text-center">Business Plan</th>
                                    <th class="text-center">Subscription Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subscription->list as $items)

                                <tr>
                                    <td>
                                        @if ($items->apiInfo->thumbnailUri != null)
                                        <div class="img-api" data-api-id="{{ $items->apiInfo->id }}">
                                            <div class="loader">
                                            </div>
                                        </div>
                                        @else
                                        <img class="img-thumbnail rounded mx-auto d-block" width="50" height="50"
                                            src="https://avatar.oxro.io/avatar.svg?name={{ $items->apiInfo->name }}"
                                            alt="Application Picture">
                                        @endif
                                    </td>
                                    <td>{{$items->apiInfo->name}} - {{$items->apiInfo->version}} </td>
                                    <td>{{$items->apiInfo->lifeCycleStatus}}</td>
                                    <td>{{$items->throttlingPolicy}}</td>
                                    <td>
                                        @if ($items->status == 'ON_HOLD')
                                        <p class="text-warning fw-semibold" data-toggle="tooltip" data-placement="left"
                                            title="Waiting for approval from admin">
                                            {{$items->status}} <span class="subs-status-icon"> <img width="17"
                                                    height="17" src="{{ asset ('assets/images/application/hold.png') }}"
                                                    alt="Hold"> </span>
                                        </p>
                                        @elseif($items->status == 'REJECTED')
                                        <p class="text-danger fw-semibold" data-toggle="tooltip" data-placement="left"
                                            title="Rejected">
                                            {{$items->status}} <span class="subs-status-icon"> <img width="17"
                                                    height="17"
                                                    src="{{ asset ('assets/images/application/reject.png') }}"
                                                    alt="Rejected"> </span>
                                        </p>
                                        @elseif ($items->status == 'BLOCKED')
                                        <p class="text-danger fw-semibold" data-toggle="tooltip" data-placement="left"
                                        title="Blocked">
                                        {{$items->status}} <span class="subs-status-icon"> <img width="17"
                                                height="17"
                                                src="{{ asset ('assets/images/application/reject.png') }}"
                                                alt="Rejected"> </span>
                                    </p>
                                        @else
                                        <p class="text-primary fw-semibold" data-toggle="tooltip" data-placement="left"
                                            title="Approved">
                                            {{$items->status}} <span class="subs-status-icon"> <img width="17"
                                                    height="17"
                                                    src="{{ asset ('assets/images/application/approve.png') }}"
                                                    alt="Approved"> </span>
                                        </p>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($items->status == 'REJECTED')
                                        {{-- <button type="button" class="btn btn-warning btn-edit-subs rounded-4"
                                            data-subs-id="{{ $items->subscriptionId }}" disabled>
                                            <i class='bx bx-edit-alt' style="color: white;"></i>
                                        </button> --}}
                                        <a class="btn btn-danger btn-deletesubs rounded-4"
                                            href="{{ route ('delete.subscription',$items->subscriptionId) }}">
                                            <i class='bx bx-trash'></i>
                                        </a>
                                        @elseif($items->status == 'ON_HOLD')
                                        <button type="button" class="btn btn-warning btn-edit-subs rounded-4"
                                            data-subs-id="{{ $items->subscriptionId }}" disabled>
                                            <i class='bx bx-edit-alt' style="color: white;"></i>
                                        </button>
                                        <a class="btn btn-danger btn-deletesubs rounded-4"
                                            href="{{ route ('delete.subscription',$items->subscriptionId) }}">
                                            <i class='bx bx-trash'></i>
                                        </a>
                                        @elseif($items->status == 'UNBLOCKED')
                                        {{-- <button type="button" class="btn btn-warning btn-edit-subs rounded-4"
                                            data-subs-id="{{ $items->subscriptionId }}">
                                            <i class='bx bx-edit-alt' style="color: white;"></i>
                                        </button> --}}
                                        <a class="btn btn-primary rounded-4" type="button"
                                            href="{{ route ('tryout.page',$application->applicationId) }}"
                                            id="btn-tryout" data-api-id="{{ $items->apiId }}">
                                            Tryout
                                            <i class="bi bi-link"></i>
                                        </a>
                                        <a class="btn btn-danger btn-deletesubs rounded-4"
                                        href="{{ route ('delete.subscription',$items->subscriptionId) }}">
                                            <i class='bx bx-trash'></i>
                                        </a>
                                        @elseif($items->status == 'BLOCKED')
                                        <a class="btn btn-primary btn-renewal rounded-4">
                                            Renewal
                                        </a>
                                        <a class="btn btn-danger btn-deletesubs rounded-4"
                                            href="{{ route ('delete.subscription',$items->subscriptionId) }}">
                                            <i class='bx bx-trash'></i>
                                        </a>
                                        @elseif ($items->status == 'DELETE_PENDING')
                                        <a class="btn btn-danger btn-deletesubs rounded-4"
                                        href="{{ route ('delete.subscription',$items->subscriptionId) }}">
                                            <i class='bx bx-trash'></i>
                                        </a>
                                        @endif
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
        <div class="col-12 my-4">
        </div>
    </div>
</div>
@include('subscription.modal.modal_subs')
@include('subscription.modal.modal_addsubs')
@push('script')

<script>
$(document).on('click', '#btn-tryout', function () {
    var idapi = $(this).data('api-id');
    localStorage.setItem('idapi', idapi);
});

$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
    $('#listsubscribe').DataTable({
        responsive: true,
        lengthMenu: [
            [5, 10, 15, -1],
            [5, 10, 15, 'All'],
        ],
    });
    $(".img-api").each(function () {
        loadImg($(this))
    });
});

var modal = new bootstrap.Modal(document.getElementById('subscription-modal'));
var modaladd = new bootstrap.Modal(document.getElementById('addsubscription-modal'));
var jqmodal = $('#subscription-modal');
var jqmodaladd = $('#addsubscription-modal');

var loaderModal = $('#modalLoader');
var contentModal = $('#modalContent');
var loaderModaladd = $('#modalLoaderadd');
var contentModaladd = $('#modalContentadd');

$(document).on('click', '#btn-add-subs', function () {
    modaladd.show();
    jqmodaladd.find('.modal-title').html('Subscribe APIs');
    var idapp = $(this).data('app-id');
    $.ajax({
        type: "GET",
        url: "{{ route('add.subscription') }}",
        dataType: 'html',
        data: {
            _token: "{{ csrf_token() }}",
            id_app: idapp,
        },
        beforeSend: function () {
            contentModaladd.html('');
            loaderModaladd.html(
                '<div class="d-flex justify-content-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>'
            );
        },
        success: function (data) {
            contentModaladd.html(data);
        },
        complete: function () {
            loaderModaladd.html('');
        },
        error: function (xhr, ajaxOptions, thrownError) {
            var pesan = xhr.status + " " + thrownError + "\n" + xhr.responseText;
            contentModaladd.html(pesan);
        },
    });
});

$(document).on('click', '.btn-edit-subs', function () {
    modal.show();
    jqmodal.find('.modal-title').html('Edit Bussines Plan');
    $('.btn-submit').show();
    jqmodal.find('.btn-submit').attr('form', 'form-edit-subscription');
    var idsubs = $(this).data('subs-id');
    $.ajax({
        type: "GET",
        url: "{{ route('edit.subscription') }}",
        dataType: 'html',
        data: {
            _token: "{{ csrf_token() }}",
            id_subs: idsubs,
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

$(document).on('click', '.btn-deletesubs', function (e) {
    e.preventDefault();
    let href = $(this).attr('href');
    Swal.fire({
        title: 'Are you sure you want to delete this item?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        toast: true,
        position: 'top-end',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            Swal.fire({
                icon: 'warning',
                title: 'The item is being deleted',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true,
                didOpen: function (toast) {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            }).then(() => {
                window.location.href = href;
            });
        }
    });
});

$(document).on('click', '.btn-renewal', function (e) {
    e.preventDefault();
    let href = $(this).attr('href');
    Swal.fire({
        title: 'Renewal API',
        text: "You won't be able to revert this!",
        icon: 'warning',
        toast: true,
        position: 'top-end',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, renewal'
    }).then((result) => {
        if (result.value) {
            Swal.fire({
                icon: 'warning',
                title: 'Waiting',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true,
                didOpen: function (toast) {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            }).then(() => {
                window.location.href = href;
            });
        }
    });
});


function loadImg(params) {
    $.ajax({
        url: '{{ route ('loadimgapi') }}',
        method: 'GET',
        data: {
            id: params.data('api-id'),
        },
        beforeSend: function () {
            $('.loader').html(
                '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
        },
        success: function (data) {
            params.html(data);
        },
        error: function (data) {

        }
    });
}
</script>
@endpush
@endsection
