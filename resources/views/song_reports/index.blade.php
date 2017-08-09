@extends('layouts.app')

@push('styles')
    <!-- DataTables -->
    <link href="/vendor/ubold/assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="/vendor/ubold/assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

@endpush

@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="page-title">Thống kê số tiền bản quyền của các bài hát</h4>
            <ol class="breadcrumb">
                <li>
                    <a href="#">Bài hát</a>
                </li>
                <li>
                    <a href="{{ route('song-reports.index') }}">Thống kê</a>
                </li>
            </ol>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card-box">
            <div class="row">
                <div class="col-sm-12">
                    <form class="form-inline" role="form" id="search-form">
                        <div class="form-group">
                            <label class="sr-only" for="">Tên bài hát</label>
                            <input type="text" id="name-search" class="form-control" placeholder="Tên bài hát" name="name" />
                        </div>home
                        <div class="form-group">
                            <label class="sr-only" for="">Tên file</label>
                            <input type="text" id="file-name-search" class="form-control" placeholder="Tên file" name="file_name" />
                        </div>
                        <div class="form-group m-l-10">
                            <label class="sr-only" for="date-search">Thời gian</label>
                            <input id="date-search" class="form-control input-daterange-datepicker" type="text" name="date" value="" placeholder="Chọn thời gian" style="width: 200px;">
                        </div>
                        <button type="submit" class="btn btn-default waves-effect waves-light m-l-15">Tìm kiếm</button>
                    </form>
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
                        <th width="2%">Mã</th>
                        <th width="20%">Bài hát</th>
                        <th width="10%">Tên file</th>
                        <th width="10%">Có thu phí</th>
                        <th width="10%">Số lần sử dụng</th>
                        <th width="15%">Tổng tiền</th>
                        <th width="10%"></th>
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
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>

<script src="/vendor/ubold/assets/plugins/moment/moment.js"></script>
<script src="/vendor/ubold/assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>

@endpush

@push('inline_scripts')
<script>
    $(function () {

        var datatable = $("#datatable").DataTable({
            searching: false,
            serverSide: true,
            processing: true,
            ajax: {
                url: "{!! route('songReport.datatables') !!}",
                data: function (d) {
                    d.name = $('#name-search').val();
                    d.file_name = $('#file-name-search').val();
                    d.date = $('#date-search').val();
                }
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'file_name', name: 'file_name'},
                {data: 'has_fee', name: 'has_fee'},
                {data: 'total_times', name: 'total_times'},
                {data: 'total_money', name: 'total_money'},
                {data: 'actions', name: 'actions', searchable: false, orderable: false}
            ],
            order: [[5, 'desc']]
        });

        $('#search-form').on('submit', function(e) {
            datatable.draw();
            e.preventDefault();
        });

        $('#search-form').on('change', function(e) {
            datatable.draw();
        });

        $('#name-search').on('keyup', function(e) {
            var name = $(this).val();
            if (name.length == 0) {
                datatable.draw();
            }
        });

        $('#phone-search').on('keyup', function(e) {
            var createdBy = $($this).val();
            if (createdBy.length == 0) {
                datatable.draw();
            }
        });

        $('#date-search').daterangepicker({
            autoUpdateInput: false,
            // startDate: "07/02/2017",
            // endDate: "08/02/2017",
            dateLimit: {
                days: 60
            },
            showDropdowns: true,
            showWeekNumbers: true,
            timePicker: false,
            timePickerIncrement: 1,
            timePicker12Hour: true,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            opens: 'left',
            drops: 'down',
            buttonClasses: ['btn', 'btn-sm'],
            applyClass: 'btn-default',
            cancelClass: 'btn-white',
            separator: ' to ',
            locale: {
                format: 'DD/MM/YYYY',
                applyLabel: 'Submit',
                cancelLabel: 'Clear',
                fromLabel: 'From',
                toLabel: 'To',
                customRangeLabel: 'Custom',
                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                firstDay: 1
            }
        });

        $('#date-search').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' : ' + picker.endDate.format('YYYY-MM-DD'));
            datatable.draw();
        });

        $('#date-search').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            datatable.draw();
        });

        $(document).on('click', '.song-detail', function(e) {
            e.preventDefault();
            if ($('.input-daterange-datepicker').val()) {
                var from = $('.input-daterange-datepicker').val().split(':')[0].trim(' ');
                var to = $('.input-daterange-datepicker').val().split(':')[1].trim(' ');
                $(this).attr('href', $(this).attr('href') + '?from=' + from + '&to=' + to);
            }
            window.location = $(this).attr('href');
        })
    });
</script>

@endpush
