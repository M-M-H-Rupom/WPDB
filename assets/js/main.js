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
                    var j_data = JSON.stringify(data);
                    $('.show_first_data').html('<pre>'+ j_data +'</pre>');
                    $('.show_more_data').html(data.id).show();
                }
            });
        });
    });
})(jQuery);