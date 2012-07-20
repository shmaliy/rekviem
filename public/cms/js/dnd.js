//dnd
var moveState = false;
//Переменные координат мыши в начале перемещения, пока неизвестны
var x0, y0;
//Начальные координаты элемента, пока неизвестны
var divX0, divY0;
var dnd = {
	d : document,
	w : window,
	md : null,
	div : function(id){return this.d.getElementById(id);},
	defXY : function(e){
		var x = y = 0;
		if (this.d.attachEvent != null) { // IE & Opera
			x = this.w.event.clientX + this.d.documentElement.scrollLeft + this.d.body.scrollLeft;
			y = this.w.event.clientY + this.d.documentElement.scrollTop + this.d.body.scrollTop;
		}
		if (!this.d.attachEvent && this.d.addEventListener) { // Gecko
			x = e.clientX + this.w.scrollX;
			y = e.clientY + this.w.scrollY;
		}
		return {x:x, y:y};		
	},
	init : function(id,e){
		moveState = false;
		var div = this.div(id);
		var e = e || window.event;
		x0 = this.defXY(e).x;
		y0 = this.defXY(e).y;
		divX0 = div.offsetLeft;
		divY0 = div.offsetTop;
		document.onmousemove = function(e){ dnd.move(id,e); };		
		document.onmouseup = function(){ moveState = false; };
		moveState = true;		
	},
	move : function(id,e){
		var div = this.div(id);
		var e = e || window.event;
	    if (moveState) {
	    	div.style.top = divY0 + this.defXY(e).y - y0 + "px";
	    	div.style.left = divX0 + this.defXY(e).x - x0 + "px";
	    }
	},
	stop : function(){ moveState = false; }
};