<div class="rounded-4 p-3">
    <div>
        <table class="table table-striped" id="addlistsubscribe">
            <thead>
                <tr>
                    <th class="text-center">API</th>
                    <th class="text-center">Version</th>
                    <th class="text-center">Subscription Type</th>
                    <th class="text-center">Subscription Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody class="fw-bold">
                @foreach ($notsubscription as $item)
                <tr>
                    <td class="text-uppercase">{{$item->name}}</td>
                    <td class="text-center">{{$item->version}}</td>
                    <td class="text-center">
                        <select class="form-select form-sm status-type-subscription" name="subs_type" aria-label="Choice Subscription Type" id="subs_type{{ $loop->iteration }}">
                            <option selected disabled>-- Select --</option>
                            <option value="prepaid">Prepaid</option>
                            <option value="postpaid">Postpaid</option>
                        </select>
                    </td>
                    <td>
                        <select class="form-select form-sm status-subscription" aria-label="Choice Subscription Status" name="status" id="status{{ $loop->iteration }}" required>
                        </select>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-primary btn-sm rounded-pill subscription-btn"
                            data-api-id="{{$item->id}}"
                            data-application-id="{{$application->applicationId}}" type="button">
                            Subscribe API <i class="bi bi-node-plus-fill"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).on('click', '.subscription-btn', function () {
        var button = $(this);
        var row = button.closest('tr');
        var subscriptionType = row.find('.status-type-subscription[name="subs_type"]').val();
        var subscriptionStatus = row.find('.status-subscription[name="status"]').val();

        $.ajax({
            url: "{{ route('store.subscription') }}",
            method: 'POST',
            data: {
                applicationid: button.data('application-id'),
                apiid: button.data('api-id'),
                status: subscriptionStatus,
                subs_type: subscriptionType,
                _token: "{{ csrf_token() }}",
            },
            beforeSend: function () {
                $('#loading').show();
            },
            success: function (data) {
                if (data.status === 'failed') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Subscription status and type must be filled',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: function (toast) {
                            toast.addEventListener('mouseenter', Swal.stopTimer);
                            toast.addEventListener('mouseleave', Swal.resumeTimer);
                        }
                    });
                } else {
                    $('#loading').hide();
                    Swal.fire({
                        icon: 'success',
                        title: 'Success add subscribe',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true,
                        didOpen: function (toast) {
                            toast.addEventListener('mouseenter', Swal.stopTimer);
                            toast.addEventListener('mouseleave', Swal.resumeTimer);
                        }
                    }).then(function(result) {
                        if (result.isDismissed) {
                            if ($('.status-type-subscription').val() === 'prepaid') {
                                window.location.href = "{{ route('customer.payment.page') }}";
                            } else {
                                window.location.href = "{{ route('subscription.page', $application->applicationId) }}";
                            }
                        }
                    });
                }

            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: function (toast) {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });
            }
        });
    });

    $(document).ready(function () {
        $('#addlistsubscribe').DataTable({
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
        });
        getApiTypeSubs($('#subs_type').val());
    });

    function  getApiTypeSubs(params, itr) {
            let type_subscription = params;
            let statusItr = '#status'+itr; 
            $.ajax({
                type: "GET",
                url: "{{ route('get.apilist.by.typesubs') }}",
                dataType: 'html',
                data: {
                    type_subscription,
                },
                beforeSend: function() {
                    $(statusItr).html('');
                },
                success: function(data) {
                    let api_typesubs_list = JSON.parse(data);
                    api_typesubs_list = api_typesubs_list.data.data;
                    options  = '';
                    api_typesubs_list.forEach(item => {
                        options += `<option value='${item.uuid}'>${item.displayName}</option>`;  
                    });
                    $(statusItr).html(options);
                },
                complete: function() {
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    var pesan = xhr.status + " " + thrownError + "\n" + xhr.responseText;
                    $(statusItr).html(pesan);
                },
            });
        }

        @foreach($notsubscription as $items)
            $(document).on('change', '#subs_type{{ $loop->iteration }}', function(e) {
                e.preventDefault();
                getApiTypeSubs($(this).val(), {{ $loop->iteration }});
            });
        @endforeach
</script>
