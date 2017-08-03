@extends('layouts.app')

@push('styles')
    <!-- DataTables -->
    <link href="/vendor/ubold/assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
    <link href="/vendor/ubold/assets/plugins/custombox/css/custombox.css" rel="stylesheet">
@endpush

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group pull-right m-t-15">
                <a href="{{ route('permissions.sync') }}" class="btn btn-default waves-effect waves-light"><i class="fa fa-refresh"></i> Đồng bộ </a>
            </div>

            <h4 class="page-title">Quyền truy cập</h4>

            <ol class="breadcrumb">
                <li>
                    <a href="/">Hệ thống</a>
                </li>

                <li class="active">
                    <a href="{{ route('permissions.index') }}">Quyền truy cập</a>
                </li>

            </ol>
        </div>
    </div>

    @include('flash-message::default')

    <div class="row">
        <div class="col-sm-12">
            <div class="card-box table-responsive">
                <h4 class="m-t-0 header-title"><b>Danh sách các quyền</b></h4>
                <p class="text-muted font-13 m-b-30">
                </p>

                <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th width="5%">ID</th>
                        <th>Tên</th>
                        <th>Tên hiển thị</th>
                        <th>Mô tả</th>
                        <th width="5%"></th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($permissions as $permission)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $permission->name }}</td>
                            <td>{{ $permission->display_name }}</td>
                            <td>{{ $permission->description }}</td>
                            <td>
                                <a class="btn btn-primary btn-xs waves-effect waves-light" href="{{ route('permissions.show', $permission->id) }}"><i class="fa fa-edit"></i> Sửa</a>
                            </td>
                        </tr>
                    @endforeach
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
    <script src="/vendor/ubold/assets/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="/vendor/ubold/assets/plugins/parsleyjs/parsley.min.js"></script>
    <!-- Modal-Effect -->
    <script src="/vendor/ubold/assets/plugins/custombox/js/custombox.min.js"></script>
    <script src="/vendor/ubold/assets/plugins/custombox/js/legacy.min.js"></script>

@endpush

@push('inline_scripts')
    <script>
       $(function () {
            //
        });
    </script>

@endpush
