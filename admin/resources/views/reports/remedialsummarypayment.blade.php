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
                            <h4 class="page-title">Reports</h4>
                        </li>
                        <li class="breadcrumb-item bcrumb-1">
                            <a href="{{URL::to('/welcome') }}">
                                <i class="fas fa-home"></i> Home</a>
                        </li>
                        <li class="breadcrumb-item bcrumb-2">
                            <a href="#" onClick="return false;">Remedial Summary Reports</a>
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



                            &nbsp; &nbsp; <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#searchModal">Search Payment<i class="material-icons">search</i> </button>


                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                            <div class="modal fade" id="searchModal" tabindex="-1" role="dialog"
                                aria-labelledby="formModal" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="formModal">Search Payment</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-signin" method="get" action=" " autocomplete="off">

                                                <label for="email_address1">Date From</label>
                                                <div class="form-group">
                                                    <div class="form-line">

                                                        <input type="date"
                                                            class="form-control"
                                                            name="fromdate">
                                                    </div>
                                                </div>

                                                <label for="email_address1">Date To</label>
                                                <div class="form-group">
                                                    <div class="form-line">

                                                        <input type="date"
                                                            class="form-control"

                                                            name="todate">
                                                    </div>
                                                </div>
                                                <br>
                                                <button type="submit"
                                                    class="btn btn-info waves-effect">Search Payment</button>

                                            </form>
                                        </div>
                                        <div class="modal-footer">

                                            <button type="button" class="btn btn-danger waves-effect"
                                                data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        </p>

                    </div>

                    @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ Session::get('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <div class="body">
                        <h5 align="center">Showing Payment from {{ $frommonth->format('M, Y') }} to {{ $tomonth->format('M, Y') }}
                        </h5>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Fee Name</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($paymentReport as $report)
                                    <tr class="odd">
                                        <td class="center">{{$loop->iteration}}</td>
                                        <td>
                                            <a href="{{ route('remedialsummarylist', array_merge(request()->query(), ['fname' => $report?->fee_name])) }}">
                                                {{ $report?->fee_name }}
                                            </a>
                                        </td>
                                        <td>{{ number_format($report?->total_amount) }}</td>


                                        </td>
                                    </tr>@endforeach
                                    <tr class="odd">
                                        <td colspan="1"> </td>
                                        <td> <strong>TOTAL</strong></td>
                                        <td>{{ number_format($totalSum) }}</td>


                                        </td>
                                    </tr>
                                </tbody>

                            </table>
                            <a href="#" id="export-button" class="btn btn-primary">Export Report</a>
                            <script>
                                const currentUrl = window.location.href;
                                const exportButton = document.getElementById('export-button');
                                const url = new URL(currentUrl);
                                url.searchParams.set('export', 'excel');
                                exportButton.href = url.href;
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection