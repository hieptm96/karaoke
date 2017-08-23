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
    <div ng-app="ktv-form" ng-controller="ktv-ctl">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">

                @if ($user->can('ktvs.create'))
                <div class="btn-group pull-right m-t-15">
                    <a href="{{ route('ktvs.create') }}"><button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light"><i class="md md-add"></i> Thêm mới </button></a>
                </div>
                @endif

                <h4 class="page-title">Danh mục thành viên</h4>
                <ol class="breadcrumb">
                    <li>
                        <a href="#">Thành viên</a>
                    </li>
                    <li class="active">
                        Danh sách
                    </li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                @if (session()->has('flash_message'))
                    <div class="alert alert-{{ session('flash_message.level') }} alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>{!! session('flash_message.message') !!}</strong>
                    </div>
                @endif
            </div>
            <div class="col-md-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col-sm-12">
                            <form class="row form-inline" role="form" id="search-form">
                                <input type="text" id="name-search" class="form-control" placeholder="Tên thành viên" name="name" />
                                <input type="text" id="email-search" class="form-control" placeholder="Email" name="email" />
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
                    <h4 class="m-t-0 header-title"><b>Danh sách thành viên</b></h4>
                    <p class="text-muted font-13 m-b-30">
                    </p>

                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th width="2%">Mã</th>
                            <th width="10%">Tên</th>
                            <th width="10%">Email</th>
                            <th width="20%">Quyền</th>
                            <th width="9%">#</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <form id="user-delete-form" method="POST" action="">
        {{ csrf_field() }}
        {{ method_field('delete') }}
    </form>
@endsection

@push('scripts')
<script src="/vendor/ubold/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/vendor/ubold/assets/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="/vendor/ubold/assets/plugins/datatables/dataTables.responsive.min.js"></script>
<script src="/vendor/ubold/assets/plugins/datatables/responsive.bootstrap.min.js"></script>

@endpush

@push('inline_scripts')
<script>
    $(function () {
        $.fn.dataTable.ext.errMode = 'none';
        var datatable = $("#datatable").DataTable({
            searching: false,
            serverSide: true,
            processing: true,
            ajax: {
                url: "{!! route('users.datatables') !!}",
                data: function (d) {
                    d.name = $('#name-search').val();
                    d.email = $('#email-search').val();
                }
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'role', name: 'role'},
                {data: 'actions', name: 'actions', orderable: false, searchable: false},
            ],
            order: [[0, 'asc']]
        });

        $('#name-search').on('keyup', function(e) {
            datatable.draw();
            e.preventDefault();
        });
        $('#email-search').on('keyup', function(e) {
            datatable.draw();
            e.preventDefault();
        });
    });
</script>

@endpush
