@extends('app')
@section('content')

<div class="content-wrapper container mb-5">
    <div class="page-content">
        <section id="create-subscription">
            <div class="row" data-aos="fade-right" data-aos-duration="1200">
                <div class="my-4">
                    <div class="font-head-subs">Add Subscription</div>
                </div>
                <div class="col-12 my-3">
                    <a class="back-to-application" href="{{ route ('subscription.page',$application->applicationId) }}"><i class='bx bxs-chevron-left' ></i> Back to Subscription</a>
                </div>
                @if ($notsubscription == null)
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="fw-bold fs-3">No APIs available</p>
                            <p class="text-warning">No API are available for this Application <i
                                    class="bi bi-exclamation-diamond"></i></p>
                        </div>
                    </div>
                </div>
                @else
                <div class="col-12">
                    <div class="card card-shadow-app rounded-4 p-3">
                        <div class="card-body">
                            <div>
                                <h5 class="text-dark">
                                    List API <i class="bi bi-gear-wide-connected"></i>
                                    <hr>
                                </h5>
                            </div>
                            <table class="table table-striped" id="addlistsubscribe">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">API</th>
                                        <th class="text-center">Version</th>
                                        <th class="text-center">Subscription Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold">
                                    @foreach ($notsubscription as $item)
                                    <tr>
                                        <td>
                                            @if ($item->thumbnailUri != null)
                                            <div class="img-api" data-api-id="{{ $item->id }}">
                                                <div class="loader">
                                                </div>
                                            </div>
                                            @else
                                            <img class="img-thumbnail rounded mx-auto d-block" width="50" height="50"
                                                src="https://avatar.oxro.io/avatar.svg?name={{ $item->name }}"
                                                alt="Application Picture">
                                            @endif
                                        </td>
                                        <td class="text-uppercase">{{$item->name}}</td>
                                        <td class="text-center">{{$item->version}}</td>
                                        <td>
                                            <select class="form-select form-sm status-subscription"
                                                aria-label="Choice Subscription Status" name="status" required>
                                                <option value="" selected disabled>-- Select --</option>
                                                @foreach ($item->throttlingPolicies as $items)
                                                <option data-status="{{$items}}" value="{{$items}}">{{$items}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-primary btn-sm rounded-pill"
                                                data-api-id="{{$item->id}}"
                                                data-application-id="{{$application->applicationId}}" type="submit"
                                                id="subscription">
                                                Subscribe API <i class="bi bi-node-plus-fill"></i>
                                            </button>
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
        </section>
    </div>
</div>
@push('script')
<script>
    $(document).ready(function () {

        $(".img-api").each(function () {
            loadImg($(this))
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

    $(document).on('click', '#subscription', function () {
        $.ajax({
            url: "{{ route ('store.subscription') }}",
            method: 'POST',
            data: {
                applicationid: $(this).data('application-id'),
                apiid: $(this).data('api-id'),
                status: $(this).closest('tr').find('.status-subscription').val(),
                _token: "{{ csrf_token() }}",
            },
            beforeSend: function () {
                $('#loading').show()
            },
            success: function (data) {
                $('#loading').hide()
                Swal.fire(
                    'Success add subscribe',
                    '',
                    'success'
                )
                window.location.href = "{{ route ('subscription.page',$application->applicationId) }}"
            },
            error: function (data) {
                Swal.fire(
                    'Error',
                    '',
                    'warning'
                )
            }
        });
    });

    $(document).ready(function () {
        $('#listsubscribe').DataTable({
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
        });
    });

</script>
@endpush
@endsection
