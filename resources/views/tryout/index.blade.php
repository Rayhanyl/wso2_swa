@extends('app')
@section('content')

@push('style')
<style>
.custom-tooltip{
  --bs-tooltip-bg: var(--bs-primary);
}
</style>
@endpush

<div class="content-wrapper container my-5">
    <div class="page-heading">
        <h3>Tryout API <i class="bi bi-collection"></i></h3>
    </div>
    <div class="page-content">
        <section id="tryout">
            <div class="row">
                <div class="col-12 my-3">
                    <a class="back-to-application reset-local-storage" href="{{ route ('subscription.page',$application->applicationId) }}"><i class='bx bxs-chevron-left' ></i> Back to Subscription</a>
                </div>
                @if ($subscription->list == null)
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <h1>Subscribe to the API first to try it</h1>
                        </div>
                    </div>
                </div>
                @else
                <div class="col-12 row">
                    <div class="col-12 col-lg-4">
                        <div class="card card-shadow-app rounded-4">
                            <div class="card-body">
                                <form class="row" action="#" method="GET">
                                    <div class="col-12">
                                        <label class="fw-bold" for="select-api-tryout">Select API:</label>
                                        <select class="form-select" aria-label="Select API Tryout" id="select-api-tryout" name="select-api-tryout" required>
                                            <option>-- Select API --</option>
                                            @foreach ($subscription->list as $items)
                                                <option value="{{ $items->apiInfo->id }}">
                                                {{ $items->apiInfo->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 my-4">
                                        {{-- <div class="form-check form-check-inline">
                                            @if (isset($sandbox->consumerKey))
                                            <input class="form-check-input" type="radio" name="callback-url" id="sandbox-callback" value="SANDBOX" checked>
                                            @else
                                            <input class="form-check-input" type="radio" name="callback-url" id="sandbox-callback" value="SANDBOX" disabled>
                                            @endif
                                            <label class="form-check-label" for="sandbox-callback">Sandbox</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            @if (isset($production->consumerKey))
                                            <input class="form-check-input" type="radio" name="callback-url" id="production-callback" value="PRODUCTION">
                                            @else
                                            <input class="form-check-input" type="radio" name="callback-url" id="production-callback" value="PRODUCTION" disabled>
                                            @endif
                                            <label class="form-check-label" for="production-callback">Production</label>
                                        </div> --}}
                                    </div>
                                    <div class="col-12 d-grid gap-2">
                                        <button class="btn btn-primary my-3" id="find-swagger-api" type="submit"> TryOut API </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-8" id="detail-api-tryout">
                        <div class="card rounded-4 card-height-tryout">
                            <div class="card-body row">
                                <div class="col-12 col-lg-12">
                                    <div class="row">
                                        <div class="col-3">
                                            <h6>App name :</h6>
                                            <small>{{ $application->name }}</small>
                                        </div>
                                        <div class="col-3">
                                            <h6>App business plan :</h6>
                                            <small>{{ $application->throttlingPolicy }}</small>
                                        </div>
                                        <div class="col-6">
                                            <h6>App description</h6>
                                            <small class="tryout-description">{{ $application->description }}</small>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-2">
                                <div class="col-12 row">
                                    <div class="col-12 col-lg-6">
                                        <div class="row">
                                            @if (isset($sandbox->consumerKey))
                                                <div class="col-12">
                                                    <p class="fw-bold">Sandbox</p>
                                                </div>
                                                <div class="col-auto">
                                                    <input type="text" data-id-consume="{{ $sandbox->consumerKey ?? '' }}" class="form-control form-control-sm rounded-2" id="sandbox-consumer-key" placeholder="Consumer key" value="{{ $sandbox->consumerKey ?? '' }}">
                                                </div>
                                                <div class="col-auto">
                                                    <button type="button" onclick="copyConsumerkeySandbox()"  class="btn btn-primary rounded-3 btn-sm mb-3 px-2">Copy Client ID</button>
                                                </div>
                                            @else
                                                <p class="fs-6">Generate <b>sandbox</b> key to get client_id </p>
                                                <p>
                                                    <a type="button" class="reset-local-storage link-get-client-id" class="btn-modal-generatekey" id="btn-modal-generatekey-sandbox" data-app-id="{{ $application->applicationId }}">Click Here <i class='bx bxs-chevron-right'></i></a>
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                            <div class="row px-2">
                                                @if (isset($production->consumerKey))
                                                    <div class="col-12">
                                                        <p class="fw-bold">Production</p>
                                                    </div>
                                                    <div class="col-auto">
                                                        <input type="text" class="form-control form-control-sm rounded-2" id="production-consumer-key" placeholder="Consumer key" value="{{ $production->consumerKey ?? '' }}">
                                                    </div>
                                                    <div class="col-auto">
                                                        <button type="button" onclick="copyConsumerkeyProduction()"  class="btn btn-primary rounded-3 btn-sm mb-3 px-2">Copy Client ID</button>
                                                    </div>
                                                @else 
                                                    <p class="fs-6">Generate <b>production</b>  key to get client_id</p>
                                                    <p>
                                                        <a type="button" class="reset-local-storage link-get-client-id" class="btn-modal-generatekey" id="btn-modal-generatekey-production" data-app-id="{{ $application->applicationId }}">Click Here <i class='bx bxs-chevron-right'></i></a>
                                                    </p>
                                                @endif
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-12 my-5" id="swagger-api-tryout" style="display: none;">
                        <div class="card card-shadow-app rounded-4">
                            <div class="card-body">
                                <div class="row justify-content-end">
                                    <div class="col-12 text-end">
                                        <p class="fw-bold">
                                            
                                        </p>
                                    </div>
                                    <div class="col-auto">
                                        <a class="button" id="download-file-postman" data-id="">
                                            <img src="{{ asset ('assets/images/tryout/postman-icon.png') }}" width="120" height="30" alt="Postman Collection">
                                        </a>
                                    </div>
                                    <div class="col-auto">
                                        <a class="button" id="download-file-openapi" data-id="">
                                            <img src="{{ asset ('assets/images/tryout/open-api-icon.png') }}" width="120" height="30" alt="OpenAPI">
                                        </a>
                                    </div>
                                </div>
                                <hr>
                                <div id="swagger-ui"></div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </section>
    </div>
</div>

@include('tryout.modal.modal_sandbox')
@include('tryout.modal.modal_production')


@push('script')
<script>

    var idapi = localStorage.getItem('idapi')

    $(document).ready(function (){
        
        $('#select-api-tryout').val(localStorage.getItem('idapi'));
        const value = localStorage.getItem('tryoutapi');
        const value2 = localStorage.getItem('urlcallback');

        if (value !== null && value2 !== null) {
            tryval = value;
            calurl = value2;

            $('#download-file-postman').data('id', tryval);
            $('#download-file-openapi').data('id', tryval);

            $("#select-api-tryout").val(tryval).change();
            $('#swagger-api-tryout').show();
            swaggeruiload(tryval,calurl);
        }else{
            $('#swagger-api-tryout').hide();
        }
    });

    $(document).on('click', '#find-swagger-api', function(e) {
        e.preventDefault();
        let tryval = $('#select-api-tryout').val();
        let calurl = $('#sandbox-consumer-key').val();

        console.log(calurl);

        $('#download-file-postman').data('id', tryval);
        $('#download-file-openapi').data('id', tryval);

        if (localStorage.getItem('callback') == 'sandbox') {
            calurl = "{{ $sandbox->callbackUrl ?? '' }}";
        }else if(localStorage.getItem('callback') == 'production'){
            calurl = "{{ $production->callbackUrl ?? '' }}";
        }else if(calurl !== undefined){
            calurl = "{{ $sandbox->callbackUrl ?? '' }}";
        }else{
            calurl = "{{ $production->callbackUrl ?? '' }}";
        }

        $('#swagger-api-tryout').show();
        swaggeruiload(tryval,calurl);
        localStorage.setItem('tryoutapi', tryval);
    });


    $(document).on('click','#download-file-openapi', function(e){
        e.preventDefault();
        window.location.href = "{{route ('downloadjsonopenapi')}}?id_api="+$(this).data('id');
        
    });

    function swaggeruiload (id,url) {
        const paramsString = window.location.href;
        const searchParams = new URLSearchParams(paramsString);
        const access_token = searchParams.toString().split('=')[1].split('&')[0];

        if (access_token !== ''){
            localStorage.setItem('Auth', access_token);
        }

        window.ui = SwaggerUIBundle({
        url: '{{ route ('swaggerjson') }}'+'?id_api='+id,
        dom_id: '#swagger-ui',
        deepLinking: true,
        filter:false,
        presets: [
            SwaggerUIBundle.presets.apis
        ],
        plugins: [
            SwaggerUIBundle.plugins.DownloadUrl
        ],  
        oauth2RedirectUrl: url,
            requestInterceptor: (req) => {
                req.headers['Authorization'] ='Bearer ' + localStorage.getItem('Auth');
                return req;
            }
        });
    }


    function copyConsumerkeySandbox() {
        var copyText = document.getElementById("sandbox-consumer-key");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value);
        Swal.fire(
            'Already Copied',
            '',
            'success'
        )
        callback = 'sandbox';
        urlcallback = "{{ $sandbox->callbackUrl ?? '' }}";
        localStorage.setItem('urlcallback', urlcallback);
        localStorage.setItem('callback', callback);
    }

    function copyConsumerkeyProduction() {
        var copyText = document.getElementById("production-consumer-key");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value);
        Swal.fire(
            'Already Copied',
            '',
            'success'
        )
        callback = 'production';
        urlcallback = "{{ $production->callbackUrl ?? '' }}";
        localStorage.setItem('urlcallback', urlcallback);
        localStorage.setItem('callback', callback);
    }

    var modalSandox = new bootstrap.Modal(document.getElementById('generate-sandbox-modal'));
    var sandboxModal = $('#generate-sandbox-modal');
    var sandboxLoader = $('#sandboxloader');
    var sandboxContent = $('#sandboxContent');

    $(document).on('click', '#btn-modal-generatekey-sandbox', function() {
        modalSandox.show();
        localStorage.setItem('idapi', idapi);
        sandboxModal.find('.modal-title').html('Generate key');
        var idapp = $(this).data('app-id');
        $.ajax({
            type: "GET",
            url: "{{ route('sandbox.form') }}",
            dataType: 'html',
            data: {
                _token: "{{ csrf_token() }}",
                id_app: idapp,
            },
            beforeSend: function() {
                sandboxContent.html('');
                sandboxLoader.html(
                    '<div class="d-flex justify-content-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>'
                );
            },
            success: function(data) {
                sandboxContent.html(data);
            },
            complete: function() {
                sandboxLoader.html('');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                var pesan = xhr.status + " " + thrownError + "\n" + xhr.responseText;
                sandboxContent.html(pesan);
            },
        });
    }); 


    var modalProduction = new bootstrap.Modal(document.getElementById('generate-production-modal'));
    var productionModal = $('#generate-production-modal');
    var productionLoader = $('#productionloader');
    var productionContent = $('#productionContent');

    $(document).on('click', '#btn-modal-generatekey-production', function() {
        modalProduction.show();
        localStorage.setItem('idapi', idapi);
        productionModal.find('.modal-title').html('Generate key');
        var idapp = $(this).data('app-id');
        $.ajax({
            type: "GET",
            url: "{{ route('production.form') }}",
            dataType: 'html',
            data: {
                _token: "{{ csrf_token() }}",
                id_app: idapp,
            },
            beforeSend: function() {
                productionContent.html('');
                productionLoader.html(
                    '<div class="d-flex justify-content-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>'
                );
            },
            success: function(data) {
                productionContent.html(data);
            },
            complete: function() {
                productionLoader.html('');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                var pesan = xhr.status + " " + thrownError + "\n" + xhr.responseText;
                productionContent.html(pesan);
            },
        });
    }); 

</script>
@endpush
@endsection
