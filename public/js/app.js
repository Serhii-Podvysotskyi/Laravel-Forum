var URL = '';
$(document).ready(function ()
{
	$("#form_submit").click(function()
	{
		$("#target_form").submit();
	});

	$("#category_submit").click(function()
	{
		$("#category_form").submit();
	});

	$(".new_category").click(function()
	{
		var id = event.target.id;
		var pieces = id.split("-");
		$("#category_form").prop('action', URL + '/forum/category/' + pieces[2] + '/new');
	});

	$(".delete_group").click(function(event)
	{
		$("#btn_delete_group").prop('href', URL + '/forum/group/' + event.target.id + '/delete');
	});

	$(".delete_category").click(function(event)
	{
		$("#btn_delete_category").prop('href', URL + '/forum/category/' + event.target.id + '/delete');
	});
});