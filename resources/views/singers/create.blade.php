@extends('layouts.app')

@push('styles')
    <link href="/vendor/ubold/assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="/css/custom.css">
@endpush

@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">

            <div class="btn-group pull-right m-t-15">
                <a href="{{ url()->previous() }}"><button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light">Quay lại </button></a>
            </div>

            <h4 class="page-title">Ca sĩ</h4>
            <ol class="breadcrumb">
                <li>
                    <a href="#">KTV</a>
                </li>
                <li>
                    <a href="{{ route('singers.index') }}">Ca sĩ</a>
                </li>
                <li class="active">
                    Thêm ca sĩ
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

    @include('common.request_errors')

    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <h4 class="m-t-0 header-title"><b>Thông tin ca sĩ</b></h4>

                <form id="singers-create" class="form-horizontal" method="post" action="{{ route('singers.store') }}" role="form"  data-parsley-validate>
                  <input type="hidden" value="{{ csrf_token() }}" name="_token">

                  <div class="form-group">
                    <label for="input-name" class="col-sm-4 control-label">Tên*: </label>
                    <div class="col-sm-7">
                      <input type="text" name="name"  class="form-control" id="input-name" placeholder="Tên" value="{{ old('name') }}">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="sex-picker" class="col-sm-4 control-label">Giới tính*: </label>
                    <div class="col-sm-7">
                      <select class="form-control" name="sex" data-style="btn-white">
                        @foreach (config('ktv.sexes') as $key => $sex)
                            <option value="{{ $key }}">{{ $sex }}</option>
                        @endforeach

                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="language-picker"class="col-sm-4 control-label">Ngôn ngữ*: </label>
                    <div class="col-sm-7">
                      <select class="form-control" name="language" data-style="btn-white">
                        @foreach (config('ktv.languages') as $key => $language)
                            <option value="{{ $key }}">{{ $language }}</option>
                        @endforeach

                      </select>

                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                      <button type="submit" class="btn btn-primary waves-effect waves-light">
                        Thêm
                      </button>
                      <a href="{{ route('singers.index') }}" class="btn btn-default waves-effect waves-light m-l-5">
                        Hủy
                      </a>
                    </div>
                  </div>
                </form>
              </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script src="/vendor/ubold/assets/plugins/parsleyjs/parsley.min.js"></script>

@endpush

@push('inline_scripts')
<script>
    $(document).ready(function() {
        $('#singers-create').validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 255
                }
            },
            messages: {
                name: {
                    required: "Tên không được để trống",
                    maxlength: "Tên tối đa 255 ký tự"
                }
            }
        });
    });
</script>
@endpush
