<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>{{ $pageTitle ?? 'Support Portal' }} </title>

    <!-- Plugins Core Css -->
    <link href="{{ asset('css/app.min.css') }}" rel="stylesheet">
    <!-- Custom Css -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <!-- You can choose a theme from css/styles instead of get all themes -->
    <link href="{{ asset('css/styles/all-themes.css') }}" rel="stylesheet" />
</head>

<body class="light">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30">
                <img class="loading-img-spin" src="{{ asset('images/loading.png') }}" alt="admin">
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="#" onClick="return false;" class="navbar-toggle collapsed" data-bs-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="#" onClick="return false;" class="bars"></a>
                <a class="navbar-brand" href="{{URL::to('/welcome') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="" />

                </a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="pull-left">
                    <li>
                        <a href="#" onClick="return false;" class="sidemenu-collapse">
                            <i data-feather="menu"></i>
                        </a>
                    </li>

                </ul>
                <ul class="pull-right">
                    <li>
                        <strong style="font-size:15px">Admin Panel</strong> </strong>
                    </li>

                </ul>

            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <div>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <div class="menu">
                <ul class="list">

                    <li class="header">-- Menu</li>

                    <!-- Dashboard -->
                    <li class="active">
                        <a href="{{URL::to('/welcome') }}">
                            <i data-feather="monitor"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>



                    <!-- Logout -->
                    <li class="active">
                        <a href="{{ URL::to('/logout') }}">
                            <i data-feather="log-out"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>


    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">An Error has Occurred</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="index.html">
                                    <i class="fas fa-home"></i>Home</a>
                            </li>
                            <li class="breadcrumb-item active">Error</li>
                        </ul>
                    </div>
                </div>
            </div>


        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-12">
                <div class="card">
                    <ul class="nav nav-tabs">

                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane body active" id="about">
                            <p class="text-default"><b>Oops! An Error has Occurred!, Contact the System Administrator</b></p>

                            <hr>

                        </div>

                    </div>
                </div>
            </div>
        </div>

        </div>
    </section>
    <script src="{{ asset('js/app.min.js') }}"></script>


    <script src="{{ asset('js/table.min.js') }}"></script>
    <!-- Custom Js -->
    <script src="{{ asset('js/admin.js') }}"></script>

    <script src="{{ asset('js/pages/index.js') }}"></script>
    <script src="{{ asset('js/pages/todo/todo.js') }}"></script>

    <script src="{{ asset('js/pages/tables/jquery-datatable.js') }}"></script>
</body>