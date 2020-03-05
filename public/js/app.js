$(document).ready(function () {

    $('.nav-link').click(function(e) {
        e.preventDefault();
        $("#home_page").load($(this).attr("href"));
    });

    function nav_redirect(data){
        $('#home_page').empty().append(data);
    }

    /*let url = this.href;
        $.ajax({
            type: "GET",
            url: url
        }).onsuccess(function (data) {
            nav_redirect(data);
        });*/
});