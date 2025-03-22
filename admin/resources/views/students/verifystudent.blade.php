@extends('apphead')

@section('contents')
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <ul class="breadcrumb breadcrumb-style ">
                        <li class="breadcrumb-item">
                            <h4 class="page-title">Search Student</h4>
                        </li>
                        <li class="breadcrumb-item bcrumb-1">
                            <a href="{{ URL::to('/welcome') }}">
                                <i class="fas fa-home"></i> Home</a>
                        </li>
                        <li class="breadcrumb-item bcrumb-2">
                            <a href="#" onClick="return false;">Student</a>
                        </li>
                        <li class="breadcrumb-item active">Search Student</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            <strong>Search</strong> Student
                        </h2>
                    </div>
                    <div class="body">
                        <form method="GET" action="{{ url('verifystudent') }}">
                            @csrf
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="matno" placeholder="Enter Student Number" value="{{ $matno ?? '' }}" autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary waves-effect">Search</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if(isset($searched) && $searched)
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            <strong>View</strong> Student Details
                        </h2>
                    </div>
                    <div class="body">
                        @if (is_null($student))
                        <div class="alert alert-danger">No record found for matriculation number: {{ $matno }}</div>
                        @else
                        <div class="alert">
                            @php
                            $filePath = '/home/prtald/public_html/eportal/storage/app/public/passport/' . $student->std_photo;
                            $fileExists = file_exists($filePath);
                            @endphp

                            @if ($fileExists)
                            <img src="{{ 'https://portal.mydspg.edu.ng/eportal/storage/app/public/passport/' . $student->std_photo }}" width="160" height="200">
                            @else
                            <img src="{{ 'https://portal.mydspg.edu.ng/eportal/public/avatar.jpg' }}" width="100" height="80">
                            @endif
                        </div>
                        <div class="row clearfix">
                            <input name="appid" type="hidden" value="{{ $student->std_id }}" />
                            <div class="col-sm-6">
                                <label for="email_address1">Matriculation Number</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" disabled value="{{ stripslashes($student->matric_no) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="email_address1">Surname</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="surname" required value="{{ stripslashes($student->surname) }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <label for="email_address1">Firstname</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text"
                                            class="form-control"

                                            name="firstname" required="required"
                                            value="{{ stripslashes($student->firstname) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label for="email_address1">Othernames</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text"
                                                    class="form-control"

                                                    name="othernames"
                                                    value="{{ stripslashes($student->othernames) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="email_address1">Gender</label>
                                    <div class="form-group">
                                        <div class="form-line">


                                            <select class="form-control select2" data-placeholder="Select" name="gender" required="required">
                                                <option>{{ stripslashes($student->gender) }}</option>
                                                <option>Male</option>
                                                <option>Female</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection