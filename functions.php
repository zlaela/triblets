<?php
/**
 * triblets functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package triblets
 */

if ( ! function_exists( 'triblets_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
 
 
function triblets_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on triblets, use a find and replace
	 * to change 'triblets' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'triblets', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	
   /*
	*
	* size limit on thumbnails.
	* Add support for customer image sizes.
	*/
	set_post_thumbnail_size( 920 , 440 , true );

	add_image_size( 'small-thumbnail', 180, 180, true );
	
	
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'triblets' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'triblets_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
	
}
endif;
add_action( 'after_setup_theme', 'triblets_setup' );



/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function triblets_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'triblets_content_width', 640 );
}
add_action( 'after_setup_theme', 'triblets_content_width', 0 );



/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function triblets_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'triblets' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );	
	
	register_sidebar( array(
		'name'          => esc_html__( 'Front Page Bar', 'triblets' ),
		'id'            => 'sidebar-2',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="agenda-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'triblets_widgets_init' );



/**
 * Enqueue scripts and styles.
 */
function triblets_scripts() {
	wp_enqueue_style( 'triblets-style', get_stylesheet_uri() );

	wp_enqueue_script( 'triblets-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'triblets-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	/*use SlidesJS*/
	wp_enqueue_script(
        'custom-script',
        get_template_directory_uri() . '/js/jquery.slides.min.js',
        array( 'jquery' ), false, true
		);
	
	/*use the unsemantic grid*/
	wp_enqueue_style( 'triblets-unsemantic', get_template_directory_uri() . '/inc/unsemantic-grid-responsive-tablet.css' );

	wp_enqueue_style( 'triblets-unsemantic_rtl', get_template_directory_uri() . '/inc/unsemantic-grid-responsive-tablet-rtl.css' );
	
	/*use the custom scripts*/
	wp_enqueue_script( 'triblets-custom-scripts', get_stylesheet_directory_uri() . '/js/triblets-scripts.js', array( 'jquery' ) );
		
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'triblets_scripts' );




/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';



/**
 * Custom Functions
 */
 
 //strip images from the_content(); for gallery page only
function remove_shortcode_from_gallery($content) {
  if ( is_page( 'gallery' ) ) {
    $content = strip_shortcodes( $content );
  }
  return $content;
}
add_filter('the_content', 'remove_shortcode_from_gallery');

	
 //Specify excerpt word count
function custom_excerpt_length() {
    return 25;
}
add_filter('excerpt_length', 'custom_excerpt_length');
 
 
 // Get top ancestor
function get_top_ancestor_id() {
    global $post;

    if ($post->post_parent) {
        $ancestors = array_reverse(get_post_ancestors($post->ID));
        //return end($ancestors);
        return $ancestors[0];
    }
    return $post->ID;
}

// Does page have children?
function has_children() {
    global $post;

    //get pages that are children to the current page
    $pages = get_pages('child_of=' . $post->ID);
    return count($pages);
}

// Get page children
function my_get_page_children($page_id, $post_type = 'page') {
    // Set up the objects needed
    $custom_wp_query = new WP_Query();
    $all_wp_pages = $custom_wp_query->query(array('post_type' => $post_type, 'posts_per_page' => -1));

    // Filter through all pages and find specified page's children
    $page_children = get_page_children($page_id, $all_wp_pages);

    return $page_children;
}

// Get child page ID
function page_children($page_id, $post_type = 'page') {
    // Set up the objects needed
    $custom_wp_query = new WP_Query();
    $all_wp_pages = $custom_wp_query->query(array('post_type' => $post_type, 'posts_per_page' => -1));
	
    // Filter through all pages and find specified page's children
    $page_children = get_page_children($page_id, $all_wp_pages);

	return $page_children;
/* 	// Toss the IDs into an array and return it
	$IDs = array();
	foreach( $page_children as $child ){		
		$child_id = $child->ID;		
		$IDs[] = $child_id;		
	}	
	return $IDs; */
}