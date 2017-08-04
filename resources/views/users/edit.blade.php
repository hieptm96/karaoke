@extends('layouts.app')

@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group pull-right m-t-15">
                <a href="{{ route('users.index') }}"><button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light">Quay lại </button></a>
            </div>

            <h4 class="page-title">Thành viên</h4>
            <ol class="breadcrumb">
                <li>
                    <a href="#">Thành viên</a>
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
                <h4 class="m-t-0 header-title"><b>Chỉnh sửa thông tin thành viên</b></h4>
                <p class="text-muted font-13 m-b-30">
                </p>

                <form action="{{ route('users.update', ['id' => $user->id])  }}" method="POST" class="form-horizontal" role="form" data-parsley-validate="" novalidate="">
                    {{ csrf_field()  }}
                    {{ method_field('patch') }}

                    <div class="col-xs-12">
                        @if (session()->has('flash_message'))
                            <div class="alert alert-{{ session('flash_message.level') }} alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>{!! session('flash_message.message') !!}</strong>
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>


                    <div class="form-group">
                        <label for="name" class="col-sm-4 control-label pull-left">Tên*</label>
                        <div class="col-sm-7">
                            <input type="text" required="" parsley-type="text" name="name" class="form-control" id="name" placeholder="Tên" value="{{ isset($user) ? old('name', $user->name) : old('name') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-sm-4 control-label pull-left">Email*</label>
                        <div class="col-sm-7">
                            <input type="email" required="" parsley-type="email" name="email" class="form-control" id="email" placeholder="Email" value="{{ isset($user) ? old('email', $user->email) : old('email') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="hori-pass1" class="col-sm-4 control-label">Password</label>
                        <div class="col-sm-7">
                            <input type="password" name="password" id="password" placeholder="Password" required="" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="province" class="col-sm-4 control-label pull-left">Quyền*</label>
                        <div class="col-sm-7">
                            <select name="role_id" id="role_id" class="form-control">
                                <option value="">-- Chọn quyền --</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ isset($user) && ($user->roles[0]->id == $role->id) ? "selected" : "" }}>{{ $role->display_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                                Cập nhật
                            </button>
                            <button type="reset" class="btn btn-default waves-effect waves-light m-l-5">
                                Hủy
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
