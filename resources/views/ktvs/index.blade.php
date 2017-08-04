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
                                <input type="text" id="name-search" class="form-control" placeholder="Tên đơn vị kinh doanh" name="name" />
                                <input type="text" id="phone-search" class="form-control" placeholder="Số điện thoại" name="phone" />
                                <input type="text" id="email-search" class="form-control" placeholder="Email" name="email" />
                                <select name="province" id="province" class="form-control" ng-model="province" ng-change="get_districts(province)">
                                    <option value="">-- Chọn tỉnh -- </option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                                    @endforeach
                                </select>
                                <select name="district" id="district-search" class="form-control">
                                    <option     value="">-- Chọn Quận/Huyện --</option>
                                    <option ng-repeat="district in districts" value="<% district.id %>"><% district.name %></option>
                                </select>

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
                            <th width="2%">Mã</th>
                            <th width="10%">Tên</th>
                            <th>Người đại diện</th>
                            <th>Điện thoại</th>
                            <th width="10%">Email</th>
                            <th width="10%">Địa chỉ</th>
                            <th width="10%">Tỉnh</th>
                            <th width="10%">Quận/Huyện</th>
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
    <form id="ktv-delete-form" method="POST" action="">
        {{ csrf_field() }}
        {{ method_field('delete') }}
    </form>
@endsection

@push('scripts')
<script src="/vendor/ubold/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/vendor/ubold/assets/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="/vendor/ubold/assets/plugins/datatables/dataTables.responsive.min.js"></script>
<script src="/vendor/ubold/assets/plugins/datatables/responsive.bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script src="/js/main.js"></script>

@endpush

@push('inline_scripts')
<script>
    var url = '{{ route('ktvreports.getdistricts') }}';
    $(function () {
        var datatable = $("#datatable").DataTable({
            searching: false,
            serverSide: true,
            processing: true,
            ajax: {
                url: "{!! route('ktvs.datatables') !!}",
                data: function (d) {
                    d.name = $('#name-search').val();
                    d.phone = $('#phone-search').val();
                    d.email = $('#email-search').val();
                    d.province = $('#province').val();
                    d.district = $('#district-search').val();
                }
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'representative', name: 'representative'},
                {data: 'phone', name: 'phone'},
                {data: 'email', name: 'email'},
                {data: 'address', name: 'address'},
                {data: 'province', name: 'province_id'},
                {data: 'district', name: 'district_id'},
                {data: 'actions', name: 'actions', orderable: false, searchable: false},
            ],
            order: [[1, 'asc']]
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
