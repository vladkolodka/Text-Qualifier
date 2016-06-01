var locale = null;

$(function () {
    var language_selector = $('#language');
    var selector = language_selector.get(0);
    var lang_url = language_selector.attr('data-src');
    var selected_lang = selector.selectedIndex;

    language_selector.material_select();
    language_selector.change(function () {
        if(selected_lang != selector.selectedIndex){
            window.location.href = lang_url + '/' + selector.options[selector.selectedIndex].getAttribute('value');
            selected_lang = selector.selectedIndex;
        }
    });

    locale = jQuery.parseJSON($('#locale_data').text());

    if(typeof start == 'function') start();
});