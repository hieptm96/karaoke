@extends('layouts.app')

@push('styles')
    <!-- DataTables -->
    <link href="/vendor/ubold/assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>

@endpush

@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group pull-right m-t-15">
                <a href="{{ route('ktvs.create') }}"><button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light">Thêm mới </button></a>
            </div>

            <h4 class="page-title">Đơn vị kinh doanh</h4>
            <ol class="breadcrumb">
                <li>
                    <a href="#">KTV</a>
                </li>
                <li class="active">
                    Danh sách đơn vị kinh doanh
                </li>
            </ol>
        </div>
    </div>

    <div class="row" ng-app="ktv-form" ng-controller="ktv-ctl">
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
                        <form class="form-inline" role="form" id="search-form">
                            <div class="form-group">
                                <label class="sr-only" for="">Tên đơn vị kinh doanh</label>
                                <input type="text" id="name-search" class="form-control" placeholder="Tên đơn vị kinh doanh" name="name" />
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="">Số điện thoại</label>
                                <input type="text" id="phone-search" class="form-control" placeholder="Số điện thoại" name="phone" />
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="">Email</label>
                                <input type="text" id="email-search" class="form-control" placeholder="Email" name="email" />
                            </div>
                            <button type="submit" class="btn btn-default waves-effect waves-light m-l-15">Tìm kiếm</button>
                            <div class="form-group">
                                <select name="province" id="province-search" class="form-control" ng-model="province" ng-change="get_districts()">
                                    <option value="">-- Chọn tỉnh -- </option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="district" id="district-search" class="form-control">
                                    <option     value="">-- Chọn Quận/Huyện --</option>
                                    <option ng-repeat="district in districts" value="<% district.id %>"><% district.name %></option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="card-box table-responsive">
                <h4 class="m-t-0 header-title"><b>Danh sách bài hát</b></h4>
                <p class="text-muted font-13 m-b-30">
                </p>

                <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th width="2%">Mã</th>
                        <th>Tên</th>
                        <th>Người đại diện</th>
                        <th>Điện thoại</th>
                        <th width="10%">Email</th>
                        <th width="10%">Địa chỉ</th>
                        <th width="10%">Tỉnh</th>
                        <th width="10%">Quận/Huyện</th>
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
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script src="/js/main.js"></script>

@endpush

@push('inline_scripts')
<script>
    var url = '{{ route('ktvs.getdistricts') }}';
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
                    d.province = $('#province-search').val();
                    d.district = $('#district-search').val();
                }
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'representative', name: 'representative'},
                {data: 'phone', name: 'phone'},
                {data: 'email', name: 'mail'},
                {data: 'address', name: 'address'},
                {data: 'province', name: 'province'},
                {data: 'district', name: 'district'},
            ],
            order: [[2, 'asc']]
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
        $('#province-search').on('change', function(e) {
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