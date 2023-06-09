@extends('app')
@section('content')

<div class="container">
    <div class="row my-5">
        <div class="col-12">
            <h1>Payment</h1>
        </div>
        <div class="col-12 my-3">
            <div class="card">
                <div class="card-body">
                    <form class="row" action="#">
                        <div class="col-12">
                            <label class="fw-bold my-2" for="">Payment</label>
                            <input class="form-control" type="text" name="" id="" value="PAY-20230512-XYZ" disabled>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label class="fw-bold my-2" for="#">Invoice</label>
                            <input class="form-control" type="text" name="" id="">
                        </div>
                        <div class="col-12 col-lg-6">
                            <label class="fw-bold my-2" for="#">Period</label>
                            <input class="form-control" type="date" name="" id="">
                        </div>
                        <div class="col-12 col-lg-6">
                            <label class="fw-bold my-2" for="#">Customer</label>
                            <input class="form-control" type="text" name="" id="">
                        </div>
                        <div class="col-12 col-lg-6">
                            <label class="fw-bold my-2" for="#">Due Date</label>
                            <input class="form-control" type="date" name="" id="">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 my-3">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped" id="customer-table-payment" style="width:100%">
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12">
            <form class="row g-3" action="#">
                <div class="col-12 text-end">
                    <p class="fw-bold">Sub total :<span class="text-primary fw-bold">&nbsp; Rp.91.800</span></p>
                </div>
                <div class="col-12 col-lg-5">
                    <label class="fw-bold my-2" for="">Attachement payment slip</label>
                    <input type="file" class="form-control" name="" id="">
                </div>
                <div class="col-12 col-lg-5">
                    <label class="fw-bold my-2" for="">Berita acara</label>
                    <input type="text" class="form-control" name="" id="">
                </div>
                <div class="col-12 col-lg-2">
                    <div class="text-white mb-3">.</div>
                    <button class="btn btn-primary w-100">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


@push('script')
    <script>
        $(document).ready(function () {
            $('#customer-table-payment').DataTable({
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