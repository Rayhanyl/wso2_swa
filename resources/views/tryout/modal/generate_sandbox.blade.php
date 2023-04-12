<form class="row g-4" action="{{ route ('oauthgenerate') }}"
    id="generatekey" method="POST">
    @csrf
    <input type="hidden" name="type" value="SANDBOX">
    <input type="hidden" name="idmapping" value="{{ $data->keyMappingId ?? '' }}">
    <input type="hidden" name="keymanager" value="{{ $data->keyManager ?? '' }}">
    <input type="hidden" name="id" value="{{ $application->applicationId }}">
    @if (isset($data->consumerKey))
    <div class="col-sm-6">
        <h6>Consumer Key</h6>
        <div class="form-group position-relative has-icon-right">
            <input type="text" class="form-control" name="consumerkey" id="consumerkey"
                value="{{ $data->consumerKey ?? '' }}" placeholder="N/A" readonly>
            <div class="form-control-icon">
                <i type="button" onclick="copyConsumerKey()" class="bi bi-clipboard"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <h6>Consumer Secret</h6>
        <div class="form-group position-relative has-icon-right">
            <input type="password" class="form-control" name="secretkey" id="secretkey"
                value="{{ $data->consumerSecret ?? '' }}" placeholder="N/A" readonly>
            <div class="form-control-icon">
                <i type="button" id="toggle-secret-key" onclick="toggleSecretKey()" class="bi bi-eye"></i>
                <i type="button" onclick="copySecretKey()" class="bi bi-clipboard"></i>
            </div>
        </div>
    </div>
    @else
    <div class="col-md-12 infoconsumer">
        <p>Key and Secret <br>
            <mark class="text-danger"> Production Key and Secret is not
                generated for this application
            </mark>
        </p>
    </div>
    @endif
    <div class="col-sm-6">
        <h6>Token Endpoint</h6>
        <div class="form-group position-relative has-icon-right">
            <input type="text" class="form-control" id="tokenendpoint" name="tokenendpoint"
                value="{{ $url }}/oauth2/token" placeholder="N/A" readonly>
            <div class="form-control-icon">
                <i type="button" onclick="copyTokenEndpoint()" class="bi bi-clipboard"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <h6>Revoke Endpoint</h6>
        <div class="form-group position-relative has-icon-right">
            <input type="text" class="form-control" id="revokeendpoint" name="revokeendpoint"
                value="{{ $url }}/oauth2/revoke" placeholder="N/A" readonly>
            <div class="form-control-icon">
                <i type="button" onclick="copyRevokeEndpoint()" class="bi bi-clipboard"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <label for="GrantTypes" class="form-label fw-light">
            <small>
                Grant Types :
            </small>
        </label>
        <div class="row">
            @foreach ($grant->grantTypes as $item)
            {{-- @if ($item == 'implicit')
        @continue
        @endif --}}
            <div class="col-md-4">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="granttype[{{ $item }}]" role="switch"
                        {{ isset($data->supportedGrantTypes) ? (in_array($item,$data->supportedGrantTypes) ? 'checked':'') : '' }}
                        {{ isset($data->supportedGrantTypes) ? '' : (($item == 'password' || $item == 'client_credentials' || $item == 'implicit' || $item == 'authorization_code') ? 'checked':'') }}>
                    <label class="form-check-label">
                        @foreach ($granttype as $key=>$label)
                        @if ($key == $item)
                        {{  $label  }}
                        @endif
                        @endforeach
                    </label>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="col-sm-6">
        <label for="GrantTypes" class="form-label fw-light">
            <small>
                Scope :
            </small>
        </label>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="scopetype[am_application_scope]" role="switch"
                        checked>
                    <label class="form-check-label" for="amapplication">am_application_scope</label>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="scopetype[default]" role="switch" checked>
                    <label class="form-check-label" for="default">Default</label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <h6>User Access Token Expiry Time</h6>
        <div class="form-group position-relative has-icon-right">
            <input type="text" class="form-control" placeholder="N/A" name="additional[user_access_token_expiry_time]"
                value="{{ $data->additionalProperties->user_access_token_expiry_time ?? '' }}">
            <div class="form-control-icon">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <div id="useraccesstoken" class="form-text">
                <small>
                    Type User Access Token Expiry Time.
                </small>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <h6>Refresh Token Expiry Time</h6>
        <div class="form-group position-relative has-icon-right">
            <input type="text" class="form-control" placeholder="N/A" name="additional[refresh_token_expiry_time]"
                value="{{ $data->additionalProperties->refresh_token_expiry_time ?? '' }}">
            <div class="form-control-icon">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <div id="refreshtoken" class="form-text">
                <small>
                    Type Refresh Token Expiry Time.
                </small>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <h6>Callback URL</h6>
        <div class="form-group position-relative has-icon-right">
            <input type="url" class="form-control" name="callback" pattern="https?://.+"
                value="{{ $data->callbackUrl ?? 'http://127.0.0.1:8000/TryOut/'.$application->applicationId }}">
            <div class="form-control-icon">
                <i class="bi bi-link-45deg"></i>
            </div>
            <div id="callback" class="form-text">
                <small>
                    Callback URL is a redirection URI
                    in the client application which is used by the authorization server
                    to send the client's user-agent (usually web browser) back after
                    granting access.
                </small>
            </div>
        </div>
    </div>
    <div class="col-12 mt-5">
        <div class="col-12 mx-auto d-grid gap-2">
            <button class="btn btn-primary rounded-3 generate text-center" type="submit"
            form="generatekey"><i class='bx bxs-key'></i>
            Generate Key</button>
        </div>
    </div>
</form>
