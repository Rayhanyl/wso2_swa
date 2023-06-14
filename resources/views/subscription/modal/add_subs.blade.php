<div class="rounded-4 p-3">
    <div class="">
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
                        <select class="form-select form-sm status-subscription" name="subs_type" aria-label="Choice Subscription Type">
                            <option selected disabled>-- Select --</option>
                            <option class="prepaid">Pre paid</option>
                            <option class="postpaid">Post paid</option>
                        </select>
                    </td>
                    <td>
                        <select class="form-select form-sm status-subscription"
                            aria-label="Choice Subscription Status" name="status" required>
                            <option selected disabled>-- Select --</option>
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

<script>
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

                    console.log(data);
                    if (data.status == 'failed') {

                        Swal.fire(
                            'Subscription status wajib di isi',
                            '',
                            'warning'
                        )

                    } else {

                        $('#loading').hide()
                        Swal.fire(
                            'Success add subscribe',
                            '',
                            'success'
                        )
                        window.location.href = "{{ route ('subscription.page',$application->applicationId) }}"            
                    }
            
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
        $('#addlistsubscribe').DataTable({
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
        });
    });
</script>