/*
 * Accordion interface ui
 * 
 * html example:
 * <dl>
 *     <dt>button</dt>
 *     <dd>content</dd>
 * </dl>
 */

if (typeof Prototype == 'undefined') {
	throw "Prototype library is required to work";
}

if (typeof Effect == 'undefined') {
	throw "Scriptaculous library is required to work";
}

if (typeof Prototype.UI == 'undefined') {
	Prototype.UI = {};
}

Prototype.UI.Accordion = Class.create();

Prototype.UI.Accordion.prototype = {
	initialize: function(container, options)
	{
		this.container = $(container);
		if (!this.container) {
			throw "Container or his id not defined";
		}
		
		this.options    = options || {};
		this.duration   = this.options.duration || 1;
		this.transition = this.options.transition || Effect.Transitions.linear;
		this.fps        = this.options.fps || 30;
		
		this.elementsDT = this.container.select('dt');
		this.elementsDD = this.container.select('dd');
		if (this.elementsDT.length <= 1 || this.elementsDD.length <= 1 || this.elementsDT.length != this.elementsDD.length) {
			throw "UI need more than one element to work";
		}
		
		this.previous = 0;
		this.next = 0;
		
		this.buttonWidth = this.elementsDT[0].getWidth();
		this.totalWidth = this.container.getWidth();
		this.contentWidth = this.elementsDD[0].getWidth();
		
		this.observe();
	},
	observe: function()
	{
		this.eventClick = this.onClick.bindAsEventListener(this);
		for (var i = 0; i < this.elementsDT.length; i++) {
			this.elementsDT[i].observe('click', this.eventClick);
			this.elementsDT[i].setStyle({cursor: 'pointer'});
		}
	},
	deobserve: function()
	{
		for (var i = 0; i < this.elementsDT.length; i++) {
			Event.stopObserving(
				this.elementsDT[i],
				'click',
				this.eventClick
			);
			this.elementsDT[i].setStyle({cursor: ''});
		}
	},
	onClick: function(event)
	{
		event.stop();
		var e = event.element();
		if (e.tagName.toLowerCase() != 'dt') {
			e = e.up('dt');
		}
		for (var i = 0; i < this.elementsDT.length; i++) {
			if (this.elementsDT[i] == e) {
				//alert(i);
				this.next = i;
				this.render();
			}
		}		
	},
	render: function()
	{
		if (this.previous == this.next) {
			return;			
		}
		
		this.deobserve();
		new Effect.Parallel([
			new Effect.Morph(this.elementsDD[this.previous], {
				style: {width: "0px"},
				duration: this.duration,
				fps: this.fps
			}),
			new Effect.Morph(this.elementsDD[this.next], {
				style: {width: this.contentWidth + "px"},
				duration: this.duration,
				fps: this.fps
			})
		], {
			duration: this.duration,
			fps: this.fps,
			afterFinish: (function(){
				this.previous = this.next;
				this.observe();
			}).bind(this)
		});
	}
};