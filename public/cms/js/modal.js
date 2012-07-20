var modal = {
	d : document,
	w : window,
	div : function(){ return this.d.createElement("div"); },
	idel : null,
	to : null,
	getp : function(par,p){
		for (var i=0; i<p.length; i++){
			var pa = p[i].split('=');
			if (pa[0] == par){ return pa[1]; }
		}
		return false;
	},
	show : function(params){
		p = params[0].split('&');
		
		var over = this.d.createElement("div");
		over.id = "overlay";
		this.d.body.insertBefore(over, this.d.getElementById("header"));
		//alert(over.offsetHeight);
				
		var con = params[1];
		var sH = over.offsetHeight;
		var sW = over.offsetWidth;
		var modw = this.d.createElement("div");
		modw.id = "modal";
		modw.style.width = this.getp('width',p)+'px';
		modw.style.top = Math.floor(sH/2-(this.getp('height',p)/2))+'px';
		modw.style.left = Math.floor(sW/2-(this.getp('width',p)/2))+'px';
		
		//window title
		var title = this.div();
		var title2 = this.div();
		var title3 = this.div();
		var close = (this.getp('close',p)=='true') ? '<div class="i"><img src="/cms/images/modal/close.png" onclick="modal.hide();" /></div>' : '';
		title3.innerHTML = close+'<div class="t" onmousedown="dnd.init(\'modal\',event)" onmouseup="moveState = false;" onmousemove="dnd.move(\'modal\', event);">'+this.getp('title',p)+'</div>';
		title3.className = "title";
		title2.appendChild(title3);
		title2.className = "title";
		title.appendChild(title2);
		title.className = "title";
		modw.appendChild(title);
		
		//window body
		var body = this.div();
		var body2 = this.div();
		var body3 = this.div();
		body3.innerHTML = params[1];
		body3.style.height = this.getp('height',p)-45+'px';
		body3.className = "body";
		body2.appendChild(body3);
		body2.className = "body";
		body.appendChild(body2);
		body.appendChild(body2);
		body.className = "body";
		modw.appendChild(body);
		
		//window bottom
		var bottom = this.div();
		var bottom2 = this.div();
		var bottom3 = this.div();
		bottom3.className = "bottom";
		bottom2.appendChild(bottom3);
		bottom2.className = "bottom";
		bottom.appendChild(bottom2);
		bottom.className = "bottom";
		modw.appendChild(bottom);
		
		this.d.body.insertBefore(modw, this.d.getElementById("header"));
		
		this.idel = 'modal';
		this.to = 1;
		fade._in("overlay", fade.getOpacity("overlay"), 0.5, "modal.fadein");
	},
	hide : function(){
		fade._out('modal', fade.getOpacity('modal'), 0, "modal.fadeout");
		this.idel = 'overlay';
		this.to = 0;
		var t2 = setTimeout("modal.remove()",1000);
	},
	remove : function(){
		var m = this.d.getElementById("modal");
		var o = this.d.getElementById("overlay");
		this.d.body.removeChild(m);
		this.d.body.removeChild(o);
	},
	fadein : function(){
		fade._in(this.idel, fade.getOpacity(this.idel), this.to);
	},
	fadeout : function(){
		fade._out(this.idel, fade.getOpacity(this.idel), this.to);
	}
};

