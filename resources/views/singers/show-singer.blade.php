@extends('layouts.app')

@push('styles')
    <link href="/vendor/ubold/assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
    <link href="/vendor/ubold/assets/plugins/custombox/css/custombox.css" rel="stylesheet">
@endpush

@section('content')

    {{-- delete singer modal --}}
    <div id="delete-singer-modal" class="modal-demo" data="">
        <button type="button" class="close" onclick="Custombox.close();">
            <span>&times;</span><span class="sr-only">Close</span>
        </button>
        <h4 class="custom-modal-title">Xóa ca sĩ</h4>
        <div class="custom-modal-text text-left">
            <form role="form" id="delete-singer-form" method="post" action="/singers/{{ $singer['id'] }}">
                <input name="_method" value="DELETE" type="hidden">
                <input type="hidden" value="{{ csrf_token() }}" name="_token">
                <div class="text-right">
                    <button type="submit" class="btn btn-danger waves-effect waves-light">Xóa</button>
                    <button type="button" class="btn btn-default waves-effect waves-light m-l-10" onclick="Custombox.close();">Hủy</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">

            <h4 class="page-title">Bài hát</h4>
            <ol class="breadcrumb">
                <li>
                    <a href="#">KTV</a>
                </li>
                <li>
                    <a href="{{ route('singers.index') }}">Ca sĩ</a>
                </li>
                <li class="active">
                    Thông tin ca sĩ
                </li>
            </ol>
        </div>
    </div>

    @if ( session()->has('edited') )
        @if ( session('edited') )
          <div class="alert alert-success fade in alert-dismissable">
              <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
              <strong>Đã cập nhât thành công thông tin!</strong>
          </div>
        @else
          <div class="alert alert-danger fade in alert-dismissable">
              <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
              <strong>Không thể thay đổi thông tin!</strong>
          </div>
        @endif
    @elseif ( session('created') )
        <div class="alert alert-success fade in alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            <strong>Đã thêm thành công thông tin!</strong>
        </div>
    @elseif( session()->has('deleted') )
        <div class="alert alert-danger fade in alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            <strong>Không thể xóa ca sĩ!</strong>
        </div>
    @endif


    <div class="row">
        <div class="col-sm-12">
            <div class="card-box table-responsive">
                <h4 class="m-t-0 header-title"><b>Thông tin ca sĩ</b></h4>

                <form class="form-horizontal" method="post" action="/singers/{{ $singer['id'] }}" role="form"  data-parsley-validate novalidate>
                   <input name="_method" value="PUT" type="hidden">
                   <input type="hidden" value="{{ csrf_token() }}" name="_token">

                  <div class="form-group">
                    <label for="input-name" class="col-sm-4 control-label">Tên: </label>
                    <div class="col-sm-7">
                      <input type="text" name="name" value="{{ $singer['name'] }}" class="form-control" id="input-name" placeholder="Tên" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="sex-picker" class="col-sm-4 control-label">Giới tính: </label>
                    <div class="col-sm-7">
                      <select class="selectpicker" value="{{ $singer['language'] }}" name="language" data-style="btn-white" id="language-picker">
                        @foreach (config('ktv.sexes') as $key => $sex)
                            <option value="{{ $key }}">{{ $sex }}</option>
                        @endforeach

                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="language-picker"class="col-sm-4 control-label">Ngôn ngữ: </label>
                    <div class="col-sm-7">
                      <select class="selectpicker" value="{{ $singer['language'] }}" name="sex" data-style="btn-white" id="language-picker">
                        @foreach (config('ktv.languages') as $key => $language)
                            <option value="{{ $key }}">{{ $language }}</option>
                        @endforeach

                      </select>

                    </div>
                  </div>
                  <div class="form-group">
                    <label for="created-by"class="col-sm-4 control-label">Người tạo: </label>
                    <div class="col-sm-7">
                      <input type="text" value="{{ $singer['created_by'] }}" id="created_by" placeholder="Người tạo" class="form-control" readonly required>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="webSite" class="col-sm-4 control-label">Thời gian tạo: </label>
                    <div class="col-sm-7">
                      <input type="text" value="{{ $singer['created_at'] }}" id="created-at" required  class="form-control" readonly placeholder="Ngày tạo">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="webSite" class="col-sm-4 control-label">Thời gian sửa đổi lần cuối: </label>
                    <div class="col-sm-7">
                      <input type="text" value="{{ $singer['updated_at'] }}" id="webSite" required class="form-control" readonly placeholder="Ngày sửa đổi cuối">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                      @if ( session('created') )
                        <a href="{{ route('singers.create') }}" class="btn btn-default waves-effect waves-light">
                          Thêm tiếp
                        </a>
                      @endif
                      <button type="submit" class="btn btn-warning waves-effect waves-light">
                        Cập nhật
                      </button>
                      <a href="#delete-singer-modal" class="btn btn-danger" data-animation="fadein" data-plugin="custommodal"
                        data-overlaySpeed="200" data-overlayColor="#36404a">Xóa</a>
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
    $( document ).ready(function() {
        $('select[name=language]').val({{ $singer['language'] }});
        $('select[name=sex]').val({{ $singer['sex'] }});
        $('.selectpicker').selectpicker('refresh')
        $('form').parsley();
    });
</script>

@endpush
