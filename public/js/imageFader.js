var ImageFader = Class.create();

ImageFader.prototype = {
	initialize: function(e)
	{
		this.element = $(e);
		if (!this.element) {
			throw "not element";
		}
		
		this.elements = this.element.select('img');
		//console.log(this.elements.length);
		this.current = 0;
		this.timer = null;
		
		this.startTimer();
	},
	startTimer: function()
	{
		this.timer = setTimeout(
			(function(){
				this.gotoNext();
			}).bind(this),
			4000
		);
	},
	gotoNext: function()
	{
		this.current++;
		
		if (this.current >= this.elements.length) {
			this.current = 0;
		}
		
		for (var i = 0; i < this.elements.length; i++) {
			if (i != this.current) {
				this.elements[i].setStyle({zIndex: 5});
			}
		}
		
		this.elements[this.current].setOpacity(0);
		this.elements[this.current].setStyle({visibility: ''});
		this.elements[this.current].setStyle({display: '', zIndex: 10});
		
		new Effect.Opacity(this.elements[this.current], {
			from: 0,
			to: 1,
			duration: 1,
			afterFinish: (function(){
				for (var i = 0; i < this.elements.length; i++) {
					if (i != this.current) {
						this.elements[i].hide();
						this.elements[i].setStyle({zIndex: 5});
					}
				}
				this.startTimer();
			}).bind(this)
		});
	}
};