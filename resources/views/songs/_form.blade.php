<div class="form-group">
    <label for="input-name" class="col-sm-4 control-label">Mã bài hát: </label>
    <div class="col-sm-7">
        <input type="text" readonly name="file_name" value="{{ $song['file_name'] }}" class="form-control" id="file-name" placeholder="Mã bài hát">
    </div>
</div>

<div class="form-group">
    <label for="input-name" class="col-sm-4 control-label">Tên*: </label>
    <div class="col-sm-7">
        <input type="text" name="name" value="{{ $song['name'] }}" class="form-control" id="input-name" placeholder="Tên">
    </div>
</div>


<div class="form-group">
    <label for="singers" class="col-sm-4 control-label">Ca sĩ: </label>
    <div class="col-sm-7">
        @foreach ($song['singers'] as $singer)
            <div class="singer">
                <div class="input-group span6 offset3">
                    <input type="text" class="hidden" name="singer[]" value="{{ $singer->id }}"/>
                    <span class="form-control" singer-data="{{ $singer->id }}">{!! $singer->name !!}</span>
                    <a class="btn btn-default input-group-addon btn-block delete-singer" >Xóa</a>
                </div>
                <br/>
            </div>
        @endforeach
        <div class="input-group span6 offset3" id="add-singer">
            <span class="form-control"></span>
            <a class="btn btn-primary input-group-addon btn-block" data-toggle="modal" data-target="#singer-modal">Thêm</a>
        </div>
    </div>
</div>

<div class="form-group">
    <label for="language-picker" class="col-sm-4 control-label">Ngôn ngữ*: </label>
    <div class="col-sm-7">
        <select class="form-control" value="{{ $song['language'] }}" name="language" data-style="btn-white" id="song-language-filter">
            @foreach (config('ktv.languages') as $key => $language)
                <option value="{{ $key }}" @if($song['language']==$key) selected  @endif>{{ $language }}</option>
            @endforeach

        </select>

    </div>
</div>

<div class="form-group">
    <label class="col-sm-4 control-label">Bài hát có thu phí hay không*:</label>
    <div class="col-sm-6">
        <div class="radio radio-primary radio-inline">
            <input type="radio" id="yes" value="1" name="has_fee" @if($song['has_fee']) checked @endif>
            <label for="yes-radio"> Có </label>
        </div>

        <div class="radio radio-primary radio-inline">
            <input type="radio" id="no" value="0" name="has_fee" @if(!$song['has_fee']) checked @endif>
            <label for="no-radio"> Không </label>

        </div>
    </div>
</div>

<hr />

<div class="form-group">
    <label for="singers" class="col-sm-4 control-label">Đơn vị sở hữu nội dung: </label>

    <div class="col-sm-7">
        <br />

        <div class="">
            <label for="" class=""></label>
            <div class="">
                <table id="author" class="table table-striped table-bordered">
                    <tr>
                        <th>Mã</th>
                        <th>Quyền tác giả</th>
                        <th>Phần trăm (%)</th>
                        <th width="20%"></th>
                    </tr>
                    <tr>
                        <td class="id"></td>
                        <td class="name">Nhạc sỹ phú quang</td>
                        <td class="percentage">100</td>
                        <td>
                            <a class="btn btn-primary btn-xs waves-effect waves-light"><i class="fa fa-edit"></i> Sửa</a>
                            <a class="btn btn-default delete-song btn-xs waves-effect waves-light"><i class="fa fa-trash"></i> Xóa</a>
                        </td>
                        <input type="text" class="id" class="hidden" value="1" name="ownerId[]">
                    </tr>
                    <tr id="add-author-row">
                        <td class="id"></td>
                        <td class="name"></td>
                        <td class="percentage"></td>
                        <td>
                            <a id="add-author" class="btn btn-primary btn-xs waves-effect waves-light" data-toggle="modal" data-target="#content-owner-modal"><i class="fa fa-edit"></i> Thêm</a>
                        </td>
                        <input type="text" class="id" class="hidden" value="1" name="ownerId[]">
                    </tr>
                </table>
            </div>
        </div>

        <div class="">
            <label for="" class=""></label>
            <div class="">
                <table id="record" class="table table-striped table-bordered dataTable">
                    <tr>
                        <th>Mã</th>
                        <th>Quyền bản ghi</th>
                        <th>Phần trăm (%)</th>
                        <th width="20%"></th>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Nhạc sỹ phú quang</td>
                        <td>100</td>
                        <td></td>
                    </tr>
                    <tr id="add-record-row">
                        <td class="id"></td>
                        <td class="name"></td>
                        <td class="percentage"></td>
                        <td>
                            <a id="add-record" class="btn btn-primary btn-xs waves-effect waves-light" data-toggle="modal" data-target="#content-owner-modal"><i class="fa fa-edit"></i> Thêm</a>
                        </td>
                        <input type="text" class="id" class="hidden" value="1" name="ownerId[]">
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<hr>

<div class="form-group">
    <label for="created-by"class="col-sm-4 control-label">Người tạo: </label>
    <div class="col-sm-7">
        <input type="text" value="{{ $song['created_by'] }}" id="created_by" placeholder="Người tạo" class="form-control" readonly>
    </div>
</div>

<div class="form-group">
    <label for="webSite" class="col-sm-4 control-label">Thời gian tạo: </label>
    <div class="col-sm-7">
        <input type="text" value="{{ $song['created_at'] }}" id="created-at"  class="form-control" readonly placeholder="Ngày tạo">
    </div>
</div>
<div class="form-group">
    <label for="webSite" class="col-sm-4 control-label">Thời gian sửa đổi lần cuối: </label>
    <div class="col-sm-7">
        <input type="text" value="{{ $song['updated_at'] }}" id="webSite" class="form-control" readonly placeholder="Ngày sửa đổi cuối">
    </div>
</div>