function start(){
    $('#content').height($(window).height() - $('#header').height());

    $(window).resize(function () {
        $('#content').height($(window).height() - $('#header').height());
    });

    $('#upload').leanModal();

    var file = $('#file_field');
    var url = file.data('url');
    file = file.get(0);
    var progress = $('#load_progress');

    var $upload_controls = $('.upload_form, .upload_buttons_wrapper');
    var $results_controls = $('.results_form, .result_buttons_wrapper');
    var $upload_status = $('#upload_status');
    var $results = $('#results');
    var allowed_formats = ['txt', 'doc', 'docx', 'odt', 'pdf'];


    function uploadControls(action, callback){
        action ? $upload_controls.fadeIn(200, callback()) : $upload_controls.fadeOut(200, callback());
    }
    function resultControls(action, callback){
        action ? $results_controls.fadeIn(200, callback()) : $results_controls.fadeOut(200, callback());
    }
    function createMaterialList(elements){
        var $ol = $('<ol class="collection">');
        elements.forEach(function (element, index, array){
            $ol.append($('<li class="collection-item">').text(element));
        });
        return $ol;
    }
    function validate(file_name){
        var extension = file_name.substr(file_name.lastIndexOf('.') + 1);
        return $.inArray(extension, allowed_formats) != -1;
    }

    $('#upload_file').click(function (event) {

        event.preventDefault();

        if (file.files.length) {

            if(!validate(file.files[0].name)){
                Materialize.toast(locale.bad_format, 4000, 'error_toast rounded');
                return;
            }
            var formData = new FormData;

            formData.append('language', $('.text_language input[type=radio]:checked').val());
            formData.append('file', file.files[0]);
            formData.append('save', $('#allow_save:checked').length);

            uploadControls(false, function (){
                window.setTimeout(function (){
                    resultControls(true, function (){
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: formData,
                            cache: false,
                            dataType: 'json',
                            processData: false,
                            contentType: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            xhr: function () {
                                var xhr = $.ajaxSettings.xhr();

                                xhr.upload.addEventListener('progress', function (evt) {
                                    if (evt.lengthComputable) { // если известно количество байт

                                        var percentComplete = Math.ceil(evt.loaded / evt.total * 100);

                                        progress.width(percentComplete + '%');
                                        if(percentComplete == 100) {
                                            $upload_status.text(locale.analysing);
                                            progress.addClass('indeterminate');
                                            progress.removeClass('determinate');
                                            progress.width('auto');
                                        }
                                    }
                                }, false);

                                return xhr;
                            },
                            beforeSend: function (xhr, settings){
                                $upload_status.text(locale.uploading);
                                progress.removeClass('red darken-2');
                                progress.removeClass('indeterminate');
                                progress.addClass('determinate');
                            },
                            success: function (respond, textStatus, jqXHR) {
                                if (typeof respond.error === 'undefined') {
                                    progress.removeClass('indeterminate');
                                    progress.addClass('determinate');
                                    progress.width('100%');

                                    if(respond.topics != undefined){
                                        $results.html(createMaterialList(respond.topics));
                                        $results.parent().show();
                                        $upload_status.text(locale.upload_done);
                                    } else if(respond.error_message != undefined){
                                        progress.addClass('red darken-2');
                                        Materialize.toast(respond.error_message, 4000, 'error_toast rounded');
                                        $upload_status.text(locale.error);
                                    }
                                }
                                else console.log('Some was wrong');
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                $upload_status.text('Error');
                                progress.addClass('red darken-2');
                                progress.removeClass('indeterminate');
                                progress.addClass('determinate');
                                progress.width('100%');
                                console.log(jqXHR);
                            }
                        })
                    });
                }, 500);
            });

        } else {
            // Materialize.toast($toastContent, 4000);
            Materialize.toast(locale.select_file_error, 4000, 'error_toast rounded');
        }

    });
    $('#back_button').click(function (event) {
        event.preventDefault();

        $results.parent().hide();
        $results.html("");

        resultControls(false, function (){
            window.setTimeout(function (){
                uploadControls(true, function (){});
            }, 400);
        });

    });
}