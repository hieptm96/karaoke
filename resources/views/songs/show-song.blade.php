@extends('layouts.app')

@push('styles')
    <link href="/vendor/ubold/assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
    <link href="/vendor/ubold/assets/plugins/custombox/css/custombox.css" rel="stylesheet">
@endpush

@section('content')

    {{-- delete song modal --}}
    <div id="delete-song-modal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3 class="modal-title">Xóa bài hát</h3>
          </div>
          <div class="modal-body">
            <p>Bạn có chắc muốn xóa bài hát không?</p>
          </div>
          <div class="modal-footer">
              <div class="custom-modal-text text-left">
                  <form role="form" id="delete-song-form" method="post" action="/songs/{{ $song['id'] }}">
                      <input name="_method" value="DELETE" type="hidden">
                      <input type="hidden" value="{{ csrf_token() }}" name="_token">
                      <div class="text-right">
                          <button type="submit" class="btn btn-danger waves-effect waves-light">Xóa</button>
                          <button type="button" class="btn btn-default waves-effect waves-light m-l-10" onclick="Custombox.close();">Hủy</button>
                      </div>
                  </form>
              </div>
          </div>
        </div>

      </div>
    </div>

    @include('songs.singer-modal')

    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">

            <h4 class="page-title">Bài hát</h4>
            <ol class="breadcrumb">
                <li>
                    <a href="#">KTV</a>
                </li>
                <li>
                    <a href="{{ route('songs.index') }}">Bài hát</a>
                </li>
                <li class="active">
                    Thông tin bài hát
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
            <strong>Đã thêm thành công bài hát!</strong>
        </div>
    @elseif( session()->has('deleted') )
        <div class="alert alert-danger fade in alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            <strong>Không thể xóa bài hát!</strong>
        </div>
    @endif


    <div class="row">
        <div class="col-sm-12">
            <div class="card-box table-responsive">
                <h4 class="m-t-0 header-title"><b>Thông tin bài hát</b></h4>

                <form class="form-horizontal" method="post" action="/songs/{{ $song['id'] }}" role="form"  data-parsley-validate novalidate>
                   <input name="_method" value="PUT" type="hidden">
                   <input type="hidden" value="{{ csrf_token() }}" name="_token">

                  <div class="form-group">
                    <label for="input-name" class="col-sm-4 control-label">Tên: </label>
                    <div class="col-sm-7">
                      <input type="text" name="name" value="{{ $song['name'] }}" class="form-control" id="input-name" placeholder="Tên" required>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="singers" class="col-sm-4 control-label">Ca sĩ: </label>
                    <div class="col-sm-7">
                      @foreach ($song['singers'] as $singer)
                      <div class="singer">
                          <div class="input-group span6 offset3">
                              <input type="text" class="hidden" name="singer[]" value="{{ $singer->id }}"/>
                              <span class="form-control" singer-data="{{ $singer->id }}">{!! $singer->name !!}</span>
                              <a class="btn btn-primary input-group-addon btn-block delete-singer" >Xóa</a>
                          </div>
                          <br/>
                      </div>
                      @endforeach
                      <div class="input-group span6 offset3" id="add-singer">
                          <span class="form-control"></span>
                          <a class="btn btn-default input-group-addon btn-block" data-toggle="modal" data-target="#singer-modal">Thêm</a>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="language-picker" class="col-sm-4 control-label">Ngôn ngữ: </label>
                    <div class="col-sm-7">
                      <select class="selectpicker" value="{{ $song['language'] }}" name="language" data-style="btn-white" id="language-picker">
                        @foreach (config('ktv.languages') as $key => $language)
                            <option value="{{ $key }}">{{ $language }}</option>
                        @endforeach

                      </select>

                    </div>
                  </div>
                  <div class="form-group">
                    <label for="created-by"class="col-sm-4 control-label">Người tạo: </label>
                    <div class="col-sm-7">
                      <input type="text" value="{{ $song['created_by'] }}" id="created_by" placeholder="Người tạo" class="form-control" readonly required>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="webSite" class="col-sm-4 control-label">Thời gian tạo: </label>
                    <div class="col-sm-7">
                      <input type="text" value="{{ $song['created_at'] }}" id="created-at" required  class="form-control" readonly placeholder="Ngày tạo">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="webSite" class="col-sm-4 control-label">Thời gian sửa đổi lần cuối: </label>
                    <div class="col-sm-7">
                      <input type="text" value="{{ $song['updated_at'] }}" id="webSite" required class="form-control" readonly placeholder="Ngày sửa đổi cuối">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                      @if ( session('created') )
                        <a href="{{ route('songs.create') }}" class="btn btn-info waves-effect waves-light">
                          Thêm tiếp
                        </a>
                      @endif
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
<script src="/vendor/ubold/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/vendor/ubold/assets/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="/vendor/ubold/assets/plugins/datatables/dataTables.responsive.min.js"></script>
<script src="/vendor/ubold/assets/plugins/datatables/responsive.bootstrap.min.js"></script>
<script src="/vendor/ubold/assets/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
<script src="/vendor/ubold/assets/plugins/parsleyjs/parsley.min.js"></script>

@endpush

@push('inline_scripts')
<script>
    $( document ).ready(function() {
        $('select[name=language]').val('{{ $song['language'] }}');
        $('.selectpicker').selectpicker('refresh');
        $('form').parsley();
    });

    $(document).on('click', '.delete-song', function(e) {
        $('#delete-song-modal').modal("show");
        e.preventDefault();
    });


    function checkExistedSinger(id) {
        console.log(typeof id);
        var singers = $('.singer-id');
        for (var i = 0; i < singers.length; i++) {
            if (singers[i].value == id) {
                return true;
            }
        }
        return false;
    }

    $(document).on('click', '.select-singer', function() {
        var singerRow = $(this).parent().parent();
        var singerId = singerRow.find('.singer-data').text();
        var singerName = singerRow.find('.singer-name').html();

        if (checkExistedSinger(singerId)) {
            return;
        }

        var addSinger = $('#add-singer');
        var newRow =
        '<div class="singer">'
        + '<div class="input-group span6 offset3">'
        +    '<input class="singer-id hidden" name="singer[]" value="' + singerId + '"></name>'
        +    '<span class="form-control" singer-data=' + singerId + '>' + singerName + '</span>'
        +    '<a class="btn btn-primary input-group-addon btn-block delete-singer" >Xóa</a>'
        + '</div>'
        + '<br/>'
        + '</div>'

        addSinger.before(newRow);
    });

    $(document).on('click', '.delete-singer', function() {
        $(this).parent().parent().remove();
    });

    $(function () {
        var datatable = $("#datatable").DataTable({
            searching: false,
            serverSide: true,
            processing: true,
            ajax: {
                url: "{!! route('singers.datatables') !!}",
                data: function (d) {
                    d.name = $('#name-filter').val();
                    d.sex = $('#sex-filter').val();
                    d.language = $('#language-filter').val();
                }
            },
            "columnDefs": [ {
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='btn btn-primary select-singer' data-dismiss='modal'>Chọn</button>",
            }, {
                "targets": 0,
                "data": null,
                'className': "singer-data",
            }, {
                "targets": 1,
                "data": null,
                'className': "singer-name",
            } ],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'sex', name: 'sex'},
                {data: 'language', name: 'language'},
                {data: 'select', name: 'select', orderable: false, searchable: false},
            ],
            order: [[2, 'asc']]
        });

        $('#search-form').on('submit', function(e) {
            datatable.draw();
            e.preventDefault();
        });

        $('#search-form').on('change', function(e) {
            datatable.draw();
        });

        $('#name-filter').on('keyup', function(e) {
            var name = $('#name-filter').val();
            if (name.length == 0) {
                datatable.draw();
            }
        });

        $('#created-by-filter').on('keyup', function(e) {
            var createdBy = $('#created-by-filter').val();
            if (createdBy.length == 0) {
                datatable.draw();
            }
        });

    });
</script>

@endpush
