// alert('hello');
// console.log(wpdb_data);
;(function($){
    $(document).ready(function(){
        // $('.wpdb_button').on('click',function(){
            let task = $(this).data('task');
            $.ajax({
                url: wpdb_data.ajax_url,
                method: 'POST',
                data: {
                    'action' : 'wpdb_action',
                    'task' : task,
                    'wpdb_nonce' : wpdb_data.wpdb_nonce, 
                },
                success: function(data){
                    console.log(data);
                    var html = '<table>';
                    html += '<tr><th> Title </th> <th> Content </th></tr>';
                     data.forEach(function(item){
                        html += '<tr> <td>' + item.title + '</td> <td>' + item.content + '</td></tr>'
                     });
                    html += '</table>';
                    $('.query_table').html(html).show();
                    // var j_data = JSON.stringify(data);
                    // $('.show_first_data').html('<pre>'+ data+'</pre>');
                    // $('.show_more_data').html(data[0].title).show();
                    // $('.show_more_data').html(data.email).show();
                }
            // });
        });
    });
})(jQuery);