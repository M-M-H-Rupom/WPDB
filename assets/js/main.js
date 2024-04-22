// alert('hello');
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
                    $('.show_first_data').html(data);
                }
            });
        });
    });
})(jQuery);