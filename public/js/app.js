$(document).ready(function () {

    $('.nav-link').click(function(e) {
        e.preventDefault();
        $('.nav-link').removeClass("select");
        $(this).addClass("select");
        $("#home_page").load($(this).attr("href"));
    });

    $("#home_page").on("submit", "form", function (e) {
        e.preventDefault();
        const form = $(this);
        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: new FormData(this),
            contentType: false,
            processData: false,
            success : function success(response) {
                $("#home_page").load($('.select').attr('href'));
            }
        })
    });

    $('#home_page').on("click", "a", function(e) {
        e.preventDefault();
        $("#home_page").load($(this).attr("href"));
    });

});