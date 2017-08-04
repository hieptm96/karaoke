@extends('layouts.app')

@push('styles')
    <link href="/vendor/ubold/assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
    <link href="/vendor/ubold/assets/plugins/custombox/css/custombox.css" rel="stylesheet">
@endpush

@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="page-title">Cập nhật roles</h4>
            <ol class="breadcrumb">
                <li>
                    <a href="/">Hệ thống</a>
                </li>
                <li>
                    <a href="{{ route('roles.index') }}">Roles</a>
                </li>
                <li class="active">
                    Cập nhật
                </li>
            </ol>
        </div>
    </div>

    @if (session()->has('flash_message'))
        <div class="alert alert-{{ session('flash_message.level') }} alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>{!! session('flash_message.message') !!}</strong>
        </div>
    @endif


    <div class="row">
        <div class="col-sm-12">
            <div class="card-box table-responsive">
                <h4 class="m-t-0 header-title"><b>Cập nhật roles</b></h4>

                <form class="form-horizontal" method="post" action="{{ route('roles.update', $role->id) }}" role="form"  data-parsley-validate novalidate>
                    {{ method_field('PUT') }}
                    <input type="hidden" value="{{ csrf_token() }}" name="_token">

                    <div class="form-group">
                        <label for="input-name" class="col-sm-2 control-label">Tên <span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <input type="text" name="name" value="{{ $role->name }}" class="form-control" id="input-name" placeholder="" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="input-name" class="col-sm-2 control-label">Hiển thị </label>
                        <div class="col-sm-4">
                            <input type="text" name="display_name" value="{{ $role->display_name }}" class="form-control" id="input-name" placeholder="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="input-name" class="col-sm-2 control-label">Mô tả </label>
                        <div class="col-sm-4">
                            <input type="text" name="description" value="{{ $role->description }}" class="form-control" id="input-name" placeholder="">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                                Cập nhật
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

@endsection

@push('scripts')
    <script src="/vendor/ubold/assets/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="/vendor/ubold/assets/plugins/parsleyjs/parsley.min.js"></script>
    <!-- Modal-Effect -->
    <script src="/vendor/ubold/assets/plugins/custombox/js/custombox.min.js"></script>
    <script src="/vendor/ubold/assets/plugins/custombox/js/legacy.min.js"></script>

@endpush

@push('inline_scripts')
    <script>

    </script>

@endpush