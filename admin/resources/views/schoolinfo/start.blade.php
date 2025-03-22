@extends('apphead')

@section('contents')
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <ul class="breadcrumb breadcrumb-style ">
                        <li class="breadcrumb-item">
                            <h4 class="page-title">Institution Info</h4>
                        </li>
                        <li class="breadcrumb-item bcrumb-1">
                            <a href="{{URL::to('/welcome') }}">
                                <i class="fas fa-home"></i> Home</a>
                        </li>
                        <li class="breadcrumb-item bcrumb-2">
                            <a href="#" onClick="return false;">Settings</a>
                        </li>
                        <li class="breadcrumb-item active">Institution Info</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="body">
                        <form class="form-signin" method="post" action="{{ route('schoolinfo.update', $schoolInfo->skid) }}" autocomplete="off">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <div class="form-label-group">
                                    <input type="text" name="schoolname" class="form-control" value="{{ old('schoolname', $schoolInfo->schoolname) }}" required="required">
                                    <label for="inputEmail"><strong>School Name</strong></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-label-group">
                                    <input type="text" name="schoolabvname" class="form-control" value="{{ old('schoolabvname', $schoolInfo->schoolabvname) }}" required="required">
                                    <label for="inputEmail"><strong>School Abbreviation Name</strong></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-label-group">
                                    <input type="text" name="schooladdress" class="form-control" value="{{ old('schooladdress', $schoolInfo->schooladdress) }}" required="required">
                                    <label for="inputEmail"><strong>School Address</strong></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-label-group">
                                            <input type="email" name="schoolemail" class="form-control" value="{{ old('schoolemail', $schoolInfo->schoolemail) }}" required="required">
                                            <label for="appno"><strong>School Email</strong></label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-label-group">
                                            <input type="text" name="endreg_date" class="form-control" value="{{ old('endreg_date', $schoolInfo->endreg_date) }}" required="required">
                                            <label for="appno"><strong>Registration End Date (<b>MAINTAIN THIS FORMAT</b>)</strong></label>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="form-group">
                                <div class="form-label-group">
                                    <input type="text" name="markuee" class="form-control" value="{{ old('markuee', $schoolInfo->markuee) }}" required="required">
                                    <label for="inputEmail"><strong>Marquee for Regular Students</strong></label>
                                </div>
                            </div>
                            <br>

                            <div><b><u>APPLICANT SETTINGS</u></b></div>
                            <div class="form-group">
                                <div class="form-label-group">
                                    <input type="text" name="appmarkuee" class="form-control" value="{{ old('appmarkuee', $schoolInfo->appmarkuee) }}" required="required">
                                    <label for="inputEmail"><strong>Marquee for Applicants</strong></label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-label-group">
                                    <input type="text" name="appendreg_date" class="form-control" value="{{ old('appendreg_date', $schoolInfo->appendreg_date) }}" required="required">
                                    <label for="inputEmail"><strong>Registration End Date for Applicant (<b>MAINTAIN THIS FORMAT</b>)</strong></label>
                                </div>
                            </div>
                            <br>


                            <input type="submit" name="submit" class="btn btn-primary btn-block" value="UPDATE SCHOOL INFORMATION" onclick="confirm('School Information will be sent for Updating')" style="width: 100%; padding: 9px; background: #1C86EE; color: white; border: 0px; ">




                            <div class="col-lg-12 p-t-20 text-center">

                                <a href="{{URL::to('/welcome') }}" class="btn btn-danger waves-effect">Go Back</a>

                            </div>

                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection