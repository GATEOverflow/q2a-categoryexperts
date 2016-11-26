(function ($) {
 "use strict";

 var core = {
initialize: function() {
this.event();
},
event : function(){

jcf.replaceAll();

// ------------------------------------------------------------------------------ //
window.prettyPrint && prettyPrint()

	$(".img-wrapper").each(function(){
			var capZoomIn = $(".capZoomIn", this),
			capZoomInDown = $(".capZoomInDown", this),
			capRollIn = $(".capRollIn", this),
			capRotateIn = $(".capRotateIn", this),
			capBounceOut = $(".capBounceOut", this);

			$(".img-caption").addClass("animated");
			capZoomIn.addClass("zoomOut");
			capZoomInDown.addClass("zoomOutDown");
			capRollIn.addClass("rollOut");
			capRotateIn.addClass("rotateOut");
			capBounceOut.addClass("bounceOut");
			$(this).on("mouseenter", function() {
					capZoomIn.addClass("zoomIn");
					capZoomIn.removeClass("zoomOut");
					capZoomInDown.addClass("zoomInDown");
					capZoomInDown.removeClass("zoomOutDown");
					capRollIn.addClass("rollIn");
					capRollIn.removeClass("rollOut");
					capRotateIn.addClass("rotateIn");
					capRotateIn.removeClass("rotateOut");
					capBounceOut.addClass("bounceIn");
					capBounceOut.removeClass("bounceOut");
					$(this).addClass("on");
					return false;
					});
			$(this).on("mouseleave", function() {
					capZoomIn.addClass("zoomOut");
					capZoomIn.removeClass("zoomIn");
					capZoomInDown.addClass("zoomOutDown");
					capZoomInDown.removeClass("zoomInDown");
					capRollIn.addClass("rollOut");
					capRollIn.removeClass("rollIn");
					capRotateIn.addClass("rotateOut");
					capRotateIn.removeClass("rotateIn");
					capBounceOut.addClass("bounceOut");
					capBounceOut.removeClass("bounceIn");
					$(this).removeClass("on");
					return false;
					});
	});	
	},
};


$(window).on("load", function(){
		core.initialize();  
		});
}(jQuery));

