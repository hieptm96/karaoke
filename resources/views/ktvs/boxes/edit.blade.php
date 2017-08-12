@extends('layouts.app')

@section('content')

    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group pull-right m-t-15">
                <a href="{{ route('ktvs.boxes.index', ['ktv' => $ktv->id]) }}"><button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light">Quay lại </button></a>
            </div>

            <h4 class="page-title">Bài hát</h4>
            <ol class="breadcrumb">
                <li>
                    <a href="#">KTV</a>
                </li>
                <li class="active">
                    Thêm mới
                </li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <h4 class="m-t-0 header-title"><b>Cập nhật thông tin đầu máy/thiêt bị phát</b></h4>
                <p class="text-muted font-13 m-b-30">
                </p>

                <form class="form-horizontal" id="edit-box-form" action="{{ route('ktvs.boxes.update', ['ktv' => $ktv->id, 'box' => $box->id]) }}">
                    {{ csrf_field() }}
                    {{ method_field('patch') }}
                    <div class="form-group">
                        <label  class="col-sm-4 control-label" for="code">Mã đầu máy*</label>
                        <div class="col-sm-7">
                            <input type="code" id="code" class="form-control" name="code" placeholder="Mã đầu máy"
                                value="{{ $box->code }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="info" >Thông tin</label>
                        <div class="col-sm-7">
                            <textarea class="form-control" id="info" name="info" placeholder="Thông tin đầu máy"
                                value="{{ $box->info }}"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                          <button type="submit" class="btn btn-primary waves-effect waves-light">
                            Cập nhật
                          </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
