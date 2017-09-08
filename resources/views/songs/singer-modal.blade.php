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


@push('inline_scripts')
    <script>
        $(document).on('click', '.delete-song', function(e) {
            $('#delete-song-modal').modal("show");
            e.preventDefault();
        });

        function checkExistedSinger(id) {
            console.log(typeof id);
            var singers = $('.singer-id');
            for (var i = 0; i < singers.length; i++) {
                if (singers[i].value == id) {
                    return true;
                }
            }
            return false;
        }

        $(document).on('click', '.select-singer', function() {
            var singerRow = $(this).parent().parent();
            var singerId = singerRow.find('.singer-data').text();
            var singerName = singerRow.find('.singer-name').html();

            if (checkExistedSinger(singerId)) {
                return;
            }

            var addSinger = $('#add-singer');
            var newRow =
                '<div class="singer">'
                + '<div class="input-group span6 offset3">'
                +    '<input class="singer-id hidden" name="singer[]" value="' + singerId + '">'
                +    '<span class="form-control" singer-data=' + singerId + '>' + singerName + '</span>'
                +    '<a class="btn btn-default input-group-addon btn-block delete-singer" >Xóa</a>'
                + '</div>'
                + '<br/>'
                + '</div>'

            addSinger.before(newRow);
        });

        $(document).on('click', '.delete-singer', function() {
            $(this).parent().parent().remove();
        });

        $(function () {
            $.fn.dataTable.ext.errMode = 'none';
            var datatable = $("#datatable").DataTable({
                searching: false,
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{!! route('singers.datatables') !!}",
                    data: function (d) {
                        d.name = $('#name-filter').val();
                        d.sex = $('#sex-filter').val();
                        d.language = $('#language-filter').val();
                    }
                },
                "columnDefs": [ {
                    "targets": -1,
                    "data": null,
                    "defaultContent": "<a class='btn btn-primary select-singer' data-dismiss='modal'>Chọn</button>",
                }, {
                    "targets": 0,
                    "data": null,
                    'className': "singer-data",
                }, {
                    "targets": 1,
                    "data": null,
                    'className': "singer-name",
                } ],
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'sex', name: 'sex'},
                    {data: 'language', name: 'language'},
                    {data: 'select', name: 'select', orderable: false, searchable: false},
                ],
                order: [[2, 'asc']]
            });

            $('#search-form').on('submit', function(e) {
                datatable.draw();
                e.preventDefault();
            });

            $('#search-form').on('change', function(e) {
                datatable.draw();
            });

            $('#name-filter').on('keyup', function(e) {
                var name = $('#name-filter').val();
                if (name.length == 0) {
                    datatable.draw();
                }
            });

            $('#created-by-filter').on('keyup', function(e) {
                var createdBy = $('#created-by-filter').val();
                if (createdBy.length == 0) {
                    datatable.draw();
                }
            });

        });
    </script>

@endpush

