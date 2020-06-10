$(function()
{
	var url = window.location.pathname;
	var piece = url.split("/");
	var file = piece[3];

	// Will only work if string in href matches with location
	$('ul.nav a[href="'+ file +'"]').parent().addClass('active');
});
