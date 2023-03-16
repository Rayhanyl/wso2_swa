@extends('app')
@section('content')


<section id="hero">
    <div class="container">
        <div class="warp-content-home">
            <div class="row p-5">
                <div class="col-12 col-lg-6 p-5" data-aos="fade-right" data-aos-duration="1000">
                    <p class="hero-head-font">Welcome to <strong class="hero-text">ASABRI</strong>  API !</p>
                    <p class="hero-description-font">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa excepturi vero eveniet. Esse cupiditate illo architecto ratione nemo quaerat adipisci.
                    </p>
                    <button class="btn btn-warning btn-hero-daftar rounded-5 px-5 py-3">
                        Daftar Sekarang
                    </button>
                </div>
                <div class="col-12 col-lg-6 text-center" data-aos="fade-down" data-aos-duration="1000">
                    <img class="w-75" src="{{ asset ('assets/images/homepage/hero.png') }}" alt="Hero Picture">
                </div>
            </div>
        </div>
    </div>
</section>

<section id="testimonial">
    <div class="container">
        <div class="warp-content-home">
            <div class="row">
                <div class="col-12 mt-5" data-aos="fade-down" data-aos-duration="1000">
                    <p class="testimonial-devider1-font">What ASABRI customer are saying</p>
                    <p class="testimonial-devider2-font">Explore our API gallery and find out how our API fit to your business case.</p>
                </div>
                <div class="col-12 col-lg-12 mt-5" data-aos="fade-up" data-aos-duration="1000">
                    <div class="row">
                        @for ($i = 0; $i < 4; $i++)
                        <div class="col-12 col-lg-3 row">
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
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="services">
    <div class="container">
        <div class="warp-content-home">
            <div class="row">
                <div class="col-12 my-5" data-aos="fade-down" data-aos-duration="1000">
                    <p class="services-devider1-font">Our Services</p>
                    <p class="services-devider2-font">Explore our API gallery and find out how our API fit to your business case.</p>
                </div>
                <div class="col-12" data-aos="fade-up" data-aos-duration="1000">
                    <div class="row">
                        @for ($i = 0; $i < 3; $i++)
                        <div class="col-4 my-3">
                            <div class="card">
                                <div class="card-body">
                                  <h5 class="card-title">Calculator</h5>
                                  <p class="card-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Impedit tempora aperiam corrupti quos harum, voluptatem rerum illum neque praesentium quis.</p>
                                  <a href="#" class="btn btn-warning rounded-3 text-white fw-bold">More Details</a>
                                </div>
                              </div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="partner">
    <div class="container">
        <div class="warp-content-home">
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
</section>
@endsection
