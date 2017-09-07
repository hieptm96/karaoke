{{-- owner modal --}}
<div id="content-owner-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width:90%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="title">Chọn đơn vị sở hữu nội dung</h4>
            </div>

            <div class="modal-body" >
                <div ng-app="ktv-form" ng-controller="ktv-ctl">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card-box">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <form class="row form-inline" role="form" id="search-form">
                                            <input type="text" id="owner-type" class="form-control hidden" />
                                            <input type="text" id="name-search" class="form-control" placeholder="Tên đơn vị sở hữu bản quyền" name="name" />
                                            <input type="text" id="phone-search" class="form-control" placeholder="Số điện thoại" name="phone" />
                                            <input type="text" id="email-search" class="form-control" placeholder="Email" name="email" />
                                            <select name="province" id="province" class="form-control" ng-model="province" ng-change="get_districts(province)">
                                                <option value="">-- Chọn tỉnh -- </option>
                                                @foreach ($provinces as $province)
                                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                                @endforeach
                                            </select>
                                            <select name="district" id="district-search" class="form-control">
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


                    {{-- <div class="row" style="height:500px;overflow:auto"> --}}
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box table-responsive">

                                <table id="content-owner-datatable" class="table table-striped table-bordered data-table">
                                    <thead>
                                    <tr>
                                        <th width="2%">Mã</th>
                                        <th width="15%">Tên</th>
                                        <th width="15%">Điện thoại</th>
                                        <th width="15%">Email</th>
                                        <th width="20%">Địa chỉ</th>
                                        <th width="15%">Tỉnh</th>
                                        <th width="15%">Quận/Huyện</th>
                                        <th width="12%">Mã số thuế</th>
                                        <th width="9%">#</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('inline_scripts')
    <script>

        var url = '{{ route('contentowners.getdistricts') }}';
        $(function () {
            $.fn.dataTable.ext.errMode = 'none';
            var contentOwnerDatatable = $("#content-owner-datatable").DataTable({
                searching: false,
                serverSide: true,
                processing: true,
                scrollY: '250px',
                scrollCollapse: false,
                ajax: {
                    url: "{!! route('contentowners.datatables') !!}",
                    data: function (d) {
                        d.type = $('#owner-type').val();
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
                    'className': "owner-id",
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
                order: [[1, 'asc']]
            });

            $('#search-form').on('submit', function(e) {
                contentOwnerDatatable.draw();
                e.preventDefault();
            });

            $('#search-form select').on('change', function(e) {
                contentOwnerDatatable.draw();
            });

            $('#search-form input').on('keyup', function(e) {
                if ($(this).val().length == 0) {
                    contentOwnerDatatable.draw();
                }
            });
        });

        $(document).on('shown.bs.modal', function() {
            var datatable = $('#content-owner-datatable').dataTable();
            datatable.fnAdjustColumnSizing();
        });

    </script>

@endpush
