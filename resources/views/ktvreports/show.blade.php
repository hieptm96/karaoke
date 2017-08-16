@extends('layouts.app')

@push('styles')
    <!-- DataTables -->
    <link href="/vendor/ubold/assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="/css/custom.css" rel="stylesheet" type="text/css"/>

@endpush

@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="pull-right m-t-15">
                <a href="#songs-report" class="btn btn-default change-report-btn hidden"> Theo bài hát </a>
                <a href="#boxes-report" class="btn btn-default change-report-btn"> Theo đầu máy </a>
            </div>


            <h4 class="page-title">Báo cáo số tiền cần thu của {{ $ktv->name }}</h4>
            <ol class="breadcrumb">
                <li>
                    <a href="#">{{ $ktv->name }}</a>
                </li>
                <li class="active">
                    Thống kê
                </li>
            </ol>
        </div>
    </div>


    <div id="songs-report" class="ktv-report">
        @include('ktvreports.ktv-songs')
    </div>
    <div id="boxes-report" class="ktv-report hidden">
        @include('ktvreports.ktv-boxes')
    </div>

@endsection

@push('scripts')
    <script src="/vendor/ubold/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/vendor/ubold/assets/plugins/datatables/dataTables.bootstrap.js"></script>
    <script src="/vendor/ubold/assets/plugins/datatables/dataTables.responsive.min.js"></script>
    <script src="/vendor/ubold/assets/plugins/datatables/responsive.bootstrap.min.js"></script>

    <script src="/vendor/ubold/assets/plugins/moment/moment.js"></script>
    <script src="/vendor/ubold/assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>

@endpush

@push('inline_scripts')
    <script>
        $('.change-report-btn').on('click', function() {
            var reportId = $(this).attr('href');
            $('.ktv-report').addClass('hidden');
            $(reportId).removeClass('hidden');
            $('.change-report-btn').removeClass('hidden');
            $(this).addClass('hidden');
        });
    </script>
@endpush

