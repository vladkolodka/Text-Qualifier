$(function (){
    $('#content').height($(window).height() - $('#header').height());

    $('#upload').click(function (){
        $('#content_card').children().fadeOut();
    });

    var language_wrapper = $('.language-selector');
    var language_selector = $('#language');
    var lang_url = language_selector.attr('data-src');

    language_selector.material_select();
    language_selector.change(function (){
        var lang_name = language_wrapper.find(".active>span").text();
        var lang = language_selector.find('option:contains("' + lang_name + '")').val();
        window.location.href = lang_url + '/' + lang;
    });
});
$(window).resize(function (){
    $('#content').height($(window).height() - $('#header').height());
});