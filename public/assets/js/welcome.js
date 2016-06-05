function start(){
    $('#content').height($(window).height() - $('#header').height());

    $(window).resize(function () {
        $('#content').height($(window).height() - $('#header').height());
    });

    $('#upload').leanModal();


    var progress = $('#load_progress');
    var $upload_controls = $('.upload_form, .upload_buttons_wrapper');
    var $results_controls = $('.results_form, .result_buttons_wrapper');
    var $upload_status = $('#upload_status');
    var $results = $('#results');

    function createMaterialList(elements){
        var $ol = $('<ol class="collection">');
        elements.forEach(function (element, index, array){
            $ol.append($('<li class="collection-item">').text(element));
        });
        return $ol;
    }

    new FileUploader(
        $("#file_field"),
        $('#upload_file'),
        function (xhr, settings) {
            console.log('Upload started');

            progress.width(0);

            $upload_controls.fadeOut(200);

            window.setTimeout(function () {
                $results_controls.fadeIn(200);
            }, 250);


            $upload_status.text(locale.uploading);

            progress.removeClass('red darken-2 indeterminate');
            progress.addClass('determinate');

        },
        function (progress_num) {
            console.log('Progress: ' + progress_num + '%');
            progress.width(progress_num + '%');
        },
        function () {
            console.log('Uploaded');

            $upload_status.text(locale.analysing);
            progress.addClass('indeterminate');
            progress.removeClass('determinate');
            progress.width('auto');
        },
        function (respond, textStatus, jqXHR) {
            console.log('Finished');
            console.log(respond);
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
        function (jqXHR, textStatus, errorThrown) {
            console.log('Error!');

            $upload_status.text('Error');
            progress.addClass('red darken-2');
            progress.removeClass('indeterminate');
            progress.addClass('determinate');
            progress.width('100%');
            console.log(jqXHR);
        },
        ['txt', 'doc', 'docx', 'odt', 'pdf'],
        function (error_num) {
            switch (error_num) {
                case 0:
                    Materialize.toast(locale.select_file_error, 4000, 'error_toast rounded');
                    break;
                case 1:
                    Materialize.toast(locale.bad_format, 4000, 'error_toast rounded');
                    break;
                case 2:
                    Materialize.toast(locale.big_file_size, 4000, 'error_toast rounded')
                    break;
            }
        },
        function () {
            return [
                ['language', $('.text_language input[type=radio]:checked').val()],
                ['save', $('#allow_save:checked').length]
            ];
        },
        10240,
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    );
    
    $('#back_button').click(function (event) {
        event.preventDefault();

        $results.parent().hide();
        $results.html("");

        $results_controls.fadeOut(200);
        $upload_controls.fadeIn(200);

    });
}