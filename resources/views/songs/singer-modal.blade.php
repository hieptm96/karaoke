{{-- singer modal --}}
<div id="singer-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Chọn ca sĩ</h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="form-inline" role="form" id="singer-filter-form">
                            <div class="form-group">
                                <input type="text" id="name-filter" class="form-control" placeholder="Tên ca sĩ" name="name" />
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
                <br />
                <div class="row">
                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th >Mã</th>
                            <th>Tên ca sĩ</th>
                            <th >Giới tính</th>
                            <th >Language</th>
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
