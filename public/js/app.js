$(document).ready(function () {

    // Initialization /home
    $("#home_page").load($('.select').attr("href"), function () {
        $("#loader").hide();
    });

    // Load on navbar click
    $('.nav-link').on("click", function(e) {
        $("#loader").show();
        e.preventDefault();
        $('.nav-link').removeClass("select");
        $(this).addClass("select");
        $("#home_page").load($(this).attr("href"), function () {
            $("#loader").hide();
        });

    });

    // Load on submit
    $("#home_page").on("submit", "form", function (e) {
        e.preventDefault();
        $("#loader").show();
        const form = $(this);
        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: new FormData(this),
            contentType: false,
            processData: false,
            success : function success(response) {
                $("#home_page").load($('.select').attr('href'), function () {
                    $("#loader").hide();
                });
            }
        })
    });

    // Load on link click
    $('#home_page').on("click", "a", function(e) {
        e.preventDefault();
        $("#loader").show();
        $("#home_page").load($(this).attr("href"), function () {
            $("#loader").hide();
        });
    });

    // Load export
    $("#export_card").on("click", "a", function (e) {
        e.preventDefault();
        $("#loader").show();

        $.ajax({
            method: "GET",
            xhrFields: {
                responseType: "blob"
            },
            url: $(this).attr("href"),
            success: function success(response) {
                $("#home_page").empty();
                let falseButton = document.createElement("a");
                falseButton.href = window.URL.createObjectURL(response);
                falseButton.download = "export.csv";

                document.body.append(falseButton);
                falseButton.click();
                falseButton.remove();
                $("#loader").hide();
            }
        })
    })

});