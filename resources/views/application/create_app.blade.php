@extends('app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-12 mt-5">
            <h1>Create Application <span><img src="{{ asset ('assets/images/application/application-icon.png') }}" alt="App" width="60" height="40"></span></h1>
        </div>
        <div class="col-12 col-lg-6 my-5">
            <div class="card card-shadow-app rounded-4">
                <div class="card-body py-4">
                    <div class="mb-4">
                        <a class="back-to-application" href="{{ route ('application.page') }}"><i class='bx bx-chevron-left'></i> Back to application</a>
                    </div>
                    <form action="{{ route ('store.application') }}" method="POST">
                        @csrf
                        <div class="mb-3 @error('appname') is-invalid @enderror">
                          <label for="appname" class="form-label fw-bold">Application name</label>
                          <input type="text" class="form-control" id="appname" name="appname" aria-describedby="appname" required>
                          <div id="appname" class="form-text">Application name cannot be changed.</div>
                            @error('appname')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 @error('shared') is-invalid @enderror">
                            <label for="shared" class="form-label fw-bold">Shared Quota</label>
                            <select class="form-select" aria-label="Choice Shared Quota" id="shared" name="shared" required>
                                <option selected disabled>-- Select --</option>
                                @foreach ($sharedquota->list as $item)
                                <option value="{{$item->name}}" data-toggle="tooltip" data-placement="top"
                                    title="{{$item->description}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                            <div id="shared" class="form-text">Assign API request per access token.</div>
                            @error('shared')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Description</label>
                            <textarea class="form-control" maxlength='512' id="description" rows="3" name="description"></textarea>
                            <div id="description" class="form-text">
                                Maximum character 512.
                                <div id="the-count">
                                    <span id="current">0</span>
                                    <span id="maximum">/ 512</span>
                                </div>
                            </div>

                            @error('description')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button class="btn btn-warning me-md-2 rounded-4 fw-bold text-white" type="submit">Save</button>
                            <a class="btn btn-outline-warning rounded-4 fw-bold" type="button" href="{{ route ('application.page') }}">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 mb-5">
            <div class="py-4 px-5">
                <img src="{{ asset ('assets/images/application/create-app.png') }}" width="580" height="580" alt="Create app images">
            </div>
        </div>
        <div class="col-12 my-3">
        </div>
    </div>
</div>

@push('script')
    <script>
        $('textarea').keyup(function() {
        
            var characterCount = $(this).val().length,
                current = $('#current'),
                maximum = $('#maximum'),
                theCount = $('#the-count');
            
            current.text(characterCount);
            
        });
    </script>
@endpush

@endsection
