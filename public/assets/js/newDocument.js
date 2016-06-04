function start() {
    var upload_form = $('.upload_form');
    var results_form = $('.results_form');
    var progress_bar = $('#load_progress');
    var status = $('#upload_status');

    new FileUploader(
        $("#file_field"),
        $('#upload_file'),
        function (xhr, settings) {
            console.log('Upload started');

            progress_bar.width(0);
            status.text(locale.uploading);
            upload_form.fadeOut();
            results_form.fadeIn();
        },
        function (progress) {
            console.log('Progress: ' + progress + '%');
            progress_bar.width(progress + '%');
        },
        function () {
            console.log('Uploaded');
            status.text(locale.analysing);
        },
        function (respond, textStatus, jqXHR) {
            console.log('Finished');
            status.text(locale.upload_done);
            window.setInterval(function (){
                results_form.fadeOut();
                upload_form.fadeIn();
            }, 1000);
        },
        function (jqXHR, textStatus, errorThrown) {
            console.log('Error!');
            console.log(jqXHR);
            $('body').html(jqXHR.responseText);
            status.text('Error');
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
                ['topic', $('#topic_id').find('option:selected').val()]
            ];
        },
        10240,
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    );
}