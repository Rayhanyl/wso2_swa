    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Swamedia Informatika - WSO2</title>
        <link rel="stylesheet" href="{{ asset ('assets/bootstrap.5.2.3/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset ('assets/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset ('assets/css/aos/aos.css') }}">
        <link rel="stylesheet" href="{{ asset ('assets/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}"
            type="text/css">
        <link rel="stylesheet" href="{{ asset ('assets/css/datatables.css') }}" type="text/css">
        <link rel="stylesheet" href="https://unpkg.com/swagger-ui-dist@4.5.0/swagger-ui.css" type="text/css" />
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous">
        </script>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        @stack('style')
    </head>

    <body>
        <nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light nav-box-shadow">
            <div class="container">
                <a href="" class="navbar-brand">
                    <img src="{{ asset ('assets/images/logo/swamedia.png') }}" height="58" alt="Navbar Logo">
                </a>
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav mx-auto">
                        @if (!getToken())
                        <a href="{{ route ('home.page') }}"
                            class="nav-item nav-link nav-font mx-2 reset-local-storage">Home</a>
                        @endif
                        @if (getToken())
                        @if (session('role') == 'admin')
                        <a href="{{ route ('admin.dashboard.page') }}"
                            class="nav-item nav-link nav-font mx-2 reset-local-storage">Dashboard</a>
                        @else
                        <a href="{{ route ('customer.dashboard.page') }}"
                        class="nav-item nav-link nav-font mx-2 reset-local-storage">Dashboard</a>
                        @endif
                        <div class="dropdown">
                            <a class="nav-link nav-font mx-2 reset-local-storage dropdown-toggle" id="dropdownAppLink"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                App
                            </a>
                            <ul class="dropdown-menu" aria-describedby="dropdownAppLink">
                                <li class="dropdown-item">
                                    <a href="{{ route ('application.page') }}"
                                        class="nav-item nav-link nav-font mx-2 reset-local-storage">Application</a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ route ('documentation.page') }}"
                                        class="nav-item nav-link nav-font mx-2 reset-local-storage">Documentation</a>
                                </li>
                            </ul>
                        </div>
                        @if (getToken() && session('role') == 'admin')
                        <div class="dropdown">
                            <a class="nav-link nav-font mx-2 reset-local-storage dropdown-toggle" id="dropdownMenuLink"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Summary
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <li><a class="dropdown-item"
                                        href="{{ route ('admin.monthly.report.summary.page') }}">Report Admin</a></li>
                                <li><a class="dropdown-item"
                                        href="{{ route ('admin.api.resource.usage.summary.page') }}">Usage Admin</a>
                                </li>
                                <li><a href="{{ route ('admin.error.summary.page') }}" class="dropdown-item">Error
                                        Summary</a></li>
                                <li><a href="{{ route ('admin.backend.api.usage.page') }}" class="dropdown-item">Backend
                                        API Usage</a></li>
                            </ul>
                        </div>
                        <div class="dropdown">
                            <a class="nav-link nav-font mx-2 reset-local-storage dropdown-toggle"
                                id="dropdownTransactionLink" data-bs-toggle="dropdown" aria-expanded="false">
                                Transaction
                            </a>
                            <ul class="dropdown-menu" aria-describedby="dropdownTransactionLink">
                                <li class="dropdown-item">
                                    <a class="nav-item nav-link nav-font mx-2 reset-local-storage">Payment</a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ route ('admin.invoice.page') }}"
                                        class="nav-item nav-link nav-font mx-2 reset-local-storage">Invoice</a>
                                </li>
                            </ul>
                        </div>
                        @else
                        <div class="dropdown">
                            <a class="nav-link nav-font mx-2 reset-local-storage dropdown-toggle" id="dropdownMenuLink"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Summary
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <li><a class="dropdown-item"
                                        href="{{ route ('customer.monthly.report.summary.page') }}">Report</a></li>
                                <li><a class="dropdown-item"
                                        href="{{ route ('customer.api.resource.usage.summary.page') }}">Usage</a></li>
                            </ul>
                        </div>
                        <div class="dropdown">
                            <a class="nav-link nav-font mx-2 reset-local-storage dropdown-toggle"
                                id="dropdownTransactionLink" data-bs-toggle="dropdown" aria-expanded="false">
                                Transaction
                            </a>
                            <ul class="dropdown-menu" aria-describedby="dropdownTransactionLink">
                                <li class="dropdown-item">
                                    <a href="{{ route ('customer.payment.page') }}"
                                        class="nav-item nav-link nav-font mx-2 reset-local-storage">Payment</a>
                                </li>
                                <li class="dropdown-item">
                                    <a class="nav-item nav-link nav-font mx-2 reset-local-storage">Invoice</a>
                                </li>
                            </ul>
                        </div>
                        @endif
                        @endif
                        @if (!getToken())
                        <a href="{{ route ('documentation.page') }}"
                            class="nav-item nav-link nav-font mx-2 reset-local-storage">Documentation</a>
                        <a href="{{ route ('about.us.page') }}"
                            class="nav-item nav-link nav-font mx-2 reset-local-storage">About Us</a>
                        @endif
                        <a href="{{ route ('question.answer.page') }}"
                            class="nav-item nav-link nav-font mx-2 reset-local-storage">Q&A</a>
                        @if (getToken())
                        {{-- <a href="{{ route ('configuration.page') }}" class="nav-item nav-link nav-font mx-2
                        reset-local-storage">Configuration</a> --}}
                        @endif
                    </div>
                    <div class="navbar-nav ms-auto">
                        @if (getToken())
                        <a href="{{ route ('logout') }}"
                            class="nav-item nav-link btn btn-outline-warning nav-btn-login rounded-4 px-4 mx-2 reset-local-storage">
                            Logout
                        </a>
                        @else
                        <a href="{{ route ('login.page') }}"
                            class="nav-item nav-link btn btn-outline-warning nav-btn-login rounded-4 px-4 mx-2">
                            Sign In
                        </a>
                        <a href="{{ route ('register.page') }}"
                            class="nav-item nav-link btn btn-warning text-light nav-btn-login rounded-4 px-4 mx-2">
                            Sign Up
                        </a>
                        @endif

                    </div>
                </div>
            </div>
        </nav>
