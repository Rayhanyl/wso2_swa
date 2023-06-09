@extends('app')
@section('content')

<div class="container">
    <div class="row my-5">
        <div class="col-12 text-center">
            <h1>Payment History</h1>
        </div>
        <div class="col-12 my-5">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                          <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Waiting for Confirmation</button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Confirmed</button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Rejected</button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="create-invoice-admin-table" style="width:100%">
                        <thead class="table-orange">
                            <tr>
                                <th>Payment No.</th>
                                <th>Invoice No.</th>
                                <th>Paid</th>
                                <th>Period</th>
                                <th>Amount</th>
                                <th>Proof of Payment</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < 5; $i++)
                            <tr>
                                <td>Pay-12312314</td>
                                <td>INV-23131231</td>
                                <td>Rp.25.000.000</td>
                                <td>27/08/2023</td>
                                <td>Rp.30.000.000</td>
                                <td>File</td>
                                <td>
                                    <button class="btn btn-primary btn-sm"><i class='bx bx-repost'></i></button>
                                    <button class="btn btn-primary btn-sm"><i class='bx bx-current-location'></i></button>
                                    <button class="btn btn-primary btn-sm"><i class='bx bx-download'></i></button>
                                </td>
                            </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@push('script')
    <script>
        
    </script>
@endpush

@endsection