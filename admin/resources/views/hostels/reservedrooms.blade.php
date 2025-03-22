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
                            <h4 class="page-title">Hostel Rooms</h4>
                        </li>
                        <li class="breadcrumb-item bcrumb-1">
                            <a href="{{URL::to('/welcome') }}">
                                <i class="fas fa-home"></i> Home</a>
                        </li>
                        <li class="breadcrumb-item bcrumb-2">
                            <a href="{{ route('hostels.index') }}"> {{ $room->room_name }}</a>
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
                    <div class="body">
                        <div class="table-responsive">
                            <!-- Room Information -->
                            <h2>Room Details</h2>
                            <p><strong>Room ID:</strong> {{ $room->roomid }}</p>
                            <p><strong>Room Name:</strong> {{ $room->roomno }}</p>
                            <p><strong>Status:</strong> {{ $room->room_status == 0 ? 'Reserved' : 'Available' }}</p>
                            <p><strong>Capacity:</strong> {{ $room->capacity }}</p>

                            <!-- Student Information -->
                            <h3>Reserved Students</h3>
                            @if($students->isEmpty())
                            <p>No students reserved this room.</p>
                            @else
                            <table class="table table-hover js-basic-example contact_list">
                                <thead>
                                    <tr>
                                        <th>Matric Number</th>
                                        <th>Surname</th>
                                        <th>Firstname</th>
                                        <th>Gender</th>
                                        <th>Allocation Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $student)
                                    <tr>
                                        <td>{{ $student->matric_no }}</td>
                                        <td>{{ $student->surname }}</td>
                                        <td>{{ $student->firstname }}</td>
                                        <td>{{ $student->gender }}</td>
                                        <td>
                                            @if($student->is_allocated)
                                            Allocated
                                            @else
                                            Not Allocated
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif

                            <a href="{{ route('activehostels.rooms', ['hostel' => $room->hostelid]) }}">
                                << Back to Room: {{ $room->roomno }}
                                    </a>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection