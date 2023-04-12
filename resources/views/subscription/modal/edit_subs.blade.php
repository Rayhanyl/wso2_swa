<form action="{{ route('update.subscription') }}" method="POST" id="form-edit-subscription">
    @csrf
    <div class="form-group">
        <input type="hidden" name="appid" value="{{ $subs->applicationId }}">
        <input type="hidden" name="apiid" value="{{ $subs->apiId }}">
        <input type="hidden" name="subsid" value="{{ $subs->subscriptionId }}">
        <input type="hidden" name="status" value="{{ $subs->status }}">
        <label for="">Current Business Plan : {{ $subs->throttlingPolicy }}</label>
        <select name="throttling" class="form-control my-2">
            @foreach ($subs->apiInfo->throttlingPolicies as $item)
                <option value="{{ $item }}" {{ $item == $subs->throttlingPolicy ? 'selected' : '' }}>  
                    {{ $item }}
                </option>
            @endforeach
        </select>
    </div>
</form>