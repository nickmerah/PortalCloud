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
                            <a href="#" onClick="return false;">Students Fee Reports</a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">

                    @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ Session::get('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <div class="body">
                        <h5 align="center">Showing Payment for {{ $paymentReport[0]?->trans_name ?? 'Fees' }} for {{ $progtype ?? 'FT and PT' }}, {{ $prog ?? 'ND and HND' }}
                        </h5>
                        <div class="table-responsive">
                            <table class="table table-hover js-basic-example contact_list">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Matriculation No</th>
                                        <th>Student Name</th>
                                        <th>Fee Name</th>
                                        <th>Fee Type</th>
                                        <th>RRR</th>
                                        <th>Amount</th>
                                        <th>Date Paid</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($paymentReport as $report)
                                    <tr class="odd">
                                        <td class="center">{{$loop->iteration}}</td>
                                        <td>{{ $report?->appno }}</td>
                                        <td>{{ $report?->fullnames }}</td>
                                        <td>{{ $report?->trans_name }}</td>
                                        <td>{{ $report?->fee_type == 'fees' ? 'Fees' : 'Other Fees' }}</td>
                                        <td>{{ $report?->rrr }}</td>
                                        <td>{{ number_format($report?->trans_amount) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($report?->t_date)->format('jS F, Y')  }}</td>
                                        </td>
                                    </tr>@endforeach
                                    <tr class="odd">
                                        <td colspan="4"> </td>
                                        <td> <strong>TOTAL</strong></td>
                                        <td>{{ number_format($totalSum) }}</td>

                                        <td>
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <a href="#" id="export-button" class="btn btn-warning">Export Report</a>
                            <script>
                                const currentUrl = window.location.href;
                                const exportButton = document.getElementById('export-button');
                                const url = new URL(currentUrl);
                                url.searchParams.set('export', 'excel');
                                exportButton.href = url.href;
                            </script>
                            <a href="{{ url()->previous() ?: route('fallbackRoute') }}" class="btn btn-success">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection