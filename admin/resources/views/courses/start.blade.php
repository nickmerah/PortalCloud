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
                            <h4 class="page-title">Courses</h4>
                        </li>
                        <li class="breadcrumb-item bcrumb-1">
                            <a href="{{URL::to('/welcome') }}">
                                <i class="fas fa-home"></i> Home</a>
                        </li>
                        <li class="breadcrumb-item bcrumb-2">
                            <a href="#" onClick="return false;">Courses</a>
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

                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Course<i class="material-icons">add</i> </button>
                            &nbsp; <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#searchModal">Search Record<i class="material-icons">search</i> </button>
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h5 class="modal-title" id="formModal">Add New</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-signin" method="post" enctype="multipart/form-data" action="{{ route('uploadcourses') }}" autocomplete="off">
                                                @csrf
                                                <label for="email_address1">Programme Type</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select name="programmet_id" class="form-control">
                                                            <option value="">Select Programme Type</option>
                                                            @foreach($programmeTypes as $programmeType)
                                                            <option value="{{ $programmeType->programmet_id }}">{{ $programmeType->programmet_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

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

                                                <label for="email_address1">Level Name</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select name="level_id" id="level_id" class="form-control">
                                                            <option value="">Select Level</option>
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

                                                <label for="csv_file">Select Course list file in .csv file</label>
                                                <div class="form-group">
                                                    <input type="file" name="csv_file" accept=".csv" required>
                                                </div>

                                                <button type="submit" class="btn btn-info waves-effect">Upload</button>

                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="{{ url('/courses-csv') }}" class="btn btn-success waves-effect">Download Template</a>
                                            <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Cancel</button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="formModal">Search Courses</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="GET" action="{{ route('courses.index') }}">
                                                <label for="email_address1">Programme Type</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select name="programmet_id" class="form-control">
                                                            <option value="">Select Programme Type</option>
                                                            @foreach($programmeTypes as $programmeType)
                                                            <option value="{{ $programmeType->programmet_id }}">{{ $programmeType->programmet_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <label for="email_address1">Programme</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select name="programme_id" id="programme-search" class="form-control">
                                                            <option value="">Select Programme</option>
                                                            @foreach($programmes as $programme)
                                                            <option value="{{ $programme->programme_id }}">{{ $programme->programme_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <label for="email_address1">Level Name</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select name="level_id" id="level_id-search" class="form-control">
                                                            <option value="">Select Level</option>
                                                        </select>

                                                    </div>
                                                </div>

                                                <label for="email_address1">Course of Study</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select name="cos" id="course-of-study-search" class="form-control">
                                                            <option value="">Select Course of Study</option>
                                                        </select>
                                                    </div>
                                                    <div id="loader-search" style="display: none; margin-top: 5px; font-style: italic; color: gray;">Loading...</div>
                                                </div>


                                                <br>
                                                <button type="submit" class="btn btn-info waves-effect">Search Course</button>

                                            </form>
                                        </div>
                                        <div class="modal-footer">

                                            <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                    updateDropdown('#programme', '#level_id', "{{ url('/get-level/:id') }}");

                                    updateDropdown('#programme-search', '#course-of-study-search', "{{ url('/get-cos/:id') }}", '#loader-search');
                                    updateDropdown('#programme-search', '#level_id-search', "{{ url('/get-level/:id') }}");
                                });
                            </script>
                            <!--edit -->
                            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="formModal">Edit Course</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="editForm" class="form-signin" method="POST" action="" autocomplete="off">
                                                @csrf
                                                @method('PUT')

                                                <label for="email_address1">Course Title</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" id="ectitle" name="ctitle" required="required">
                                                    </div>
                                                </div>

                                                <label for="email_address1">Course Code</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" id="ecode" name="ccode" required="required">
                                                    </div>
                                                </div>

                                                <label for="email_address1">Course Unit</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" id="ecunit" name="cunit" required="required">
                                                    </div>
                                                </div>

                                                <label for="email_address1">Level Name</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select id="elevel_id" name="level_id" class="form-control" required>
                                                            <option value="">Select Level</option>
                                                            @foreach($levels as $level)
                                                            <option value="{{ $level->level_id }}">{{ $level->level_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <label for="email_address1">Programme</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select id="eprogramme_id" name="programme_id" class="form-control" required>
                                                            <option value="">Select Programme</option>
                                                            @foreach($programmes as $programme)
                                                            <option value="{{ $programme->programme_id }}">{{ $programme->programme_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <label for="email_address1">Programme Type</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select id="eprogrammet_id" name="programmet_id" class="form-control" required>
                                                            <option value="">Select Programme Type</option>
                                                            @foreach($programmeTypes as $programmeType)
                                                            <option value="{{ $programmeType->programmet_id }}">{{ $programmeType->programmet_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <label for="email_address1">Course of Study</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select id="ecos" name="cos" class="form-control" required>
                                                            <option value="">Select Course of Study</option>
                                                            @foreach($courseofstudy as $cos)
                                                            <option value="{{ $cos->do_id }}">{{ $cos->programme_option }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>


                                                <label for="email_address1">Semester</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select id="esemester" name="semester" class="form-control" required>
                                                            <option value="">Select Semester</option>
                                                            <option value="First Semester">First Semester</option>
                                                            <option value="Second Semester">Second Semester</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <input type="hidden" class="form-control" id="ethecourse_id" name="thecourse_id" required="required">
                                                <br>
                                                <button type="submit" class="btn btn-info waves-effect">Update</button>

                                            </form>
                                        </div>
                                        <div class="modal-footer">

                                            <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end edit -->
                        </div>
                        </p>



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
                        <div class="table-responsive">
                            <table class="table table-hover js-basic-example contact_list" style="font-size:12px">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th>Unit</th>
                                        <th>Dept</th>
                                        <th>Level</th>
                                        <th>Semester</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($courses as $course)
                                    <tr class="odd">
                                        <td class="center">{{$loop->iteration}}</td>
                                        <td>{{ $course->thecourse_title }}</td>
                                        <td>{{ $course->thecourse_code}}</td>
                                        <td>{{ $course->thecourse_unit}}</td>
                                        <td>{{ $course->deptOption->programme_option}}</td>
                                        <td>{{ $course->level->level_name}}</td>
                                        <td>{{ $course->semester}}</td>
                                        <td>
                                            <?php if ($showdelete) {  ?>
                                                <button data-bs-toggle="modal" data-id="{{ $course->thecourse_id }}" id="fieldEdit" class="btn btn-success edit">
                                                    <i class="material-icons">create</i>
                                                </button>

                                                <button class="btn btn-danger" onclick="deleteCourse({{ $course->thecourse_id }}, '{{ $course->thecourse_code }}')">
                                                    <i class="material-icons">delete</i>
                                                </button>

                                            <?php } ?>
                                        </td>
                                    </tr>@endforeach
                                </tbody>

                            </table>

                            <script type="text/javascript">
                                $(document).on('click', '#fieldEdit', function(e) {
                                    e.preventDefault();

                                    var thecourse_id = $(this).data('id');
                                    let _token = $('meta[name="csrf-token"]').attr('content');

                                    $.ajax({
                                        url: "{{ url('courses') }}/" + thecourse_id,
                                        type: "GET",
                                        data: {
                                            thecourse_id: thecourse_id,
                                            _token: _token
                                        },
                                        success: function(response) {
                                            $('#editModal').modal('show');
                                            if (response.done) {
                                                $('#ethecourse_id').val(response.data.thecourse_id);
                                                $('#ectitle').val(response.data.thecourse_title);
                                                $('#ecode').val(response.data.thecourse_code);
                                                $('#ecunit').val(response.data.thecourse_unit);
                                                $('#elevel_id').val(response.data.levels);
                                                $('#esemester').val(response.data.semester);
                                                $('#eprogramme_id').val(response.data.prog);
                                                $('#eprogrammet_id').val(response.data.prog_type);
                                                $('#ecos').val(response.data.stdcourse);
                                                $('#editForm').attr('action', "{{ url('courses') }}/" + thecourse_id);
                                            } else {
                                                $('.edit_response').html('<div class="alert bg-danger alert-dismissable" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em>' + response.data + '</div>');
                                            }
                                        },
                                        error: function(response) {
                                            $('.edit_response').html('<div class="alert bg-danger alert-dismissable" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em>An error occurred while processing your request.</div>');
                                        }
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function deleteCourse(cid, cname) {
        var confirmation = confirm(`You are about to delete the course ${cname}, click OK to continue or Cancel to abort.`);
        if (confirmation) {

            fetch(`{{ url('/deletecourse/') }}/${cid}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Something went wrong!');
                });
        }
    }
</script>
@endsection