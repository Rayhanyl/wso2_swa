<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="col-12 col-lg-8">
                <h1>{{ $detailapi->name }}</h1>
                <p class="fw-bold">Description:</p>
                @if ($detailapi->description == null)
                    <p>No description for this API</p>
                @else
                <p class="fw-light">{{ $detailapi->description }}</p>
                @endif
            </div>
            <div class="col-12 col-lg-4 text-center">
                @if ($detailapi->hasThumbnail == true)
                <div class="img-api" data-api-id="{{ $detailapi->id }}">
                    <div class="loader">
                    </div>
                </div>
                @else
                <img class="img-thumbnail rounded" width="150" height="150"
                    src="https://avatar.oxro.io/avatar.svg?name={{ $detailapi->name }}"
                    alt="Application Picture">
                @endif
                {{-- <img class="img-thumbnail rounded-circle w-50" src="https://avatar.oxro.io/avatar.svg?name={{ $detailapi->name }}&length=1" alt=""> --}}
            </div>
        </div>
    </div>
    <div class="col-12 mt-4">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Dokumentasi menggunakan INLINE</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Dokumentasi versi markdown</button>
            </li>
          </ul>
          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active px-5" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                @if ($inline != null)
                    {!!  $inline !!}    
                @else
                    Tidak ada dokumentasi untuk API ini.    
                @endif
            </div>
            <div class="tab-pane fade px-5" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                @if ($markdown != null)
                <pre id="data-markdown" style="display:none;">{{ $markdown }}</pre>
                <div id="markdown-content">
                @else
                <pre id="data-markdown" style="display:none;">Tidak ada dokumentasi untuk API ini.</pre>
                <div id="markdown-content">
                @endif
                </div>
            </div>
          </div>
    </div>
</div>


<script>
    $(document).ready(function () {
            $(".img-api").each(function () {
                    loadImg($(this))
            });
        });

    function loadImg(params) {
        $.ajax({
            url: '{{ route ('loadimgapidocument') }}',
            method: 'GET',
            data: {
                id: params.data('api-id'),
            },
            beforeSend: function () {
                $('.loader').html(
                    '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>'
                    );
            },
            success: function (data) {
                params.html(data);
            },
            error: function (data) {

            }
        });
    }
</script>