$(document).ready(function() {
    "use strict";
    
	$("#recent-column5").owlCarousel({
		autoPlay: 3000,
		items : 5,
		navigation : true,
		pagination : false,
		itemsDesktop : [1199,3],
        itemsDesktopSmall : [979,3],
		itemsTablet : [768, 3],
	});
	
	$("#recent-column4").owlCarousel({
		autoPlay: 3000,
		items : 4,
		navigation : true,
		pagination : false,
		itemsDesktop : [1199,3],
        itemsDesktopSmall : [979,3],
		itemsTablet : [768, 3],
	});
	
	$("#recent-column3").owlCarousel({
		autoPlay: 3000,
		items : 3,
		navigation : true,
		pagination : false,
		itemsDesktop : [1199,3],
        itemsDesktopSmall : [979,3],
		itemsTablet : [768, 1],
	});
	
	$("#owl-services").owlCarousel({
		autoPlay: false,
		items : 3,
		navigation : true,
		pagination : false,
		itemsDesktop : [1199,3],
        itemsDesktopSmall : [979,3],
		itemsTablet : [768, 1],
	});
	
	$("#team").owlCarousel({
		autoPlay: false,
		items : 4,
		navigation : true,
		pagination : false,
		itemsDesktop : [1199,3],
        itemsDesktopSmall : [979,3],
		itemsTablet : [768, 3],
	});
	
	$("#team1").owlCarousel({
		autoPlay: false,
		items : 4,
		navigation : true,
		pagination : false,
		itemsDesktop : [1199,3],
        itemsDesktopSmall : [979,3],
		itemsTablet : [768, 3],
	});
    
    
    $("#slider-app").owlCarousel({
        navigation : false,
        pagination : false,
        slideSpeed : 300,
        paginationSpeed : 400,
        singleItem:true,
        autoPlay : 3000
    });

});
