@extends('apphead')

@section('contents')
<script src="{{ asset('js/jquery.min.js') }}"></script>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <ul class="breadcrumb breadcrumb-style ">
                        <li class="breadcrumb-item">
                            <h4 class="page-title">Reports</h4>
                        </li>
                        <li class="breadcrumb-item bcrumb-1">
                            <a href="{{URL::to('/welcome') }}">
                                <i class="fas fa-home"></i> Home</a>
                        </li>
                        <li class="breadcrumb-item bcrumb-2">
                            <a href="#" onClick="return false;">Remedial Registration</a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">


                    @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ Session::get('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <div class="body">
                        <h5 align="center">Showing Remedial Registraion for {{ $currentSession->cs_session }}/{{ $currentSession->cs_session + 1 }} Session</h5>
                        <div class="table-responsive">
                            <table class="table table-hover js-basic-example contact_list">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Mat No</th>
                                        <th>Fullnames</th>
                                        <th>Level</th>
                                        <th>No of courses</th>
                                        <th>Courses</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($remedialReg as $remedial)
                                    <tr class="odd">
                                        <td class="center">{{$loop->iteration}}</td>
                                        <td>{{ $remedial['matno'] }}</td>
                                        <td>{{ stripslashes($remedial['surname']) }} {{ stripslashes($remedial['firstname']) }} {{ stripslashes($remedial['othername']) }}</td>
                                        <td>{{ $remedial['level'] }}</td>
                                        <td>{{ count($remedial['course_codes']->toArray()) }}</td>
                                        <td>{{ implode(', ', $remedial['course_codes']->toArray()) }}</td>


                                    </tr>@endforeach
                                </tbody>

                            </table>

                            <a href="{{ route('expremedialregistration', array_merge(request()->query(), ['export' => 'excel'])) }}" class="btn btn-primary">Export Report</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection