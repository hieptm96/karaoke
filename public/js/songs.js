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
    +    '<input class="singer-id hidden" name="singer[]" value="' + singerId + '"></name>'
    +    '<span class="form-control" singer-data=' + singerId + '>' + singerName + '</span>'
    +    '<a class="btn btn-primary input-group-addon btn-block delete-singer" >Xóa</a>'
    + '</div>'
    + '<br/>'
    + '</div>'

    addSinger.before(newRow);
});

$(document).on('click', '.delete-singer', function() {
    $(this).parent().parent().remove();
});

$(function () {
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
