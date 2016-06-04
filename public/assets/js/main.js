var locale = null;

$(function () {
    $('select').material_select();
    var language_selector = $('#language');
    var selector = language_selector.get(0);
    var lang_url = language_selector.attr('data-src');
    var selected_lang = selector.selectedIndex;

    // language_selector.material_select();
    language_selector.change(function () {
        if(selected_lang != selector.selectedIndex){
            window.location.href = lang_url + '/' + selector.options[selector.selectedIndex].getAttribute('value');
            selected_lang = selector.selectedIndex;
        }
    });

    locale = jQuery.parseJSON($('#locale_data').text());

    if(typeof start == 'function') start();
});

function FileUploader(fileInput, submitButton, onBeforeStart, onProgress,
                      onUploaded, onFinished, onError, allowed_formats,
                      onValidateError, getData, maxSize, headers){
    this.allowed_formats = allowed_formats;
    this.url = fileInput.data('url');
    this.file = fileInput.get(0);
    this.maxSize = maxSize * 1024;

    var that = this;
    submitButton.click(function (event){
        event.preventDefault();

        // file not selected
        if(!that.file.files.length){
            onValidateError(0);
            return false;
        }

        // bad file format
        if (!that.validate(that.file.files[0].name)) {
            onValidateError(1);
            return false;
        }

        // big file size
        if(that.file.files[0].size > that.maxSize){
            onValidateError(2);
            return false;
        }

        var data = new FormData;

        if(typeof getData == 'function'){
            var parameters = getData();

            parameters.forEach(function (element, index, array){
                data.append(element[0], element[1]);
            });
        }
        data.append(that.file.name, that.file.files[0]);

        $.ajax({
            url: that.url,
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            processData: false,
            contentType: false,
            headers: headers,
            xhr: function () {
                var xhr = $.ajaxSettings.xhr();

                xhr.upload.addEventListener('progress', function (evt) {
                    if (evt.lengthComputable){

                        var percentComplete = Math.ceil(evt.loaded / evt.total * 100);

                        onProgress(percentComplete);
                        if(percentComplete == 100) onUploaded();
                    }
                }, false);

                return xhr;
            },
            beforeSend: onBeforeStart,
            success: onFinished,
            error: onError
        });

    });
}
FileUploader.prototype.validate = function (file_name){
    var extension = file_name.substr(file_name.lastIndexOf('.') + 1);
    return $.inArray(extension, this.allowed_formats) != -1;
};