@extends('layouts.app')

@push('styles')
    <!-- DataTables -->
    <link href="/vendor/ubold/assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>

@endpush

@php
$user = Auth::user();
@endphp

@section('content')

    @include('ktvs.boxes.box-modal')
   
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">

            @if ($user->can('ktvs.create'))
            <div class="btn-group pull-right m-t-15">
                <a href="" data-toggle="modal" data-target="#add-box-modal"><button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light"><i class="md md-add"></i> Thêm mới </button></a>
            </div>
            @endif

            <h4 class="page-title">Danh mục đơn vị kinh doanh</h4>
            <ol class="breadcrumb">
                <li>
                    <a href="#">Đơn vị kinh doanh</a>
                </li>
                <li class="active">
                    Danh sách
                </li>
            </ol>
        </div>
    </div>

    @include('flash-message::default')

    @include('common.request_errors')

    <div class="row">
        <div class="col-md-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="row form-inline" role="form" id="search-form">

                            <button type="submit" class="btn btn-default waves-effect waves-light m-l-15">Tìm kiếm</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="card-box table-responsive">
                <h4 class="m-t-0 header-title"><b>Danh sách đơn vị kinh doanh</b></h4>
                <p class="text-muted font-13 m-b-30">
                </p>

                <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th width="10%">Mã</th>
                        <th>Thông tin</th>
                        <th width="15%"></th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="/vendor/ubold/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/vendor/ubold/assets/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="/vendor/ubold/assets/plugins/datatables/dataTables.responsive.min.js"></script>
<script src="/vendor/ubold/assets/plugins/datatables/responsive.bootstrap.min.js"></script>
<script src="/js/custom.js"></script>

@endpush

@push('inline_scripts')
<script>
    var dataSet = [['123', '123', '1232', '232'], ['343', '43434', '323', '32']];
    $(function () {
        var datatable = $("#datatable").DataTable({
            searching: false,
            // serverSide: true,
            // processing: true,
            "columnDefs": [ {
                "data": null,
                "defaultContent": '<a class="btn btn-primary btn-xs edit-box waves-effect waves-light" data-toggle="modal" data-target="#edit-box-modal"><i class="fa fa-edit"></i> Sửa</a>'
                        + ' <a class="delete-box btn btn-default btn-xs waves-effect waves-light" data-toggle="modal" data-target="#delete-box-modal"><i class="fa fa-trash"></i> Xóa</a>',
                "targets": -1,
                orderable: false
            },
            {
                "targets": 0,
                "className": "box-code"
            },
            {
                "targets": 1,
                "className": "box-info"
            } ],
            data: dataSet,
            // ajax: {
            //     url: "{!! route('ktvs.datatables') !!}",
            //     data: function (d) {
            //         d.name = $('#name-search').val();
            //         d.phone = $('#phone-search').val();
            //         d.email = $('#email-search').val();
            //         d.province = $('#province').val();
            //         d.district = $('#district-search').val();
            //     }
            // },
            // columns: [
            //     {data: 'id', name: 'id'},
            //     {data: 'name', name: 'name'},
            //     {data: 'representative', name: 'representative'},
            // ],
            order: [[0, 'asc']]
        });

        $('#name-search').on('keyup', function(e) {
            datatable.draw();
            e.preventDefault();
        });
        $('#phone-search').on('keyup', function(e) {
            datatable.draw();
            e.preventDefault();
        });
        $('#email-search').on('keyup', function(e) {
            datatable.draw();
            e.preventDefault();
        });
        $('#province').on('change', function(e) {
            datatable.draw();
            e.preventDefault();
        });
        $('#district-search').on('change', function(e) {
            datatable.draw();
            e.preventDefault();
        });
    });
</script>

@endpush
