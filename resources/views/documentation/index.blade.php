@extends('app')
@section('content')

<div class="height-documentation container-fluid">
    <div class="row g-0">
        <div class="documentation-bg-list-api col-12 col-lg-3 p-4">
            <div class="sticky-top" style="top:120px;">
                <div class="row">
                    <div class="col-12">
                        <div class="input-group mb-3">
                            <span class="documentation-icon-search" id="Search-API"><i class='hover-search bx bx-search' ></i></span>
                            <input type="text" class="form-control" name="name_api" id="name_api" placeholder="Search API" aria-label="Search API" aria-describedby="Search-API" style="border-left:0px solid">
                        </div>
                    </div>
                    <div class="col-12 px-5">
                        <div class="d-flex justify-content-center">
                            <div id="loader">
                            </div>
                        </div>
                    </div>
                    <div id="documentation-list-api">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-9 p-4">
            <div class="d-flex justify-content-center">
                <div id="loader2">
                </div>
            </div>
            <div id="result-document">
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
    $( document ).ready(function(){
        searchApi('');
    });

    $('#name_api').keyup(function(){
        searchApi($(this).val());
    });

    function searchApi(params) {
        $.ajax({
            type: "GET",
            url: "{{ route('list.api') }}",
            dataType: 'html',
            data: {
                name_api: params,
            },
            beforeSend: function() {
                $('#documentation-list-api').html('');
                $('#loader').html('<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>');
            },
            success: function(data) {
                $('#documentation-list-api').html(data);
            },
            complete: function() {
                $('#loader').html('');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                var pesan = xhr.status + " " + thrownError + "\n" + xhr.responseText;
                $('#documentation-list-api').html(pesan);
            },
        });
    };

    $(document).on('click', '.button-result-document', function() {
        $.ajax({
            type: "GET",
            url: "{{ route('result.documentation') }}",
            dataType: 'html',
            data: {
                id_api: $(this).data('id'),
            },
            beforeSend: function() {
                $('#result-document').html('');
                $('#loader2').html('<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>');
            },
            success: function(data) {
                $('#result-document').html(data);
                const markdownText = $('#data-markdown').html();
                const converter = new showdown.Converter();
                const htmlText = converter.makeHtml(markdownText);
                document.getElementById("markdown-content").innerHTML = htmlText;

            },
            complete: function() {
                $('#loader2').html('');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                var pesan = xhr.status + " " + thrownError + "\n" + xhr.responseText;
                $('#result-document').html(pesan);
            },
        });
    });

    </script>
@endpush

@endsection