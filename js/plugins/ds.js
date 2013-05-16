var c =0;

$(document).ready(function(){

$('input.autoselect').click( function() { $(this).select(); })
$('div.res').click( function() { $(this).hide(); });
$('input.fn').click( function() { $('div.introd span').text( $('input.fn').val() ) });
$('#ds_menu select').change( function() { 
	var go = $(this).children('option:selected').val(); 
	if (go != "#") { window.location = go }
});

$('li.fn a').click( function() {
		var s = $(this).parent('li.fn').attr('rel');
		var d = $(this).parent('li.fn').attr('data');
		var txt = $('#plugins_pack textarea').text();
		var fnc = $('input.fn').val();
		var str = s+"\n";
		$('#plugins_pack textarea').text(txt+str);
		$('input.fn').val( fnc + d)
});

$('h3 a.rz').click( function() { var U = $(this).attr('href'); $(this).load(U); return false; });




});