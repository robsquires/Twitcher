// JavaScript Document
jQuery(document).ready(function()
{

////////////////////////////////////////////////////////////////////////////////////
//
//	slideshow settings
//
jQuery('.slide_entry').cycle({
		fx: 'fade',
		speed:  'slow',
        timeout: 6000,
		pause: 1,
		pager:'#pager', 	
		pagerAnchorBuilder: function(idx, slide) { return '<li><a href="#"></a></li>'; }
	});

////////////////////////////////////////////////////////////////////////////////////
//
//	testimonials settings
//

jQuery('#testimonials').cycle({
		fx: 'scrollVert',        
		speed:  'slow',
		easing: 'easeOutExpo',
		prev:   '#prev', 
    	next:   '#next',
        timeout: 6000,
		cleartype:  1,
		pause: 1
	});

////////////////////////////////////////////////////////////////////////////////////

kostadino_imagehover();
kostadino_lightbox();

});

///////////////////////////////////////////////////////////////////////////////////// 

//----------
// image hover
//----------
function kostadino_imagehover(){
	
	$("#screens li, .slide_entry li ").hover(function() {
				$(this).find("img").animate({opacity: 0.8}, "slow");
				$(this).find(".over_image").animate({opacity: "show", top: "50%"}, "slow","easeOutExpo");
				$(this).find(".description").animate({bottom: "-120px"}, "fast");
			}, function() {
				$(this).find("img").animate({opacity: 1}, "fast");
				$(this).find(".over_image").animate({opacity: "hide", top: "-60px"}, "fast");
				$(this).find(".description").animate({bottom: "0px"}, "fast");
	});
	

}


//----------
// fancybox lightbox
//----------
function kostadino_lightbox(){
	
	$("a[rel=fancyzoom]").fancybox();
	
	$("a[rel=fancyzoom_group]").fancybox();
	
	//----------
	// fancybox vimeo 
	//----------
	$("a[rel=fancyvimeo]").click(function() {
		$.fancybox({
				'padding'		: 0,
				'autoScale'		: false,
				'title'			: this.title,			
				'href'			: this.href.replace(new RegExp("[0-9]", "i"), 'moogaloop.swf?clip_id=1'),
				'type'			: 'swf',
				'swf'			: {'wmode':'transparent','allowfullscreen':'true'}
		});

	return false;
	});	
	
	//----------
	// fancybox youtube 
	//----------
	$("a[rel=fancytube]").click(function() {
		$.fancybox({
				'padding'             : 0,
				'autoScale'   : false,
				'transitionIn'        : 'none',
				'transitionOut'       : 'none',
				'title'               : this.title,
				'width'               : 680,
				'height'              : 495,
				'href'                : this.href.replace(new RegExp("watch\\?v=", "i"), 'v/'),
				'type'                : 'swf',    // <--add a comma here
				'swf'                 : {'allowfullscreen':'true', 'wmode':'opaque'} // <-- flashvars here
		}); 

	return false;
	});	
	
}
