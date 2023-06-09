@extends('app')
@section('content')

    <div class="hero" id="section-hero">
        <div class="container">
            <div class="row p-5">
                <div class="col-12 col-lg-6 p-5" data-aos="fade-right" data-aos-duration="1000">
                    <p class="hero-head-font">Welcome to <strong class="hero-text">SWAMEDIA</strong>  API !</p>
                    <p class="hero-description-font">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa excepturi vero eveniet. Esse cupiditate illo architecto ratione nemo quaerat adipisci.
                    </p>
                    <a href="{{ route ('register.page') }}" class="btn btn-warning btn-hero-daftar rounded-5 px-5 py-3">
                        Daftar Sekarang
                    </a>
                </div>
                <div class="col-12 col-lg-6 d-none d-sm-none d-lg-block text-center" data-aos="fade-down" data-aos-duration="1000">
                    <img class="w-75" src="{{ asset ('assets/images/homepage/hero.png') }}" alt="Hero Picture">
                </div>
            </div>
        </div>
    </div>
    <div class="testimonial" id="section-testimonial">
        <div class="container">
            <div class="row">
                <div class="body-testimonial col-12" data-aos="fade-up" data-aos-duration="1000">
                    <p class="testimonial-devider1-font">What SWAMEDIA customer are saying</p>
                    <p class="testimonial-devider2-font">Explore our API gallery and find out how our API fit to your business case.</p>
                </div>
                <div class="col-12 my-5 py-3">
                    <div class="row">
                        @for ($i = 0; $i < 4; $i++)
                        <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-duration="1000">
                            <div class="row">
                                <div class="zoom col-12 text-center hover-zoom">
                                    <img class="img-thumbnail mx-auto w-50 rounded-5 p-3" src="{{ asset ('assets/images/clients/tokopedia.png') }}" alt="Testimonial Picture">
                                </div>
                                <div class="col-12 text-center my-3">
                                    <p class="testimonial-head-font">
                                        Tokopedia
                                    </p>
                                </div>
                                <div class="col-12 testimonial-description-font px-4">
                                    <footer class="blockquote-footer">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt facere, vero expedita est dolor quo ullam et pariatur voluptates eum? <cite title="Source Title">Source Title</cite></footer>
                                    <hr class="style-1">
                                </div>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div> 
            </div>
        </div>
    </div>
    <div class="services" id="section-services">
        <div class="container">
            <div class="row">
                <div class="col-12 mt-4" data-aos="fade-down" data-aos-duration="1000">
                    <p class="services-devider1-font">Our Services</p>
                    <p class="services-devider2-font">Explore our API gallery and find out how our API fit to your business case.</p>
                </div>
                <div class="col-12 px-5 py-3 mb-5" data-aos="fade-right" data-aos-duration="1000">
                    <div class="row">
                        @foreach ($listapi->list as $item)
                        <div class="col-12 col-lg-4 my-3">
                            <div class="card rounded-4 card-shadow-app">
                                <div class="card-body">
                                    {{-- <div class="card-img mb-4">
                                        @if ($item->thumbnailUri != null)
                                        <div class="img-api" data-api-id="{{ $item->id }}">
                                            <div class="loader">
                                            </div>
                                        </div>
                                        @else
                                        <img class="rounded-circle" width="50" height="50"
                                            src="https://avatar.oxro.io/avatar.svg?name={{ $item->name }}"
                                            alt="Application Picture">
                                        @endif
                                    </div> --}}
                                    <div class="card-title">
                                        <div>
                                            <h4>{{ $item->name }}</h3>
                                        </div>
                                        @if ($item->description != null)
                                            <p class="description-api-homepage">{{ $item->description }}</p>
                                        @else
                                        <div class="my-4">
                                            <p>No description for this API</p>
                                        </div>
                                        @endif
                                        <div class="my-2">
                                            <a href="{{ route ('documentation.page') }}" class="btn btn-primary rounded-4 btn-icon-homepage">Documentaion <i class='bx bxs-chevron-right'></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="partner" id="section-partner">
        <div class="container">
            <div class="row">
                <div class="col-12 my-5" data-aos="fade-down" data-aos-duration="1000">
                    <p class="partner-devider1-font">Our Partners</p>
                    <p class="partner-devider2-font">As a company, we value the partnerships we have built over the years and are committed to fostering long-lasting, mutually beneficial relationships with our partners.</p>
                </div>
                <div class="col-12" data-aos="fade-up" data-aos-duration="1000">
                    <div class="row">
                        <div class="zoom col-4 col-lg-2 my-4">
                            <img class="w-75" src="{{ asset ('assets/images/clients/blibli.png') }}" alt="">
                        </div>
                        <div class="zoom col-4 col-lg-2 my-4">
                            <img class="w-75" src="{{ asset ('assets/images/clients/tokopedia.png') }}" alt="">
                        </div>
                        <div class="zoom col-4 col-lg-2 my-4">
                            <img class="w-75" src="{{ asset ('assets/images/clients/swamedia.png') }}" alt="">
                        </div>
                        <div class="zoom col-4 col-lg-2 my-4">
                            <img class="w-75" src="{{ asset ('assets/images/clients/1asabri.png') }}" alt="">
                        </div>
                        <div class="zoom col-4 col-lg-2 my-4">
                            <img class="w-75" src="{{ asset ('assets/images/clients/shopee.png') }}" alt="">
                        </div>
                        <div class="zoom col-4 col-lg-2 my-4">
                            <img class="w-75" src="{{ asset ('assets/images/clients/bukalapak.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            $(document).ready(function () {
                $(".img-api").each(function () {
                        loadImg($(this))
                });
            });
        
            function loadImg(params) {
                $.ajax({
                    url: '{{ route ('loadimgapihomepage') }}',
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
    @endpush

@endsection
 