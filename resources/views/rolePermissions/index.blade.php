@extends('layouts.app')

@push('styles')
    <!-- DataTables -->
    <link href="/vendor/ubold/assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
    <link href="/vendor/ubold/assets/plugins/custombox/css/custombox.css" rel="stylesheet">
    <link href="/vendor/ubold/assets/plugins/switchery/css/switchery.min.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h4 class="page-title">Roles</h4>

            <ol class="breadcrumb">
                <li>
                    <a href="/">Hệ thống</a>
                </li>

                <li>
                    <a href="{{ route('roles.index') }}">Roles</a>
                </li>

                <li class="active">
                    {{ $role->name }}
                </li>
            </ol>
        </div>
    </div>

    @include('flash-message::default')

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default panel-border">
                <div class="panel-heading">
                    <h3 class="panel-title">Permissions</h3>
                </div>
                <div class="panel-body">
                    {!! Form::open(['route' => ['rolePermissions.update', $role->id], 'method' => 'put', 'role' => 'form']) !!}
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="30%">Name</th>
                            <th>Description</th>
                            <th>Has Access</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($permissions as $permission)
                            <tr>
                                <td>{{ $permission['name'] }}</td>
                                <td>{{ $permission->description }}</td>
                                <td>
                                    <label>
                                        <input type="checkbox"
                                               {{ $role->hasPermission($permission['name']) ? ' checked="checked"' : '' }} data-plugin="switchery" data-color="#81c868" name="permissions[{{ $permission['id'] }}]"
                                               value="1">
                                        <span class="lbl"></span>
                                    </label>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    {!! Form::button('<i class="md md-save"></i> Save', ['type' => 'submit', 'class' => 'btn btn-primary waves-effect waves-light']) !!}

                    {{ Form::close() }}
                </div>
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
    <script src="/vendor/ubold/assets/plugins/switchery/js/switchery.min.js"></script>

@endpush

@push('inline_scripts')
    <script>
        $(function () {
            //
        });
    </script>

@endpush
