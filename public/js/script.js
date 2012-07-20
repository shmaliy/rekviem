// JavaScript Document
function page(pagen){
	var par = {'function' : 'set_page', page: pagen, location:window.location.href};
	new Ajax.Request('/index.php', {
		method: 'post',
		parameters: par,
		onCreate : (function(){}).bind(this),
		onComplete : (function(request){
			eval(request.responseText);			
		}).bind(this)
	});		
}
function fade_in_bg(){
	el = $('header_logo_bg2');
	new Effect.Appear(el, { from : el.getOpacity(), to : 0.0 });
}
function fade_out_bg(){
	el = $('header_logo_bg2');
	new Effect.Appear(el, { from : el.getOpacity(), to : 1.0 });
}
function fade_in_pbg(){
	el = $('header_phone_bg2');
	new Effect.Appear(el, { from : el.getOpacity(), to : 0.0 });
}
function fade_out_pbg(){
	el = $('header_phone_bg2');
	new Effect.Appear(el, { from : el.getOpacity(), to : 1.0 });
}
function authorize(form){
	var par = form.serialize();
	new Ajax.Request('/index.php', {
		method: 'post',
		parameters: par,
		onCreate : (function(){}).bind(this),
		onComplete : (function(request){
			eval(request.responseText);
			
		}).bind(this)
	});		
}
function logout(){
	var par = {'function' : 'users->logout'};
	new Ajax.Request('/index.php', {
		method: 'post',
		parameters: par,
		onCreate : (function(){}).bind(this),
		onComplete : (function(request){
			eval(request.responseText);			
		}).bind(this)
	});		
}