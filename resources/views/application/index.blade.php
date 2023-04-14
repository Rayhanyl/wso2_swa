@extends('app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-12 my-5">
            <div class="card rounded-4 p-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-2">
                            <h3 class="text-capitalize">Welcome, <span class="text-warning">{{ session('firstname') }} {{ session('lastname') }}</span> !</h3>
                            <p class="fw-light">Explore our API gallery and find out how our API fit to your business case.</p>
                        </div>
                        <div class="col-12 col-lg-12 my-3">
                            <div class="row px-4">
                                <div class="col-12 col-lg-3">
                                    <div class="card card-shadow-app rounded-4">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-4 d-flex align-items-center justify-content-center">
                                                    <img width="65" height="50" src="{{ asset ('assets/images/application/application-icon.png') }}" alt="">
                                                </div>
                                                <div class="col-8 text-center">
                                                    <div class="fw-bold" style="font-size: 14px;">
                                                        Application
                                                    </div>
                                                    <div class="fw-bold text-center" style="font-size: 24px;">
                                                        {{ $application->count }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <div class="card card-shadow-app rounded-4">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-4 d-flex align-items-center justify-content-center">
                                                    <img width="50" height="50" src="{{ asset ('assets/images/application/icon-create.png') }}" alt="">
                                                </div>
                                                <div class="col-8 text-center">
                                                    <div class="fw-bold" style="font-size: 14px;">
                                                        Application Created
                                                    </div>
                                                    <div class="fw-bold text-center" style="font-size: 24px;">
                                                        {{ $created_count }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <div class="card card-shadow-app rounded-4">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-4 d-flex align-items-center justify-content-center">
                                                    <img width="50" height="50" src="{{ asset ('assets/images/application/icon-approved.png') }}" alt="">
                                                </div>
                                                <div class="col-8 text-center">
                                                    <div class="fw-bold" style="font-size: 14px;">
                                                        Application Approved
                                                    </div>
                                                    <div class="fw-bold text-center" style="font-size: 24px;">
                                                        {{ $approved_count }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <div class="card card-shadow-app rounded-4">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-4 d-flex align-items-center justify-content-center">
                                                    <img width="50" height="50" src="{{ asset ('assets/images/application/icon-rejected.png') }}" alt="">
                                                </div>
                                                <div class="col-8 text-center">
                                                    <div class="fw-bold" style="font-size: 14px;">
                                                        Application Rejected
                                                    </div>
                                                    <div class="fw-bold text-center" style="font-size: 24px;">
                                                        {{ $rejected_count }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 my-3 ">
                            <div class="row px-5 py-3">
                                <div class="col-6">
                                    <img width="550" height="450" src="{{ asset ('assets/images/application/list-overview.png') }}" alt="Overview">
                                </div>
                                <div class="col-6">
                                    <img width="520" height="460" src="{{ asset ('assets/images/application/application-overview.png') }}" alt="List">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mb-4"  data-aos="fade-up" data-aos-duration="1000">
            <div class="card rounded-4">
                <div class="card-body">
                    <h3>Application list</h3>
                    <p>Creating an Asabri application is easy and straightforward. So why wait? Join the Asabri revolution today and start building your application.</p>
                    <a href="{{ route ('create.application.page') }}" class="btn btn-primary rounded-4 add-icon-app">Create application</a>
                    <hr>
                    <div class="table-responsive">
                        @if ($application->list == null)
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h2><i class="bi bi-chevron-double-up"></i></h2>
                                    <h3>Create Application First !</h3>
                                </div>
                            </div>
                        </div>
                        @else
                        <table class="table table-striped" id="listapplication" style="width:100%">
                            <thead class="table-orange">
                                <tr>
                                    <th>Application name</th>
                                    <th>Shared quota</th>
                                    <th>Subscription</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($application->list as $item)
                                    <tr>
                                        <td style="width:15%">
                                            @if ($item->status == 'CREATED' || $item->status == 'REJECTED')
                                                <img class="img-thumbnail rounded mx-auto d-block" width="75" height="75"
                                                src="{{asset ('assets/images/application/app.png')}}" alt="Application Picture">
                                            @else
                                                <a href="#">
                                                    <img class="img-thumbnail rounded mx-auto d-block" width="75" height="75"
                                                        src="{{asset ('assets/images/application/app.png')}}" alt="Application Picture">
                                                </a>
                                            @endif
                                            <p class="text-center">
                                                {{$item->name}}
                                            </p>
                                        </td>
                                        <td style="width:15%">{{$item->throttlingPolicy}}</td>
                                        <td>{{$item->subscriptionCount}}</td>
                                        <td>
                                            <p class="list-app-description">
                                                {{$item->description}}
                                            </p>
                                        </td>
                                        <td>{{ $item->status }}</td>
                                        <td class="text-center">
                                            <div class="btn-group dropend">
                                                <button type="button" class="btn btn-outline-primary btn-sm rounded"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class='bx bx-list-ul'></i>    
                                                </button>
                                                <ul class="dropdown-menu">
                                                    @if ($item->status == 'APPROVED')
                                                    <li><a class="dropdown-item"
                                                            href="{{route ('sandbox.page',$item->applicationId)}}">
                                                            <i class="bi bi-bookmarks"></i> Managekeys</a>
                                                    </li>
                                                    <li><a class="dropdown-item"
                                                            href="{{route ('subscription.page',$item->applicationId)}}">
                                                            <i class="bi bi-bookmarks"></i> Subscription</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{route ('edit.application.page',$item->applicationId)}}">
                                                            <i class="bi bi-pen"></i> Edit Application</a>
                                                    </li>
                                                    @endif
                                                    <li>
                                                        <a class="dropdown-item btn-deleteapp"
                                                            href="{{route ('delete.application',$item->applicationId)}}"><i
                                                                class="bi bi-trash2"></i> Delete Application</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 my-4">

        </div>
    </div>
</div>

@push('script')
<script>
    $(document).ready(function () {
        $('#listapplication').DataTable({
            responsive: true,
            lengthMenu: [
                [5, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
        });
    });

    $(document).on('click', '.btn-deleteapp', function(e){
            e.preventDefault();
            let href = $(this).attr('href');
            Swal.fire({
                title: 'Are you sure you want to delete this item?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    window.location.href=href;
                }
            })
        });

</script>
@endpush

@endsection
