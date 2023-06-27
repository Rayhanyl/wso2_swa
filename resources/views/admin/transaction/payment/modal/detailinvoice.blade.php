<div class="row g-3">
    <div class="col-12 col-lg-6">
        <p class="fw-bold">{{ $invoice->id }}</p>
    </div>
    <div class="col-12 col-lg-6 text-end">
        <b>Period :</b>
        {{ \Carbon\Carbon::parse($invoice->periodStartDate)->format('d M Y') }} -
        {{ \Carbon\Carbon::parse($invoice->periodEndDate)->format('d M Y') }}
    </div>
</div>