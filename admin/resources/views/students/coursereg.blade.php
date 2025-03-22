@extends('apphead')

@section('contents')
<script src="{{ asset('js/jquery.min.js') }}"></script>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <ul class="breadcrumb breadcrumb-style ">
                        <li class="breadcrumb-item">
                            <h4 class="page-title"> Students</h4>
                        </li>
                        <li class="breadcrumb-item bcrumb-1">
                            <a href="{{URL::to('/welcome') }}">
                                <i class="fas fa-home"></i> Home</a>
                        </li>
                        <li class="breadcrumb-item bcrumb-2">
                            <a href="#" onClick="return false;">Course Registration</a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">

                        <p>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#searchModal">Search Record<i class="material-icons">search</i> </button>

                            <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="formModal">Search Students</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="GET" action="{{ route('coursereg') }}">
                                                <label for="email_address1">Matriculation No</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" name="matric_no" value="{{ request('matric_no') }}">
                                                    </div>
                                                </div>

                                                <label for="email_address1">Surname</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" name="surname" value="{{ request('surname') }}">
                                                    </div>
                                                </div>
                                                <br>
                                                <button type="submit" class="btn btn-info waves-effect">Search Student</button>

                                            </form>
                                        </div>
                                        <div class="modal-footer">

                                            <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            </p>

                        </div>
                        @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        @if ($errors->any())

                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <div class="body">
                            <div class="table-responsive">

                                <table class="table table-hover js-basic-example contact_list" style="font-size:12px">
                                    <thead>
                                        <tr>
                                            <th class="center">#</th>
                                            <th class="center"> Matriculation No </th>
                                            <th class="center"> Fullnames </th>
                                            <th class="center">Course of Study</th>
                                            <th class="center"> Programme </th>
                                            <th class="center"> Level </th>
                                            <th class="center"> Actions </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $student)
                                        <tr class="odd gradeX">
                                            <td class="table-img center">

                                                @php
                                                $filePath = '/home/prtald/public_html/eportal/storage/app/public/passport/' . $student->std_photo;
                                                $fileExists = file_exists($filePath);
                                                @endphp

                                                @if ($fileExists)
                                                <img src="{{ 'https://portal.mydspg.edu.ng/eportal/storage/app/public/passport/' . $student->std_photo }}" width="100" height="80">
                                                @else
                                                <img src="{{ 'https://portal.mydspg.edu.ng/eportal/public/avatar.jpg' }}" width="100" height="80">
                                                @endif

                                            </td>
                                            <td class="center">{{ $student->matric_no }}</td>
                                            <td class="center">{{ stripslashes($student->surname) }} {{ stripslashes($student->firstname) }} {{ stripslashes($student->othername) }}</td>
                                            <td class="center">{{ $student->stdcourseOption->programme_option ?? 'N/A' }}

                                                <input id="smode{{$student->std_id}}" type="hidden" value="{{ $student->std_id }}" />

                                            </td>
                                            <td class="center"> {{ $student->programme->aprogramme_name ?? 'N/A' }} {{ $student->programmeType->programmet_aname ?? 'N/A' }} </td>
                                            <td class="center">

                                                {{ $student->level->level_name ?? 'N/A' }}

                                            </td>
                                            <td class="center">
                                                <a href="{{URL::to('/courseview/'.$student->std_id) }}" class="btn btn-tbl-edit">
                                                    <i class="material-icons">visibility</i>
                                                </a>

                                            </td>
                                        </tr>


                                        @endforeach


                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>
                                <div>
                                    {{ $students->appends(request()->query())->links('vendor.pagination.minimal') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection