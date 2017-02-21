(function($) {
    $(function() {
        Dropzone.autoDiscover = false;
        $('.dropzone').dropzone({
            maxFilesize: 3,
            acceptedFiles: ".csv, .xls",
            paramName: "csv_file",
            maxFiles: 1,
            dictDefaultMessage: '点击该区域并选择上传的csv文件',
            //addRemoveLinks: true,
            init: function() {
                this.on("complete", function(file) {
                    if(file.status == 'error'){
                        // setTimeout("window.location.reload();",2000);
                    }
                }),
                this.on("success", function(file, res) {
                    if(res.success === true){
                        $('.import-message').addClass('active');
                        $('.import-message').html(res.data + ' devices have been imported.');
                        // setTimeout("window.location.reload();",2000);
                    }else{
                        // setTimeout("window.location.reload();",2000);
                    }
                })
            }
        });

        $('body').on('click', '.switch-left-col ul li', function(event) {
            $(event.target).closest('ul').find('li').removeClass('active');
            $('.switch-right-col div.switch-item').removeClass('active');
            $(this).addClass('active');
            var t = $(this).index();
            $('.switch-right-col div.switch-item:eq(' + t + ')').addClass('active');
        });

        $('body').on('click', '.right-column .switch-right-col .new-device .btn-set .btn-add', function(event) {
            var $form = $(event.target).closest('form');
            $form.submit();
            return false;
        });
        if(group ==1){
            var _url = '/devices/newpost';
        }else{
            var _url = '/adevices/newpost';
        }
        $('.new-device form').validator().on("submit", function(e){
            console.log($('.new-device form').serializeObject());
            if(!e.isDefaultPrevented()){
                e.preventDefault();
                $.ajax({
                    url: _url,
                    data: $('.new-device form').serializeObject(),
                    type: 'POST'
                }).done(function(response) {
                    console.log(response);
                });
                return false;
            }
        });

        $('body').on('click', '.right-column .edit-device .btn-set .btn-add', function(event) {
            var $form = $(event.target).closest('form');
            $form.submit();
            return false;
        });
        $('.edit-device form').validator().on("submit", function(e){
            console.log($('.edit-device form').serializeObject());
            if(!e.isDefaultPrevented()){
                e.preventDefault();
                $.ajax({
                    url: '/devices/editpost',
                    data: $('.edit-device form').serializeObject(),
                    type: 'POST'
                }).done(function(response) {
                    console.log(response);
                });
                return false;
            }
        });

    });
})(jQuery);