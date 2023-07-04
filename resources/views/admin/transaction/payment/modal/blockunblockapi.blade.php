<form class="row" id="form-block-unblock-api" action="{{ route ('block.unblock.api.action') }}" method="POST">
    @csrf
    <input type="hidden" name="id_subs" value="{{ $id_subs }}">
    <div class="col-12">
        <label class="fw-bold my-2" for="#">Option block :</label>
        <select class="form-select" name="option_block">
            <option value="1">Block</option>
            <option value="2">Unblock</option>
        </select>
    </div>
    <div class="col-12 my-2">
        <label class="fw-bold my-2" for="#">Reason :</label>
        <textarea class="form-control" name="reason" cols="5" rows="5"></textarea>
    </div>
</form>