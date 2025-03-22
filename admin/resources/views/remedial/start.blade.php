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
                            <h4 class="page-title">All Remedial Students</h4>
                        </li>
                        <li class="breadcrumb-item bcrumb-1">
                            <a href="{{URL::to('/welcome') }}">
                                <i class="fas fa-home"></i> Home</a>
                        </li>
                        <li class="breadcrumb-item bcrumb-2">
                            <a href="#" onClick="return false;">Remedial Students</a>
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


                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#admissionModal">Upload List<i class="material-icons">file_upload</i> </button>


                            <div class="modal fade" id="admissionModal" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="formModal">Upload Remedial List</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-signin" method="post" enctype="multipart/form-data" action="{{ route('uploadremediallist') }}">
                                                @csrf

                                                <label for="csv_file">Select Remedial list file in .csv file</label>

                                                <div class="form-group">

                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <input type="file" name="csv_file" accept=".csv" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <br>
                                                <button type="submit" class="btn btn-info waves-effect">Upload List</button>

                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="{{ url('/download-remedial-csv') }}" class="btn btn-success waves-effect">Download Template</a>
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
                                            <th class="center">Level</th>
                                            <th class="center"> Session </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $student)
                                        <tr class="odd gradeX">
                                            <td class="center">{{$loop->iteration}}</td>
                                            <td class="center">{{ $student->matno }}</td>
                                            <td class="center">{{ stripslashes($student->surname) }} {{ stripslashes($student->firstname) }} {{ stripslashes($student->othername) }}</td>
                                            <td class="center">{{ $student->level ?? 'N/A' }} </td>
                                            <td class="center">{{ $student->sess }}/{{ $student->sess + 1}} </td>

                                        </tr>


                                        @endforeach


                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection