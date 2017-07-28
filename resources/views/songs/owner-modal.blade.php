{{-- owner modal --}}
<div id="owner-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Chon đơn vị sở hữu nội dung</h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="form-inline" role="form" id="owner-search-form">
                            <div class="form-group">
                                <input type="text" id="name-filter" class="form-control" placeholder="Tên ca sĩ" name="name" />
                            </div>

                            <button type="submit" class="btn btn-default waves-effect waves-light m-l-15">Tìm kiếm</button>
                        </form>
                    </div>
                </div>
                <br />
                <div class="row">
                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th >Mã</th>
                            <th>Tên ca sĩ</th>
                            <th width="10%"></th>
                        </tr>
                        </thead>


                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
