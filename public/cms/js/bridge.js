var fade = {
    step    : 0.1,
    delay   : 5,
    timer   : null,
    setOpacity : function(elem, nOpacity) {
        if (typeof elem == 'string') elem = document.getElementById(elem);
        var props = ['MozOpacity', 'KhtmlOpacity', 'opacity'];
        for (var i in props) {
            if (typeof elem.style[props[i]] == 'string') {
                elem.style[props[i]] = nOpacity;
                return;
            }
        }
        // IE 6+
        try {
            nOpacity = 100 * parseFloat(nOpacity);
            if ((oAlpha = elem.filters['DXImageTransform.Microsoft.alpha'] || elem.filters.alpha)) oAlpha.opacity = nOpacity;
            else elem.style.filter += "progid:DXImageTransform.Microsoft.Alpha(opacity="+nOpacity+");";
        } catch (e) {
            // IE <= 5.5 OR Opera < 9 OR another browser. Do nothing
        }
    },
    getOpacity : function(elem){
    	elem = document.getElementById(elem);
        if (elem){
        	var cs = window.getComputedStyle(elem, "");
        	var op;
        	if (navigator.userAgent.indexOf("MSIE")!= -1){op = elem.filters.alpha['opacity']/100;}
        	else {op = cs.getPropertyValue("opacity");}
        	//alert(op);
        	return parseFloat(op);
        }
    },
    _out : function(id, from, to, callback) {
    	from -= this.step;
        from = from <= to ? to : from;
        if (this.doit(id, from, to, callback)) 
            this.timer = setTimeout("fade._out('"+id+"', "+from+", "+to+", '"+(callback ? callback : '')+"')", this.delay);
    },
    _in : function(id, from, to, callback) {
        from += this.step;
        from = from >= to ? to : from;
        if (this.doit(id, from, to, callback)) 
            this.timer = setTimeout("fade._in('"+id+"', "+from+", "+to+", '"+(callback ? callback : '')+"')", this.delay);
    },
    doit : function(id, from, to, callback) {
        this.setOpacity(id, from);
        clearTimeout(this.timer);
        if (from == to) {
            if (callback) eval(callback+'()');
        } else return true;
    }
};

if (!window.getComputedStyle) {
    window.getComputedStyle = function(el, pseudo) {
        this.el = el;
        this.getPropertyValue = function(prop) {
            var re = /(\-([a-z]){1})/g;
            if (prop == 'float') prop = 'styleFloat';
            if (re.test(prop)) {
                prop = prop.replace(re, function () {
                    return arguments[2].toUpperCase();
                });
            }
            return el.currentStyle[prop] ? el.currentStyle[prop] : null;
        };
        return this;
    };
}

function message(mes){
	text = document.getElementById('info_text');
	text.innerHTML = mes;
	fade._in('info_float', fade.getOpacity('info_float'), 1);
	var t = setTimeout("message_hide()", 3000);
}

function message_hide(){ fade._out('info_float', 1, 0, 'message_clear'); }
function message_clear(){ text = document.getElementById('info_text'); text.innerHTML = ''; }

function call(module, method, data){
	if (data){ xajax_exe(module, method, data); }
	else { xajax_exe(module, method); }
}

function gethiddenparam(param){ return (param == '') ? 'null' : param; }
function sethiddenparam(mod,param){
	var cb = getcheckbox('popup');
	var out = (cb != 'null') ? cb.join('|') : '';
	//alert(cb);
	eval('document.forms.'+mod+'.'+param+'.value = "'+out+'";');
	modal.hide();
}

function getform(f){
	if (fm = document.forms[f]){
		var fe = fm.elements;
		var e = new Array();
		for (var j=0; j<fe.length; j++){
			if (fe[j].type == 'text'){
				e[e.length] = new Array(fe[j].name, fe[j].value);
			}
			else if (fe[j].type == 'textarea'){
				var content = false;
				content = tinyMCE.get(fe[j].id).getContent();
				if (content != false || content == ''){
					e[e.length] = new Array(fe[j].name, content);
				}else{
					e[e.length] = new Array(fe[j].name, fe[j].value);
				}
			}
			else if (fe[j].type == 'checkbox'){
				if (fe[j].checked){
					if (fe[j].value != 'on'){
						e[e.length] = new Array(fe[j].name, fe[j].value);
					}
					else if (fe[j].value == 'on'){
						e[e.length] = new Array(fe[j].name, 'true');
					}
				}else{
					e[e.length] = new Array(fe[j].name, 'false');
				}
			}
			else if (fe[j].type == 'hidden'){
				e[e.length] = new Array(fe[j].name, fe[j].value);
			}
			else if (fe[j].type == 'password'){
				e[e.length] = new Array(fe[j].name, fe[j].value);
			}
			else if (fe[j].type == 'select-one'){
				e[e.length] = new Array(fe[j].name, fe[j].value);
			}
			else if (fe[j].type == 'select-multiple'){
				var selected = new Array;
				for (var c=0; c<fe[j].options.length; c++){
					selected[selected.length] = fe[j].options[c].value;
				}
				e[e.length] = new Array(fe[j].name, selected);							
			}
			else if (fe[j].type == 'radio'){}
		}
		return new Array(fm.name, e);
	}
	else return false;
}

function getcheckbox(parent){
	var tbl = document.getElementById(parent);
	var cb = tbl.getElementsByTagName('INPUT');
	var o = new Array();
	for (var i=0; i<cb.length; i++){
		if (cb[i].type == 'checkbox' && cb[i].checked == true){
			o[o.length] = cb[i].name;
		}
	}
	return (o.length!=0) ? o : 'null';
}

function getorder(parent){
	var tbl = document.getElementById(parent);
	var cb = tbl.getElementsByTagName('INPUT');
	var o = new Array();
	for (var i=0; i<cb.length; i++){
		if (cb[i].type == 'text' && cb[i].className == 'order'){
			o[o.length] = new Array(cb[i].name, cb[i].value);
		}
	}
	return (o.length!=0) ? o : 'null';	
}

function find_substr(string, sub_string){
	var t = 0;
	for (var i=0; i<string.length; i++){
		if (sub_string == string.substr(i, sub_string.length)){
			t++;
		}
	}
	return (t > 0) ? true : false;
}

var image_editor = {
	add : function(form){
		if (fm = document.forms[form]){
			var gallery = fm.elements['fb_files'];
			var content = fm.elements['images'];
			for (var i=0; i < gallery.options.length; i++){
				if (gallery.options[i].selected){
					var option = document.createElement("option");
					option.appendChild(document.createTextNode(gallery.options[i].text));
					option.setAttribute("value", gallery.options[i].value);
					content.appendChild(option);
				}
			}
		}
	},
	del:function(form){
		if (fm = document.forms[form]){
			var content = fm.elements['images'];
			content.options[content.selectedIndex] = null;
		}
	},
	move:function(form, param){
		if (fm = document.forms[form]){
			var content = fm.elements['images'];
			var idx = content.selectedIndex;
			if (param == 'up' && idx > 0){
				var oOption = content.options[idx];
				var oPrevOption = content.options[idx-1];
				content.insertBefore(oOption, oPrevOption);
			}
			else if (param == 'down' && idx < content.options.length-1 ){
				var oOption = content.options[idx];
				var oNextOption = content.options[idx+1];
				content.insertBefore(oNextOption, oOption);
			}
		}
	},
	view:function(form, param){
		if (fm = document.forms[form]){
			var gallery = fm.elements['fb_files'];
			var content = fm.elements['images'];
			var fb_file = document.getElementById('fb_file');
			var fb_image = document.getElementById('fb_image');
			if (param == 'gallery'){fb_file.src = "/cms/image.php?image=../"+gallery.options[gallery.selectedIndex].value+'&mode=square_fit&p1=94';}
			else if (param == 'content'){fb_image.src = "/cms/image.php?image=../"+content.options[content.selectedIndex].value+'&mode=square_fit&p1=94';}
		}
	},
	upd_files:function(data){
		var files = document.forms[data[0]].elements['fb_files'];
		files.options.length = 0;
		for (var i=0; i<data[1].length; i++){
			var element = data[1][i];
			var option = document.createElement("option");
			option.appendChild(document.createTextNode(element[0]));
			option.setAttribute("value", element[1]);
			files.appendChild(option);
		}	
	},
	upd_folders:function(data){
		var folders = document.forms[data[0]].elements['fb_path'];
		folders.options.length = 0;
		for (var i=0; i<data[1].length; i++){
			var element = data[1][i];
			var option = document.createElement("option");
			option.appendChild(document.createTextNode(element[0]));
			option.setAttribute("value", element[1]);
			folders.appendChild(option);
		}	
	},
};

var core = {
	_fb_setmode:function(){xajax_exe('core', '_fb_setmode', document.getElementById("fb_mode").value);},
	_fb_setpath:function(path){xajax_exe('core', '_fb_setpath', path);},
	_fb_setfile:function(path){xajax_exe('core', '_fb_setfile', path);},
	_fb_setfield:function(data){
		var e;
		if (find_substr(data[0], ';')){
			e = data[0].split(';')
			for (var i=0; i<e.length; i++){
				if (find_substr(e[i], '.')){
					var f = e[i].split('.');
					var form = f[0];
					var field = f[1];
					if (fm = document.forms[form]){
						var fe = fm.elements[field];
						if (fe.type == 'text'){fe.value = data[1]; }
					}					
				}else{
					if (find_substr(e[i], '@')){
						var src = e[i].split('@');
						if (document.getElementById(src[0]).nodeName == "IMG"){
							document.getElementById(src[0]).src = "/cms/image.php?image=../"+data[1].substr(1,data[1].length)+src[1];
						}
					}else{
						if (document.getElementById(e[i]).nodeName == "IMG"){
							document.getElementById(e[i]).src = data[1];
						}
					}
				}
			}
		}else{
			e = data[0];
			if (find_substr(e, '.')){
				var f = e.split('.');
				var form = f[0];
				var field = f[1];
				if (fm = document.forms[form]){
					var fe = fm.elements[field];
					if (fe.type == 'text'){fe.value = data[1]; }
				}					
			}else{
				if (find_substr(e, '@')){
					var src = e.split('@');
					if (document.getElementById(src[0]).nodeName == "IMG"){
						document.getElementById(src[0]).src = "/cms/image.php?image=../"+data[1].substr(1,data[1].length)+src[1];
					}
				}else{
					if (document.getElementById(e).nodeName == "IMG"){
						document.getElementById(e).src = data[1];
					}
				}
			}
		}
	},
	_logout:function(id){xajax_exe('users', '_logout', id);}
};


function cssmenuhover()
{
	if(!document.getElementById("menu"))
		return;
	var lis = document.getElementById("menu").getElementsByTagName("LI");
	for (var i=0; i<lis.length; i++)
	{
		if (lis[i].className != "disabled")
		{
			lis[i].onmouseover = function(){ this.className += " hover"; };
			lis[i].onmouseout = function(){ this.className = this.className.replace(new RegExp(" hover\\b"), ""); };
		}
	}
}
var selected_tab = 0;
function tabs(root, selected){
	var d = document;
	selected_tab = selected;
	var tab = new Array();
	var btns_container = d.getElementById(root+'_btn');
	var btns = btns_container.getElementsByTagName('A');
	var tabs_container = d.getElementById(root);
	var tabs = tabs_container.getElementsByTagName('DIV');
	
	for (var j=0; j<tabs.length; j++){
		if (tabs[j].className == 'tab'){ tab[tab.length] = tabs[j]; }
	}
	for (var i=0; i<btns.length; i++){
		if (i == selected){ btns[i].className = 'selected'; tab[i].style.display = 'block'; }
		else { btns[i].className = ''; tab[i].style.display = 'none'; }
	}
}

window.onload = function (){
	cssmenuhover();
	xajax_exe('core', 'page');
	var t = setTimeout("xajax_exe('core', '_mes')", 500);
};


