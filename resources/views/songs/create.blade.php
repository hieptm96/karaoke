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
            <div class="btn-group pull-right m-t-15">
                <a href="{{ route('songs.index') }}"><button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light">Quay lại </button></a>
            </div>

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

    @include('songs.owner-modal')


    @include('flash-message::default')

    @include('common.request_errors')

    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <h4 class="m-t-0 header-title"><b>Thông tin bài hát</b></h4>

                <form class="form-horizontal" method="post" action="{{ route('songs.store') }}" role="form"  data-parsley-validate novalidate>
                  <input type="hidden" value="{{ csrf_token() }}" name="_token">

                  <div class="form-group">
                    <label for="input-name" class="col-sm-4 control-label">Tên*: </label>
                    <div class="col-sm-7">
                      <input type="text" name="name" value="" class="form-control" id="input-name" placeholder="Tên" required>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="input-name" class="col-sm-4 control-label">Tên file*: </label>
                    <div class="col-sm-7">
                      <input type="text" name="file_name" value="" class="form-control" id="file-name" placeholder="Tên file" required>
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
					<label class="col-sm-4 control-label">Bài hát có thu phí hay không*: </label>
					<div class="col-sm-6">

                        <div class="radio radio-primary radio-inline">
                            <input type="radio" id="inlineRadio1" value="1" name="has_fee" checked>
                            <label for="inlineRadio1"> Có </label>
                        </div>

                        <div class="radio radio-primary radio-inline">
                            <input type="radio" id="inlineRadio1" value="0" name="has_fee">
                            <label for="inlineRadio1"> Không </label>

                        </div>
					</div>
				  </div>

                  <hr />

                  <div class="form-group">
                    <label for="singers" class="col-sm-4 control-label">Đơn vị sở hữu nội dung: </label>

                    <div class="col-sm-6">
                        <br />

                        <div class="">
                          <label for="singers" class="">Nhạc sĩ: </label>
                          <div class="">
                            <div class="input-group owner" id="musican-owner">
                                <input type="text" class="hidden" name="musican-owner"></name>
                                <span class="name form-control"></span>
                                <a class="btn btn-primary owner-btn select-owner-btn input-group-addon btn-block" data-toggle="modal" data-target="#owner-modal">Chọn</a>
                            </div>
                          </div>
                        </div>

                        <div class="">
                          <label for="singers" class="">Lời: </label>
                          <div class="">
                            <div class="input-group owner" id="title-owner">
                                <input type="text" class="hidden" name="title-owner"></name>
                                <span class="name form-control"></span>
                                <a class="btn btn-primary owner-btn select-owner-btn input-group-addon btn-block" data-toggle="modal" data-target="#owner-modal">Chọn</a>
                            </div>
                          </div>
                        </div>

                        <div class="">
                          <label for="singers" class="">Ca sĩ: </label>
                          <div class="">
                            <div class="input-group owner" id="singer-owner">
                                <input type="text" class="hidden" name="singer-owner"></name>
                                <span class="name form-control"></span>
                                <a class="btn btn-primary owner-btn select-owner-btn input-group-addon btn-block" data-toggle="modal" data-target="#owner-modal">Chọn</a>
                            </div>
                          </div>
                        </div>


                        <div class="">
                          <label for="singers" class="">Quay phim: </label>
                          <div class="">
                            <div class="input-group owner" id="film-owner">
                                <input type="text" class="hidden" name="film-owner"></name>
                                <span class="name form-control"></span>
                                <a class="btn btn-primary owner-btn select-owner-btn input-group-addon btn-block" data-toggle="modal" data-target="#owner-modal">Chọn</a>
                            </div>
                          </div>
                        </div>


                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                      <button type="submit" class="btn btn-primary waves-effect waves-light submit-btn">
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

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script src="/js/main.js"></script>

@endpush

@push('inline_scripts')
<script>

    var deleteAndEditAction = '<a class="btn btn-primary owner-btn delete-owner input-group-addon btn-block" >Xóa</a>'
    + '<a class="btn btn-default owner-btn select-owner-btn input-group-addon btn-block" data-toggle="modal" data-target="#owner-modal">Sửa</a>';
    var selectAction = '<a class="btn btn-primary owner-btn select-owner-btn input-group-addon btn-block" data-toggle="modal" data-target="#owner-modal">Chọn</a>';

    function checkAction() {
        $('.owner').each(function(owner) {
            var val = $(this).find('.hidden').val();
            console.log('val: ' + val);
            if(val != '') {
                $(this).find('.owner-btn').remove();
                $(this).append(deleteAndEditAction);
            } else {
                $(this).find('.owner-btn').remove();
                $(this).append(selectAction);
            }
        })
    }

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

        $('#singer-filter-form').on('submit', function(e) {
            datatable.draw();
            e.preventDefault();
        });

        $('#singer-filter-form').on('change', function(e) {
            datatable.draw();
        });

        $('#name-filter').on('keyup', function(e) {
            var name = $('#name-filter').val();
            if (name.length == 0) {
                datatable.draw();
            }
        });

    });

    // owners
    var url = '{{ route('contentowners.getdistricts') }}';
    var owner;
    $(function () {
        var datatable = $("#content-owner-datatable").DataTable({
            searching: false,
            serverSide: true,
            processing: true,
            scrollY: '250px',
            scrollCollapse: false,
            ajax: {
                url: "{!! route('contentowners.datatables') !!}",
                data: function (d) {
                    d.name = $('#name-search').val();
                    d.phone = $('#phone-search').val();
                    d.email = $('#email-search').val();
                    d.province = $('#province').val();
                    d.district = $('#district-search').val();
                }
            },
            "columnDefs": [ {
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='btn btn-primary select-owner' data-dismiss='modal'>Chọn</button>",
            }, {
                "targets": 0,
                "data": null,
                'className': "owner-data",
            }, {
                "targets": 1,
                "data": null,
                'className': "owner-name",
            } ],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'phone', name: 'phone'},
                {data: 'email', name: 'email'},
                {data: 'address', name: 'address'},
                {data: 'province', name: 'province_id'},
                {data: 'district', name: 'district_id'},
                {data: 'code', name: 'code'},
                {name: 'select', orderable: false, searchable: false},
            ],
            order: [[2, 'asc']]
        });

        $('#name-search').on('keyup', function(e) {
            datatable.draw();
            e.preventDefault();
        });
        $('#phone-search').on('keyup', function(e) {
            datatable.draw();
            e.preventDefault();
        });
        $('#email-search').on('keyup', function(e) {
            datatable.draw();
            e.preventDefault();
        });
        $('#province').on('change', function(e) {
            datatable.draw();
            e.preventDefault();
        });
        $('#district-search').on('change', function(e) {
            datatable.draw();
            e.preventDefault();
        });

        $('.modal').on('shown.bs.modal', function() {
            // console.log('1');
        })
    });

    function changeOwnerValue(ownerId, ownerName) {
        owner.find(".hidden").val(ownerId);
        owner.find('.name').text(ownerName);

        checkAction();
    }

    // select owner event
    $(document).on('click', '.select-owner', function() {
        var ownerRow = $(this).parent().parent();
        var ownerId = ownerRow.find('.owner-data').text();
        var ownerName = ownerRow.find('.owner-name').html();

        changeOwnerValue(ownerId, ownerName);
    });

    $(document).on('shown.bs.modal', '#owner-modal', function() {
        var datatable = $("#content-owner-datatable").dataTable();
        datatable.fnAdjustColumnSizing();
    });

    $('#modal-content').on('shown', function() {
        $("#txtname").focus();
    })

    // delete owner event
    $(document).on('click', '.delete-owner', function() {
        var ownerRow = $(this).parent();
        ownerRow.find(".hidden").val('');
        ownerRow.find('.name').text('');

        ownerRow.find('.owner-btn').remove();
        ownerRow.append(selectAction);
    });

    // select owner event
    $(document).on('click', '.select-owner-btn', function() {
        owner = $(this).parent();
    });

</script>

@endpush
