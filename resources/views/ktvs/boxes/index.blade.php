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

    {{--@include('ktvs.boxes.box-modal')--}}

    {{-- delete song modal --}}
    <div id="delete-box-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">Xóa đầu máy/thiết bị phát</h3>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc muốn xóa đầu máy/thiết bị phát không?</p>
                </div>
                <div class="modal-footer">
                    <div class="custom-modal-text text-left">
                        <form role="form" id="delete-box-form" method="post" action="">
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

            @if ($user->can('ktvs.create'))
            <div class="btn-group pull-right m-t-15">
                <a href="{{ route('ktvs.boxes.create', ['ktv' => $ktv->id]) }}"><button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light"><i class="md md-add"></i> Thêm mới </button></a>
            </div>
            @endif

            <h4 class="page-title">Danh mục đơn vị kinh doanh</h4>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('ktvs.index') }}">Đơn vị kinh doanh</a>
                </li>
                <li>
                    {{ $ktv->name }}
                </li>
                <li class="active">
                    Danh sách đầu máy/thiết bị phát
                </li>
            </ol>
        </div>
    </div>

    @include('flash-message::default')

    @include('common.request_errors')


    <div class="row">
        <div class="col-sm-12">
            <div class="card-box table-responsive">
                <h4 class="m-t-0 header-title"><b>Danh sách đầu máy/thiết bị phát</b></h4>
                <p class="text-muted font-13 m-b-30">
                </p>

                <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th width="10%">Mã</th>
                        <th>Thông tin</th>
                        <th width="15%"></th>
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
<script src="/js/custom.js"></script>

@endpush

@push('inline_scripts')
<script>

    $(document).on('click', '.delete-box', function(e) {
        var boxRow = $(this).parent().parent();
        var action = window.location.href + '/' + boxRow.attr('box-data');
//        console.log('action: ' + action);
        $('#delete-box-form').attr('action', action);
    });

    var dataSet = [];

    $(function () {
        $.fn.dataTable.ext.errMode = 'none';
        var datatable = $("#datatable").DataTable({
            searching: true,
            // serverSide: true,
            processing: true,
            "createdRow": function ( row, data, index ) {
                $(row).attr('box-data', data['id']);
            },
            "columnDefs": [ {
                    "targets": 0,
                    "className": "box-code"
                },
                {
                    "targets": 1,
                    "className": "box-info"
                }
            ],
            data: dataSet,
            columns: [
                {data: 'code'},
                {data: 'info', name: 'name'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "oLanguage": {
                "sSearch": "Lọc: "
            },
            order: [[0, 'asc']]
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


        $.ajax({
            url: '{{ route('ktvs.boxes.datatables', ['ktv' => $ktv->id]) }}',
            method: 'get',
            dataType: 'json',
            beforeSend: function() {
                $('.dataTables_processing', $('#datatable').closest('.dataTables_wrapper')).show();
            },
            success: function(data) {
                datatable.clear().rows.add(data).draw()
                $('.dataTables_processing', $('#datatable').closest('.dataTables_wrapper')).hide();
            }
        });

    });
</script>

@endpush
