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
                            <h4 class="page-title">Admissions</h4>
                        </li>
                        <li class="breadcrumb-item bcrumb-1">
                            <a href="{{URL::to('/welcome') }}">
                                <i class="fas fa-home"></i> Home</a>
                        </li>
                        <li class="breadcrumb-item bcrumb-2">
                            <a href="#" onClick="return false;">Admitted List</a>
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

                            @php
                            $userData = session('user_data');
                            if ($userData) {
                            $decryptedUserData = json_decode(Crypt::decryptString($userData), true);
                            }
                            @endphp
                            @if ($decryptedUserData['uGroup'] == 1)
                            &nbsp;
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#admissionModal">Change Admission Department<i class="material-icons">file_upload</i> </button>

                            @endif
                            <div class="modal fade" id="admissionModal" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="formModal">Upload List</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-signin" method="post" enctype="multipart/form-data" action="{{ url('uploaddeptchangelist') }}">
                                                @csrf

                                                <label for="email_address1">Programme</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select name="programme_id" id="programme" class="form-control">
                                                            <option value="">Select Programme</option>
                                                            @foreach($programmes as $programme)
                                                            <option value="{{ $programme->programme_id }}">{{ $programme->programme_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <label for="email_address1">Course of Study</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select name="cos" id="course-of-study" class="form-control">
                                                            <option value="">Select Course of Study</option>
                                                        </select>
                                                    </div>
                                                    <div id="loader" style="display: none; margin-top: 5px; font-style: italic; color: gray;">Loading...</div>
                                                </div>



                                                <label for="csv_file">Select Admission list file in .csv file</label>

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
                                            <a href="{{ url('/download-admission-csv') }}" class="btn btn-success waves-effect">Download Template</a>
                                            <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </p>

                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script>
                                function updateDropdown(triggerSelector, targetSelector, apiUrl, loaderSelector = null) {
                                    $(triggerSelector).change(function() {
                                        const id = $(this).val();
                                        $(targetSelector).empty().append('<option value="">Select</option>');

                                        if (id) {
                                            if (loaderSelector) {
                                                $(loaderSelector).show();
                                            }

                                            $.ajax({
                                                url: apiUrl.replace(':id', id),
                                                type: "GET",
                                                cache: false,
                                                dataType: "json",
                                                success: function(data) {
                                                    let sortedData = Object.entries(data).sort((a, b) => a[1].localeCompare(b[1]));

                                                    sortedData.forEach(([key, value]) => {
                                                        $(targetSelector).append(`<option value="${key}">${value}</option>`);
                                                    });
                                                },
                                                error: function() {
                                                    alert("Failed to load data.");
                                                },
                                                complete: function() {
                                                    if (loaderSelector) {
                                                        $(loaderSelector).hide();
                                                    }
                                                }
                                            });
                                        }
                                    });
                                }

                                // Update script for both forms
                                $(document).ready(function() {
                                    updateDropdown('#programme', '#course-of-study', "{{ url('/get-cos/:id') }}", '#loader');
                                    updateDropdown('#programme-search', '#course-of-study-search', "{{ url('/get-cos/:id') }}", '#loader-search');
                                });
                            </script>

                        </div>

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
                            <form id="editForm" class="form-signin" method="POST" action="{{ route('admitapplicant') }}" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                <div class="table-responsive">
                                    <table class="table table-hover js-basic-example contact_list">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Application Number</th>
                                                <th>Course</th>
                                                <th>Adm Status</th>
                                                <th>Clearance Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($admitted as $applicant)
                                            @php

                                            // Skip if $applicant is null or has no stdprogramme_id
                                            if (is_null($applicant) || is_null($applicant->stdprogramme_id)) {
                                            continue;
                                            }
                                            @endphp
                                            <tr class="odd">
                                                <td class="center">{{$loop->iteration}}</td>
                                                <td>{{ stripslashes($applicant->surname) }} {{ stripslashes($applicant->firstname) }} {{ stripslashes($applicant->othername) }}</td>
                                                <td>{{ $applicant->app_no }}</td>
                                                <td>{{ $applicant->deptOption->programme_option }}</td>
                                                <td><b style="color: {{ $applicant->adm_status == 1 ? 'green' : 'red' }}">
                                                        {{ $applicant->adm_status == 1 ? 'Admitted' : 'Not Admitted' }}
                                                    </b></td>
                                                <td> <b style="color: {{ $applicant->eclearance == 1 ? 'green' : 'red' }}">
                                                        {{ $applicant->eclearance == 1 ? 'Cleared' : 'Not Cleared' }}
                                                    </b></td>
                                            </tr>@endforeach
                                        </tbody>

                                    </table>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection