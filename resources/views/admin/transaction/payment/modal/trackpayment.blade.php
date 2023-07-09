<div class="row g-0">
    <div class="col-10">
        <div class="row">
            <div class="col-12">
                <p><b>Payment No</b> : <span class="text-primary">{{ $trackpayment->data->payment->id }}</span></p>
            </div>
            <div class="col-12">
                <p> <b>Period</b> :
                    <span>{{ \Carbon\Carbon::parse($trackpayment->data->invoice->periodStartDate)->format('d M Y') }} -
                        {{ \Carbon\Carbon::parse($trackpayment->data->invoice->periodEndDate)->format('d M Y') }}</span>
                </p>
            </div>
            <div class="col-12">
                <p> <b>Amount</b> : <span>Rp.
                        {{ number_format($trackpayment->data->invoice->totalAmount, 0, ',', '.') }}</span></p>
            </div>
        </div>
    </div>
    <div class="col-2">
        @if ($trackpayment->data->payment->verifiedStateId === 2 )
        <p class="text-success">
            <i class='bx bx-check-circle' style="font-size:64px;"></i>
        </p>
        @elseif ($trackpayment->data->payment->verifiedStateId === 3)
        <p class="text-danger">
          <i class='bx bx-x-circle' style="font-size:64px;"></i>
        </p>
        @else

        @endif
    </div>
</div>
<hr class="my-3">
<div>
    @foreach ($trackpayment->data->paymentLogs as $item)
    <div class="row g-0">
        <div class="col-12 row my-2">
            <div class="col-3">
                {{ \Carbon\Carbon::parse($item->createdTime)->format('d M y H:i') }}
            </div>
            <div class="col-1 d-flex align-items-center">
                <h6 class="text-primary">
                    <i class='bx bxs-right-arrow'></i>
                </h6>
            </div>
            <div class="col-7">
                <span class="fw-bold">{{ $item->title }}</span> <br>
                <span class="text-primary"> {{ $item->verifiedStateText }} </span>
            </div>
        </div>
    </div>
    @endforeach
</div>
