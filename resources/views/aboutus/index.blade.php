@extends('app')
@section('content')

    <div class="bg-question">
        <div class="section-aboutus-hero pt-5">
            <div class="container">
                <div class="row px-5">
                    <div class="padding-title col-12 col-lg-4" data-aos="fade-right" data-aos-duration="1000">
                        <div class="font-hero-title1">
                            This is
                        </div>
                        <div class="font-hero-title2">
                            ASABRI
                        </div>
                    </div>
                    <div class="col-12 col-lg-8" data-aos="fade-left" data-aos-duration="1000">
                        <p class="font-hero-content text-end">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium fugit adipisci cupiditate expedita voluptatibus esse placeat rem quisquam odio quidem. Nihil ea doloribus placeat magnam, aliquid assumenda facere quo in a expedita veritatis harum ad. Repellat, quaerat ducimus sit harum commodi expedita quod similique eius magni! Officiis numquam accusamus quisquam?.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-bg-asabri pb-5">
            <div class="container" data-aos="fade-up" data-aos-duration="1000">
                <div class="row d-flex justify-content-center px-5">
                    <div class="col-11">
                        <div class="card mopishm-card">
                            <div class="card-body text-center">
                                <img class="w-100" src="{{ asset ('assets/images/aboutus/asabri.jpg') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-aboutus-asabriapi">
            <div class="container">
                <div class="row px-5">
                    <div class="col-12 col-lg-6 text-center" data-aos="fade-up-right" data-aos-duration="1000"> 
                        <img class="w-100" src="{{ asset ('assets/images/aboutus/asabriapi.png') }}" alt="Picture Asabri API">
                    </div>
                    <div class="col-12 col-lg-6" data-aos="fade-down-left" data-aos-duration="1000"> 
                        <p class="font-asabriapi-content1">ASABRI API</p>
                        <p class="font-asabriapi-content2">
                            Asabri API is your one-stop solution for all your financial needs. With our API, you can access a wide range of financial services, including payments, transfers, and more. Our API is designed to be easy to use, secure, and reliable, so you can focus on what you do best.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-aboutus-widget" data-aos="zoom-in-up" data-aos-duration="1000">
            <div class="container">
                <div class="row px-5">
                    <div class="col-12 col-lg-4">
                        <div class="card bg-transparent shadow">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-lg-9">
                                        <p class="font-widget-content1">Transaction</p>
                                        <p class="font-widget-content2">2500 +</p>
                                    </div>
                                    <div class="col-12 col-lg-3">
                                        <div class="text-center">
                                            <img class="w-75" src="{{ asset ('assets/images/aboutus/icon-transaction.png') }}" alt="Icon Widget">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="card bg-transparent shadow">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-lg-8">
                                        <p class="font-widget-content1">Application user</p>
                                        <p class="font-widget-content2">2500 +</p>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <div class="text-center">
                                            <img class="w-50" src="{{ asset ('assets/images/aboutus/icon-user.png') }}" alt="Icon Widget">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="card bg-transparent shadow">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-lg-8">
                                        <p class="font-widget-content1">Clients</p>
                                        <p class="font-widget-content2">2500 +</p>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <div class="text-center">
                                            <img class="w-50" src="{{ asset ('assets/images/aboutus/icon-person.png') }}" alt="Icon Widget">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-aboutus-industry">
            <div class="container" data-aos="zoom-out-up" data-aos-duration="1000">
                <div class="row d-flex justify-content-center px-5">
                    <div class="font-aboutus-industry mx-5">
                        Industry
                        <hr class="style-1">
                    </div>
                    <div class="icon-card-idustry col-3 mt-5 text-center zoom">
                        <img class="" src="{{ asset ('assets/images/aboutus/Education.png') }}" alt="Icon Industry">
                        <p class="font-industry-content">Education</p>
                    </div>
                    <div class="icon-card-idustry col-3 mt-5 text-center zoom">
                        <img class="" src="{{ asset ('assets/images/aboutus/Financial.png') }}" alt="Icon Industry">
                        <p class="font-industry-content">Financial services</p>
                    </div>
                    <div class="icon-card-idustry col-3 mt-5 text-center zoom">
                        <img class="" src="{{ asset ('assets/images/aboutus/Medical.png') }}" alt="Icon Industry">
                        <p class="font-industry-content">Medical</p>
                    </div>
                    <div class="icon-card-idustry col-3 mt-5 text-center zoom">
                        <img class="" src="{{ asset ('assets/images/aboutus/oil.png') }}" alt="Icon Industry">
                        <p class="font-industry-content">Oil and Gas</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection