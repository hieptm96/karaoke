@extends('layouts.app')

@push('styles')
    <link href="/vendor/ubold/assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
@endpush

@section('content')

    @include('songs.singer-modal')

    @include('songs.owner-modal')

    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">

            @if ( session('created') )
                <div class="btn-group pull-right m-t-15">
                    <a href="{{ route('songs.create') }}" class="btn btn-default"><i class="md md-add"></i> Thêm tiếp </a>
                </div>
            @else
                <div class="btn-group pull-right m-t-15">
                    <a href="{{ route('songs.index') }}"><button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light">Quay lại </button></a>
                </div>
            @endif


            <h4 class="page-title">Bài hát</h4>
            <ol class="breadcrumb">
                <li>
                    <a href="#">KTV</a>
                </li>
                <li>
                    <a href="{{ route('songs.index') }}">Bài hát</a>
                </li>
                <li class="active">
                    Sửa Thông tin bài hát
                </li>
            </ol>
        </div>
    </div>

    @include('flash-message::default')

    @include('common.request_errors')

    <div class="row">
        <div class="col-sm-12">
            <div class="card-box table-responsive">
                <h4 class="m-t-0 header-title"><b>Thông tin bài hát</b></h4>

                <form class="form-horizontal" id="song-filer-form" method="post" action="{{ route('songs.update', $song['file_name'])}}" role="form"  data-parsley-validate>
                   <input name="_method" value="PUT" type="hidden">
                   <input type="hidden" value="{{ csrf_token() }}" name="_token">
                   <input type="hidden" value="{{ $song['id'] }}" name="song_id">


                  <div class="form-group">
                    <label for="input-name" class="col-sm-4 control-label">Tên*: </label>
                    <div class="col-sm-7">
                      <input type="text" name="name" value="{{ $song['name'] }}" class="form-control" id="input-name" placeholder="Tên" required>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="input-name" class="col-sm-4 control-label">Tên file*: </label>
                    <div class="col-sm-7">
                      <input type="text" name="file_name" value="{{ $song['file_name'] }}" class="form-control" id="file-name" placeholder="Tên file" required>
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
                    <label for="language-picker" class="col-sm-4 control-label">Ngôn ngữ*: </label>
                    <div class="col-sm-7">
                      <select class="form-control" value="{{ $song['language'] }}" name="language" data-style="btn-white" id="song-language-filter">
                        @foreach (config('ktv.languages') as $key => $language)
                            <option value="{{ $key }}" @if($song['language']==$key) selected  @endif>{{ $language }}</option>
                        @endforeach

                      </select>

                    </div>
                  </div>

                  <div class="form-group">
      					<label class="col-sm-4 control-label">Bài hát có thu phí hay không*:</label>
      					<div class="col-sm-6">
                        <div class="radio radio-primary radio-inline">
                            <input type="radio" id="yes" value="1" name="has_fee" @if($song['has_fee']) checked @endif>
                            <label for="yes-radio"> Có </label>
                        </div>

                        <div class="radio radio-primary radio-inline">
                            <input type="radio" id="no" value="0" name="has_fee" @if(!$song['has_fee']) checked @endif>
                            <label for="no-radio"> Không </label>

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
                                <input type="text" class="hidden" name="musican-owner" value="{{ $song['contentOwners']['musican']['id'] or '' }}">
                                <span class="name form-control">{{ $song['contentOwners']['musican']['name'] or '' }}</span>
                                <a class="btn btn-primary owner-btn select-owner-btn input-group-addon btn-block" data-toggle="modal" data-target="#owner-modal">Chọn</a>
                            </div>
                          </div>
                        </div>

                        <div class="">
                          <label for="singers" class="">Lời: </label>
                          <div class="">
                            <div class="input-group owner" id="title-owner">
                                <input type="text" class="hidden" name="title-owner" value="{{ $song['contentOwners']['title']['id'] or '' }}">
                                <span class="name form-control">{{ $song['contentOwners']['title']['name'] or '' }}</span>
                                <a class="btn btn-primary owner-btn select-owner-btn input-group-addon btn-block" data-toggle="modal" data-target="#owner-modal">Chọn</a>
                            </div>
                          </div>
                        </div>

                        <div class="">
                          <label for="singers" class="">Ca sĩ: </label>
                          <div class="">
                            <div class="input-group owner" id="singer-owner">
                                <input type="text" class="hidden" name="singer-owner" value="{{ $song['contentOwners']['singer']['id'] or '' }}">
                                <span class="name form-control">{{ $song['contentOwners']['singer']['name'] or '' }}</span>
                                <a class="btn btn-primary owner-btn select-owner-btn input-group-addon btn-block" data-toggle="modal" data-target="#owner-modal">Chọn</a>
                            </div>
                          </div>
                        </div>


                        <div class="">
                          <label for="singers" class="">Quay phim: </label>
                          <div class="">
                            <div class="input-group owner" id="film-owner">
                                <input type="text" class="hidden" name="film-owner" value="{{ $song['contentOwners']['film']['id'] or '' }}">
                                <span class="name form-control">{{ $song['contentOwners']['film']['name'] or '' }}</span>
                                <a class="btn btn-primary owner-btn select-owner-btn input-group-addon btn-block" data-toggle="modal" data-target="#owner-modal">Chọn</a>
                            </div>
                          </div>
                        </div>
                    </div>
                  </div>

                  <hr>

                  <div class="form-group">
                    <label for="created-by"class="col-sm-4 control-label">Người tạo: </label>
                    <div class="col-sm-7">
                      <input type="text" value="{{ $song['created_by'] }}" id="created_by" placeholder="Người tạo" class="form-control" readonly>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="webSite" class="col-sm-4 control-label">Thời gian tạo: </label>
                    <div class="col-sm-7">
                      <input type="text" value="{{ $song['created_at'] }}" id="created-at"  class="form-control" readonly placeholder="Ngày tạo">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="webSite" class="col-sm-4 control-label">Thời gian sửa đổi lần cuối: </label>
                    <div class="col-sm-7">
                      <input type="text" value="{{ $song['updated_at'] }}" id="webSite" class="form-control" readonly placeholder="Ngày sửa đổi cuối">
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
<script src="/vendor/ubold/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/vendor/ubold/assets/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="/vendor/ubold/assets/plugins/datatables/dataTables.responsive.min.js"></script>
<script src="/vendor/ubold/assets/plugins/datatables/responsive.bootstrap.min.js"></script>
<script src="/vendor/ubold/assets/plugins/parsleyjs/parsley.min.js"></script>


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

    $( document ).ready(function() {
        checkAction();
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
        +    '<input class="singer-id hidden" name="singer[]" value="' + singerId + '">'
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

    // owners
    var url = '{{ route('contentowners.getdistricts') }}';
    var owner;
    var contentOwnerDatatable;
    $(function () {
        contentOwnerDatatable = $("#content-owner-datatable").dataTable({
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
            contentOwnerDatatable.draw();
            e.preventDefault();
        });
        $('#phone-search').on('keyup', function(e) {
            contentOwnerDatatable.draw();
            e.preventDefault();
        });
        $('#email-search').on('keyup', function(e) {
            contentOwnerDatatable.draw();
            e.preventDefault();
        });
        $('#province').on('change', function(e) {
            contentOwnerDatatable.draw();
            e.preventDefault();
        });
        $('#district-search').on('change', function(e) {
            contentOwnerDatatable.draw();
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
        console.log('1');
        contentOwnerDatatable.fnAdjustColumnSizing();
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
