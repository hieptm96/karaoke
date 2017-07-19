@extends('layouts.app')

@push('styles')
    <link href="/vendor/ubold/assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
@endpush

@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">

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

    {{-- @if ( !empty($edited) )
        @if ( $edited === true )
          <div class="alert alert-success fade in alert-dismissable">
              <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
              <strong>Đã thêm thành công ca sĩ!</strong>
          </div>
        @else
          <div class="alert alert-danger fade in alert-dismissable">
              <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
              <strong>Không thể thêm ca sĩ!</strong>
          </div>
        @endif
    @endif --}}


    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <h4 class="m-t-0 header-title"><b>Thông tin ca sĩ</b></h4>

                <form class="form-horizontal" method="post" action="{{ route('singers.store') }}" role="form"  data-parsley-validate novalidate>
                   <input type="hidden" value="{{ csrf_token() }}" name="_token">

                  <div class="form-group">
                    <label for="input-name" class="col-sm-4 control-label">Tên <span class="text-danger">*</span>: </label>
                    <div class="col-sm-7">
                      <input type="text" name="name"  class="form-control" id="input-name" placeholder="Tên" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="sex-picker" class="col-sm-4 control-label">Giới tính: </label>
                    <div class="col-sm-7">
                      <select class="selectpicker" name="language" data-style="btn-white" id="language-picker">
                        @foreach (config('ktv.sexes') as $key => $sex)
                            <option value="{{ $key }}">{{ $sex }}</option>
                        @endforeach

                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="language-picker"class="col-sm-4 control-label">Ngôn ngữ: </label>
                    <div class="col-sm-7">
                      <select class="selectpicker" name="sex" data-style="btn-white" id="language-picker">
                        @foreach (config('ktv.languages') as $key => $language)
                            <option value="{{ $key }}">{{ $language }}</option>
                        @endforeach

                      </select>

                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                      <button type="submit" class="btn btn-warning waves-effect waves-light">
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
<script src="/vendor/ubold/assets/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
<script src="/vendor/ubold/assets/plugins/parsleyjs/parsley.min.js"></script>

@endpush
