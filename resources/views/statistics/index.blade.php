@extends('layouts.app')

@push('styles')
    <!-- DataTables -->
    <link href="/vendor/ubold/assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
    <link href="/vendor/ubold/assets/plugins/custombox/css/custombox.css" rel="stylesheet">
@endpush

@section('content')

    <!-- Page-Title -->
    <div class="row">

        <div class="col-sm-12">
            <div class="btn-group pull-right m-t-15">
                <a href="{{ route('songs.create') }}" class="btn btn-default"><i class="md md-add"></i> Thêm bài hát </a>
            </div>

            <h4 class="page-title">Bài hát</h4>
            <ol class="breadcrumb">
                <li>
                    <a href="#">KTV</a>
                </li>
                <li class="active">
                    Thống kê
                </li>
            </ol>
        </div>
    </div>

    <div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <div class="row">
                <div class="col-sm-12">
                    <form class="form-inline" role="form" id="search-form">
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
                <h4 class="m-t-0 header-title"><b>Thống kê dữ liệu</b></h4>
                <p class="text-muted font-13 m-b-30">
                </p>

                <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Tên bài hát</th>
                        <th>File name</th>
                        <th width="10%">Số lần dùng</th>
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

    $(function () {
        var datatable = $("#datatable").DataTable({
            searching: false,
            serverSide: true,
            processing: true,
            ajax: {
                url: "{!! route('statistics.datatables') !!}",
                data: function (d) {
                    // d.name = $('input[name=name]').val();
                    // d.singer = $('#singer-filter').val();
                    // d.language = $('#language-filter').val();
                }
            },
            columns: [
                {data: 'song_file_name', name: 'song_file_name'},
                {data: 'song_name', name: 'song_name'},
                {data: 'times', name: 'times'}
            ],
            order: [[0, 'asc']]
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

        $('#singer-filter').on('keyup', function(e) {
            var createdBy = $('#singer-filter').val();
            if (createdBy.length == 0) {
                datatable.draw();
            }
        });
    });
</script>

@endpush
