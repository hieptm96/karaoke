
<div class="form-group">
    <label for="input-name" class="col-sm-4 control-label">Tên*: </label>
    <div class="col-sm-7">
        <input type="text" name="name" value="{{ isset($song) ? old('phone', $song['name']) : old('name') }}" class="form-control" id="input-name" placeholder="Tên">
    </div>
</div>


<div class="form-group">
    <label for="singers" class="col-sm-4 control-label">Ca sĩ: </label>
    <div class="col-sm-7">
        @if (isset($song))
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
        @endif
        <div class="input-group span6 offset3" id="add-singer">
            <span class="form-control"></span>
            <a class="btn btn-primary input-group-addon btn-block" data-toggle="modal" data-target="#singer-modal">Thêm</a>
        </div>
    </div>
</div>

<div class="form-group">
    <label for="language-picker" class="col-sm-4 control-label">Ngôn ngữ*: </label>
    <div class="col-sm-7">
        <select class="form-control" name="language" data-style="btn-white" id="song-language-filter">
            @foreach (config('ktv.languages') as $key => $language)
                <option value="{{ $key }}" @if(isset($song) && $song['language']==$key) selected  @endif>{{ $language }}</option>
            @endforeach

        </select>

    </div>
</div>

<div class="form-group">
    <label class="col-sm-4 control-label">Bài hát có thu phí hay không*:</label>
    <div class="col-sm-6">
        <div class="radio radio-primary radio-inline">
            <input type="radio" id="yes" value="1" name="has_fee" @if(isset($song) && $song['has_fee']) checked @endif checked>
            <label for="yes-radio"> Có </label>
        </div>

        <div class="radio radio-primary radio-inline">
            <input type="radio" id="no" value="0" name="has_fee" @if(isset($song) && !$song['has_fee']) checked @endif>
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
                <table id="author" class="table table-striped table-bordered" owner-type="{{ array_search('author', config('ktv.contentOwnerTypes')) }}">
                    <tr>
                        <th width="10%">Mã</th>
                        <th>Quyền tác giả</th>
                        <th width="15%">Phần trăm (%)</th>
                        <th width="20%"></th>
                    </tr>

                    @if (!empty($song['contentOwners']['author']))
                        @foreach ($song['contentOwners']['author'] as $owner)
                            <tr class="content-owner">
                                <td class="id"><input size="10" class="input-td" name="authorIds[]" id="owner-id" type="text" readonly value="{{ $owner['id'] }}"></td>
                                <td class="name">{{ $owner['name'] }}</td>
                                <td class="percentage"><input size="6" id="percentage" name="authorPercentages[{{ $owner['id'] }}]"
                                                              class="input-td autonumber" data-a-sep="," data-a-dec="." type="text" value="{{ $owner['percentage'] }}"></td>
                                <td>
                                    <a class="btn btn-primary btn-xs waves-effect waves-light edit-owner" data-toggle="modal" data-target="#content-owner-modal"><i class="fa fa-edit"></i> sửa</a>
                                    <a class="btn btn-default delete-owner btn-xs waves-effect waves-light"><i class="fa fa-trash"></i> Xóa</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif

                    <tr id="add-content-owner-row">
                        <td class="id"></td>
                        <td class="name"></td>
                        <td class="percentage"></td>
                        <td>
                            <a id="add-author" class="add-content-owner-btn btn btn-primary btn-xs waves-effect waves-light" data-toggle="modal" data-target="#content-owner-modal"><i class="fa fa-edit"></i> Thêm</a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="">
            <label for="" class=""></label>
            <div class="">
                <table id="record" class="table table-striped table-bordered dataTable" owner-type="{{ array_search('record', config('ktv.contentOwnerTypes')) }}">
                    <tr>
                        <th width="10%">Mã</th>
                        <th>Quyền bản ghi</th>
                        <th width="15%">Phần trăm (%)</th>
                        <th width="20%"></th>
                    </tr>

                    @if (!empty($song['contentOwners']['record']))
                        @foreach ($song['contentOwners']['record'] as $owner)
                            <tr class="content-owner">
                                <td class="id"><input size="10" class="input-td" name="recordIds[]" id="owner-id" type="text" readonly value="{{ $owner['id'] }}"></td>
                                <td class="name">{{ $owner['name'] }}</td>
                                <td class="percentage"><input size="6" id="percentage" name="recordPercentages[{{ $owner['id'] }}]"
                                                              class="input-td autonumber" data-a-sep="," data-a-dec="." type="text" value="{{ $owner['percentage'] }}"></td>
                                <td>
                                    <a class="btn btn-primary edit-owner btn-xs waves-effect waves-light" data-toggle="modal" data-target="#content-owner-modal"><i class="fa fa-edit"></i> sửa</a>
                                    <a class="btn btn-default delete-owner btn-xs waves-effect waves-light"><i class="fa fa-trash"></i> Xóa</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif

                    <tr id="add-content-owner-row">
                        <td class="id"></td>
                        <td class="name"></td>
                        <td class="percentage"></td>
                        <td>
                            <a id="add-record" class="add-content-owner-btn btn btn-primary btn-xs waves-effect waves-light" data-toggle="modal" data-target="#content-owner-modal"><i class="fa fa-edit"></i> Thêm</a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

@if (isset($song))
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
@endif

@push('inline_scripts')
<script src="/vendor/ubold/assets/plugins/bootstrap-inputmask/bootstrap-inputmask.min.js" type="text/javascript"></script>
<script src="/vendor/ubold/assets/plugins/autoNumeric/autoNumeric.js" type="text/javascript"></script>
@endpush


@push('inline_scripts')
    <script>
        var rowTemplate =
            '<tr class="content-owner">'
            +    '<td class="id"><input size="10" class="input-td" id="owner-id" type="text" readonly></td>'
            +    '<td class="name"></td>'
            +    '<td class="percentage"><input size="6" id="percentage" name="percentage" class="input-td autonumber" data-a-sep="," data-a-dec="." type="text"></td>'
            +    '<td>'
            +    '    <a class="btn btn-primary btn-xs waves-effect waves-light edit-owner" data-toggle="modal" data-target="#content-owner-modal"><i class="fa fa-edit"></i> sửa</a>'
            +    '    <a class="btn btn-default delete-owner btn-xs waves-effect waves-light"><i class="fa fa-trash"></i> Xóa</a>'
            +    '</td>'
            +'</tr>';


        function updatePercentage(table) {
            var contentOwnerRows = table.find('.content-owner');

            console.log('length:', contentOwnerRows.length);

            var percentagePerOwner = (100 / contentOwnerRows.length).toFixed(2);
            contentOwnerRows.each(function() {
                $(this).find('#percentage').val(percentagePerOwner);
            });
        }

        function ContentOwnerManager() {
            this.ownerTable = null;
            this.ownerRowToEdit = null;
            this.action = null; // "add" or "edit"
            this.ownerType = null; // "author" or "record"

            this.addOwnerRow = function(ownerRowData) {
                var ownerId = ownerRowData.find('.owner-id').html();

                if (this.checkExistedOwnerId(ownerId)) {
                    return;
                }

                var beforeElement = this.ownerTable.find('#add-content-owner-row');

                var newRow = $(rowTemplate).clone().insertBefore(beforeElement);

                newRow.find('#owner-id').val(ownerId);
                newRow.find('#owner-id').attr('name', this.ownerType + 'Ids[]');
                newRow.find('.name').html(ownerRowData.find('.owner-name').html());
                newRow.find('#percentage').attr('name', this.ownerType + 'Percentages[' + ownerId + ']');

                updatePercentage(this.ownerTable);
            }

            this.editOwnerRow = function(selectedOwnerRow) {
                var ownerId = selectedOwnerRow.find('.owner-id').html();

                if (this.checkExistedOwnerId(ownerId)) {
                    return;
                }

                this.ownerRowToEdit.find('#owner-id').val(ownerId);
                this.ownerRowToEdit.find('.name').html(selectedOwnerRow.find('.owner-name').html());

                var inputName = this.ownerRowToEdit.find('#percentage').attr('name');
                var newInputName = inputName.replace(/[0-9]+/g, ownerId);
                this.ownerRowToEdit.find('#percentage').attr('name', newInputName);
            }

            this.checkExistedOwnerId = function(ownerId) {
                var contentOwnerRows = this.ownerTable.find('.content-owner');
                for (let i = 0; i < contentOwnerRows.length; i++) {
                    if ($(contentOwnerRows.get(i)).find('#owner-id').val() === ownerId) {
                        return true;
                    }
                }

                return false;
            }


            this.handleSelectOwner = function(selectedOwnerRow) {
                if (this.action === 'add') {
                    this.addOwnerRow(selectedOwnerRow);
                } else if (this.action === 'edit') {
                    this.editOwnerRow(selectedOwnerRow);
                }
            }

            this.registerAddOwnerAction = function(ownerTable, ownerType) {
                this.ownerTable = ownerTable;
                this.action = 'add';
                this.ownerType = ownerType;
            }

            this.registerEditOwnerAction = function(ownerTable, ownerRowToEdit) {
                this.ownerTable = ownerTable;
                this.action = 'edit';
                this.ownerRowToEdit = ownerRowToEdit;
            }
        }

        var contentOwnerManager = new ContentOwnerManager();


        $(function() {
            $('#songs-edit').validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 255
                    },
                    file_name: {
                        required: true,
                        maxlength: 255
                    }
                },
                messages: {
                    name: {
                        required: "Tên không được để trống",
                        maxlength: "Tên tối đa 255 ký tự"
                    },
                    file_name: {
                        required: "Mã bài hát không được để trống",
                        maxlength: "Mã bài hát tối đa 255 ký tự"
                    }
                }
            });

            $(document).on('click', '#add-author', function() {
                $('input#owner-type').val({{ array_search('author', config('ktv.contentOwnerTypes')) }});

                var table = $(this).closest('table');
                contentOwnerManager.registerAddOwnerAction(table, 'author');
            });

            $(document).on('click', '#add-record', function() {
                $('input#owner-type').val({{ array_search('record', config('ktv.contentOwnerTypes')) }});

                var table = $(this).closest('table');
                contentOwnerManager.registerAddOwnerAction(table, 'record');
            });

            $(document).on('click', '.select-owner', function(e) {
                var row = $(this).parent().parent();
                contentOwnerManager.handleSelectOwner(row);
            });

            $(document).on('click', '.delete-owner', function(e) {
                var table = $(this).closest('table');
                $(this).parent().parent().remove();
                updatePercentage(table);
            });

            $(document).on('click', '.edit-owner', function(e) {
                $('input#owner-type').val($(this).closest('table').attr('owner-type'));

                var row = $(this).parent().parent();
                var table = $(this).closest('table');
                contentOwnerManager.registerEditOwnerAction(table, row);
            });
        });

        $(function($) {
            $('.autonumber').autoNumeric('init');
        });

    </script>

@endpush
