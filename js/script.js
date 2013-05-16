/* will be avaliable for all
   -------------------------
*/

function dbn_addPanel(T,L){
	if ((typeof window.sidebar == "object") && (typeof window.sidebar.addPanel == "function")) {
    		window.sidebar.addPanel (T,L,"");
 	} 
}

jQuery.fn.centerin = function () {
    this.css("position","absolute");
    this.css("top", ( $(window).height() - this.height() ) / 2+$(window).scrollTop() + "px");
    this.css("left", ( $(window).width() - this.width() ) / 2+$(window).scrollLeft() + "px");
    return this;
}

function nid_createCookie(name, value, days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        var expires = "; expires=" + date.toGMTString();
    } else var expires = "";
    document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
}

function nid_readCookie(name) {
    var nameEQ = escape(name) + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return unescape(c.substring(nameEQ.length, c.length));
    }
    return null;
}

function nid_eraseCookie(name) {
    createCookie(name, "", -1);
}


function nid_init(w) {

var m1=$('#nid_top > ul > li:eq(0)');
var m2=$('#nid_top > ul > li:eq(1)');
var m3=$('#nid_top > ul > li:eq(2)');
var m4=$('#nid_top > ul > li:eq(3)');
var m5=$('#nid_top > ul > li:eq(4)');

if ( w > 800) {  m1.show(); m2.show(); m3.show(); m4.show(); m5.show(); $('li.info').show(); }
if ( w < 800) {  m1.show(); m2.show(); m3.show(); m4.show(); m5.hide(); $('li.info').show(); }
if ( w < 580) {  m1.show(); m2.show(); m3.show(); m4.hide(); m5.hide(); $('li.info').hide(); }
if ( w < 430) {  m1.show(); m2.show(); m3.hide(); m4.hide(); m5.hide(); $('li.info').hide(); $('.nx').hide(); }
if ( w < 290) {  m1.show(); m2.hide(); m3.hide(); m4.hide(); m5.hide(); $('li.info').hide(); $('.nx').hide(); }

var h = $(window).height() - 32 - 141; 
$('div.safepaging').css('min-height',h+"px");

}

$(document).ready(function(){

$(".autof li").wrapInner('<div></div>');
$(".autof table tr:odd").css("background","#eef");

$(window).resize(function(){ nid_init($(window).width()); }); 
nid_init($(window).width()); 

$('#tabtab div.tab').hide(); 
$('#tabtab div.tab:first').show(); 
$('#tabtab ul.tabmenu li a:first').addClass('active'); 
$('#tabtab ul.tabmenu li a').click(function(){ 
	$('#tabtab ul.tabmenu li a').removeClass('active'); 
	$(this).addClass('active');
	var currentTab = $(this).attr('href'); 
	$('#tabtab div.tab').hide();
	$(currentTab).show(); 
	return false; 
}); 

}) // doc.ready function //
