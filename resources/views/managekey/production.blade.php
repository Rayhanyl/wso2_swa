@extends('app')
@section('content')

<div class="bg-question">
    <div class="container">
        <div class="row">
            <div class="my-4">
                <div class="font-head-subs">Manage keys</div>
                <div class="font-appname-subs my-2">{{ $application->name }}</div>
            </div>
            <div class="col-12 my-3">
                <a class="back-to-application" href="{{ route ('application.page',$application->applicationId) }}"><i class='bx bxs-chevron-left' ></i> Back to application</a>
            </div>
            <div class="col-12 mt-5">
                <nav class="nav">
                    <div class="row">
                        <div class="col-6">
                            <a class="nav-managekey" href="{{ route ('sandbox.page',$application->applicationId) }}">Sandbox</a>
                        </div>
                        <div class="col-6">
                            <a class="nav-managekey active" aria-current="page" href="{{ route ('production.page',$application->applicationId) }}">Production</a>
                        </div>
                    </div>
                </nav>
                <hr>
            </div>
            <div class="col-12">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="view" id="oauth-view" value="oauth2-view" checked>
                    <label class="form-check-label" for="oauth-view">Oauth2</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="view" id="apikey-view" value="apikey-view">
                    <label class="form-check-label" for="apikey-view">API key</label>
                  </div>
            </div>
            <div class="production-oauth-page" id="production-oauth-page">
                <div class="col-12 my-3">
                    <form class="row g-4"
                    action="{{ isset($data->keyMappingId) ?  route('updategenerate') : route('oauthgenerate') }}"
                    id="generatekey" method="POST">
                    @csrf   
                    <input type="hidden" name="type" value="PRODUCTION">
                    <input type="hidden" name="idmapping" value="{{ $data->keyMappingId ?? '' }}">
                    <input type="hidden" name="keymanager" value="{{ $data->keyManager ?? '' }}">
                    <input type="hidden" name="id" value="{{ $application->applicationId }}">
                    @if (isset($data->consumerKey))
                    <div class="col-sm-5">
                        <h6>Consumer Key</h6>
                        <div class="form-group position-relative has-icon-right">
                            <input type="text" class="form-control" name="consumerkey" id="consumerkey"
                                value="{{ $data->consumerKey ?? '' }}" placeholder="N/A" readonly>
                            <div class="form-control-icon">
                                <i type="button" onclick="copyConsumerKey()"
                                    class="bi bi-clipboard"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <h6>Consumer Secret</h6>
                        <div class="input-group position-relative has-icon-right">
                            <input type="password" class="form-control" name="secretkey" id="secretkey"
                                value="{{ $data->consumerSecret ?? '' }}" placeholder="N/A" readonly style="border-right:0px solid">
                            <span class="input-group-text bg-white">
                                <i type="button" id="toggle-password" onclick="toggleSecretKey()" class='bx bx-low-vision'></i>
                            </span>
                        </div>
                    </div>
                    @else
                    <div class="col-md-12 infoconsumer">
                        <p>Key and Secret <br>
                            <mark class="text-danger"> Production Key and Secret is not yet
                                generated for this application.</mark></p>
                    </div>
                    @endif
                    <div class="col-sm-5">
                        <h6>Token Endpoint</h6>
                        <div class="form-group position-relative has-icon-right">
                            <input type="text" class="form-control" id="tokenendpoint"
                                name="tokenendpoint" value="{{ $url }}/oauth2/token" placeholder="N/A"
                                readonly>
                            <div class="form-control-icon">
                                <i type="button" onclick="copyTokenEndpoint()"
                                    class="bi bi-clipboard"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <h6>Revoke Endpoint</h6>
                        <div class="form-group position-relative has-icon-right">
                            <input type="text" class="form-control" id="revokeendpoint"
                                name="revokeendpoint" value="{{ $url }}/oauth2/revoke" placeholder="N/A"
                                readonly>
                            <div class="form-control-icon">
                                <i type="button" onclick="copyRevokeEndpoint()"
                                    class="bi bi-clipboard"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5">
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
                                    <input class="form-check-input" type="checkbox"
                                        name="granttype[{{ $item }}]" role="switch"
                                        {{ isset($data->supportedGrantTypes) ? (in_array($item,$data->supportedGrantTypes) ? 'checked':'') : '' }}
                                        {{ isset($data->supportedGrantTypes) ? '' : (($item == 'password' || $item == 'client_credentials' || $item == 'implicit' || $item == 'authorization_code') ? 'checked':'') }}>
                                    <label class="form-check-label">
                                        @foreach ($granttype as $key=>$label)
                                        @if ($key == $item)
                                        {{ $label }}
                                        @endif
                                        @endforeach
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <label for="GrantTypes" class="form-label fw-light">
                            <small>
                                Scope :
                            </small>
                        </label>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox"
                                        name="scopetype[am_application_scope]" role="switch" checked>
                                    <label class="form-check-label"
                                        for="amapplication">am_application_scope</label>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox"
                                        name="scopetype[default]" role="switch" checked>
                                    <label class="form-check-label" for="default">Default</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 me-2">
                        <h6>User Access Token Expiry Time</h6>
                        <div class="form-group position-relative has-icon-right">
                            <input type="text" class="form-control" placeholder="N/A"
                                name="additional[user_access_token_expiry_time]"
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
                    <div class="col-sm-3 mx-5">
                        <h6>Application Token Expiry Time</h6>
                        <div class="form-group position-relative has-icon-right">
                            <input type="text" class="form-control" placeholder="N/A"
                                name="additional[application_access_token_expiry_time]"
                                value="{{ $data->additionalProperties->application_access_token_expiry_time ?? '' }}">
                            <div class="form-control-icon">
                                <i class="bi bi-hourglass-split"></i>
                            </div>
                            <div id="refreshtoken" class="form-text">
                                <small>
                                    Type Aapplication Refresh Token Expiry Time.
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 ms-2">
                        <h6>Refresh Token Expiry Time</h6>
                        <div class="form-group position-relative has-icon-right">
                            <input type="text" class="form-control" placeholder="N/A"
                                name="additional[refresh_token_expiry_time]"
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
                    <div class="col-sm-10">
                        <h6>Callback URL</h6>
                        <div class="form-group position-relative has-icon-right">
                            {{-- <input type="url" class="form-control" name="callback" pattern="https?://.+"
                                value="{{ $data->callbackUrl ?? 'http://127.0.0.1:8000/TryOut/'.$application->applicationId }}"> --}}
                            <input type="url" class="form-control" name="callback" pattern="https?://.+"
                                value="{{ $data->callbackUrl ?? 'https://devportal.belajarwso2.com/TryOut/'.$application->applicationId }}">
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
                    <div class="col-10 mt-5">
                        <div class="row">
                            @if (isset($data->keyMappingId))
                            <div class="col-4 d-grid gap-2">
                                <button class="btn btn-primary fw-bold rounded-3 generate" type="submit"
                                form="generatekey">
                                <i class="bi bi-recycle"></i>
                                Update</button>
                            </div>
                            <div class="col-4 d-grid gap-2">
                                <button class="btn btn-primary fw-bold rounded-3 generate" type="submit"
                                data-bs-toggle="modal" data-bs-target="#generateaccess"
                                form="generateaccess">
                                Generate Access Token</button>
                            </div>
                            <div class="col-4 d-grid gap-2">
                                <button class="btn btn-primary fw-bold rounded-3 generate" type="submit"
                                        data-bs-toggle="modal" data-bs-target="#generatecurl" form="generatecurl">
                                        CURL to Generate Access Token</button>
                            </div>
                            @else
                            <div class="col-5 d-grid gap-2">
                                <button class="btn btn-primary rounded-3 generate" type="submit"
                                form="generatekey"><i class='bx bxs-key'></i>
                                GENERATE KEY</button>
                            </div>
                            @endif
                        </div>
                    </div>
                </form>
                </div>
            </div>
            <div class="production-apikey-page row" id="production-apikey-page" style="display: none;">
                <div class="col-12 my-4">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-none-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-none" type="button" role="tab" aria-controls="pills-none"
                                aria-selected="true">None</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-http-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-http" type="button" role="tab" aria-controls="pills-http"
                                aria-selected="false">IP Addresses</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-apiaddress-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-apiaddress" type="button" role="tab"
                                aria-controls="pills-apiaddress" aria-selected="false">HTTP Referrers (Web
                                Sites)</button>
                        </li>
                        <li class="nav-item" role="presentation">
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-none" role="tabpanel"
                            aria-labelledby="pills-none-tab" tabindex="0">
                            @include('managekey.production.none')
                        </div>
                        <div class="tab-pane fade" id="pills-http" role="tabpanel"
                            aria-labelledby="pills-http-tab" tabindex="0">
                            @include('managekey.production.ipaddress')
                        </div>
                        <div class="tab-pane fade" id="pills-apiaddress" role="tabpanel"
                            aria-labelledby="pills-apiaddress-tab" tabindex="0">
                            @include('managekey.production.http')
                        </div>
                    </div>
                </div>
            </div>
            <div class="my-5">
            </div>
        </div>
    </div>
</div>


{{-- Modal --}}
<div class="modal fade" id="generatecurl" tabindex="-1" aria-labelledby="generatecurlLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="generatecurlLabel">Get CURL to Generate Access Token</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>The following cURL command shows how to generate an access token using the Password Grant type.</p>
                <div class="d-flex mb-3">
                    <div class="col-10 bg-curl p-3 rounded">
                        curl -k -X POST {{ $url }}/oauth2/token -d "grant_type=password&username={{ session('firstname') }}&password=Password"
                        -H "Authorization: Basic <a id="userpasscurl" class="text-primary">Base64(consumer-key:consumer-secret)</a>"
                    </div>
                    <div id="oauth-basic" style="display:none;">curl -k -X POST {{ $url }}/oauth2/token -d "grant_type=password&username={{ session('firstname') }}&password=Password" -H "Authorization: Basic {{ $base64 }}"</div>
                    <div class="col-2 copy-curl-icon ms-3">
                        <a type="button" onclick="copyCurloauthbasic()"><i class='bx bx-copy-alt'></i></a>
                    </div>
                </div>
                <div class="my-2">
                    <p>In a similar manner, you can generate an access token using the Client Credentials grant type with
                        the following cURL command.</p>
                </div>
                <div class="d-flex mb-3">
                    <div class="col-10 bg-curl p-3 rounded">
                        curl -k -X POST {{ $url }}/oauth2/token -d "grant_type=client_credentials"
                        -H "Authorization: Basic <a id="credentialcurl" class="text-primary">Base64(consumer-key:consumer-secret)</a>"
                    </div>
                    <div id="oauth-credentials" style="display:none;">curl -k -X POST {{ $url }}/oauth2/token -d "grant_type=client_credentials" -H "Authorization: Basic {{ $base64 }}"
                    </div>
                    <div class="col-2 copy-curl-icon ms-3">
                        <a type="button" onclick="copyCurlcredential()"><i class='bx bx-copy-alt'></i></a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="generateaccess" tabindex="-1" aria-labelledby="generateaccessLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="generateaccessLabel">Generate Access Token</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('accesstoken') }}" method="POST" id="form-accesstoken">
                    @csrf
                    <input type="hidden" name="consumersecretkey" value="{{ $data->consumerSecret ?? '' }}">
                    <input type="hidden" name="id" value="{{ $application->applicationId }}">
                    <input type="hidden" name="idmapping" value="{{ $data->keyMappingId ?? '' }}">
                    <input type="hidden" name="expiretoken" value="{{ $data->additionalProperties->application_access_token_expiry_time ?? '' }}">
                </form>
                <div class="before-accesstoken">
                    <p class="fw-bold">Scopes</p>
                    <hr>
                    <p class="text-break">When you generate access tokens to APIs protected by scope/s, you can select
                        the scope/s and then generate the token for it. Scopes enable fine-grained access control to API
                        resources based on user roles. You define scopes to an API resource. When a user invokes the
                        API, his/her OAuth 2 bearer token cannot grant access to any API resource beyond its associated
                        scopes.</p>
                </div>
                <div class="result-accesstoken">
                    <h4>Please Copy the Access Token</h4>
                    <p>
                        If the token type is JWT or API Key, please copy this generated token value as it will be
                        displayed only for the current browser session. ( The token will not be visible in the UI after
                        the page is refreshed. )
                    </p>
                    <label for="text-accesstoken"></label>
                    <textarea name="token" id="text-accesstoken" cols="100" rows="7" disabled>
                </textarea>
                    <div class="my-2">
                        <button class="btn btn-success" onclick="myAccesstoken()">Copy To clipboard</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-accesstoken" form="form-accesstoken">
                    Generate
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="generateapikey" tabindex="-1" aria-labelledby="generateapikeyLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="generateapikeyLabel">Generate API Key</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="before-apikeys">
                    <div class="form-check">
                        <form action="{{ route ('genapikey') }}" id="form-apikeys" method="POST">
                            @csrf
                            <input type="hidden" name="keytype" value="PRODUCTION">
                            <input type="hidden" name="appid" value="{{ $application->applicationId }}">
                            <div class="mb-3">
                                <input class="form-check-input" type="checkbox" name="infinitevalidity"
                                    id="infinitevalidity" checked>
                                <label class="form-check-label" for="infinitevalidity">
                                    API Key with infinite validity period
                                </label>
                            </div>
                            <div class="mb-3 periodapikey" style="display: none;">
                                <label for="exampleInputEmail1" class="form-label">
                                    <small>API Key validity period*</small>
                                </label>
                                <input type="number" class="form-control" id="validityPeriod" name="validityPeriod"
                                    aria-describedby="validityPeriod" placeholder="Enter time in seconds">
                                <div id="validityPeriod" class="form-text">You can set an expiration period to determine
                                    the validity period of the token after generation. Set this as -1 to ensure that the
                                    apikey never expires.</div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="result-apikeys">
                    <p>Please Copy the API Key
                        If the token type is JWT or API Key, please copy this generated token value as it will be
                        displayed only for the current browser session. ( The token will not be visible in the UI after
                        the page is refreshed. )</p>
                    <div>
                        <label for="text-apikey"></label>
                        <textarea name="token" id="text-apikey" cols="100" rows="10" disabled>
                        </textarea>
                    </div>
                    <div>
                        <small>Above token has a validity period of seconds.</small>
                    </div>
                    <button class="btn btn-success" onclick="copyApikey()">Copy To clipboard</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-apikeys" form="form-apikeys">
                    Generate
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
{{-- Modal --}}

@push('script')
    <script>

    $(document).ready(function () {
        $('.result-accesstoken').hide();
    });

    const myModalEl = document.getElementById('generateaccess')
    myModalEl.addEventListener('hidden.bs.modal', event => {
        $('.btn-accesstoken').show();
        $('.before-accesstoken').show();
        $('.result-accesstoken').hide();
    });

    $(document).on('submit', '#form-accesstoken', function (e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: new FormData(this),
            processData: false,
            dataType: 'json',
            contentType: false,
            beforeSend: function () {
                $('.btn-accesstoken').html(`Loading`).attr(
                    'disabled', true);
            },
            success: function (data) {
                if (data.code != '900967') {
                    $('.before-accesstoken').hide();
                    $('.result-accesstoken').show();
                    $('#text-accesstoken').val(data.data.accessToken);
                    $('.btn-accesstoken').hide();
                    $('.btn-accesstoken').html(`Generate`)
                        .attr('disabled', false);
                } else {
                    Swal.fire(
                        'Error',
                        '',
                        'error'
                    )
                    $('.before-accesstoken').hide();
                    $('.result-accesstoken').show();
                    $('#text-accesstoken').val('Error please call developer for fix this!');
                    $('.btn-accesstoken').hide();
                    $('.btn-accesstoken').html(`Generate`)
                        .attr('disabled', false);
                }
            },
            error: function (data) {
                Swal.fire(
                    'Error',
                    '',
                    'warning'
                )
            }
        });
    });

    $('#credentialcurl').on('click', function (e) {
        e.preventDefault();
        if ($(this).html() == 'Base64(consumer-key:consumer-secret)') {
            $(this).html('{{ $base64 }}');
        } else {
            $(this).html('Base64(consumer-key:consumer-secret)');
        }
    });

    $('#userpasscurl').on('click', function (e) {
        e.preventDefault();
        if ($(this).html() == 'Base64(consumer-key:consumer-secret)') {
            $(this).html('{{ $base64 }}');
        } else {
            $(this).html('Base64(consumer-key:consumer-secret)');
        }
    });

    function copyCurloauthbasic() {
        var copyText = document.getElementById("oauth-basic").textContent;
        navigator.clipboard.writeText(copyText)
            .then(function() {
                Swal.fire(
                    'Already Copied',
                    '',
                    'success'
                );
            })
            .catch(function(err) {
                console.error('Unable to copy text to clipboard', err);
            });
    }
    
    function copyCurlcredential() {
        var copyText = document.getElementById("oauth-credentials").textContent;
        navigator.clipboard.writeText(copyText)
            .then(function() {
                Swal.fire(
                    'Already Copied',
                    '',
                    'success'
                );
            })
            .catch(function(err) {
                console.error('Unable to copy text to clipboard', err);
            });
    }

    function copyConsumerKey() {
        var copyText = document.getElementById("consumerkey");

        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices

        navigator.clipboard.writeText(copyText.value);

        Swal.fire(
            'Already Copied',
            '',
            'success'
        )
    }

    function copySecretKey() {
        var copyText = document.getElementById("secretkey");

        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices

        navigator.clipboard.writeText(copyText.value);

        Swal.fire(
            'Already Copied',
            '',
            'success'
        )
    }

    function toggleSecretKey() {
        var passwordField = document.getElementById("secretkey");
        var toggleBtn = document.getElementById("toggle-secret-key");
        if (passwordField.type === "password") {
            passwordField.type = "text";
        } else {
            passwordField.type = "password";
        }
    }

    function copyRevokeEndpoint() {
        var copyText = document.getElementById("revokeendpoint");

        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices

        navigator.clipboard.writeText(copyText.value);

        Swal.fire(
            'Already Copied',
            '',
            'success'
        )
    }

    function copyTokenEndpoint() {
        var copyText = document.getElementById("tokenendpoint");

        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices

        navigator.clipboard.writeText(copyText.value);

        Swal.fire(
            'Already Copied',
            '',
            'success'
        )
    }

    function myAccesstoken() {
        var copyText = document.getElementById("text-accesstoken");

        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices

        navigator.clipboard.writeText(copyText.value);

        Swal.fire(
            'Already Copied',
            '',
            'success'
        )
    }

    $('#pills-none-tab').on('click',function(){
            reset();
        }); 
        $('#pills-apiaddress-tab').on('click',function(){
            reset();
        }); 
        $('#pills-http-tab').on('click',function(){
            reset();
        });
        $('#infinitevalidity').on('click',function(){
            resetvalidity();
    });

    function resetvalidity(){
        $('#validityPeriod').val('');
    }

    function reset(){
        $('.boxaddress').html('');
        $('#addip').val('');
        $('.boxhttp').html('');
        $('#addhttp').val('');
    }

    // API ADDRESS
    function isValidIPv6(ip) {
        let ipv6Pattern = /^s*((([0-9A-Fa-f]{1,4}:){7}([0-9A-Fa-f]{1,4}|:))|(([0-9A-Fa-f]{1,4}:){6}(:[0-9A-Fa-f]{1,4}|((25[0-5]|2[0-4]d|1dd|[1-9]?d)(.(25[0-5]|2[0-4]d|1dd|[1-9]?d)){3})|:))|(([0-9A-Fa-f]{1,4}:){5}(((:[0-9A-Fa-f]{1,4}){1,2})|:((25[0-5]|2[0-4]d|1dd|[1-9]?d)(.(25[0-5]|2[0-4]d|1dd|[1-9]?d)){3})|:))|(([0-9A-Fa-f]{1,4}:){4}(((:[0-9A-Fa-f]{1,4}){1,3})|((:[0-9A-Fa-f]{1,4})?:((25[0-5]|2[0-4]d|1dd|[1-9]?d)(.(25[0-5]|2[0-4]d|1dd|[1-9]?d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){3}(((:[0-9A-Fa-f]{1,4}){1,4})|((:[0-9A-Fa-f]{1,4}){0,2}:((25[0-5]|2[0-4]d|1dd|[1-9]?d)(.(25[0-5]|2[0-4]d|1dd|[1-9]?d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){2}(((:[0-9A-Fa-f]{1,4}){1,5})|((:[0-9A-Fa-f]{1,4}){0,3}:((25[0-5]|2[0-4]d|1dd|[1-9]?d)(.(25[0-5]|2[0-4]d|1dd|[1-9]?d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){1}(((:[0-9A-Fa-f]{1,4}){1,6})|((:[0-9A-Fa-f]{1,4}){0,4}:((25[0-5]|2[0-4]d|1dd|[1-9]?d)(.(25[0-5]|2[0-4]d|1dd|[1-9]?d)){3}))|:))|(:(((:[0-9A-Fa-f]{1,4}){1,7})|((:[0-9A-Fa-f]{1,4}){0,5}:((25[0-5]|2[0-4]d|1dd|[1-9]?d)(.(25[0-5]|2[0-4]d|1dd|[1-9]?d)){3}))|:)))(%.+)?s*(\/([0-9]|[1-9][0-9]|1[0-1][0-9]|12[0-8]))?$/;
        return ipv6Pattern.test(ip);
    }

    function isValidIPv4(ip) {
        let ipv4Pattern = /^([0-9]{1,3}\.){3}[0-9]{1,3}(\/([0-9]|[1-2][0-9]|3[0-2]))?$/;
        return ipv4Pattern.test(ip);
    }

    $('.addip').on('click',function(e){
        e.preventDefault();
        let valip = $('.textaddress').val();
            if (valip == '') {
                Swal.fire(
                    'Cannot be empty',
                    '',
                    'warning'
                )
            }else if (!isValidIPv6(valip) && !isValidIPv4(valip)){
                Swal.fire(
                    'Invalid IP address',
                    '',
                    'warning'
                )
            }else{
                $('.boxaddress').append(`<div class="col-3 d-flex deletboxipaddress"><div><p class="permitip">${valip}</p></div><div><a type="button" class="btn-sm text-danger mx-3 deleteaddress"><i class='bx bx-trash'></i></a></div></div>`);
                $('.textaddress').val('');
            }
    });
    
    $(document).on('click','.deleteaddress', function(){
        $(this).parents('.deletboxipaddress').remove();
    });

    // Array to string IPADDRESS
    function arraytostringip(ipaddresses){
        let ipaddress = '';
        ipaddresses.forEach((element,i) => {
            if(i > 0 ){
                ipaddress += ',' + element;
            }else{
                ipaddress = element;
            }
        });
        return ipaddress;
    }

    // HTTP REFERER
    $('.addhttp').on('click',function(e){
        e.preventDefault();
        let valhttp = $('.texthttp').val();
        if (valhttp == '') {
            Swal.fire(
                    'Cannot be empty',
                    '',
                    'warning'
                )
        } else {
            $('.boxhttp').append(`<div class="col-3 d-flex deletboxhttp"><div><p class="permithttp">${valhttp}</p></div><div><a type="button" class="btn-sm text-danger mx-3 deletehttp"><i class='bx bx-trash'></i></a></div></div>`);
            $('.texthttp').val('');
        }
    });

    $(document).on('click','.deletehttp', function(){
        $(this).parents('.deletboxhttp').remove();
    });

    // Array to string HTTP REFERRER
    function arraytostringhttp(httpreferrers){
        let httpreferer = '';
        httpreferrers.forEach((element,i) => {
            if(i > 0 ){
                httpreferer += ',' + element;
            }else{
                httpreferer = element;
            }
        });
        return httpreferer;
    }

    // GENERATE APIKEY
    $("#infinitevalidity").change(function() {
        if($(this).prop('checked')) {
            $('.periodapikey').hide();
        } else {
            $('.periodapikey').show();
        }
    });

    $(document).ready(function() {
        $('.result-apikeys').hide();
    });
    
    const myModalApikey = document.getElementById('generateapikey')
    myModalApikey.addEventListener('hidden.bs.modal', event => {
        $('.btn-apikeys').show();
        $('.before-apikeys').show();
        $('.result-apikeys').hide();
    });

    $(document).on('submit','#form-apikeys', function(e){
        let httpreferrers = [];
        let ipaddresses = [];

        $('.permitip').each(function(i, obj) {
            ipaddresses.push($(this).html());
        });
        $('.permithttp').each(function(i, obj) {
            httpreferrers.push($(this).html());
        });
        
        let arripaddress = arraytostringip(ipaddresses);
        let arrhttpreferers = arraytostringhttp(httpreferrers);
        let formdata = new FormData(this);
        
        formdata.append('ipaddresses',arripaddress);
        formdata.append('httpreferrers',arrhttpreferers);

        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: formdata,
            processData: false,
            dataType: 'json',
            contentType: false,
            beforeSend: function() {
                $('.btn-apikeys').html(`<i class='bx bx-cog bx-spin'></i> Loading`).attr('disabled', true);
            },
            success: function(data) {
                $('.before-apikeys').hide();
                $('.result-apikeys').show();
                $('#text-apikey').val(data.data.apikey);
                $('#text-valitytime').val(data.data.validityTime);
                $('.btn-apikeys').hide();
                $('.btn-apikeys').html(`<i class='bx bx-cog bx-rotate-180'></i> Generate`).attr('disabled', false);
            }
        });
    });

    // Copy text APIKEY
    function copyApikey() {
        // Get the text field
        var copyText = document.getElementById("text-apikey");

        // Select the text field
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices

        // Copy the text inside the text field
        navigator.clipboard.writeText(copyText.value);
        // if(copyText.value.length > 10) copyText.value = copyText.value.substring(0,20);

        Swal.fire(
        'Already Copied',
        '',
        'success'
        )
    }

    $(document).ready(function() {
        $('input[type=radio][name=view]').change(function() {
            if (this.value === 'oauth2-view') {
                $('#production-oauth-page').show();
                $('#production-apikey-page').hide();
            }
            else if (this.value === 'apikey-view') {
                $('#production-oauth-page').hide();
                $('#production-apikey-page').show();
            }
        });
    });
    </script>
@endpush

@endsection