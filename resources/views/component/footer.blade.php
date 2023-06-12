
<div class="bg-footer">
    <div class="container">
        <div class="footer p-4">
            <div class="row">
                <div class="col-12 col-lg-4 bg-light text-dark rounded">
                    <div class="row">
                        <div class="col-12">
                            <img style="height:70px;width:85px;" src="{{ asset ('assets/images/logo/x10s.png') }}" alt="Footer Logo">
                        </div>
                        <div class="col-12 footer-font-address my-2">
                            Jl. Sido Mulyo No.29, Sukaluyu, Kec. Cibeunying Kaler, Kota Bandung, Jawa Barat 40123.
                        </div>
                        <div class="col-12 col-lg-6">
                            <i class='bx bxs-phone'></i> (021) 8094140
                        </div>
                        <div class="col-12 col-lg-6">
                            <i class='bx bx-support'></i> 150043
                        </div>
                    </div>
                </div>
                <div class="col-6 col-sm-3 col-lg-2">
                    <p class="footer-font-head">
                        About Us
                    </p>
                    <p class="footer-font-content">
                        Our Services
                    </p>
                    <p class="footer-font-content">
                        How It Works
                    </p>
                    <p class="footer-font-content">
                        Become a Partner
                    </p>
                </div>
                <div class="col-6 col-sm-3 col-lg-2">
                    <p class="footer-font-head">
                        Terms and Conditions
                    </p>
                </div>
                <div class="col-6 col-sm-3 col-lg-2">
                    <p class="footer-font-head">
                        Social Media
                    </p>
                    <p class="footer-font-content">
                        Twitter <i class='bx bxl-twitter' ></i> 
                    </p>
                    <p class="footer-font-content">
                         Facebook <i class='bx bxl-facebook-circle'></i>
                    </p>
                    <p class="footer-font-content">
                         Instagram <i class='bx bxl-instagram-alt' ></i>
                    </p>
                </div>
                <div class="col-6 col-sm-3 col-lg-2">
                    <p class="footer-font-head">
                        Need more help? 
                    </p>
                    <p class="footer-font-content">
                        Please contact us at
                        <br>
                        <a class="text-warning">
                            helpdesk@SWAMEDIA.id
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset ('assets/js/jquery-3.6.1.js')}}" ></script>
<script src="https://unpkg.com/swagger-ui-dist@4.5.0/swagger-ui-bundle.js" crossorigin></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.3.0/chart.min.js"></script>
<script src="{{ asset ('assets/js/datatables.min.js') }}"></script>
{{-- <script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
<script src="{{ asset ('assets/bootstrap.5.2.3/js/bootstrap.min.js') }}"></script>
<script src="{{ asset ('assets/js/aos/aos.js') }}"></script>
<script src="{{ asset ('assets/showdown/showdown.min.js') }}"></script>
@include('sweetalert::alert')
<script>
    AOS.init();
    $('.reset-local-storage').on('click',function(){
        localStorage.removeItem('tryoutapi');
        localStorage.removeItem('urlcallback');
        localStorage.removeItem('access_token_parshing');
        localStorage.removeItem('Auth');
        localStorage.removeItem('idapi');
        localStorage.removeItem('callback');
    });
</script>
@stack('script')
</body>
</html>