@extends('layouts.app')

@push('styles')
    <link href="/vendor/ubold/assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
@endpush

@section('content')

    {{-- delete song modal --}}
    <div id="delete-singer-modal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3 class="modal-title">Xóa ca sĩ</h3>
          </div>
          <div class="modal-body">
            <p>Bạn có chắc muốn xóa ca sĩ không?</p>
          </div>
          <div class="modal-footer">
              <div class="custom-modal-text text-left">
                  <form role="form" id="delete-singer-form" method="post" action="/singers/{{ $singer['id'] }}">
                      {{-- <input name="_method" value="DELETE" type="hidden"> --}}
                      {{ method_field('DELETE') }}
                      <input type="hidden" value="{{ csrf_token() }}" name="_token">
                      <div class="text-right">
                          <button type="submit" class="btn btn-danger waves-effect waves-light">Xóa</button>
                          <button type="button" class="btn btn-default waves-effect waves-light m-l-10" data-dismiss="modal">Hủy</button>
                      </div>
                  </form>
              </div>
          </div>
        </div>

      </div>
    </div>

    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">

            @if ( session('created') )
                <div class="btn-group pull-right m-t-15">
                    <a href="{{ route('singers.create') }}" class="btn btn-default"><i class="md md-add"></i> Thêm tiếp </a>
                </div>
            @else
                <div class="btn-group pull-right m-t-15">
                    <a href="{{ route('singers.index') }}"><button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light">Quay lại </button></a>
                </div>
            @endif

            <h4 class="page-title">Ca sĩ</h4>
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

    @if (session()->has('flash_message'))
        <div class="alert alert-{{ session('flash_message.level') }} alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>{!! session('flash_message.message') !!}</strong>
        </div>
    @endif

    @include('common.request_errors')


    <div class="row">
        <div class="col-sm-12">
            <div class="card-box table-responsive">
                <h4 class="m-t-0 header-title"><b>Thông tin ca sĩ</b></h4>

                <form id="singers-edit" class="form-horizontal" method="post" action="/singers/{{ $singer['id'] }}" role="form"  data-parsley-validate>
                   <input name="_method" value="PUT" type="hidden">
                   <input type="hidden" value="{{ csrf_token() }}" name="_token">

                  <div class="form-group">
                    <label for="input-name" class="col-sm-4 control-label">Tên: </label>
                    <div class="col-sm-7">
                      <input type="text" name="name" value="{{ $singer['name'] }}" class="form-control" id="input-name" placeholder="Tên">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="sex-picker" class="col-sm-4 control-label">Giới tính: </label>
                    <div class="col-sm-7">
                      <select class="form-control" name="sex" data-style="btn-white" id="language-picker">
                        @foreach (config('ktv.sexes') as $key => $sex)
                            <option value="{{ $key }}" @if($singer['sex'] == $key) selected @endif>{{ $sex }}</option>
                        @endforeach

                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="language-picker" class="col-sm-4 control-label">Ngôn ngữ: </label>
                    <div class="col-sm-7">
                      <select class="form-control" name="language" data-style="btn-white" id="language-picker">
                        @foreach (config('ktv.languages') as $key => $language)
                            <option value="{{ $key }}" @if($singer['language'] == $key) selected @endif>{{ $language }}</option>
                        @endforeach

                      </select>

                    </div>
                  </div>

                  <hr>

                  <div class="form-group">
                    <label for="created-by"class="col-sm-4 control-label">Người tạo: </label>
                    <div class="col-sm-7">
                      <input type="text" value="{{ $singer['created_by'] }}" id="created_by" placeholder="Người tạo" class="form-control" readonly>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="webSite" class="col-sm-4 control-label">Thời gian tạo: </label>
                    <div class="col-sm-7">
                      <input type="text" value="{{ $singer['created_at'] }}" id="created-at"  class="form-control" readonly placeholder="Ngày tạo">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="webSite" class="col-sm-4 control-label">Thời gian sửa đổi lần cuối: </label>
                    <div class="col-sm-7">
                      <input type="text" value="{{ $singer['updated_at'] }}" id="webSite" class="form-control" readonly placeholder="Ngày sửa đổi cuối">
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
    </div>

@endsection

@push('scripts')
<script src="/vendor/ubold/assets/plugins/parsleyjs/parsley.min.js"></script>

@endpush

@push('inline_scripts')
<script>
    $(document).on('click', '.delete-singer', function(e) {
        $('#delete-singer-modal').modal("show");
        e.preventDefault();
    });

    $( document ).ready(function() {
        $('select[name=language]').val({{ $singer['language'] }});
        $('select[name=sex]').val({{ $singer['sex'] }});
        $('form').parsley();

        $('#singers-edit').validate({
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
