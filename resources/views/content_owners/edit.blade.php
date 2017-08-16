@extends('layouts.app')

@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group pull-right m-t-15">
                <a href="{{ route('contentowners.index') }}"><button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light">Quay lại </button></a>
            </div>

            <h4 class="page-title">Manage</h4>
            <ol class="breadcrumb">
                <li>
                    <a href="#">Đơn vị sở hữu bản quyền</a>
                </li>
                <li class="active">
                    Chỉnh sửa
                </li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <h4 class="m-t-0 header-title"><b>Chỉnh sửa đơn vị sở hữu bản quyền</b></h4>
                <p class="text-muted font-13 m-b-30">
                </p>

                <form action="{{ route('contentowners.update', ['id' => $content_owner->id])  }}" method="POST" id="content-owner-form" class="form-horizontal" role="form" data-parsley-validate="" novalidate="">
                    {{ method_field('patch') }}
                    @include('content_owners._form')
                </form>
            </div>
        </div>
    </div>

@endsection
