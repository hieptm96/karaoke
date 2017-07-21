@extends('layouts.app')

@push('styles')
    <link href="/vendor/ubold/assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
    <link href="/vendor/ubold/assets/plugins/custombox/css/custombox.css" rel="stylesheet">
@endpush

@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">

            <h4 class="page-title">bài hát</h4>
            <ol class="breadcrumb">
                <li>
                    <a href="#">KTV</a>
                </li>
                <li>
                    <a href="{{ route('songs.index') }}">Bài hát</a>
                </li>
                <li class="active">
                    Thêm bài hát
                </li>
            </ol>
        </div>
    </div>

    @include('songs.singer-modal')


    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <h4 class="m-t-0 header-title"><b>Thông tin bài hát</b></h4>

                <form class="form-horizontal" method="post" action="{{ route('songs.store') }}" role="form"  data-parsley-validate novalidate>
                  <input type="hidden" value="{{ csrf_token() }}" name="_token">

                  <div class="form-group">
                    <label for="input-name" class="col-sm-4 control-label">Tên: </label>
                    <div class="col-sm-7">
                      <input type="text" name="name" value="" class="form-control" id="input-name" placeholder="Tên" required>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="singers" class="col-sm-4 control-label">Ca sĩ: </label>
                    <div class="col-sm-7">
                      <div class="input-group span6 offset3" id="add-singer">
                          <span class="form-control"></span>
                          <a class="btn btn-default input-group-addon btn-block" data-toggle="modal" data-target="#singer-modal">Thêm</a>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="language-picker" class="col-sm-4 control-label">Ngôn ngữ: </label>
                    <div class="col-sm-7">
                      <select class="selectpicker" name="language" data-style="btn-white" id="language-picker">
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
                      <a href="{{ route('songs.index') }}" class="btn btn-default waves-effect waves-light m-l-5">
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
<script src="/vendor/ubold/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/vendor/ubold/assets/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="/vendor/ubold/assets/plugins/datatables/dataTables.responsive.min.js"></script>
<script src="/vendor/ubold/assets/plugins/datatables/responsive.bootstrap.min.js"></script>
<script src="/vendor/ubold/assets/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
<script src="/vendor/ubold/assets/plugins/parsleyjs/parsley.min.js"></script>
<!-- Modal-Effect -->
<script src="/vendor/ubold/assets/plugins/custombox/js/custombox.min.js"></script>
<script src="/vendor/ubold/assets/plugins/custombox/js/legacy.min.js"></script>

@endpush

@push('inline_scripts')
<script>

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
        +    '<a class="btn btn-warning input-group-addon btn-block delete-singer" >Xóa</a>'
        + '</div>'
        + '<br/>'
        + '</div>'

        console.log(newRow);
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
