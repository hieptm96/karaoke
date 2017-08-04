@extends('layouts.app')

@push('styles')
<!-- DataTables -->
<link href="/vendor/ubold/assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
<link href="/vendor/ubold/assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="/vendor/ubold/assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
<link href="/css/custom.css" rel="stylesheet" type="text/css"/>

@endpush

@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="page-title">Báo cáo số tiền cần thu của các đơn vị kinh doanh</h4>
            <ol class="breadcrumb">
                <li>
                    <a href="#">Đơn vị kinh doanh</a>
                </li>
                <li class="active">
                    Thống kê
                </li>
            </ol>
        </div>
    </div>

    <div class="row" ng-app="ktv-form" ng-controller="ktv-ctl">
        <div class="col-md-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="form-inline" role="form" id="search-form">
                            <div class="form-group">
                                <label class="sr-only" for="">Tên đơn vị kinh doanh</label>
                                <input type="text" id="name-search" class="form-control" placeholder="Tên đơn vị kinh doanh" name="name" />
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="">Số điện thoại</label>
                                <input type="text" id="phone-search" class="form-control" placeholder="Số điện thoại" name="phone" />
                            </div>
                            <select name="province" id="province" class="form-control fix-select" ng-model="province" ng-change="get_districts()">
                                <option value="">-- Chọn tỉnh -- </option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                @endforeach
                            </select>
                            <select name="district" id="district-search" class="form-control fix-select">
                                <option     value="">-- Chọn Quận/Huyện --</option>
                                <option ng-repeat="district in districts" value="<% district.id %>"><% district.name %></option>
                            </select>
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
                <h4 class="m-t-0 header-title"><b>Danh sách đơn vị kinh doanh</b></h4>

                <div class="btn-group pull-right m-t-15">
                    <button id="export-report" type="submit" class="btn btn-default waves-effect waves-light">Export <i class="fa fa-file-excel-o"></i><span class="m-l-5"></span></button>
                </div>


                <p class="text-muted font-13 m-b-30">
                </p>

                <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th width="2%">Mã</th>
                        <th>Đơn vị kinh doanh</th>
                        <th width="10%">Tỉnh/Thành</th>
                        <th width="10%">Quận/Huyện</th>
                        <th width="10%">Số điện thoại</th>
                        <th width="10%">Số lần sử dụng bài hát</th>
                        <th>Tổng tiền</th>
                        <th width="10%">Thanh toán</th>
                        <th width="7%">#</th>
                        <th width="7%">#</th>
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
<script src="/js/main.js"></script>

<script src="/vendor/ubold/assets/plugins/moment/moment.js"></script>
<script src="/vendor/ubold/assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>

@endpush

@push('inline_scripts')
<script>
    var url = '{{ route('ktvs.getdistricts') }}';
    $(function () {
        var datatable = $("#datatable").DataTable({
            searching: false,
            serverSide: true,
            processing: true,
            ajax: {
                url: "{!! route('ktvreports.datatables') !!}",
                data: function (d) {
                    d.name = $('#name-search').val();
                    d.phone = $('#phone-search').val();
                    d.province = $('#province').val();
                    d.district = $('#district-search').val();
                    d.date = $('.input-daterange-datepicker').val();
                }
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'ktv', name: 'ktv_name'},
                {data: 'province', name: 'province_id'},
                {data: 'district', name: 'district_id'},
                {data: 'phone', name: 'phone'},
                {data: 'times', name: 'times'},
                {data: 'total_money', name: 'fee_total_times'},
                {data: 'fee_status', name: 'fee_status'},
                {data: 'fee_actions', name: 'fee_actions', orderable: false, searchable: false},
                {data: 'actions', name: 'actions', orderable: false, searchable: false},
            ],
            order: [[7, 'asc'], [6, 'desc']]
        });

        $('#name-search').on('keyup', function(e) {
            datatable.draw();
            e.preventDefault();
        });
        $('#phone-search').on('keyup', function(e) {
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

        $(document).on('click', '.ktv-fee-confirm', function(e) {
//            e.preventDefault();
            $.ajax({
                url: "{{ route('ktvreports.store') }}",
                type: "POST",
                data: {
                    "_token": '{{ csrf_token() }}',
                    "ktv_id": $(this).attr('data-id'),
                },
                success: function (response) {
                    if (response.status == true) {
                        datatable.draw();
                    }
//                    console.log(response);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });

        $('#export-report').on('click', function (e) {
            $.ajax({
                url: "{{ route('ktvreports.exportExcel') }}",
                type: "POST",
                data: {
                    "_token": '{{ csrf_token() }}',
                    "name": $('input[name=name]').val(),
                    "phone": $('#phone-search').val(),
                    "province": $('#province').val(),
                    "district": $('#district-search').val(),
                    "date": $('.input-daterange-datepicker').val()
                },
                success: function (res) {
                    location.href = res.path;
                },
                error: function () {

                }
            });
        });

        // Datepicker
        $('.input-daterange-datepicker').daterangepicker({
            autoUpdateInput: false,
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

        $('.input-daterange-datepicker').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' : ' + picker.endDate.format('YYYY-MM-DD'));
            datatable.draw();
        });

        $('.input-daterange-datepicker').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

        $(document).on('click', '.ktv-detail', function(e) {
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
