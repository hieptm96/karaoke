@extends('layouts.app')

@push('styles')
    <!-- DataTables -->
    <link href="/vendor/ubold/assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
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
                  <form role="form" id="delete-song-form" method="post" action="">
                      <input name="_method" value="DELETE" type="hidden">
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
            <div class="btn-group pull-right m-t-15">
                <a href="{{ route('songs.create') }}" class="btn btn-default"><i class="md md-add"></i> Thêm bài hát </a>
            </div>

            <h4 class="page-title">Bài hát</h4>
            <ol class="breadcrumb">
                <li>
                    <a href="#">KTV</a>
                </li>
                <li>
                    <a href="#">Bài hát</a>
                </li>
                <li class="active">
                    Danh sách bài hát
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
                            <label class="sr-only" for="">Tên bài hát</label>
                            <input type="text" id="name-filter" class="form-control" placeholder="Tên bài hát" name="name" />
                        </div>

                        <div class="form-group">
                            <label class="sr-only" for="">Tên ca sĩ</label>
                            <input type="text" id="singer-filter" class="form-control" placeholder="Tên ca sĩ" name="singer" />
                        </div>

                        <div class="form-group col-md-3">
                            {{-- <label for=""></label> --}}
                            <select class="selectpicker" id="owner-types-filter" name="owner-types" data-style="btn-white" title="Chọn loại sử hữu..." multiple>
                                <option value="musican">Nhạc sĩ</option>
                                <option value="title">Lời</option>
                                <option value="singer">Ca sĩ</option>
                                <option value="film">Quay phim</option>
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
                        <th>Tên bài hát</th>
                        <th>Tên file</th>
                        <th>Thu phí</th>
                        <th>Hình thức sở hữu</th>
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
                url: "{!! route('contentowner.datatables', ['id' => $id]) !!}",
                data: function (d) {
                    d.name = $('input[name=name]').val();
                    d.ownerTypes = $('#owner-types-filter').val();
                }
            },
            columns: [
                {data: 'name', name: 'name'},
                {data: 'file_name', name: 'file_name'},
                {data: 'has_fee', name: 'has_fee', searchable: false},
                {data: 'owner_type', name: 'owner_type', searchable: false, orderable: false},
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

        $('#singer-filter').on('keyup', function(e) {
            var createdBy = $('#singer-filter').val();
            if (createdBy.length == 0) {
                datatable.draw();
            }
        });
    });
</script>

@endpush
