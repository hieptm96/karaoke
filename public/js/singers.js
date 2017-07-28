
// $('delete-singer-modal').submit(function(e) {
//     $.ajax({
//         url: "/singers/delete",
//         method: "POST",
//         data: {singerID: singerID},
//         success: function(response) {
//             var str = '';
//             for (var i = 0; i < response.length; i++) {
//                 str += '<tr><th scope="row">' + (i + 1) + '</td>';
//                 str += '<td>' + response[i].name + '</td>';
//                 str += '<td class="sample-email">' + response[i].email + '</td>';
//                 str += '<td class="text-right"><button type="button" class="btn btn-primary waves-effect select-account" data-dismiss="modal">Select</button></td></tr>';
//             }
//             $('table tbody').html(str);
//         },
//         error: function(error) {
//             console.log(error);
//         }
//     });
//     $(document).on('click', '.select-account', function() {
//         $('#email').val($(this).parent().parent().find('.sample-email').text());
//         $('#password').val('123456');
//     });
// });

$(document).on('click', '[href="#edit-singer-modal"]', function () {
    var singerRow = $(this).parent().parent();

    var singerID = singerRow.attr('data');
    $('#edit-singer-form #singerID').val(singerID);

    var singerName = singerRow.find('#name').html().trim();
    $('#edit-singer-form #name').val(singerName);

    var sex = singerRow.find('#sex').attr('data');
    console.log(sex);
    var sexes = $('#edit-singer-form .sex');
    console.log(  sexes);
    sexes[sex-1].checked = true;
});

$(document).on('click', '[href="#delete-singer-modal"]', function () {
    var singerRow = $(this).parent().parent();
    var singerID = singerRow.attr('data');
    $('#delete-singer-form #singerID').val(singerID);
});
