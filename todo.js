$(function() {
    // 的確なエラーチェックが行われる
    'use strict'

    $('#new_name').focus();

    //delete
    $('#todos').on('click', '.delete_todo', function() {
        var id = $(this).parents('li').data('id');
        console.log("ccc")
        if (confirm('are you sure?')) {
            $.post('_ajax.php', {
                id: id,
                mode: 'delete',
                token: $('#token').val()
            },function(){
                $('#todo_' + id ).fadeOut(800);
            });
        }
    })
    //update
    $('#todos').on('click', '.update_todo', function() {
        var id = $(this).parents('li').data('id');

        $.post('_ajax.php', {
            id: id,
            mode: 'update',
            token: $('#token').val()
        },function(res){
            if (res.gender === '1') {
                $('#todo_' + id ).find('.todo_title').addClass('done')
            } else {
                $('#todo_' + id ).find('.todo_title').removeClass('done')
            }
        })
    });
    

    //create
    $('#new_todo_form').on('click', function() {

        var name = $('#new_name').val();
        var gender = $('input[name="gender"]:checked').val();
        var birthday = $('input[name="date"]').val();
        $.post('_ajax.php', {
            name: name,
            gender: gender,
            birthday: birthday,
            mode: 'create',
            token: $('#token').val()
        },function(res){
            var $li = $('#todo_template') .clone();
            $li
                .attr('id', 'todo_' + res.id)
                .data('id', res.id)
                .find('.todo_title').text(name);
            $('#todos').prepend($li.fadeIn());
            $('#new_name').val('').focus();

        });
        return false;
    });
});