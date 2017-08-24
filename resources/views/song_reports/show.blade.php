@extends('layouts.app')

@push('styles')
    <!-- DataTables -->
    <link href="/vendor/ubold/assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="/vendor/ubold/assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="/css/custom.css" rel="stylesheet" type="text/css"/>

@endpush

@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="page-title">Thống kê dữ liệu sử dụng bài hát <strong>{{ $song['name'] }}</strong></h4>
            <ol class="breadcrumb">
                <li>
                    <a href="#">Bài hát</a>
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
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="card-box table-responsive">
                <h4 class="m-t-0 header-title"><b>Danh sách đơn vị kinh doanh</b></h4>

                <p class="text-muted font-13 m-b-30">
                </p>

                <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th width="2%">Mã</th>
                        <th width="20%">Đơn vị kinh doanh</th>
                        <th width="20%">Số điện thoại</th>
                        <th width="20%">Tỉnh/Thành</th>
                        <th width="20%">Quận/Huyện</th>
                        <th width="20%">Số lần sử dụng</th>
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

<script src="/js/main.js"></script>

@endpush

@push('inline_scripts')
<script>
    var url = '{{ route('ktvs.getdistricts') }}';
    $(function () {
        $.fn.dataTable.ext.errMode = 'none';
        var datatable = $("#datatable").DataTable({
            searching: false,
            serverSide: true,
            processing: true,
            ajax: {
                url: "{!! route('songDetailReport.datatables', ['song' => $song['id']]) !!}",
                data: function (d) {
                    d.name = $('#name-search').val();
                    d.phone = $('#phone-search').val();
                    d.province = $('#province').val();
                    d.district = $('#district-search').val();
                    d.date = $('#date-search').val();
                    d.from = '{{ Request::get('from') }}';
                    d.to = '{{ Request::get('to') }}';
                }
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'k.name'},
                {data: 'phone', name: 'k.phone'},
                {data: 'province', name: 'k.province_id'},
                {data: 'district', name: 'k.district_id'},
                {data: 'total_times', name: 'total_times'},
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


    });
</script>

@endpush
