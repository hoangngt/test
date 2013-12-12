// Hover Intent
(function($){
	/* hoverIntent by Brian Cherne */
	$.fn.hoverIntent = function(f,g) {
		// default configuration options
		var cfg = {
			sensitivity: 7,
			interval: 100,
			timeout: 0
		};
		// override configuration options with user supplied object
		cfg = $.extend(cfg, g ? { over: f, out: g } : f );

		// instantiate variables
		// cX, cY = current X and Y position of mouse, updated by mousemove event
		// pX, pY = previous X and Y position of mouse, set by mouseover and polling interval
		var cX, cY, pX, pY;

		// A private function for getting mouse position
		var track = function(ev) {
			cX = ev.pageX;
			cY = ev.pageY;
		};

		// A private function for comparing current and previous mouse position
		var compare = function(ev,ob) {
			ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t);
			// compare mouse positions to see if they've crossed the threshold
			if ( ( Math.abs(pX-cX) + Math.abs(pY-cY) ) < cfg.sensitivity ) {
				$(ob).unbind("mousemove",track);
				// set hoverIntent state to true (so mouseOut can be called)
				ob.hoverIntent_s = 1;
				return cfg.over.apply(ob,[ev]);
			} else {
				// set previous coordinates for next time
				pX = cX; pY = cY;
				// use self-calling timeout, guarantees intervals are spaced out properly (avoids JavaScript timer bugs)
				ob.hoverIntent_t = setTimeout( function(){compare(ev, ob);} , cfg.interval );
			}
		};

		// A private function for delaying the mouseOut function
		var delay = function(ev,ob) {
			ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t);
			ob.hoverIntent_s = 0;
			return cfg.out.apply(ob,[ev]);
		};

		// A private function for handling mouse 'hovering'
		var handleHover = function(e) {
			// next three lines copied from jQuery.hover, ignore children onMouseOver/onMouseOut
			var p = (e.type == "mouseover" ? e.fromElement : e.toElement) || e.relatedTarget;
			while ( p && p != this ) { try { p = p.parentNode; } catch(e) { p = this; } }
			if ( p == this ) { return false; }

			// copy objects to be passed into t (required for event object to be passed in IE)
			var ev = jQuery.extend({},e);
			var ob = this;

			// cancel hoverIntent timer if it exists
			if (ob.hoverIntent_t) { ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t); }

			// else e.type == "onmouseover"
			if (e.type == "mouseover") {
				// set "previous" X and Y position based on initial entry point
				pX = ev.pageX; pY = ev.pageY;
				// update "current" X and Y position based on mousemove
				$(ob).bind("mousemove",track);
				// start polling interval (self-calling timeout) to compare mouse coordinates over time
				if (ob.hoverIntent_s != 1) { ob.hoverIntent_t = setTimeout( function(){compare(ev,ob);} , cfg.interval );}

			// else e.type == "onmouseout"
			} else {
				// unbind expensive mousemove event
				$(ob).unbind("mousemove",track);
				// if hoverIntent state is true, then call the mouseOut function after the specified delay
				if (ob.hoverIntent_s == 1) { ob.hoverIntent_t = setTimeout( function(){delay(ev,ob);} , cfg.timeout );}
			}
		};

		// bind the function to the two event listeners
		return this.mouseover(handleHover).mouseout(handleHover);
	};
	
})(jQuery);


// Superfish Menu
;(function($){
	$.fn.superfish = function(op){

		var sf = $.fn.superfish,
			c = sf.c,
			$arrow = $(['<span class="',c.arrowClass,'"> &#187;</span>'].join('')),
			over = function(){
				var $$ = $(this), menu = getMenu($$);
				clearTimeout(menu.sfTimer);
				$$.showSuperfishUl().siblings().hideSuperfishUl();
			},
			out = function(){
				var $$ = $(this), menu = getMenu($$), o = sf.op;
				clearTimeout(menu.sfTimer);
				menu.sfTimer=setTimeout(function(){
					o.retainPath=($.inArray($$[0],o.$path)>-1);
					$$.hideSuperfishUl();
					if (o.$path.length && $$.parents(['li.',o.hoverClass].join('')).length<1){over.call(o.$path);}
				},o.delay);	
			},
			getMenu = function($menu){
				var menu = $menu.parents(['ul.',c.menuClass,':first'].join(''))[0];
				sf.op = sf.o[menu.serial];
				return menu;
			},
			addArrow = function($a){ $a.addClass(c.anchorClass).append($arrow.clone()); };
			
		return this.each(function() {
			var s = this.serial = sf.o.length;
			var o = $.extend({},sf.defaults,op);
			o.$path = $('li.'+o.pathClass,this).slice(0,o.pathLevels).each(function(){
				$(this).addClass([o.hoverClass,c.bcClass].join(' '))
					.filter('li:has(ul)').removeClass(o.pathClass);
			});
			sf.o[s] = sf.op = o;
			
			$('li:has(ul)',this)[($.fn.hoverIntent && !o.disableHI) ? 'hoverIntent' : 'hover'](over,out).each(function() {
				if (o.autoArrows) addArrow( $('>a:first-child',this) );
			})
			.not('.'+c.bcClass)
				.hideSuperfishUl();
			
			var $a = $('a',this);
			$a.each(function(i){
				var $li = $a.eq(i).parents('li');
				$a.eq(i).focus(function(){over.call($li);}).blur(function(){out.call($li);});
			});
			o.onInit.call(this);
			
		}).each(function() {
			var menuClasses = [c.menuClass];
			if (sf.op.dropShadows  && !($.browser.msie && $.browser.version < 7)) menuClasses.push(c.shadowClass);
			$(this).addClass(menuClasses.join(' '));
		});
	};

	var sf = $.fn.superfish;
	sf.o = [];
	sf.op = {};
	sf.IE7fix = function(){
		var o = sf.op;
		if ($.browser.msie && $.browser.version > 6 && o.dropShadows && o.animation.opacity!=undefined)
			this.toggleClass(sf.c.shadowClass+'-off');
		};
	sf.c = {
		bcClass     : 'sf-breadcrumb',
		menuClass   : 'sf-js-enabled',
		anchorClass : 'sf-with-ul',
		arrowClass  : 'sf-sub-indicator',
		shadowClass : 'sf-shadow'
	};
	sf.defaults = {
		hoverClass	: 'sfHover',
		pathClass	: 'overideThisToUse',
		pathLevels	: 1,
		delay		: 800,
		animation	: {opacity:'show'},
		speed		: 'normal',
		autoArrows	: true,
		dropShadows : true,
		disableHI	: false,		// true disables hoverIntent detection
		onInit		: function(){}, // callback functions
		onBeforeShow: function(){},
		onShow		: function(){},
		onHide		: function(){}
	};
	$.fn.extend({
		hideSuperfishUl : function(){
			var o = sf.op,
				not = (o.retainPath===true) ? o.$path : '';
			o.retainPath = false;
			var $ul = $(['li.',o.hoverClass].join(''),this).add(this).not(not).removeClass(o.hoverClass)
					.find('>ul').hide().css('visibility','hidden');
			o.onHide.call($ul);
			return this;
		},
		showSuperfishUl : function(){
			var o = sf.op,
				sh = sf.c.shadowClass+'-off',
				$ul = this.addClass(o.hoverClass)
					.find('>ul:hidden').css('visibility','visible');
			sf.IE7fix.call($ul);
			o.onBeforeShow.call($ul);
			$ul.animate(o.animation,o.speed,function(){ sf.IE7fix.call($ul); o.onShow.call($ul); });
			return this;
		}
	});

})(jQuery);


// InsetBorder Effect
(function($) {
	
	$.fn.insetBorder = function(options) {
		
		if ((options!=undefined) && (options.inset!=undefined))
		{
			if (options.insetleft==undefined) { options.insetleft = options.inset; }
			if (options.insetright==undefined) { options.insetright = options.inset; }
			if (options.insettop==undefined) { options.insettop = options.inset; }
			if (options.insetbottom==undefined) { options.insetbottom = options.inset; }
		}
		
		// defaults
		options = $.extend({
			speed : 250,
			insetleft : 10,
			insetright : 10,
			insettop : 10,
			insetbottom : 10,
			borderColor : '#ffffff',
			borderType: "solid",
			outerClass : "ibe_outer",
			innerClass : "ibe_inner"
		}, options);
		
		// run plugin on entire jQuery set
		return this.each(function(i) {
				
      var			
  			$el = $(this),
  			ibe_height = $el.outerHeight(),
			  ibe_width = $el.outerWidth();
			
  		var
			  wrapper = $("<div />", {
  			  "class": options.outerClass,
  			  "css"  : {
    				"width": ibe_width,
    				"height": ibe_height,
    				"overflow": "hidden",
    				"top": 0,
    				"left": 0,
    				"position": "relative"
  				},
    		  "mouseenter": function() {
    				  $el
    					 .next()
    					 .animate({
    					   "top": "-" + options.insettop + "px", 
    					   "left": "-" + options.insetleft + "px", 
    					   "height": ibe_height, 
    					   "width": ibe_width, 
    					   "opacity": 0.1
    					 }, {
    					   "duration": options.speed, 
    					   "queue": false,
    					   "complete": function() {
    					   
    					     // BUG: for some reason this is getting called twice.
    					     
    					     // Kinda works... attempt at allowing selectability of main element
    					     // The problem is this only fires on complete but must make visibile on mouseleave no matter what
    					     // $el.next().css("visibility", "hidden");
    					     
    					   }
    					 });
  					 
  				  // on mouseleave
  					},
  					"mouseleave": function() {
  					  
  					  $el
  					     .next()
  					     // .css({
  					     //  "visibility": "visible"
  					     // })
  						   .animate({
  						     "top": 0, 
  						     "left": 0, 
  						     "height": (ibe_height - (options.insettop + options.insetbottom)) + "px", 
  						     "width": (ibe_width - (options.insetleft + options.insetright)) + "px", 
  						     "opacity": 1
  						   }, {
  						    "duration": options.speed, 
  						    "queue": false
  						  });
  						  
  					} 
  				}),
			   
			 after = $("<div />", {
  			  "class": options.innerClass,
  			  "css"  : {
    				"height": (ibe_height - (options.insettop + options.insetbottom)) + "px",
    				"width": (ibe_width - (options.insetleft + options.insetright)) + "px",
    				"border-left": options.insetleft + "px " + options.borderType + " " + options.borderColor,
    				"border-right": options.insetright + "px " + options.borderType + " " + options.borderColor,
    				"border-top": options.insettop + "px " + options.borderType + " " + options.borderColor,
    				"border-bottom": options.insetbottom + "px " + options.borderType + " " + options.borderColor,
    				"position": "absolute",
    				"top": 0,
    				"left": 0
			    }
			   });

			$el.wrap(wrapper).after(after);
		});
	};
})(jQuery);



// Jquery Collapse
(function($) {
    
    // Use a cookie counter to allow multiple instances of the plugin
    var cookieCounter = 0;
    
    $.fn.extend({
        collapse: function(options) {
            
            var defaults = {
                head : "h3",
                group : "div, ul",
                cookieName : "collapse",
                // Default function for showing content
                show: function() { 
                    this.show();
                },
                // Default function for hiding content
                hide: function() { 
                    this.hide();
                }
            };
            var op = $.extend(defaults, options);
            
            // Default CSS classes
            var active = "active",
                inactive = "inactive";
            
            return this.each(function() {
                
                // Increment coookie counter to ensure cookie name integrity
                cookieCounter++;
                var obj = $(this),
                    // Find all headers and wrap them in <a> for accessibility.
                    sections = obj.find(op.head).wrapInner('<a href="#"></a>'),
                    l = sections.length,
                    cookie = op.cookieName + "_" + cookieCounter;
                    // Locate all panels directly following a header
                    var panel = obj.find(op.head).map(function() {
                        var head = $(this)
                        if(!head.hasClass(active)) {
                            return head.next(op.group).hide()[0];
                        }
                        return head.next(op.group)[0];
                    });
    
                // Bind event for showing content
                obj.bind("show", function(e, bypass) {
                    var obj = $(e.target);
                    // ARIA attribute
                    obj.attr('aria-hidden', false)
                        .prev()
                        .removeClass(inactive)
                        .addClass(active);
                    // Bypass method for instant display
                    if(bypass) {
                        obj.show();
                    } else {
                        op.show.call(obj);
                    }
                });

                // Bind event for hiding content
                obj.bind("hide", function(e, bypass) {
                    var obj = $(e.target);
                    obj.attr('aria-hidden', true)
                        .prev()
                        .removeClass(active)
                        .addClass(inactive);
                    if(bypass) {
                        obj.hide();
                    } else {
                        op.hide.call(obj);
                    }
                });
                
                // Look for existing cookies
                if(cookieSupport) {
                    for (var c=0;c<=l;c++) {
                        var val = $.cookie(cookie + c);
                        // Show content if associating cookie is found
                        if ( val == c + "open" ) {
                            panel.eq(c).trigger('show', [true]);
                        // Hide content
                        } else if ( val == c + "closed") {
                            panel.eq(c).trigger('hide', [true]);
                        }
                    }
                }
                
                // Delegate click event to show/hide content.
                obj.bind("click", function(e) {
                    var t = $(e.target);
                    // Check if header was clicked
                    if(!t.is(op.head)) {
                        // What about link inside header.
                        if ( t.parent().is(op.head) ) {
                            t = t.parent();
                        } else {
                            return;
                        }
                        e.preventDefault();
                    }
                    // Figure out what position the clicked header has.
                    var num = sections.index(t),
                        cookieName = cookie + num,
                        cookieVal = num,
                        content = t.next(op.group);
                    // If content is already active, hide it.
                    if(t.hasClass(active)) {
                        content.trigger('hide');
                        cookieVal += 'closed';
                        if(cookieSupport) {
                            $.cookie(cookieName, cookieVal, { path: '/', expires: 10 });
                        }
                        return;
                    }
                    // Otherwise show it.
                    content.trigger('show');
                    cookieVal += 'open';
                    if(cookieSupport) {
                        $.cookie(cookieName, cookieVal, { path: '/', expires: 10 });
                    }
                });
            });
        }
    });

    // Make sure can we eat cookies without getting into trouble.
    var cookieSupport = (function() {
        try {
            $.cookie('x', 'x', { path: '/', expires: 10 });
            $.cookie('x', null);
        }
        catch(e) {
            return false;
        }
        return true;
    })();
})(jQuery);


/*!
 * jQuery Cookie Plugin
 */
(function($) {
    $.cookie = function(key, value, options) {

        // key and at least value given, set cookie...
        if (arguments.length > 1 && (!/Object/.test(Object.prototype.toString.call(value)) || value === null || value === undefined)) {
            options = $.extend({}, options);

            if (value === null || value === undefined) {
                options.expires = -1;
            }

            if (typeof options.expires === 'number') {
                var days = options.expires, t = options.expires = new Date();
                t.setDate(t.getDate() + days);
            }

            value = String(value);

            return (document.cookie = [
                encodeURIComponent(key), '=', options.raw ? value : encodeURIComponent(value),
                options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
                options.path    ? '; path=' + options.path : '',
                options.domain  ? '; domain=' + options.domain : '',
                options.secure  ? '; secure' : ''
            ].join(''));
        }

        // key and possibly options given, get cookie...
        options = value || {};
        var decode = options.raw ? function(s) { return s; } : decodeURIComponent;

        var pairs = document.cookie.split('; ');
        for (var i = 0, pair; pair = pairs[i] && pairs[i].split('='); i++) {
            if (decode(pair[0]) === key) return decode(pair[1] || ''); // IE saves cookies with empty string as "c; ", e.g. without "=" as opposed to EOMB, thus pair[1] may be undefined
        }
        return null;
    };
})(jQuery);