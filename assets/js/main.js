// alert('hello');
// console.log(wpdb_data);
;(function($){
    $(document).ready(function(){
         $('.wpdb_button').on('click',function(){
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
                    var j_data = JSON.stringify(data);
                    $('.show_first_data').html('<pre>'+ data+'</pre>');
                    $('.show_more_data').html(data[0].title).show();
                    $('.show_more_data').html(data.email).show();
                }
            });
        });

        $('.action_option').on('click',function(){
            let f_task = $(this).data('task');
            // window[f_task]();
            $.ajax({
                url : wpdb_data.ajax_url,
                type : 'POST',
                data : {
                    'action' : 'options_data',
                    'f_task' : f_task,
                    'f_nonce' : wpdb_data.wpdb_nonce,
                },
                success : function(data){
                    console.log(data)
                },
                error : function(){
                    alert("Something Wrong...");
                    console.error('failed');
                }

            })
        });
    });
})(jQuery);
function add_option(){
    alert('add');
}