//This is the front-page slider
(function($) {
	$(document).ready(function() {
	  $('#slides').slidesjs({	
		height: 500,
		navigation: false,
        pagination: {
          effect: "slide"
        },
        effect: {
          slide: {
                speed: 400
          }
        },
		callback: {
			loaded: function(number) {
				$("#slider_content2,#slider_content3").hide(0);
			},
			start: function(number)
			{				
				$("#slider_content"+number).delay(300).fadeOut(500);
			},
			complete: function(number)
			{			
				$("#slider_content"+number).delay(400).fadeIn(700);
			}		
		},
		play: {
			active: false,
			auto: false,
			interval: 6000,
			pauseOnHover: true,
			effect: "slide"
		}
	  });
	});
}(jQuery));

//This slides in the lessons
	jQuery(document).ready(function workBelt($) {
		$('.thumb-unit').click( function(){
			$('.work-belt').css('left','-100%');
			$('.work-belt').addClass("slided");
			$('.work-container').show();
		});		
		$('.work-return').click( function(){
			$('.work-belt').css('left','0%');
			$('.work-belt').removeClass("slided");
			$('.work-container').hide(800); //fade over 800ms
		});	
	});
	jQuery(document).ready(function workLoad($) {
		$.ajaxSetup ({ cache: false });		
		$('.thumb-unit').click( function(){
			var $this = $(this), 
				newTitle = $this.find('strong').text(),
				spinner = '<div class="loader">Loading...</div>',
				newHTML = $this.find('#content').text();
			$('.project-load').html(spinner).load(newHTML);
			$('.project-title').text(newTitle); 
		});
	});
