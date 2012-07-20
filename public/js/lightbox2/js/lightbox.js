/*

    Table of Contents
    -----------------
    Configuration

    Lightbox Class Declaration
    - initialize()
    - updateImageList()
    - start()
    - changeImage()
    - resizeImageContainer()
    - showImage()
    - updateDetails()
    - updateNav()
    - preloadNeighborImages()
    - end()
    
    Function Calls
    - document.observe()
   
*/
// -----------------------------------------------------------------------------------

//
//  Configurationl
//
LightboxOptions = Object.extend({
    fileLoadingImage:        '/js/lightbox2/images/loading.gif',     
    fileBottomNavCloseImage: '/js/lightbox2/images/close.png',

    overlayOpacity: 0.8,   // controls transparency of shadow overlay

    animate: true,         // toggles resizing animations
    resizeSpeed: 6,        // controls the speed of the image resizing animations (1=slowest and 10=fastest)

    borderSize: 10,         //if you adjust the padding in the CSS, you will need to update this variable

	upScale:true,  // upscale smaller than viewport size images 
	// When grouping images this is used to write: Image # of #.
	// Change it for non-english localization
	labelImage: "Изображение",
	labelOf: "из"
}, window.LightboxOptions || {});

// -----------------------------------------------------------------------------------

var Lightbox = Class.create();

Lightbox.prototype = {
    imageArray: [],
    activeImage: undefined,
    
    // initialize()
    // Constructor runs on completion of the DOM loading. Calls updateImageList and then
    // the function inserts html at the bottom of the page which is used to display the shadow 
    // overlay and the image container.
    //
    initialize: function() {    
        this.updateImageList();
        
        if (LightboxOptions.resizeSpeed > 10) LightboxOptions.resizeSpeed = 10;
        if (LightboxOptions.resizeSpeed < 1)  LightboxOptions.resizeSpeed = 1;

	    this.resizeDuration = LightboxOptions.animate ? ((11 - LightboxOptions.resizeSpeed) * 0.15) : 0;
	    this.overlayDuration = LightboxOptions.animate ? 0.3 : 0;  // shadow fade in/out duration

        // When Lightbox starts it will resize itself from 250 by 250 to the current image dimension.
        // If animations are turned off, it will be hidden as to prevent a flicker of a
        // white 250 by 250 box.
        var size = (LightboxOptions.animate ? 250 : 1) + 'px';
        

        // Code inserts html at the bottom of the page that looks similar to this:
        //
        //  <div id="overlay"></div>
        //  <div id="lightbox">
        //      <div id="outerImageContainer">
        //          <div id="imageContainer">
        //              <img id="lightboxImage">
        //              <div style="" id="hoverNav">
        //                  <a href="#" id="prevLink"></a>
        //                  <a href="#" id="nextLink"></a>
        //              </div>
        //              <div id="loading">
        //                  <a href="#" id="loadingLink">
        //                      <img src="images/loading.gif">
        //                  </a>
        //              </div>
        //          </div>
        //      </div>
        //      <div id="imageDataContainer">
        //          <div id="imageData">
        //              <div id="imageDetails">
        //                  <span id="caption"></span>
        //                  <span id="numberDisplay"></span>
        //              </div>
        //              <div id="bottomNav">
        //                  <a href="#" id="bottomNavClose">
        //                      <img src="images/close.gif">
        //                  </a>
        //              </div>
        //          </div>
        //      </div>
        //  </div>


        var objBody = $$('body')[0];
		
        objBody.insertBefore(Builder.node('div',{id:'lightbox'}, [
            Builder.node('div',{id:'outerImageContainer'}, 
                Builder.node('div',{id:'imageContainer'}, [
                    Builder.node('img',{id:'lightboxImage'}), 
                    Builder.node('div',{id:'hoverNav'}, [
                        Builder.node('a',{id:'prevLink', href: '#' }),
                        Builder.node('a',{id:'nextLink', href: '#' })
                    ]),
                    Builder.node('div',{id:'loading'}, 
                        Builder.node('a',{id:'loadingLink', href: '#' }, 
                            Builder.node('img', {src: LightboxOptions.fileLoadingImage})
                        )
                    )
                ])
            ),
            Builder.node('div', {id:'imageDataContainer'},
                Builder.node('div',{id:'imageData'}, [
                    Builder.node('div',{id:'imageDetails'}, [
                        Builder.node('span',{id:'caption'}),
                        Builder.node('span',{id:'numberDisplay'})
                    ]),
                    Builder.node('div',{id:'bottomNav'},
                        Builder.node('a',{id:'bottomNavClose', href: '#' },
                            Builder.node('img', { src: LightboxOptions.fileBottomNavCloseImage })
                        )
                    )
                ])
            )
        ]), $('header'));
		
		objBody.insertBefore(Builder.node('div',{id:'overlay'}), $('header'));


		$('overlay').hide().observe('click', (function() { this.end(); }).bind(this));
		$('lightbox').hide().observe('click', (function(event) { if (event.element().id == 'lightbox') this.end(); }).bind(this));
		$('outerImageContainer').setStyle({ width: size, height: size });
		$('prevLink').observe('click', (function(event) { event.stop(); this.changeImage(this.activeImage - 1); }).bindAsEventListener(this));
		$('nextLink').observe('click', (function(event) { event.stop(); this.changeImage(this.activeImage + 1); }).bindAsEventListener(this));
		$('loadingLink').observe('click', (function(event) { event.stop(); this.end(); }).bind(this));
		$('bottomNavClose').observe('click', (function(event) { event.stop(); this.end(); }).bind(this));

        var th = this;
        (function(){
            var ids = 
                'overlay lightbox outerImageContainer imageContainer lightboxImage hoverNav prevLink nextLink loading loadingLink ' + 
                'imageDataContainer imageData imageDetails caption numberDisplay bottomNav bottomNavClose';   
            $w(ids).each(function(id){ th[id] = $(id); });
        }).defer();
    },

    //
    // updateImageList()
    // Loops through anchor tags looking for 'lightbox' references and applies onclick
    // events to appropriate links. You can rerun after dynamically adding images w/ajax.
    //
    updateImageList: function() {   
        this.updateImageList = Prototype.emptyFunction;

        document.observe('click', (function(event){
            var target = event.findElement('a[rel^=lightbox]') || event.findElement('area[rel^=lightbox]');
            if (target) {
                event.stop();
                this.start(target);
            }
        }).bind(this));
    },
    
    //
    //  start()
    //  Display overlay and lightbox. If image is part of a set, add siblings to imageArray.
    //
    start: function(imageLink){
        $$('select', 'object', 'embed').each(function(node){ node.style.visibility = 'hidden' });

        // stretch overlay to fill page and fade in
		var ps = this.pageSize();
        $('overlay').setStyle({ height:ps.tH + 'px' });

        new Effect.Appear(this.overlay, { duration: this.overlayDuration, from: 0.0, to: LightboxOptions.overlayOpacity, queue:'front' });

        this.imageArray = [];
        var imageNum = 0;       

        if ((imageLink.rel == 'lightbox')){
            // if image is NOT part of a set, add single image to imageArray
            this.imageArray.push([imageLink.href, imageLink.title]);         
        } else {
            // if image is part of a set..
            this.imageArray = 
                $$(imageLink.tagName + '[href][rel="' + imageLink.rel + '"]').
                collect(function(anchor){ return [anchor.href, anchor.title]; }).
                uniq();
            
            while (this.imageArray[imageNum][0] != imageLink.href) { imageNum++; }
        }

        // calculate top and left offset for the lightbox 
        var lightboxTop = (ps.vH - this.lightbox.getHeight() - 50)/2;
        var lightboxLeft = ps.sL;
        this.lightbox.setStyle({ top: lightboxTop + 'px', left: lightboxLeft + 'px' }).show();
        
        this.changeImage(imageNum);
    },

    //
    //  pageSize()
    //  Calculate total page sizes & view area & scroll offsets.
    //
	pageSize : function(){
		var vp = document.viewport.getDimensions();
		var so = document.viewport.getScrollOffsets();
		return { tW : vp.width + so.left, tH : vp.height + so.top, vW : vp.width, vH : vp.height, sL : so.left, sT : so.top }
	},

    //
    //  changeImage()
    //  Hide most elements and preload image in preparation for resizing image container.
    //
    changeImage: function(imageNum){
		var ps = this.pageSize();
        this.activeImage = imageNum; // update global var

        // hide elements during transition
        new Effect.Fade(this.lightboxImage, { 
            duration: this.resizeDuration, 
            queue: 'front' 
        });
        //this.lightboxImage.hide();
        this.hoverNav.hide();
        this.prevLink.hide();
        this.nextLink.hide();
		// HACK: Opera9 does not currently support scriptaculous opacity and appear fx
        this.imageDataContainer.setStyle({opacity: .0001});
        this.numberDisplay.hide();      
        
		(function(){
			if (LightboxOptions.animate) this.loading.show();
			var imgPreloader = new Image();
			
			// once image is preloaded, resize image container
	
			imgPreloader.onload = (function(){
				this.lightboxImage.src = this.imageArray[this.activeImage][0];
				
				var oHeight = imgPreloader.height;
				var oWidth = imgPreloader.width;
				
				var arI = oWidth/oHeight;
				var arV = (ps.vW - LightboxOptions.borderSize*2 - 50) / (ps.vH - LightboxOptions.borderSize*2 - 100);
				
				if (arV > arI && arI < 1){
					oHeight = ps.vH - LightboxOptions.borderSize*2 - 100;
					oWidth = imgPreloader.width*oHeight/imgPreloader.height;
					if (!this.upScale && (oHeight > imgPreloader.height || oWidth > imgPreloader.width) ) {
						oHeight = imgPreloader.height;
						oWidth = imgPreloader.width;						
					}
				}
				
				if (arV > arI && arI > 1){
					oHeight = ps.vH - LightboxOptions.borderSize*2 - 100;
					oWidth = imgPreloader.width*oHeight/imgPreloader.height;
					if (!this.upScale && (oHeight > imgPreloader.height || oWidth > imgPreloader.width) ) {
						oHeight = imgPreloader.height;
						oWidth = imgPreloader.width;						
					}
				}
				
				if (arV < arI && arI < 1){
					oWidth = ps.vW - LightboxOptions.borderSize*2 - 50;
					oHeight = imgPreloader.height*oWidth/imgPreloader.width;
					if (!this.upScale && (oHeight > imgPreloader.height || oWidth > imgPreloader.width) ) {
						oHeight = imgPreloader.height;
						oWidth = imgPreloader.width;						
					}
				}
				
				if (arV < arI && arI > 1){
					oWidth = ps.vW - LightboxOptions.borderSize*2 - 50;
					oHeight = imgPreloader.height*oWidth/imgPreloader.width;
					if (!this.upScale && (oHeight > imgPreloader.height || oWidth > imgPreloader.width) ) {
						oHeight = imgPreloader.height;
						oWidth = imgPreloader.width;						
					}
				}
				
				this.resizeImageContainer(oWidth, oHeight);
			}).bind(this);
			imgPreloader.src = this.imageArray[this.activeImage][0];
        }).bind(this).delay(this.resizeDuration);
    },
	
    //
    //  resizeImageContainer()
    //
    resizeImageContainer: function(imgWidth, imgHeight) {
		var ps = this.pageSize();
        // get current width and height
        var widthCurrent  = this.outerImageContainer.getWidth();
        var heightCurrent = this.outerImageContainer.getHeight();

        // get new width and height
        var widthNew  = (imgWidth  + LightboxOptions.borderSize * 2);
        var heightNew = (imgHeight + LightboxOptions.borderSize * 2);

        // calculate size difference between new and old image, and resize if necessary
        var wDiff = widthCurrent - widthNew;
        var hDiff = heightCurrent - heightNew;
		
		var oTop = (ps.vH - heightNew - 50)/2;
		var oLeft = ps.sL;
		
		if (hDiff != 0){
			new Effect.Parallel(
				[ 
					new Effect.Morph( this.outerImageContainer, {
						style:'height:'+heightNew+'px;',
						duration: this.resizeDuration
					}), 
					new Effect.Morph(this.lightbox, {
						style:'top:'+oTop+'px;',
						duration: this.resizeDuration
					})
				], 
				{ duration: this.resizeDuration } 
			);
		}
		if (wDiff != 0){
			new Effect.Parallel(
				[ 
					new Effect.Morph(this.outerImageContainer, {
						style:'width:'+widthNew+'px;',
						duration:this.resizeDuration,
						delay:this.resizeDuration
					}), 
					new Effect.Morph(this.lightbox, {
						style:'left:'+oLeft+'px;',
						duration: this.resizeDuration,
						delay: this.resizeDuration
					})
				], 
				{ duration: this.resizeDuration, delay: this.resizeDuration } 
			);
		}

        // if new and old image are same size and no scaling transition is necessary, 
        // do a quick pause to prevent image flicker.
        var timeout = 0;
        if ((hDiff == 0) && (wDiff == 0)){
            timeout = 100;
            if (Prototype.Browser.IE) timeout = 250;   
        }

        (function(){
            this.prevLink.setStyle({ height: imgHeight + 'px' });
            this.nextLink.setStyle({ height: imgHeight + 'px' });
            this.imageDataContainer.setStyle({ width: widthNew + 'px' });
            this.lightboxImage.setStyle({ width: imgWidth + 'px' });

            this.showImage();
        }).bind(this).delay(timeout / 1000);
    },
    
    //
    //  showImage()
    //  Display image and begin preloading neighbors.
    //
    showImage: function(){
        this.loading.hide();
        new Effect.Appear(this.lightboxImage, { 
            duration: this.resizeDuration, 
            queue: 'end', 
            afterFinish: (function(){ this.updateDetails(); }).bind(this) 
        });
        this.preloadNeighborImages();
    },

    //
    //  updateDetails()
    //  Display caption, image number, and bottom nav.
    //
    updateDetails: function() {
        // if caption is not null
        if (this.imageArray[this.activeImage][1] != ""){
            this.caption.update(this.imageArray[this.activeImage][1]).show();
        }
        
        // if image is part of set display 'Image x of x' 
        if (this.imageArray.length > 1){
            this.numberDisplay.update( LightboxOptions.labelImage + ' ' + (this.activeImage + 1) + ' ' + LightboxOptions.labelOf + '  ' + this.imageArray.length).show();
        }

        new Effect.Parallel(
            [ 
                new Effect.SlideDown(this.imageDataContainer, { sync: true, duration: this.resizeDuration, from: 0.0, to: 1.0 }), 
                new Effect.Appear(this.imageDataContainer, { sync: true, duration: this.resizeDuration }) 
            ], 
            { 
                duration: this.resizeDuration, 
                afterFinish: (function() {
	                // update overlay size and update nav
			    	var ps = this.pageSize();
	                this.overlay.setStyle({ height: ps.tH + 'px' });
	                this.updateNav();
                }).bind(this)
            } 
        );
    },

    //
    //  updateNav()
    //  Display appropriate previous and next hover navigation.
    //
    updateNav: function(){
        this.hoverNav.show();        
        if (this.activeImage > 0){ this.prevLink.show(); }// if not first image in set, display prev image button        
        if (this.activeImage < (this.imageArray.length - 1)){ this.nextLink.show(); }// if not last image in set, display next image button        
    },

    //
    //  preloadNeighborImages()
    //  Preload previous and next images.
    //
    preloadNeighborImages: function(){
        var preloadNextImage, preloadPrevImage;
        if (this.imageArray.length > this.activeImage + 1){
            preloadNextImage = new Image();
            preloadNextImage.src = this.imageArray[this.activeImage + 1][0];
        }
        if (this.activeImage > 0){
            preloadPrevImage = new Image();
            preloadPrevImage.src = this.imageArray[this.activeImage - 1][0];
        }
    
    },

    //
    //  end()
    //
    end: function() {
        this.lightbox.hide();
        new Effect.Fade(this.overlay, { duration: this.overlayDuration });
        $$('select', 'object', 'embed').each(function(node){ node.style.visibility = 'visible' });
    }
};

document.observe('dom:loaded', function(){
	if(typeof Prototype != 'undefined' && typeof Scriptaculous != 'undefined'){ new Lightbox(); } 
});