@extends('app')
@section('content')

    <div class="bg-question">
        <div class="container">
            <div class="row">
                <div class="col-12 mt-5 text-center">
                    <p class="question-font-heading">Frequently Asked <strong class="text-warning">Questions</strong></p>
                </div>
                <div class="col-12 mt-5 mb-5">
                    <div class="col-6  mx-auto">
                        <div class="input-group mb-3 shadow rounded-5">
                            <span class="question-input-text"><i class='bx bx-search'></i></span>
                            <input type="text" class="form-control" placeholder="Enter your search question" aria-label="Enter your search question" style="border-left:0px solid;border-right:0px solid">
                            <span class="question-input-text1"><i class='bx bx-log-in-circle'></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-12 px-5 mb-5">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                      @foreach ($faqs as $item)
                        <div class="accordion-item">
                          <h2 class="accordion-header" id="{{ $item->order }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $item->order_flush }}" aria-expanded="false" aria-controls="{{ $item->order_flush }}">
                                <h6 class="text-uppercase">
                                   {{ $item->question }}
                                </h6> 
                            </button>
                          </h2>
                          <div id="{{ $item->order_flush }}" class="accordion-collapse collapse" aria-labelledby="{{ $item->order }}" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">{{ $item->answere ?? 'No answer provided.' }}</div>
                          </div>
                        </div>
                      @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection