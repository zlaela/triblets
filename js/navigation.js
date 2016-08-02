/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables tab
 * support for dropdown menus.
 */
( function() {
	var container, button, navmenu, menu, links, subMenus, subMenuButton, i, i2, len;
	
	container = document.getElementById( 'topnav' ); //was site-navigation
	if ( ! container ) {
		return;
	}
	
	button = container.getElementsByTagName( 'button' )[0];
	if ( 'undefined' === typeof button ) {
		return;
	}

	//navmenu = container.getElementsByClassName( 'main-navigation' )[0];
	navmenu = container.getElementsByTagName( 'nav' )[0];
	navmenu.className += 'main-navigation';	
	
	menu = container.getElementsByTagName( 'ul' )[0];
	
	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {
		button.style.display = 'none';
		return;
	}

	menu.setAttribute( 'aria-expanded', 'false' );
	if ( -1 === menu.className.indexOf( 'nav-menu' ) ) {
		menu.className += ' nav-menu';
	}
	
	button.onclick = function() {
		if ( -1 !== menu.className.indexOf( 'toggled' ) ) { //menu was container
			menu.className = menu.className.replace( ' toggled', '' ); //menu was 
			//added for div sizing
			navmenu.className = navmenu.className.replace( ' expand', '' );
		
			button.setAttribute( 'aria-expanded', 'false' );
			menu.setAttribute( 'aria-expanded', 'false' );
		} else {
			menu.className += ' toggled'; 		//menu was container
			//added for div sizing
			navmenu.className += ' expand';
			
			button.setAttribute( 'aria-expanded', 'true' );
			menu.setAttribute( 'aria-expanded', 'true' );
		}
	};

	// Get all the link elements within the menu.
	links    = menu.getElementsByTagName( 'a' );
	subMenus = menu.getElementsByTagName( 'ul' );

	
	// Set menu items with submenus to aria-haspopup="true".
	// Add button to submenus 
	for ( i = 0, len = subMenus.length; i < len; i++ ) {
		subMenus[i].parentNode.setAttribute( 'aria-haspopup', 'true' );
		subMenus[i].insertAdjacentHTML( 'afterend', '<button class="menu-down-arrow"><i class="material-icons"></i></button>' );
	};	
	
	// Make the submenu button do things
	subMenuButton = menu.getElementsByTagName( 'button' );
	for ( i2 = 0, len = subMenuButton.length; i2 < len; i2++ ){
		subMenuButton[i2].addEventListener( 'click', function( e ){
			e.preventDefault();
			//alert("clicked button");
			
			var self = this;
			  
			if ( self.previousElementSibling.className.indexOf( 'toggled-submenu' ) !== -1 ) { // if .sub-menu has .toggled-submenu class
				self.previousElementSibling.className = self.previousElementSibling.className.replace( ' toggled-submenu', '' ); // remove it
				self.previousElementSibling.setAttribute( 'aria-expanded', 'false' );
				
				console.log( 'button.' + self.className + ' is not toggled' );
			} else {
				self.previousElementSibling.className += ' toggled-submenu'; // otherwise, add it
				self.previousElementSibling.setAttribute( 'aria-expanded', 'true' );
				
				console.log( 'button.' + self.className + ' is toggled' );
			}			
		})
	};
		
	// Each time a menu link is focused or blurred, toggle focus.
	for ( i = 0, len = links.length; i < len; i++ ) {
		links[i].addEventListener( 'focus', toggleFocus, true );
		links[i].addEventListener( 'blur', toggleFocus, true );
	};
	
	/**
	 * Sets or removes .focus class on an element.
	 */
	function toggleFocus() {
		var self = this;

		// Move up through the ancestors of the current link until we hit .nav-menu.
		while ( -1 === self.className.indexOf( 'nav-menu' ) ) {

			// On li elements toggle the class .focus.
			if ( 'li' === self.tagName.toLowerCase() ) {
				if ( -1 !== self.className.indexOf( 'focus' ) ) {
					self.className = self.className.replace( ' focus', '' );
				} else {
					self.className += ' focus';
				}
			}
			self = self.parentElement;
		}
	};
	
	/**
	 * Toggles `focus` class to allow submenu access on tablets.
	 */
	( function( menu ) { //menu was container
		var touchStartFn, i,
			parentLink = menu.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' ); //menu was container

		if ( 'ontouchstart' in window ) {
			touchStartFn = function( e ) {
				var menuItem = this.parentNode, i;

				if ( ! menuItem.classList.contains( 'focus' ) ) {
					e.preventDefault();
					for ( i = 0; i < menuItem.parentNode.children.length; ++i ) {
						if ( menuItem === menuItem.parentNode.children[i] ) {
							continue;
						}
						menuItem.parentNode.children[i].classList.remove( 'focus' );
					}
					menuItem.classList.add( 'focus' );
				} else {
					menuItem.classList.remove( 'focus' );
				}
			};

			for ( i = 0; i < parentLink.length; ++i ) {
				parentLink[i].addEventListener( 'touchstart', touchStartFn, false );
			}
		}
	}( menu ) ); //menu was container
	
	
	// Polyfill for Internet Explorer 8
	// Source: https://github.com/Alhadis/Snippets/blob/master/js/polyfills/IE8-child-elements.js
	if(!("nextElementSibling" in document.documentElement)){
		Object.defineProperty(Element.prototype, "nextElementSibling", {
			get: function(){
				var e = this.nextSibling;
				while(e && 1 !== e.nodeType)
					e = e.nextSibling;
				return e;
			}
		});
	}
} )();
	