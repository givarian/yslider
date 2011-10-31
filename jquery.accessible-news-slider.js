
(function( $ ){
	$.fn.accessNews = function(settings){
	
		var defaults = {
			// title for the display
			title: "TODAY NEWS:",
			// subtitle for the display
			subtitle: "November 27 2010",
			// width of the container
			width: 500,
			// number of slides to advance when paginating
			slideBy: 4,
			// the speed for the pagination
			speed: "normal",
			// slideshow interval
			slideShowInterval: 5000,
			// slideshow interval
			autoplay: true,
			// delay before slide show begins
			slideShowDelay: 5000,
			// theme
			theme: "default",
			// allow the pagination to wrap continuously instead of stopping when the beginning or end is reached 
			continuousPaging : true,
			// selector for the story title
			contentTitle: "h3",
			// selector for the story subtitle
			contentSubTitle: "abbr",
			// height of image area
			imgHeight: "200px",
			// height of content area
			contentHeight: "50px",
			// height of carousel area
			carouselHeight: "180px",
			// selector for the story description
			contentDescription: "p",
			// function to call when the slider first initializes
			onLoad: null,
			// function to call when the slider is done being created
			onComplete: null
		};
		
		return this.each(function(){
			
			settings = jQuery.extend(defaults, settings);
			var _this = jQuery(this);
			var _id = _this.attr('id');
			var stories = _this.children();
			var intervalId;
			var _storyIndictor;
			var _storyIndictors;
			
			
			var cache = {
				loadImages: function(images) {
					
						var cache = [];
						// Arguments are image paths relative to the current page.
						
							
							var args_len = images.length;
							for (var i = args_len; i--;) {
								var cacheImage = document.createElement('img');
								cacheImage.src = images[i];
								cache.push(cacheImage);
						
  					}
					
				}
			}
			
			
			var preloader = {
				loadImages: function() {
					var imagesArray = [];
					var images = stories.find('img').each(function() {
        				var image = $(this);
						var imageUrl = image.attr('longdesc');
						imagesArray.push(imageUrl)
					})
					
					cache.loadImages(imagesArray);
					
				}
			}
			
			var browserChecker = {
				check: function () {
					if (/Opera[\/\s](\d+\.\d+)/.test(navigator.userAgent)){ //test for Opera/x.x or Opera x.x (ignoring remaining decimal places);
 						var oprversion=new Number(RegExp.$1) // capture x.x portion and store as a number
 						//alert("opera" + _id);
						jQuery(".jqans-pagination-controls a span", jQuery("." + _id)).css("border-left-width", "0.4em").css("border-right-width", "0.4em").css("border-top-width", "0.4em");
						jQuery(".jqans-pagination-controls-play-pause", jQuery("." + _id)).css("bottom", 7);
					}
					
					if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)) { //test for MSIE x.x;
 						var ieversion=new Number(RegExp.$1) // capture x.x portion and store as a number
						
						jQuery(".jqans-pagination-controls-back a span", jQuery("." + _id)).css("font-size", "0.7em").css('right', -5);
						jQuery(".jqans-pagination-controls-next a span", jQuery("." + _id)).css("font-size", "0.7em");
 						
					}
				}
			}
			
			var container = {
				_wrapper: "<div class=\"jqans-wrapper " + settings.theme +  " " + _id + "\"></div>",
				_container: "<div class=\"jqans-container\"></div>",
				_headline: jQuery("<div class='jqans-headline'></div>").html(["<p><strong>", settings.title, "</strong> ", settings.subtitle, "</p>"].join("")),
				_content: jQuery("<div class='jqans-content'></div>"),
				_stories: "<div class=\"jqans-stories\"></div>",
				_first: jQuery(stories[0]),
				
				init: function(){
				
					if (settings.onLoad)
					{
						settings.onLoad.call($(this));
					}
				
					// wrap the ul with our div class and assigned theme
					_this.wrap(this._wrapper);
					// our container where we show the image and news item
					_this.before(this._container);
					// set the width of the container
					//var width = (stories.length * this._first.outerWidth(true));
					
					//var width = settings.width / setings.slidesBy;
					var mod = settings.slideBy - (stories.length % settings.slideBy);
					for (i=0; i<mod; i++) {
							jQuery('<li></li>').addClass('fake').appendTo(_this);
					}
					//stories = _this.children();
					
					jQuery("." + _id).css("width", settings.width);
					jQuery(".jqans-container", jQuery("." + _id)).css("width", settings.width);
					jQuery(_this).css("height", settings.carouselHeight);
					
					var storyWidth = Math.ceil((settings.width / settings.slideBy) * 10);
					storyWidth = Math.ceil(storyWidth / 10);
					//alert(storyWidth);
					var storiesWidth = Math.ceil((settings.width / settings.slideBy)) * (stories.length + mod);
					
					_this.css("width",storiesWidth);
						
					jQuery("li", _this).css("width",storyWidth);
					jQuery("li", _this).css("height", settings.carouselHeight);
					
					if (settings.title.length)
					{
						this.append(this._headline);
					}
					this.append(this._content);
					
					// create the selector indictor
					this.selector(settings.width);
					
					this.set(0);
					
					// pagination setup
					pagination.init();
					
					// slideshow setup
					slideshow.init();
					
					$(window)
						.blur(function(){
   						slideshow.off();
					})
						.focus(function(){
    					slideshow.on();
					});
					
					_this.wrap(this._stories);
					
					if (settings.onComplete)
					{
						settings.onComplete.call($(this));
					}
					
					pagination.controls();
					browserChecker.check();
					preloader.loadImages();

				},
				
				selector: function(width){
					var s = "";
					for(var i = 1; i <= stories.length; i++){
						s += "<li><div/></li>";
					}
					var o = jQuery("<div class=\"jqans-stories-selector\"></div>");
					o.append("<ul>"+ s +"</ul>");
					_storyIndictor = jQuery(o.find("ul"));
					_storyIndictors = _storyIndictor.children();
					var selectorStoryWidth = Math.ceil((settings.width / settings.slideBy) * 10);
					selectorStoryWidth = Math.ceil(selectorStoryWidth / 10);
					var mod = settings.slideBy - (stories.length % settings.slideBy);
					var selectorStoriesWidth =Math.ceil((settings.width / settings.slideBy)) * (stories.length + mod);
					//alert(storiesWidth)
					o.css("width", selectorStoriesWidth);
					jQuery("li", o).css("width",selectorStoryWidth);
					_this.before(o);
				},
				
				append: function(content){
					this.get().append(content);
				},
				
				// returns the main container
				get: function(){
					return _this.parents("div.jqans-wrapper").find('div.jqans-container');
				},
				
				set: function(position){
					var container = this.get();
					var story = jQuery(stories[position]);
					var storyIndictor = jQuery(_storyIndictors[position]);
					var _content = jQuery("div.jqans-content", container);
					var imgContainer = jQuery('<div></div>');
					imgContainer.css('height', settings.imgHeight)
					var imgLink = jQuery("<a href='" + jQuery('a', story).attr('href') + "'/>");
					var img = jQuery('<img></img>');
					imgLink.append(img);
					imgContainer.append(imgLink);
					var para = jQuery('<div></div>');
					var title = jQuery(settings.contentTitle + " a", story).attr('title') || jQuery(settings.contentTitle, story).text();
					//var image = 
					img.attr('src', jQuery('img', story).attr('longdesc') );
					para.html("<h1><a href='" + jQuery('a', story).attr('href') + "'>" + title + "</a></h1>" + "<p>" + jQuery(settings.contentDescription, story).html() + "</p>");
					para.css('height', settings.contentHeight);
					_content.empty();
					_content.append(imgContainer);
					_content.append(para);
					stories.removeClass('selected');
					story.addClass('selected');
					_storyIndictors.removeClass('selected');
					storyIndictor.addClass('selected');
				}
				
			};
			
			var pagination = {
			
				loaded: false,
				_animating: false,
				_totalPages: 0,
				_currentPage: 1,
				_storyWidth: 0,
				_slideByWidth: 0,

				init: function(){
					if (stories.length > settings.slideBy) {
						this._totalPages = Math.ceil(stories.length / settings.slideBy);
						this._storyWidth = Math.ceil((settings.width / settings.slideBy) * 10) ;
						this._storyWidth = Math.ceil(this._storyWidth / 10);
						stories.css("width", this._storyWidth)
						
						
					
						
						//jQuery(stories[0]).outerWidth(true);
						this._slideByWidth = this._storyWidth * settings.slideBy;
						this.draw();
						this.loaded = true;
					}
				},
				
				draw: function(){
				
					var _viewAll = jQuery("<div class=\"jqans-pagination\"></div>").html(["<div class=\"jqans-pagination-count\"><span class=\"jqans-pagination-count-start\">1</span>-<span class=\"jqans-pagination-count-end\">", settings.slideBy, "</span> / <span class=\"jqans-pagination-count-total\">", stories.length, "</span></div><div class=\"jqans-pagination-controls\"><span class=\"jqans-pagination-controls-back\"><a href=\"#\" title=\"Back\"><span>&lt;&lt; Back</span></a></span><span class=\"jqans-pagination-controls-play-pause\"><span id=\"play-pause-wrapper\"><a href=\"#\" title=\"Play\" id=\"control-play\"><span>Play</span></a><a href=\"#\" title=\"Pause\" id=\"control-pause\"><span>Pause</span><div id=\"pause-left\"></div><div id=\"pause-right\"></div></a></span></span><span class=\"jqans-pagination-controls-next\"><a href=\"#\" title=\"Next\"><span>Next &gt;&gt;</span></a></span></div>"].join(""));
					_this.after(_viewAll);
					
					var _next = jQuery(".jqans-pagination-controls-next > a", _viewAll);
					var _back = jQuery(".jqans-pagination-controls-back > a", _viewAll);
					var _play = jQuery("#control-play", _viewAll);
					var _pause = jQuery("#control-pause", _viewAll);
					
					_next.click(function(){
						
						var page = pagination._currentPage + 1;
						pagination.to(page);
						return false;
						
					});
					
					_back.click(function(){
						
						var page = pagination._currentPage - 1;
						pagination.to(page);
						return false;
						
					});
					
					_play.click(function(){
						_play.css("display", "none");
						_pause.css("display", "");
						settings.autoplay = true;
						slideshow.on();
						return false;
						
					});
					
					_pause.click(function(){
						_play.css("display", "");
						_pause.css("display", "none");
						settings.autoplay = false;
						slideshow.off();
						return false;
					});

				},
				
				to: function(page){

					if(this._animating){
						return;
					}
					
					// we're animating! 
					this._animating = true;
					
					var viewAll = _this.parent("div").next(".jqans-pagination");
					var startAt = jQuery(".jqans-pagination-count-start", viewAll);
					var endAt = jQuery(".jqans-pagination-count-end", viewAll);
					
					if(page > this._totalPages)
					{
						page =  settings.continuousPaging ? 1 : this._totalPages;
					}
					
					if (page < 1)
					{
						page =  settings.continuousPaging ? this._totalPages : 1;
					}

					var _startAt = (page * settings.slideBy) - settings.slideBy;
					var _endAt = (page * settings.slideBy);
					if (_endAt > stories.length)
					{
						_endAt = stories.length;
					}
					var _left = parseInt(_this.css("left"));
					var _offset = (page * this._slideByWidth) - this._slideByWidth; 
					startAt.html(_startAt + 1);
					endAt.html(_endAt);
					
					_left = (_offset * -1);
						
					_this.animate({
						left: _left
					}, isNaN(settings.speed) ? settings.speed : parseInt(settings.speed));
					
					_storyIndictor.animate({
						left: _left
					}, isNaN(settings.speed) ? settings.speed : parseInt(settings.speed));
					
					// when paginating set the active story to the first
					// story on the page
					container.set(_startAt);

					this._currentPage = page;
					
					// no more animating :(
					this._animating = false;
						
				},
				controls: function() {
					if (settings.autoplay) {
						jQuery("#control-play", jQuery("." + _id)).css("display", "none");
					} else {
						jQuery("#control-pause", jQuery("." + _id)).css("display", "none");
					}
				}

			};
			
			var slideshow = {
				
				init: function(){
					this.attach();
					this.off();
					if(settings.autoplay) {
						intervalId = setTimeout(function(){
							slideshow.on();
						}, parseInt(settings.slideShowDelay));
					}
				},
				
				on: function(){
					this.off();
					if(settings.autoplay) {
						intervalId = setInterval(function(){
							slideshow.slide();
						}, parseInt(settings.slideShowInterval));
					}
				},
				
				off: function(){
					clearInterval(intervalId);
				},
				
				slide: function(){
				
					//currently selected story
					var current = jQuery("li.selected", _this);
					// the next story 
					var next = current.next("li:not(.fake)");
					// page number
					var page = 0;
					
					if (!next.length)
					{
						next = jQuery(stories[0]);
						page = 1;
					}
					
					var storyIndex = stories.index(next);
					
					if (pagination.loaded) {

						var storyMod = (storyIndex) % settings.slideBy;
						
						if (storyMod === 0) {
							page = (Math.ceil(storyIndex / settings.slideBy)) + 1;
						}
						
						if (page > 0) {
							pagination.to(page);
						}
					}
					
					container.set(storyIndex);
					
				},
				
				attach: function(){
					
					var that = jQuery(_this).parent("div.jqans-wrapper");
					that.hover(function(){
						// pause the slideshow on hover
						slideshow.off();
					}, function (){
						// resume slideshow on mouseout
						slideshow.on();
					});
					
				}
				
			};
			
			//setup the container
			container.init();
			// append hover every to each element to update container content
			stories.hover(function(){
				// set container contect to hovered li
				container.set(stories.index(this));
			}, function(){
				// do nothing
			});

		});
	};
})( jQuery );