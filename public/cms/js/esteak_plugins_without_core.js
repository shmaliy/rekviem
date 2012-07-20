//this is needed to catch mousewheel events
Element.Events.extend({
	'wheelup': {
		type: Element.Events.mousewheel.type,
		map: function(event) {
			event = new Event(event);
			if(event.wheel >= 0) {
				this.fireEvent('wheelup', event);
			}
		}
	},
	
	'wheeldown': {
		type: Element.Events.mousewheel.type,
		map: function(event) {
			event = new Event(event);
			if(event.wheel < 0) {
				this.fireEvent('wheeldown', event);
			}
		}
	}
});

var ScrollControl = new Class({
	options: {
		'createControls': 		false,	//if this is set to true, the default controls are added automatically.
										//if you set this to false (default), you have to define the controls in HTML
										//and give them as parameters to this control (see: this.initialize())
		'htmlElementPrefix': 	'scrollcontroll_',	//if you want to use several scroll controls on the same 
													//site but with different styles, give them another prefix here
		'wheelStepSize': 		15,	//amount of pixels that the content is scrolled on mousewheel event
		'scrollStepSize': 		3,	//amount of pixels that the content is scrolled on button click
		'controlOffset': 		10	//amount of pixels between the scroll controls and the content
	},
	/**
	 * Initializes a new scroll control.
	 * Usage: 
	 * var myScroller = new ScrollControl($('content'), {}, $('scrolltrack'), $('scrollknob'), $('scrollUpBtn'), $('scrollDownBtn'));
	 * or
	 * var myScroller = new ScrollControl($('content'), {'createControls': true});
	 * Example: see http://www.aplusmedia.de for an example
	 * 
	 * Known issues/TODOs:
	 * - vertical scrollbars are not yet possible
	 * 
	 * @param {HTMLelement} contentElement which contains the content which shall be scrolled
	 * @param {Object}		optional, you can adjust different settings here
	 * @param {HTMLelement} optional, scrollTrack the container which limits the knob
	 * @param {HTMLelement} optional, scrollKnob the actual scroll handle knob
	 * @param {HTMLelement} optional, scrollUpBtn a button which can be clicked to scroll up
	 * @param {HTMLelement} optional, scrollDownBtn a button which can be clicked to scroll down
	 */
	initialize: function(contentElement, options, scrollTrack, scrollKnob, scrollUpBtn, scrollDownBtn) {
		this.setOptions(options);
		//fix opera wheel directions
		if(window.opera) {
			this.options.wheelStepSize *= -1;
		}
		//add scrollbar functionality
		this.contentElement = contentElement;
		this.createContainers();
		//create controls or use user set controls
		if(this.options.createControls) {
			this.createControls();
		} else {
			this.scrollUpBtn = scrollUpBtn.injectInside(this.scrollContainer);
			this.scrollTrack = scrollTrack.injectAfter(this.scrollUpBtn).setStyle('display', 'block');
			this.scrollKnob = scrollKnob;
			this.scrollDownBtn = scrollDownBtn.injectAfter(this.scrollTrack);
		}
		
		//adjust scrollKnob in size, depending on content length
		var trackHeight = this.scrollTrack.getCoordinates()['height'];
		var contentHeight = this.contentElement.getCoordinates()['height'];
		this.scrollKnob.setStyle('height', Math.round(Math.pow(trackHeight , 2) / contentHeight ) );
		this.currentStep = 0;
		this.scrollHeight = contentHeight - trackHeight;
		//adjust width
		this.contentElement.setStyles({
			'width': (this.contentElement.getCoordinates()['width'] - (this.scrollTrack.getCoordinates()['width'] + this.options.controlOffset)) + 'px',
			'position': 'absolute'
		});
		//if content is too short, do nothing at all
		if(this.contentElement.getCoordinates()['height'] < this.scrollTrack.getCoordinates()['height']) {
			this.scrollKnob.setStyle('display', 'none');
			return;
		}
		this.mySlide = new Slider(this.scrollTrack, this.scrollKnob, {
			steps: this.scrollHeight,
			mode: 'vertical',
			onChange: this.refresh.bind(this)
		});
		//add button functionality
		if($defined(this.scrollUpBtn)) {
			this.scrollUpBtn.addEvents({	'mousedown': this.startScrolling.bind(this, 'up'),
											'mouseup': this.stopScrolling.bind(this),
											'mouseout': this.stopScrolling.bind(this)
			}).setStyle('display', 'block');
		}
		if($defined(this.scrollDownBtn)) {
			this.scrollDownBtn.addEvents({	'mousedown': this.startScrolling.bind(this, 'down'),
											'mouseup': this.stopScrolling.bind(this),
											'mouseout': this.stopScrolling.bind(this)
			}).setStyle('display', 'block');
		}
		//add mousewheel functionality
		this.contentElement.addEvents({
			'wheelup': this.doWheelUp.bind(this),
			'wheeldown': this.doWheelDown.bind(this)
		});
	},
	
	/**
	 * Creates the new containers, so "normal" overflow scrolling will be disabled.
	 */
	createContainers: function() {
		//convert scrolling container
		var mask = new Element('div', {
			'id': this.options.htmlElementPrefix + 'contentmask'
		}).injectBefore(this.contentElement).adopt(this.contentElement);
		this.contentElement.setStyles({
			'overflow': 'visible',
			'margin-top': '0',
			'height': 'auto'
		});
		this.scrollContainer = new Element('div', {
			'id': this.options.htmlElementPrefix + 'scrollcontainer'
		}).injectAfter(mask).setStyle('display', 'block');
	},
	
	/**
	 * Creates the controls, including scroll up and down buttons and a 
	 * scrolltrack with something to grab and drag around
	 */
	createControls: function() {
		this.scrollUpBtn = new Element('div', {
			'id': this.options.htmlElementPrefix + 'scrollUpBtn'
		}).injectInside(this.scrollContainer);
		this.scrollTrack = new Element('div', {
			'id': this.options.htmlElementPrefix + 'scrolltrack'
		}).injectAfter(this.scrollUpBtn);
		this.scrollKnob = new Element('div', {
			'id': this.options.htmlElementPrefix + 'scrollknob'
		}).injectInside(this.scrollTrack);
		this.scrollDownBtn = new Element('div', {
			'id': this.options.htmlElementPrefix + 'scrollDownBtn'
		}).injectAfter(this.scrollTrack);
	},
	
	/**
	 * Handles mousewheel action upwards.
	 * Stops wheel event to avoid multiple scrollbars to be invoked.
	 * 
	 * @param {Event} e
	 */
	doWheelUp: function(e) {
		new Event(e).stop();
		this.scrollUp(this.options.wheelStepSize);
	},
	
	/**
	 * Handles mousewheel action downwards.
	 * Stops wheel event to avoid multiple scrollbars to be invoked.
	 * 
	 * @param {Event} e
	 */
	doWheelDown: function(e) {
		new Event(e).stop();
		this.scrollDown(this.options.wheelStepSize);
	},
	
	/**
	 * Starts scrolling on click on the buttons
	 * 
	 * @param {Object} mode
	 */
	startScrolling: function(mode) {
		if(mode == 'up') {
			this.scrollIntervall = this.scrollUp.periodical(50, this, this.options.scrollStepSize);
		} else {
			this.scrollIntervall = this.scrollDown.periodical(50, this, this.options.scrollStepSize);
		}
	},
	
	/**
	 * Invoked when the scrolling buttons are released.
	 */
	stopScrolling: function() {
		$clear(this.scrollIntervall);
	},
	
	/**
	 * Refreshes the entire control.
	 * 
	 * @param {Integer} step
	 */
	refresh: function(step) {
		if(step == this.currentStep) {
			return;
		}
		step = Math.round(step.toInt().limit(0, this.scrollHeight));
		this.mySlide.set(step);
		this.currentStep = step;
		this.contentElement.setStyle('top', -step);
	},
	
	/**
	 * Used to scroll the content upwards
	 * 
	 * @param {Integer} amount of pixels to scroll
	 */
	scrollUp: function(amount) {
		this.refresh(this.currentStep - amount);
	},
	
	/**
	 * Used to scroll the content downwards
	 * 
	 * @param {Integer} amount of pixels to scroll
	 */
	scrollDown: function(amount) {
		this.refresh(this.currentStep + amount);
	}
});
ScrollControl.implement(new Options);
