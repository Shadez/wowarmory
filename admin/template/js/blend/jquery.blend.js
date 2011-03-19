/*
	jQuery Blend v1.1
	(c) 2009 Jack Moore - www.colorpowered.com - jack@colorpowered.com
	Licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php
*/
(function($){
    /*
        Blend creates a 2nd layer on top of the target element.
        This layer is faded in and out to create the effect.  The orignal, bottom layer
        has it's class set to 'hover' and remains that way for the duration to
        keep the CSS :hover state from being apparent when the object is moused-over.
    */
    
    $.fn.blend = function(options, callback) {
	
	var settings = $.extend({}, $.fn.blend.settings, options);
        
        $(this).each(function(){
            
            var $this = $(this),
		$target = $(settings.target ? settings.target : this),
		$hover,
		target = [],
		i,
		length,
		style = {},
		active = false,
		out = 0,
		opacity = settings.opacity,
		properties = [
		    'background-color',
		    'background-image',
		    'background-repeat',
		    'background-attachment',
		    'background-position',
		    'background-position-x',
		    'background-position-y'
		];
	    
	    length = properties.length;
            
            if($target[0].style.position != 'absolute'){
                $target.css({position:'relative'});   
            }
            
            if(!$target.hasClass('hover')){
                $target.wrapInner('<div style="position:relative" />');
            }
	    
	    for (i=0; i<length; i++){
		target[i] = $target.css(properties[i]);
	    }
	    
	    $target.addClass("hover");
	    
	    style = {};
		style.position='absolute';
		style.top=0;
		style.left=0;
		style.width=$target.css('width');
		style.height=$target.css('height');
		for (i=0; i<length; i++){
		    style[properties[i]] = $target.css(properties[i]);
		}
	    
	    //checks to see if blend has already been applied to an element.
            if($target.find(".jsblend").length === 0){
                $hover = $('<div class="jsblend" />').css(style);
		
		if(settings.top){
		    $hover.appendTo($target);
		} else {
		    $hover.prependTo($target);
		}
            } else {
                $hover = $target.find(".jsblend");
            }
	    
	    style = {};
		for (i=0; i<length; i++){
		    style[properties[i]] = target[i];
		}
	    
	    $target.css(style);
            
            if(settings.reverse){
                out = settings.opacity;
                opacity = 0;
            }
            $hover.css({opacity:out});
            
            function pulse(o){
                if(active){
                    $hover.fadeTo(settings.speed, o, function(){
                        pulse(o==out?opacity:out);
                    });
                }
            }
	    
            if(settings.pulse && settings.active){
                active = true;
                pulse(opacity);
	    } else if(settings.pulse){
                $this.hover(function(){
                    active = true;
                    pulse(opacity);
                }, function(){
                    active = false;
                    $hover.stop(true).fadeTo(settings.speed, out);
                });
            } else {
                $this.hover(function(){
                    $hover.stop().fadeTo(settings.speed, opacity);
                }, function(){
                    $hover.stop().fadeTo(settings.speed, out);
                });
            }
	    
        });
        return this;
    };
    
    $.fn.blend.settings = {
        speed : 500,
        opacity : 1,
        target : false,
        reverse : false,
	pulse : false,
	active : false,
	top : false
    };
    
})(jQuery);