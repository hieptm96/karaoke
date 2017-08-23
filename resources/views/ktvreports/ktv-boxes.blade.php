<div id="ktv-boxes-report">
    <div class="row" ng-app="ktv-form" ng-controller="ktv-ctl">
        <div class="col-md-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="form-inline" role="form" id="search-form">
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
                <h4 class="m-t-0 header-title"><b>Danh sách đầu máy</b></h4>

                <div class="btn-group pull-right m-t-15">
                    {{--<button id="export-report" type="submit" class="btn btn-default waves-effect waves-light">Export <i class="fa fa-file-excel-o"></i><span class="m-l-5"></span></button>--}}
                </div>


                <p class="text-muted font-13 m-b-30">
                </p>

                <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Mã đầu máy</th>
                        <th>Số lần sử dụng bài hát có phí</th>
                        <th>Số lần sử dụng bài hát không phí</th>
                        <th>Tổng số lần sử dụng bài hát</th>
                    </tr>
                    </thead>


                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('inline_scripts')
    <script>
        $(function () {
            var datatable = $("#ktv-boxes-report #datatable").DataTable({
                searching: false,
                serverSide: true,
                processing: true,
                paging: false,
                ajax: {
                    url: "{!! route('ktvBoxesDetailReports.datatables', ['id' => $ktv->id]) !!}",
                    data: function (d) {
                        d.id = {{ $ktv->id }};
                        d.date = $('#ktv-boxes-report .input-daterange-datepicker').val();
                        d.from = '{{ Request::get('from') }}';
                        d.to = '{{ Request::get('to') }}';
                    }
                },
                columns: [
                    {data: 'box_code', name: 'box_code'},
                    {data: 'fee_times', name: 'fee_times'},
                    {data: 'no_fee_times', name: 'no_fee_times'},
                    {data: 'sum_times', name: 'sum_times'},
                ],
                order: [[1, 'desc']]
            });


            // Datepicker
            $('#ktv-boxes-report .input-daterange-datepicker').daterangepicker({
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

            $('#ktv-boxes-report .input-daterange-datepicker').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' : ' + picker.endDate.format('YYYY-MM-DD'));
                datatable.draw();
            });

            $('#ktv-boxes-report .input-daterange-datepicker').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });
    </script>

@endpush
