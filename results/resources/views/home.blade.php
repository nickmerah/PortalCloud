@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif

                    <div class="navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto">

                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('students') }}">Student Management</a>
                            </li>



                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('uploadresult') }}">Upload Result Sheet</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('manualresult') }}">Enter Result Scores</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('uploadedresult') }}">Course Results</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('delresult') }}">Delete Results</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('resultsummary') }}"> Result Summary</a>
                            </li>


                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection