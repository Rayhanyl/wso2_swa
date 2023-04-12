@extends('app')
@section('content')
    
    <div class="height-configurasi">
        <div class="row g-0">
            <div class="configurasi-bg col-12 col-lg-3 p-4 shadow">
                <div class="sticky-top" style="top:120px;">
                    <h2>Configuration</h2>
                    <div class="list-meu px-2 mt-5">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-transparent configuration-list-menu"><i class='bx bx-home-alt'></i>
                                <a href="{{ route ('configuration.page') }}">
                                    Home page
                                </a> 
                            </li>
                            <li class="list-group-item bg-transparent configuration-list-menu"><i class='bx bx-question-mark'></i> 
                                <a href="{{ route ('faqs.page') }}">
                                    Frequently ask question
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div> 
            <div class="col-12 col-lg-9 p-4">
                <h1>Home Page Configuration</h1>
                <hr>
            </div>
        </div>
    </div>

@endsection