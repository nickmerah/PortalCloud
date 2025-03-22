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
                            <a href="#" onClick="return false;">Admission List</a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">




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

                    @php
                    $successCount = 0;
                    $errorCount = 0;
                    @endphp
                    <div class="body">
                        <form id="editForm" class="form-signin" method="POST" action="{{ route('admitapplicant') }}" enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example contact_list">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>AppliedCourse</th>
                                            <th>AdmittedCourse</th>
                                            <th>Course</th>
                                            <th>Remark</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($admitted as $admit)
                                        @php
                                        $applicant = $admit->applicant;

                                        // Skip if $applicant is null or has no stdprogramme_id
                                        if (is_null($applicant) || is_null($applicant->stdprogramme_id)) {
                                        continue;
                                        }

                                        $filteredCourses = $courses->where('prog_id', $applicant->stdprogramme_id);
                                        $programmeOption = $applicant->deptOption->programme_option ?? 'N/A';
                                        @endphp
                                        <tr class="odd">
                                            <td class="center">{{$loop->iteration}}</td>
                                            <td>{{ $admit->appno }}</td>
                                            <td>{{ $admit->applicant->deptOption->programme_option }}</td>
                                            <td>{{ $admit->course}}
                                                @php

                                                $isMatch = false;
                                                $closeMatch = null;
                                                $minDistance = null;


                                                foreach ($filteredCourses as $course) {
                                                $distance = levenshtein(strtolower($admit->course), strtolower($course->programme_option));

                                                // Set a threshold, for example, distance of 5 or less is considered a match
                                                if ($minDistance === null || $distance < $minDistance) {
                                                    $minDistance=$distance;
                                                    $closestMatch=$course->programme_option;
                                                    $closestCourseId = $course->do_id;
                                                    }
                                                    }

                                                    if ($minDistance <= 10) {
                                                        // Consider this a close match if within the threshold
                                                        $closeMatch=$closestMatch;
                                                        }


                                                        $isSame=$closeMatch===$admit->course;
                                                        // Increment counters
                                                        if ($isSame) {
                                                        $successCount++;
                                                        $resultText = 'Same';
                                                        $isMatch = true;
                                                        } else {
                                                        $errorCount++;
                                                        $resultText = 'Changed';
                                                        }
                                                        @endphp


                                            </td>
                                            <td>{{ $closeMatch ?? 'N/A' }}</td>
                                            <td>
                                                {{ $resultText }}
                                                @if ($isSame)
                                                <input type="hidden" name="hidden_field[{{ $admit->appno }}]" value="{{ $admit->appno }}">
                                                <input type="hidden" name="cosId[{{ $admit->appno }}]" value="{{ $closestCourseId }}">
                                                @endif
                                            </td>
                                            <td>
                                                @if ($isMatch)
                                                <span class="text-success">OK</span>
                                                @else
                                                <span class="text-danger">NOT OK</span>
                                                <input type="hidden" name="appno[{{ $admit->appno }}]" value="{{ $admit->appno }}">
                                                <input type="hidden" name="cosId[{{ $admit->appno }}]" value="{{ $closestCourseId }}">
                                                <input type="hidden" name="cos[{{ $admit->appno }}]" value="{{ $closestMatch }}">
                                                @endif
                                                @if ($closeMatch)
                                                <div>
                                                    <strong>Close Match:</strong> {{ $closestMatch }}
                                                </div>
                                                @endif
                                            </td>
                                        </tr>@endforeach
                                    </tbody>

                                </table>
                                <div>
                                    <p>Same Course: {{ $successCount }}</p>
                                    <p>Changed Course: {{ $errorCount }}</p>

                                    <button type="submit" name="action" value="admit" class="btn btn-success waves-effect" data-bs-dismiss="modal">Admit Successful</button>
                                    <button type="submit" name="action" value="resolve_errors" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Resolve Errors({{ $errorCount }}) </button>

                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
@endsection