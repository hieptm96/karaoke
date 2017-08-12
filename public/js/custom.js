$(document).on('click', '.edit-box', function() {
    var boxRow = $(this).parent().parent();
    var code = boxRow.find('.box-code').text();
    var info = boxRow.find('.box-info').text();
    
    console.log('code: ' + $('#edit-box-form input#code'));

    $('#edit-box-form input#code').val( boxRow.find('.box-code').text() );
    $('#edit-box-form textarea#info').text( boxRow.find('.box-info').text() );
});

$(document).on('click', 'button#done', function() {
    var code = $('input#code').val();
    var info = $('textarea#info').text();

    if (boxRow != null) {
        boxRow.find('#code').text(code);
        boxRow.find('#info').text(info);
    }
});

$(document).ready(function() {
    $(document).on('click', '.ktv-delete', function(e) {
        if (!confirm('Bạn chắc chắn muốn xóa?')) return;
        e.preventDefault();
        $('#ktv-delete-form').attr('action', '/admin/ktvs/' + $(this).attr('data-id'));
        $('#ktv-delete-form').submit();
    });

});
