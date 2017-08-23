@extends('layouts.app')

@push('styles')
    <!-- DataTables -->
    <link href="/vendor/ubold/assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
@endpush

@php
$user = Auth::user();
@endphp

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
                  <form role="form" id="delete-singer-form" method="post" action="">
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
        <div class="col-sm-12">
            @if ($user->can('singers.create'))
            <div class="btn-group pull-right m-t-15">
                <a href="{{ route('singers.create') }}" class="btn btn-default"><i class="md md-add"></i> Thêm ca sĩ </a>
            </div>
            @endif

            <h4 class="page-title">Danh mục ca sĩ</h4>
            <ol class="breadcrumb">
                <li>
                    <a href="#">Ca sĩ</a>
                </li>
                <li class="active">
                    Danh sách
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

    <div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <div class="row">
                <div class="col-sm-12">
                    <form class="form-inline" role="form" id="search-form">
                        <div class="form-group">
                            <input type="text" id="name-filter" class="form-control" placeholder="Tên ca sĩ" name="name" />
                        </div>

                        <div class="form-group">
                            <input type="text" id="created-by-filter" class="form-control" placeholder="Người tạo" name="createdBy" />
                        </div>

                        <div class="form-group">
                          <select class="form-control" id="sex-filter" name="sex" data-style="btn-white">
                            <option value>--Chọn giới tính--</option>
                            @foreach (config('ktv.sexes') as $key => $sex)
                                <option value="{{ $key }}">{{ $sex }}</option>
                            @endforeach

                          </select>
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
                <h4 class="m-t-0 header-title"><b>Danh sách ca sĩ</b></h4>
                <p class="text-muted font-13 m-b-30">
                </p>

                <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th width="2%">Mã</th>
                        <th>Tên ca sĩ</th>
                        <th width="10%">Giới tính</th>
                        <th width="10%">Language</th>
                        <th width="10%">Người tạo</th>
                        <th width="10%">Ngày tạo</th>
                        <th width="10%">Ngày cập nhật</th>
                        @if (Auth::user()->can('singers.edit', 'singers.destroy', true))
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
@endpush

@push('inline_scripts')
<script>
    $(document).on('click', '.delete-singer', function(e) {
        var singer_id = $(this).parent().parent().find('.singer-data').text();
        var action = '/singers/' + singer_id;
        console.log('action: ' + action);
        $('#delete-singer-form').attr('action', action);
    });

    $(function () {
        $.fn.dataTable.ext.errMode = 'none';
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
                    d.createdBy = $('#created-by-filter').val();
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
                {data: 'sex', name: 'sex'},
                {data: 'language', name: 'language'},
                {data: 'created_by', name: 'created_by'},
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'},
                @if (Auth::user()->can('singers.edit', 'singers.destroy', true))
                {data: 'actions', name: 'actions', orderable: false, searchable: false}
                @endif
            ],
            order: [[1, 'asc']]
        });

        $('#search-form').on('submit', function(e) {
            datatable.draw();
            e.preventDefault();
        });

        $('#search-form select').on('change', function(e) {
            datatable.draw();
        });

        $('#search-form input').on('keyup', function(e) {
            var createdBy = $(this).val();
            if (createdBy.length == 0) {
                datatable.draw();
            }
        });
    });
</script>

@endpush
