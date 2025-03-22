@extends('apphead')

@section('contents')
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <ul class="breadcrumb breadcrumb-style ">
                        <li class="breadcrumb-item">
                            <h4 class="page-title">Dashboard</h4>
                        </li>
                        <li class="breadcrumb-item bcrumb-1">
                            <a href="{{URL::to('/dashboard') }}">
                                <i class="fas fa-home"></i> Home</a>
                        </li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-12">
                <div class="card">
                    <ul class="nav nav-tabs">
                        <li class="nav-item m-l-10">
                            <a class="nav-link active" data-bs-toggle="tab" href="#about">Restricted</a>
                        </li>

                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane body active" id="about">
                            <p class="text-default"> You are not authorized to view this feature</p>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>
</section>
@endsection