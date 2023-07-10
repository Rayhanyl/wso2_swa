@extends('app')
@section('content')

<div class="container">
    <div class="row my-5">
        <div class="col-12 text-center">
            <h1>Create Invoice Administrator</h1>
        </div>
        <div class="col-12 my-2">
            <a class="back-to-application" href="{{ route ('admin.invoice.page') }}"><i class='bx bx-chevron-left'></i> Back to list invoice</a>
        </div>
        <div class="col-12 my-3">
            <div class="card card-shadow-app rounded-4">
                <div class="card-body">
                    <div class="row p-3">
                        <div class="col-12 d-flex justify-content-center">
                            <form class="row g-4" action="{{ route ('admin.create.invoice.page') }}">
                                <div class="col-12 col-lg-12">
                                    <label class="fw-bold my-2" for="">Issue date</label>
                                    <input class="form-control" type="date" name="issue_date" value="{{ now()->format('Y-m-d') }}">
                                </div>
                                <div class="col-12 col-lg-12">
                                    <label class="fw-bold my-2" for="customer_name">Customer name</label>
                                    <select id="customer_name" name="customer_name" class="form-select">
                                    @foreach ($customers->data as $item)
                                        <option class="text-capitalize" value="{{ $item->username }}" {{ $username == $item->username ? 'selected':'' }}>{{ $item->username }} - ({{ $item->organizationName }})</option>
                                    @endforeach
                                </select>
                                </div>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary" type="submit">Get List Subscription</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 my-3">
            <div class="card card-shadow-app rounded-4">
                <div class="card-body">
                    <table class="table table-striped" id="create-invoice-admin-table" style="width:100%">
                        <thead class="table-orange">
                            <tr>
                                <th>#</th>
                                <th>API Name</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>TAX</th>
                                <th>Amount</th>
                                <th>Start Date</th>
                                <th style="display:none;">Start Date</th>
                                <th>End Date</th>
                                <th style="display:none;">End Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="pick_api" id="pick_api_{{ $loop->iteration }}" value="{{ $item->subsId }}">
                                        </div>
                                    </td>
                                    <td>
                                        {{ $item->apiName }} <br>
                                        ( {{ $item->subsName }} )
                                    </td>
                                    <td class="price">
                                        {{ $item->price }}
                                    </td>
                                    <td>
                                        <input type="number" class="form-control discount" name="discount" min="1" max="100">
                                    </td>
                                    <td>
                                        <select class="form-control" name="tax_api">
                                            <option value="10">10%</option>
                                            <option value="11">11%</option>
                                            <option value="12">12%</option>
                                        </select>
                                    </td>
                                    <td class="amount">
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($item->periodStartDate)->format('Y-m-d') }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($item->periodEndDate)->format('Y-m-d') }}
                                    </td>
                                    <td class="startdate" style="display: none;">
                                        {{ $item->periodStartDate }}
                                    </td>
                                    <td class="enddate" style="display: none;">
                                        {{ $item->periodEndDate }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12 my-3">
            <form class="row" action="{{ route ('admin.create.invoice') }}" method="POST">
                @csrf
                <div class="col-12 data-api">
                    <input type="hidden" name="username" id="username" value="{{ $username }}">
                    <input type="hidden" name="issue" id="issue" value="{{ $issue }}">
                    <input type="hidden" name="amount_total_form" id="amount_total_form">
                    <input type="hidden" name="amount_form" id="amount_form">
                    <input type="hidden" name="subs_id_form" id="subs_id">
                    <input type="hidden" name="tax" id="tax">
                    <input type="hidden" name="discount" id="discount">
                    <input type="hidden" name="price_form" id="price_form">
                    <input type="hidden" name="startdate_form" id="startdate_form">
                    <input type="hidden" name="enddate_form" id="enddate_form">
                </div>
                <div class="col-5">
                    <label class="fw-bold my-2" for="">Notes:</label>
                    <textarea class="form-control" name="notes" id="" cols="10" rows="5"></textarea>
                </div>
                <div class="col-2">
                    <label class="fw-bold my-2" for="">Notifikasi</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="notif[]" value="EMAIL" id="email-notif">
                        <label class="form-check-label" for="email-notif">
                            Email
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="notif[]" value="WA" id="wa-notif">
                        <label class="form-check-label" for="wa-notif">
                            WhatsApp
                        </label>
                    </div>
                </div>
                <div class="col-5 text-end my-auto">
                    <h5>Sub total: <span id="subtotal" class="text-primary fw-bold"></span></h5>
                    <button class="my-2 btn btn-primary">Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script')
<script>
    $(document).ready(function () {
        $('#create-invoice-admin-table').DataTable({
            responsive: true,
            lengthMenu: [
                [5, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
        });

        $('input[type="radio"][name="pick_api"]').on('change', function () {
            calculateSubtotal($(this));
        });

        $('input[name="discount"], select[name="tax_api"]').on('change', function () {
            calculateSubtotal($('input[type="radio"][name="pick_api"]:checked'));
        });

        function calculateSubtotal(selectedApi) {
            let price = parseFloat(selectedApi.closest('tr').find('.price').text());
            let startDate = selectedApi.closest('tr').find('.startdate').text();
            let endDate = selectedApi.closest('tr').find('.enddate').text();
            let discount = parseFloat(selectedApi.closest('tr').find('input[name="discount"]').val()) || 0;
            let tax = parseFloat(selectedApi.closest('tr').find('select[name="tax_api"]').val()) || 0;
            let subtotal = price;
 
            let taxAmount = 0;
            let discountAmount = 0;

            if (tax) {
                taxAmount = subtotal * (tax / 100);
            }

            if (discount) {
                discountAmount = subtotal * (discount / 100);
            }

            subtotal += taxAmount - discountAmount;


            selectedApi.closest('tr').find('.amount').text(subtotal.toFixed(2));

            let amountTotal = 0;
            let amount = 0;

            $('input[type="radio"][name="pick_api"]:checked').each(function () {
                amountTotal += parseFloat($(this).closest('tr').find('.amount').text());
                amount += parseFloat($(this).closest('tr').find('.amount').text());
            });

            $('#amount_total_form').val(amountTotal.toFixed(2));
            $('#amount_form').val(amount.toFixed(2));
            $('#price_form').val(price);
            $('#subs_id').val(selectedApi.val());
            $('#tax').val(tax);
            $('#startdate_form').val(startDate);
            $('#enddate_form').val(endDate);
            $('#discount').val(discount);
            $('#subtotal').text(formatCurrency(subtotal.toFixed(2)));

            function formatCurrency(amount) {
                return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(amount);
            }
        }

    });

</script>
@endpush
@endsection
