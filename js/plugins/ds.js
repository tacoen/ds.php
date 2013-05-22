var c =0;

function ds_noscrolling(elem) {
	elem.wrapInner("<div class='ds_noscroll'>");
	var left = elem.offset().left; var top = elem.offset().top; 
	var width = elem.outerWidth(); var height = elem.outerHeight();
	elem.children('div.ds_noscroll').css({
		position: 'fixed',
		top: top+'px', left: left+'px',
		width: width, height: height
	});
}

$(document).ready(function(){

$('input.autoselect').click( function() { $(this).select(); })
$('div.res').click( function() { $(this).hide(); });
$('input.fn').change( function() { $('div.introd span').text( $('input.fn').val() ) });

$('#ds_menu select').change( function() { 
	var go = $(this).children('option:selected').val(); 
	if (go != "#") { window.location = go }
});


/*
$('#plugins_pack textarea').ready( function() {
	var asli = $('#plugins_pack textarea').text();
	$('#plugins_pack textarea').text(asli+"---");
})
*/

var txt = $('#plugins_pack textarea').text();

$('#plugins_pack textarea').bind('input propertychange', function() { txt = $(this).val(); })

$('li.fn a').click( function(e) {
		e.preventDefault();
		var s = $(this).parent('li.fn').attr('rel');
		var d = $(this).parent('li.fn').attr('data');
		var str = s+"\n";
		var update = txt+str;
		var fnc = $('input.fn').val();
		$('#plugins_pack textarea').val(update);
		txt = $('#plugins_pack textarea').val();
		$('input.fn').val( fnc + d)
});

$('h3 a.rz').click( function() { var U = $(this).attr('href'); $(this).load(U); return false; });

if($("#plugins_pack").length > 0) { ds_noscrolling( $("#plugins_pack") ); }


});