@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group pull-right m-t-15">
                <a href="{{ url('/') }}"><button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light">Quay lại </button></a>
            </div>

            <h4 class="page-title">Hệ thống</h4>
            <ol class="breadcrumb">
                <li>
                    <a href="#">Hệ thống</a>
                </li>
                <li class="active">
                    Cấu hình giá
                </li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <h4 class="m-t-0 header-title"><b>Chi tiết giá</b></h4>
                <p class="text-muted font-13 m-b-30">
                </p>

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

                <form action="{{ route('configs.update', ['id' => $id]) }}" method="POST" class="form-horizontal" role="form" data-parsley-validate="" novalidate="">
                    {{ csrf_field()  }}
                    {{ method_field('patch') }}

                    <div class="form-group">
                        <label for="price" class="col-sm-4 control-label pull-left">Giá*</label>
                        <div class="col-sm-7">
                            <input type="text" required="" parsley-type="text" name="price" class="form-control" id="price" value="{{ $config['price'] }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="singer_rate" class="col-sm-4 control-label pull-left">Ca sỹ (%)*</label>
                        <div class="col-sm-7">
                            <input type="number" required="" parsley-type="text" name="singer_rate" class="form-control" id="singer_rate" value="{{ $config['singer_rate'] }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="musician_rate" class="col-sm-4 control-label pull-left">Tác giả (%)*</label>
                        <div class="col-sm-7">
                            <input type="number" required="" parsley-type="text" name="musician_rate" class="form-control" id="musician_rate" value="{{ $config['musician_rate'] }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="title_rate" class="col-sm-4 control-label pull-left">Lời (%)*</label>
                        <div class="col-sm-7">
                            <input type="number" required="" parsley-type="text" name="title_rate" class="form-control" id="title_rate" value="{{ $config['title_rate'] }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="film_rate" class="col-sm-4 control-label pull-left">Quay phim (%)*</label>
                        <div class="col-sm-7">
                            <input type="number" required="" parsley-type="text" name="film_rate" class="form-control" id="film_rate" value="{{ $config['film_rate'] }}">
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

@push('inline_scripts')
<script>
    $(document).ready(function() {
        $('#price').keyup(function() {
            if ($(this).val() == '') $(this).val('0');
            var n = parseInt($(this).val().replace(/\D/g,''),10);
            $(this).val(n.toLocaleString('vi-VN'));
        });
    });
</script>

@endpush
