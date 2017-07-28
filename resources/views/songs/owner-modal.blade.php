{{-- owner modal --}}
<div id="owner-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width:90%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Chon đơn vị sở hữu nội dung</h4>
            </div>

            <div class="modal-body">
                <div ng-app="ktv-form" ng-controller="ktv-ctl">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card-box">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <form class="row form-inline" role="form" id="search-form">
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

                                <table id="content-owner-datatable" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th width="2%">Mã</th>
                                        <th width="20%">Tên</th>
                                        <th width="10%">Điện thoại</th>
                                        <th width="20%">Email</th>
                                        <th width="20%">Địa chỉ</th>
                                        <th width="20%">Tỉnh</th>
                                        <th width="20%">Quận/Huyện</th>
                                        <th width="9%">Mã số thuế</th>
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
