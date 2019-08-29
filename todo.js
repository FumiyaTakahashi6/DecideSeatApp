$(function() {
    // 的確なエラーチェックが行われる
    'use strict'

    $('#new_name').focus();

    // ユーザーデータの削除
    $('#todos').on('click', '.delete_todo', function() {
        var id = $(this).parents('li').data('id');
        console.log("削除しました")
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
    // ユーザーデータの更新
    $('#todos').on('click', '.update_todo', function() {
        var id = $(this).parents('li').data('id');
        let name = $("form[id="+id+"]").children('input[id=cheng_name]').val();
        let gender = $("form[id="+id+"]").children('input[name=gender]:checked').val();
        let birthday = $("form[id="+id+"]").children('input[name=birthday_date]').val();
        console.log("更新しました")
        $.post('_ajax.php', {
            id: id,
            name: name,
            gender: gender,
            birthday: birthday,
            mode: 'update',
            token: $('#token').val()
        },function(res){
            console.log(id);
            if (res.gender === '1') {
                $('#todo_' + id ).find('.todo_title').addClass('done')
            } else {
                $('#todo_' + id ).find('.todo_title').removeClass('done')
            }
        })
    });
    

    // ユーザーデータの作成
    $('#new_todo_form').on('click', function() {
        console.log("作成しました")
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
    // テーブルの追加
    $('#new_table').on('click', function() {
        var num = $('#num').val();
        $('#tables').append('<span class= "table" data-table=' + num + '>テーブル ' + num + '人</span>');
        alert("追加しました")
    });

    $('#shuffle_button').on('click', function() {
        
        let table_seats = []
        $('span[class="table"]').each(function(index,element) {
            let seats = $(element).data('table');
            table_seats[index] = seats;
        })

        let participant_id = []
        $('input:checked').each(function(index) {
            let id = $(this).parents('li').data('id');
            participant_id[index] = id;
        })
        console.log(table_seats)
        console.log(participant_id)

        $.ajax({
            type: 'POST',
            url: './random.php',
            dataType:'text',
            data: {
              id : participant_id,
              table_seats : table_seats
            },
            success: function(response) {
              alert(response);
            }
          });
    });
});