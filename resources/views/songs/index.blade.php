@extends('layouts.app')

@push('styles')
    <!-- DataTables -->
    <link href="/vendor/ubold/assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
    <link href="/vendor/ubold/assets/plugins/custombox/css/custombox.css" rel="stylesheet">
@endpush

@php
$user = Auth::user();
@endphp

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
                        <form role="form" id="delete-song-form" method="post" action="">
                            <input name="_method" value="DELETE" type="hidden">
                            {{-- {{ method_field('DELETE') }} --}}
                            <input type="hidden" value="{{ csrf_token() }}" name="_token">
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">Xóa</button>
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

        {{ Session::has('deleted') }}

        <div class="col-sm-12">
            @if ($user->can('songs.create'))
            <div class="btn-group pull-right m-t-15">
                <a href="{{ route('songs.create') }}" class="btn btn-default"><i class="md md-add"></i> Thêm bài hát </a>
            </div>
            @endif

            <h4 class="page-title">Danh mục bài hát</h4>
            <ol class="breadcrumb">
                <li>
                    <a href="#">Bài hát</a>
                </li>
                <li class="active">
                    Danh sách
                </li>
            </ol>
        </div>
    </div>

    @include('flash-message::default')

    <div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <div class="row">
                <div class="col-sm-12">
                    <form class="form-inline" role="form" id="search-form">
                        <div class="form-group">
                            <label class="sr-only" for="">Mã bài hát</label>
                            <input type="text" id="id-filter" class="form-control" placeholder="Mã bài hát" name="id" />
                        </div>

                        <div class="form-group">
                            <label class="sr-only" for="">Tên bài hát</label>
                            <input type="text" id="name-filter" class="form-control" placeholder="Tên bài hát" name="name" />
                        </div>

                        <div class="form-group">
                            <label class="sr-only" for="">Tên ca sĩ</label>
                            <input type="text" id="singer-filter" class="form-control" placeholder="Tên ca sĩ" name="singer" />
                        </div>

                        <div class="form-group">
                          <select class="form-control" id="language-filter" name="language" data-style="btn-white">
                            <option value>--Chọn ngôn ngữ--</option>
                            @foreach (config('ktv.languages') as $key => $language)
                                <option value="{{ $key }}">{{ $language }}</option>
                            @endforeach

                          </select>
                        </div>

                        <button type="submit" class="btn btn-default waves-effect waves-light m-l-15">Tìm kiếm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="card-box table-responsive">
                <h4 class="m-t-0 header-title"><b>Danh sách bài hát</b></h4>
                <p class="text-muted font-13 m-b-30">
                </p>

                <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th width="10%">Mã bài hát</th>
                        <th>Tên bài hát</th>
                        <th>Ca sỹ</th>
                        <th>Thu phí</th>
                        <th width="10%">Language</th>
                        <th width="10%">Người tạo</th>
                        <th width="10%">Ngày tạo</th>
                        <th width="10%">Ngày cập nhật</th>
                        @if (Auth::user()->can('songs.edit', 'songs.destroy', true))
                        <th width="12%">#</th>
                        @endif
                    </tr>
                    </thead>


                    <tbody>
                    </tbody>
                </table>
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
    $(document).on('click', '.delete-song', function(e) {
        var song_id = $(this).parent().parent().attr('row-data');
        console.log("song_id: " + song_id);
        var action = '/songs/' + song_id;
        $('#delete-song-form').attr('action', action);
    });

    $(function () {
        var datatable = $("#datatable").DataTable({
            searching: false,
            serverSide: true,
            processing: true,
            "createdRow": function ( row, data, index ) {
                $(row).attr("row-data", data['id']);
            },
            ajax: {
                url: "{!! route('songs.datatables') !!}",
                data: function (d) {
                    d.id = $('#id-filter').val();
                    d.name = $('#name-filter').val();
                    d.singer = $('#singer-filter').val();
                    d.language = $('#language-filter').val();
                }
            },
            "columnDefs": [ {
                "targets": 0,
                "data": null,
                'className': "singer-data",
            } ],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'singers', name: 'singers', orderable: false, searchable: false},
                {data: 'has_fee', name: 'has_fee', searchable: false},
                {data: 'language', name: 'language'},
                {data: 'created_by', name: 'created_by'},
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'},
                @if (Auth::user()->can('songs.edit', 'songs.destroy', true))
                {data: 'actions', name: 'actions', orderable: false, searchable: false}
                @endif
//                {data: 'actions', name: 'actions', orderable: false, searchable: false}
            ],
            order: [[0, 'asc']]
        });

        $('#search-form').on('submit', function(e) {
            datatable.draw();
            e.preventDefault();
        });

        $('#search-form select').on('change', function(e) {
            datatable.draw();
        });
        
        $('#search-form input').on('keyup', function(e) {
            if ($(this).val().length == 0) {
                datatable.draw();
            }
        });
    });
</script>

@endpush
