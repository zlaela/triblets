//All AJAX tutorial to load all content in one spot

//when the DOM is ready...
$(function() {

	//if you're in the home page, find the li with the class of home and remove it, and then add the class current_page_item
	$(".home li.home").removeClass("home").addClass("current_page_item");
	
	$("#column-wrap").append("<img src='/images/ajax-loader.gif' id=ajax-loader");
	// cache the selector
	$var $mainContent = $("#main-content"),
		i = 0;
		//get the base of URL of the site
		$siteURL = "http://" + top.location.host.toString(),
		//target only internal links (links in the theme, not to YouTube, etc.)
		//links where target = siteURL
		$internalLinks = $('a[href^=' + siteURL + ']'),
		
		//hash is #/<page>/. We added # to prevent links from loading another page
		hash = window.location.hash,
		//cache ajax-loader loader here
		$ajaxSpinner = $("#ajax-loader"),
		URL = '';
		$el, $allLinks= $("a");
		
	//deep linking: can send out a link with # and it will still load the correct page.
	if (hash) {
		$ajaxSpinner.fadeIn();
		$mainContent.animate({ opacity: "0.1" });
		$(".current_page_item").removeClass("current_page_item");
		$('a[href^=' + hash + ']').addClass("current_link").parent().addClass("current_page_item");
		hash = hash.substring(1);
		URL = hash. " #inside";
		$mainContent.load(URL, function() {
			$ajaxSpinner.fadeOut();
			$mainContent.animate({ poacity: "1" });			
		});
	}
		
		
	//when the internal link is clicked -- each link
	$internalLinks.each( function() {
		
		//set the attribute of its href to a # + the pathname of itself
		$(this).attr("href", "#" + this.pathname);
		//this makes it so each link's href doesn't do anything because it's prepended with a '#'	
	}).click( function() {
		//spinner load
		$ajaxSpinner.fadeIn();
		//animate the content to fade-in (user feedback)
		$mainContent.animate({ poacity: "0.1" });
		//cache the selector
		$el = $(this);
		//remove current_page_item class from any item that has it
		$(".current_page_item").removeClass("current_page_item");
		
		$allLinks.removeClass("current_link");
		
		
		//get the href of that link that we're going to load and set it to URL
		//get rid of the #
		URL = $el.attr("href").substring(1);
		
		URL = URL + " #inside";
		
		
		$main.Content.load(URL, function() {
			
			$el.addClass("current_link").parent().addClass("current_page_item");
			$ajaxSpinner.fadeOut();
			$mainContent.animate({ poacity: "1" });
		});
		
		//prevent devault action of following link
		//e.preventDefault();
		//this is not needed so the RUL changs with a link is clicked.
	});
	
	
	// AJAX the search. search has a customer URL that we need to hook
	$("#searchform").submit(function(e) {
		$ajaxSpinner.fadeIn();
		$mainContent.animate({ poacity: "0.1" });
		$el = $(this);
		$(".current_page_item").removeClass("current_page_item");		
		$allLinks.removeClass("current_link");
		
		//
		URL = "/?s" + $("#s").val() + " #inside";
				$main.Content.load(URL, function() {
			
			$el.addClass("current_link").parent().addClass("current_page_item");
			$ajaxSpinner.fadeOut();
			$mainContent.animate({ poacity: "1" });
		});
		e.preventDefault();
	});
		
	//tests
	//in the section mainContent load the #inside section from the contact page
	$mainContent.load("/contact/ #inside");
	//add class to internal links only
	$internalLinks.addClass("internal");

});