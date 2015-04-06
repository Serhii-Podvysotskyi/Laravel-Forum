var URL = '';
$(document).ready(function () {
    $("#form_submit").click(function() {
	$("#target_form").submit();
    });
    $("#category_submit").click(function() {
	$("#category_form").submit();
    });
    $(".new_category").click(function() {
	var id = event.target.id;
	var pieces = id.split("-");
	$("#category_form").prop('action', URL + '/category/' + pieces[2] + '/new');
    });
    $(".delete_group").click(function(event) {
	$("#btn_delete_group").prop('href', URL + '/group/' + event.target.id + '/delete');
    });
    $(".delete_category").click(function(event) {
	$("#btn_delete_category").prop('href', URL + '/category/' + event.target.id + '/delete');
    });
    $("#favourite").click(function() {
        $.ajax({
            method: "POST",
            url: document.URL + "/favourite"});
        if($(this).hasClass("btn-default")) {
            $(this).removeClass("btn-default");
            $(this).addClass("btn-warning");
        } else {
            $(this).addClass("btn-default");
            $(this).removeClass("btn-warning");
        }
    });
    $("div#like.like").click(function() {
        var id = $(this).parents("div.row").first().attr('id');
        $.ajax({
            method: "POST",
            url: URL + "/comment/" + id + "/like"})
            .done(function(data) {
                $("div#" + id + ".row div#like.like span").text(data);
            });
        if($(this).hasClass("active")) {
            $(this).removeClass("active");
        } else {
            $(this).addClass("active");
        }
    });
});