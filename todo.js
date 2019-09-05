$(function() {
    // 的確なエラーチェックが行われる
    'use strict'

    $('#new_name').focus();

    // ユーザーデータの削除
    $('#todos').on('click', '.delete_todo', function() {
        console.log("削除しました")
        let id = $(this).parents('li').data('id');
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
        console.log("更新しました")
        let id = $(this).parents('li').data('id');
        let name = $("form[id="+id+"]").children('input[id=chang_name]').val();
        let gender = $("form[id="+id+"]").children('input[name=gender]:checked').val();
        let birthday = $("form[id="+id+"]").children('input[name=birthday_date]').val();
        let department_id = $("form[id="+id+"]").children('#department').val();
        $.post('_ajax.php', {
            id: id,
            name: name,
            gender: gender,
            birthday: birthday,
            department_id: department_id,
            mode: 'update',
            token: $('#token').val()
        },function(){
        })
    });
    

    // ユーザーデータの作成
    $('#new_todo_form').on('click', function() {
        console.log("作成しました")
        let name = $('#new_name').val();
        let gender = $('input[name="gender"]:checked').val();
        let birthday = $('input[name="date"]').val();
        let department_id = $('#department').val();

        $.post('_ajax.php', {
            name: name,
            gender: gender,
            birthday: birthday,
            department_id: department_id,
            mode: 'create',
            token: $('#token').val()
        },function(){
            location.reload();
        });
        return false;
    });

    // テーブルの追加
    $('#new_table').on('click', function() {
        let num = $('#num').val();
        $('#tables').append('<span class= "table" data-table=' + num + '>テーブル ' + num + '人</span>');
    });

    $('#shuffle_button').on('click', function() {
        let table_seats = []
        $('span[class="table"]').each(function(index,element) {
            let seats = $(element).data('table');
            table_seats[index] = seats;
        })

        let participant_ids = []
        $('input:checked').each(function(index) {
            let id = $(this).parents('li').data('id');
            participant_ids[index] = id;
        })

        $.ajax('./random.php',{
            type: 'POST',
            dataType:'text',
            data: {
              ids : participant_ids,
              table_seats : table_seats
            },
        })
        .done(function (res) {
            let seat_results = JSON.parse(res);
            if(typeof seat_results === "string"){
                alert(seat_results);
            } else {
                $('#seat_results').empty();
                seat_results.forEach(function( table ) {
                    $('#seat_results').append('<tr><th scope="row">テーブル(' + table.length + '人席)</th></tr>');
                    table.forEach(function( seat ) {
                        $('#seat_results').append('<tr><th scope="row">' + seat['name'] + '</th><th scope="row">' + seat['department_id'] + '</th></tr>');
                    }); 
                }); 
            }
        })
    });
});