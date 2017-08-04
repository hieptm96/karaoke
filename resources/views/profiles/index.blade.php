@extends('layouts.app')

@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="page-title">Thông tin tài khoản</h4>
            <ol class="breadcrumb">
                <li>
                    <a href="#">Tài khoản</a>
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
                <h4 class="m-t-0 header-title"><b>Chỉnh sửa thông tin tài khoản</b></h4>
                <p class="text-muted font-13 m-b-30">
                </p>

                <form action="{{ route('profiles.update', ['id' => Auth::id()])  }}" method="POST" class="form-horizontal" role="form" data-parsley-validate="" novalidate="">
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
                    <div>
                        {{ csrf_field()  }}
                        {{ method_field('patch') }}

                        <div class="form-group">
                            <label for="name" class="col-sm-4 control-label pull-left">Tên*</label>
                            <div class="col-sm-7">
                                <input type="text" required="" parsley-type="text" name="name" class="form-control" id="name" placeholder="Tên" value="{{ Auth::user()->name }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-4 control-label pull-left">Email*</label>
                            <div class="col-sm-7">
                                <input type="email" required="" parsley-type="email" name="email" class="form-control" id="email" placeholder="Email" value="{{ Auth::user()->email }}">
                            </div>
                        </div>
                        <hr>
                        <h4 class="m-t-0 header-title"><b>Thay đổi mật khẩu</b></h4>
                        <div class="form-group">
                            <label for="password" class="col-sm-4 control-label pull-left">Mật khẩu hiện tại*</label>
                            <div class="col-sm-7">
                                <input type="password" required="" parsley-type="password" name="password" class="form-control" id="password" placeholder="Mật khẩu">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="new_password" class="col-sm-4 control-label pull-left">Mật khẩu mới*</label>
                            <div class="col-sm-7">
                                <input type="password" required="" parsley-type="password" name="new_password" class="form-control" id="new_password" placeholder="Mật khẩu mới">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="re_password" class="col-sm-4 control-label pull-left">Xác nhận mật khẩu*</label>
                            <div class="col-sm-7">
                                <input type="password" required="" parsley-type="password" name="re_password" class="form-control" id="re_password" placeholder="Mật khẩu xác nhận">
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
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
