@extends('app')
@section('content')

<div class="container">
    <div class="row my-5">
        <div class="col-12 text-center">
            <h1>Crate Invoice Administrator</h1>
        </div>
        <div class="col-12 my-2">
            <a class="back-to-application" href="{{ route ('admin.invoice.page') }}"><i class='bx bx-chevron-left'></i> Back to list invoice</a>
        </div>
        <div class="col-12 my-3">
            <div class="card card-shadow-app rounded-4">
                <div class="card-body">
                    <form class="row g-4" action="#">
                        <div class="col-12">
                            <label class="fw-bold my-2" for="">Invoice Number</label>
                            <input class="form-control" type="text" value="INV-XYZ-0212" disabled>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label class="fw-bold my-2" for="">Issue date</label>
                            <input class="form-control" type="date">
                        </div>
                        <div class="col-12 col-lg-6">
                            <label class="fw-bold my-2" for="">Due date</label>
                            <input class="form-control" type="date">
                        </div>
                        <div class="col-12">
                            <label class="fw-bold my-2" for="">Customer Name</label>
                            <input class="form-control" type="text">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 my-3">
            <div class="card card-shadow-app rounded-4">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12 text-end">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#additemmodal">Add item</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="create-invoice-admin-table" style="width:100%">
                        <thead class="table-orange">
                            <tr>
                                <th>API Name</th>
                                <th>Business Plan</th>
                                <th>QTY Req</th>
                                <th>QTY Resp OK</th>
                                <th>QTY Resp NOK</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>TAX</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < 10; $i++) <tr>
                                <td>Pizzahack</td>
                                <td>Unlimited</td>
                                <td>500</td>
                                <td>450</td>
                                <td>30</td>
                                <td>Rp.550.000.00</td>
                                <td>10%</td>
                                <td>
                                    <select class="form-control" name="#" id="">
                                        <option value="#">10%</option>
                                        <option value="#">11%</option>
                                        <option value="#">12%</option>
                                        <option value="#">13%</option>
                                    </select>
                                </td>
                                <td>Rp.500.000.00</td>
                                <td><button class="btn btn-primary btn-sm">Details</button></td>
                                </tr>
                                @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12 my-3">
            <form class="row" action="#">
                <div class="col-5">
                    <label class="fw-bold my-2" for="">Notes:</label>
                    <textarea class="form-control" name="#" id="" cols="30" rows="10"></textarea>
                </div>
                <div class="col-2">
                    <label class="fw-bold my-2" for="">Notifikasi</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            Email
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                        <label class="form-check-label" for="flexCheckChecked">
                            WhatsApp
                        </label>
                    </div>
                </div>
                <div class="col-5 text-end my-auto">
                    <p>Sub total : <span class="text-primary fw-bold">Rp.91.800</span></p>
                    <button class="my-2 btn btn-primary">Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Add Item --}}

<div class="modal fade" id="additemmodal" tabindex="-1" aria-labelledby="additem" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="additem">Add items</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row" action="#">
                    <div class="col-12">
                        <p class="">Invoce :&nbsp;<span class="text-primary fw-bold">INV.230032</span></p>
                        <p class="">Period :&nbsp;<span class="text-primary fw-bold">jan 17 - Feb 19</span></p>
                        <p class="">Customer :&nbsp;<span class="text-primary fw-bold">PT.XZR</span></p>
                    </div>
                    <hr>
                    <div class="col-12">
                        <table class="table table-striped" id="items-add-admin-table" style="width:100%">
                            <thead class="table-orange">
                                <tr>
                                    <th></th>
                                    <th>API Name</th>
                                    <th>Business Plan</th>
                                    <th>QTY Req</th>
                                    <th>QTY Resp OK</th>
                                    <th>QTY Resp NOK</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 0; $i < 10; $i++) <tr>
                                    <td>
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                    </td>
                                    <td>Pizzahack</td>
                                    <td>Unlimited</td>
                                    <td>500</td>
                                    <td>450</td>
                                    <td>30</td>
                                    </tr>
                                    @endfor
                            </tbody>
                        </table>
                    </div>
                    <div class="d-grid gap-2 my-2">
                        <button class="btn btn-warning text-white fw-bold w-50 mx-auto" type="button">OK</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal Add Item --}}

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

        $('#items-add-admin-table').DataTable({
            responsive: true,
            lengthMenu: [
                [5, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
        });
    });

</script>

@endpush

@endsection
