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
            <div class="header-configurasi">
                <h3>Frequently ask question</h3>
                <hr>
            </div>
            <div class="content">
                <div class="card card-shadow-app rounded-3 p-3">
                    <div class="card-body">
                        <table class="table table-striped" id="listfaqs">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Question</th>
                                    <th class="text-center">Answere</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($faqs as $items)
                                <tr>
                                    <td>{{ $items->id }}</td>
                                    <td>{{ $items->question }}</td>
                                    <td>{{ $items->answere ?? 'No answer provided.' }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route ('faqs.create.page') }}" class="btn btn-primary rounded-5">
                                                <i class='bx bx-add-to-queue'></i>
                                            </a>
                                            <a href="#" class="btn btn-warning text-white rounded-5 mx-2">
                                                <i class='bx bx-edit-alt'></i>
                                            </a>
                                            <a href="#" class="btn btn-danger rounded-5">
                                                <i class='bx bx-trash' ></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>

@push('script')
    <script>
        $(document).ready(function () {
            $('#listfaqs').DataTable({
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, 'All'],
                ],
            });
        });
    </script>
@endpush



@endsection