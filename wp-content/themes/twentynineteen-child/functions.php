<?php
function my_theme_enqeue_style() {

	wp_register_style( 'fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css' );
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css', wp_get_theme()->get('version'), false );
	wp_enqueue_style('bootstrap-css', get_stylesheet_directory_uri(). '/css/bootstrap.min.css', array(), wp_get_theme()->get('version'), false );
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style'), '1.5', false );
	//wp_enqueue_style( 'child-style-extra', get_stylesheet_directory_uri() . '/css/style-extra.css', array(), '0.2', false );

	wp_enqueue_script( 'jquery', get_stylesheet_directory_uri(). '/js/jquery-min.js', array(), '', true);
	wp_enqueue_script('bootstrap-js', get_stylesheet_directory_uri(). '/js/bootstrap.min.js', '', '', true );
	wp_enqueue_script( 'main-js', get_stylesheet_directory_uri(). '/js/main.js' , array('jquery'), '0.2', true );

	wp_enqueue_style( 'fontawesome');
	wp_enqueue_script( 'child-script' );

}
add_action('wp_enqueue_scripts', 'my_theme_enqeue_style');

function shape_register_custom_background() {
	$args = array(
		'default-color' => 'e9e0d1',
	);

	$args = apply_filters( 'shape_custom_background_args', $args );

	if ( function_exists( 'wp_get_theme' ) ) {
		add_theme_support( 'custom-background', $args );
	} else {
		define( 'BACKGROUND_COLOR', $args['default-color'] );
		define( 'BACKGROUND_IMAGE', $args['default-image'] );
		add_custom_background();
	}
}
add_action( 'after_setup_theme', 'shape_register_custom_background' );
add_theme_support( 'custom-header' );

function my_custom_mime_types( $mimes ) {

	// New allowed mime types.
	$mimes['svg'] = 'image/svg+xml';
	$mimes['svgz'] = 'image/svg+xml';
	$mimes['doc'] = 'application/msword';

	// Optional. Remove a mime type.
	unset( $mimes['exe'] );

	return $mimes;
}
add_filter( 'upload_mimes', 'my_custom_mime_types' );

// move admin bar to bottom
function fb_move_admin_bar() { ?>
<style type="text/css">
	body.admin-bar #wphead {
		padding-top: 28px;
	}
	body.admin-bar #footer {
		padding-bottom: 0;
	}
	#wpadminbar {
		direction: ltr;
		color: #ccc;
		font-size: 13px;
		font-weight: 400;
		font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;
		line-height: 2.46153846;
		height: 32px;
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		min-width: 600px;
		z-index: 99999;
		background: #23282d;
	}
	#wpadminbar .quicklinks .menupop ul {
		bottom: 28px;
	}
</style>
<?php }
// on backend area
add_action( 'admin_head', 'fb_move_admin_bar' );
// on frontend area
add_action( 'wp_head', 'fb_move_admin_bar' );

function twentynineteen_custom_logo_setup() {
	// SET NEW LOGO SIZE IN CHILD 
	if ( ! function_exists( 'twentynineteen_setup' ) ) :
	function twentynineteen_setup() {
		add_theme_support( 'custom-logo', array(
			'flex-height' => true,
			'header-text' => array( 'site-title', 'site-description' ),
		), 9 );
	}
	endif;
}
add_action( 'after_setup_theme', 'twentynineteen_custom_logo_setup',10 );

add_filter('wp_nav_menu_items', 'add_search_form', 10, 2);
function add_search_form($items, $args) {
	if( $args->theme_location == 'primary' )
		$items .= '<li class="search main-nav__menu-search" title="Search"><form role="search" method="get" id="searchform" action="'.home_url( '/' ).'"><input type="text" value="" name="s" id="s" placeholder="Search" /><button type="submit" id="searchsubmit"><i class="fas fa-search"></i></button></form></li>';
	return $items;
}

add_action( 'pre_get_posts', function( $query ) {
	// Check that it is the query we want to change: front-end search query
	if( $query->is_main_query() && ! is_admin() && $query->is_search() ) {
		// Change the query parameters
		$query->set( 'posts_per_page', 10 );
	}
} );




class My_Walker_Nav_Menu extends Walker_Nav_Menu {
	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ){
		$GLOBALS['dd_children'] = ( isset($children_elements[$element->ID]) )? 1:0;
		$GLOBALS['dd_depth'] = (int) $depth;
		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}
	function start_lvl(&$output, $depth) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"main-nav__sub-menu\">\n";
	}
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) 
	{
		global $wp_query, $wpdb;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$li_attributes = '';
		$class_names = $value = '';
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		
		$has_children = $wpdb->get_var("SELECT COUNT(meta_id) FROM wp_postmeta WHERE meta_key='_menu_item_menu_item_parent' AND meta_value='".$item->ID."'");
    if ($has_children > 0) array_push($classes,'main-nav__menu-item--dropdown');

		//Add class and attribute to LI element that contains a submenu UL.
		if ($args->has_children > 0){
			//$classes[]    = 'dropdown';
			//$li_attributes .= 'data-dropdown="dropdown"';
		}
		$classes[] = 'main-nav__menu-item menu-item-' . $item->ID;
		//If we are on the current page, add the active class to that menu item.
		$classes[] = ($item->current) ? 'active' : '';
		//Make sure you still add all of the WordPress classes.
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

		$class_names = ' class="' . esc_attr( $class_names ) . '"';
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
		$has_children = $wpdb->get_var(
			$wpdb->prepare("
       SELECT COUNT(*) FROM $wpdb->postmeta
       WHERE meta_key = %s
       AND meta_value = %d
       ", '_menu_item_menu_item_parent', $item->ID)
		);

		$output .= $indent . '<li' . $id . $value . $class_names .'>';
		// 			$output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>dd';
		//Add attributes to link element.
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url ) ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		// Check if menu item is in main menu

		if ( $depth == 0 && $has_children > 0  ) {
			// These lines adds your custom class and attribute
			$attributes .= ' class=" dropdown-toggle"';
			//$attributes .= ' data-toggle="dropdown"';
		}
		$item_output = $args->before;

		// Add the caret if menu level is 0
		if ( $depth == 0 && $has_children > 0  ) {
			$item_output .= '<span class="main-nav__menu-item-link" '. $attributes .'>';
			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			$item_output .= ' <b class="caret"></b>';
			$item_output .= '</span>';
		} else {
			$item_output .= '<a class="main-nav__menu-item-link" '. $attributes .'>';
			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			$item_output .= ' <b class="caret"></b>';
			$item_output .= '</a>';
		}

		$item_output .= $args->after;
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

// function setup_theme_admin_menus() {
//     add_menu_page('Theme settings', 'GB theme', 'manage_options', 
//         'tut_theme_settings', 'theme_settings_page', 'dashicons-art', '58');

//     add_submenu_page('tut_theme_settings', 
//         'Front Page Elements', 'Front Page', 'manage_options', 
//         'tut_theme_settings', 'theme_front_page_settings'); 
// }
// add_action("admin_menu", "setup_theme_admin_menus");

// function theme_front_page_settings() {
// 	// Check that the user is allowed to update options
// if (!current_user_can('manage_options')) {
//     wp_die('You do not have sufficient permissions to access this page.');
// }
//     require_once( __DIR__ . '/gbtheme-options.php');
// }

?>