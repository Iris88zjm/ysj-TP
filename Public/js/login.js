(function($) {
    $(function() {
        $('body').on('click', '.login-container .btn-set .btn-login', function(event) {
            var $form = $(event.target).closest('form');
            $form.submit();
            return false;
        });
        $('body').on('keypress', '', function(event) {
            if(event.keyCode === 13){
                $('.login-container form').submit();
            }
        });
        $('.login-container form').validator().on("submit", function(e){
            if(!e.isDefaultPrevented()){
                e.preventDefault();
                $.ajax({
                    url: '/Index/loginpost',
                    data: $('.login-container form').serializeObject(),
                    type: 'POST'
                }).done(function(response) {
                    if(response.success === true){
                        window.location.href = '/admin/dashboard'
                    }
                });
                return false;
            }
        });
    });
})(jQuery);