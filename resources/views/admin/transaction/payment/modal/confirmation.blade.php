<form action="{{ route ('admin.confirmation.payment') }}" method="POST" id="form-confirmation-payment">
    @csrf
    @method('PUT')
    <input type="hidden" name="payment_id" value="{{ $payment_id }}">
    <div class="row">
        <div class="col-6">
            <label for="#">Status</label>
            <select class="form-control" name="status" id="status">
                <option value="1">Verified</option>
                <option value="2">Rejected</option>
            </select>
        </div>
        <div class="col-6">
            <label for="#"><i class='bx bx-bell'></i> Notification</label>
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
        <div class="col-12">
            <label class="fw-bold my-2" for="">Notes:</label>
            <textarea class="form-control" name="notes" id="" cols="10" rows="5"></textarea>
        </div>
    </div>
</form>