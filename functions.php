<?php

// set upload sizes
@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );

// IE6-8 polyfills
function add_ie () {
	echo "<!--[if (gte IE 6)&(lte IE 8)]>\n";
	echo "<script src='" . get_template_directory_uri() . "/js/selectivizr.js'></script>\n";
	echo "<![endif]-->\n";
}
add_action('wp_head', 'add_ie');

// enqueue scripts
function si_scripts() {
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', get_template_directory_uri() . '/js/scripts.js', false, '1.11.0', false );
	wp_register_script( 'main', get_template_directory_uri() . '/js/script.js', false, '1.7.1', true );
	wp_register_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.js', false, '2.7.1', false );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'main' );
	wp_enqueue_script( 'modernizr' );
}
add_action( 'wp_enqueue_scripts', 'si_scripts' );

// enqueue styles
function si_css() {
	wp_register_style( 'OpenSans', 'http://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800', false, false );
	wp_register_style( 'styles', get_template_directory_uri() . '/css/styles.css', false, false );
	wp_enqueue_style( 'styles' );
	wp_enqueue_style( 'OpenSans' );
}
add_action( 'wp_enqueue_scripts', 'si_css' );

function remove_menus () {
global $menu;
	$restricted = array( __('Posts'), __('Links'), __('Tools'), __('Comments'), __('Plugins'), __('Settings'));
	end ($menu);
	while (prev($menu)){
		$value = explode(' ',$menu[key($menu)][0]);
		if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
	}
}
add_action('admin_menu', 'remove_menus');

function my_remove_menu_pages() {
	remove_submenu_page ('themes.php', 'themes.php');
	remove_submenu_page ('themes.php', 'theme-editor.php');
	remove_submenu_page ('themes.php', 'customize.php');
}
add_action( 'admin_init', 'my_remove_menu_pages' );
	
// content width for breakpoints
if ( ! isset( $content_width ) )
	$content_width = 960;

// theme functions
function stop_ivory()  {
	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'post-thumbnails' );	
	set_post_thumbnail_size( 2048, 1342, true );
	add_image_size( 'who', 340, 192, true );
	add_image_size( 'big', 750, 350, true );
	add_image_size( 'sliver', 750, 150, true );
	add_image_size( 'mobile', 264, 264, true );
	add_image_size( 'grid', 297, 174, true );
	add_image_size( 'sliver', 1120, 350, true );
	add_filter('show_admin_bar', '__return_false');
	add_editor_style( get_template_directory_uri() . '/editor-style.css' );	
	$markup = array( 'search-form', 'comment-form', 'comment-list', );
	add_theme_support( 'html5', $markup );	
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	remove_action( 'wp_head', 'start_post_rel_link' );
	remove_action( 'wp_head', 'index_rel_link' );
	remove_action( 'wp_head', 'adjacent_posts_rel_link' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'feed_links', 2 );
	add_filter('login_errors', create_function('$a', "return null;"));
	add_filter('jpeg_quality', function($arg){return 90;});
}
add_action( 'after_setup_theme', 'stop_ivory' );

// menu locations
function si_menu() {
	$locations = array(
		'Header' => __( 'Main Menu', 'stop_ivory' ),
		'Mobile' => __( 'Mobile Menu', 'stop_ivory' ),
		'Social' => __( 'Social Menu', 'stop_ivory' ),
	);
	register_nav_menus( $locations );
}
add_action( 'init', 'si_menu' );

function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function new_excerpt_more( $more ) {
	return '';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );

function excerpt($limit) {
	$excerpt = explode(' ', get_the_excerpt(), $limit);
	if (count($excerpt)>=$limit) {
		array_pop($excerpt);
		$excerpt = implode(" ",$excerpt).'';
	} else {
		$excerpt = implode(" ",$excerpt);
	}
	$excerpt = preg_replace('`[[^]]*]`','',$excerpt);
	return $excerpt;
}

function content($limit) {
	$content = explode(' ', get_the_content(), $limit);
	if (count($content)>=$limit) {
		array_pop($content);
		$content = implode(" ",$content).'...';
	} else {
		$content = implode(" ",$content);
	}
	$content = preg_replace('/[.+]/','', $content);
	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]&gt;', $content);
	return $content;
}

function show_posts_nav() {
	global $wp_query;
	return ($wp_query->max_num_pages > 1);
}

remove_filter('term_description','wpautop');

function remove_post_custom_fields() {
	remove_meta_box( 'tagsdiv-post_tag' , 'post' , 'normal' ); 
	remove_meta_box( 'categorydiv' , 'post' , 'normal' ); 
}
add_action( 'admin_menu' , 'remove_post_custom_fields' );

function partner() {
	$labels = array(
		'name'				=> _x( 'Partners', 'Post Type General Name', 'stop_ivory' ),
		'singular_name'	   => _x( 'Partner', 'Post Type Singular Name', 'stop_ivory' ),
		'menu_name'		   => __( 'Partners', 'stop_ivory' ),
		'parent_item_colon'   => __( 'Parent Partner:', 'stop_ivory' ),
		'all_items'		   => __( 'All Partners', 'stop_ivory' ),
		'view_item'		   => __( 'View Partner', 'stop_ivory' ),
		'add_new_item'		=> __( 'Add New Partner', 'stop_ivory' ),
		'add_new'			 => __( 'Add New', 'stop_ivory' ),
		'edit_item'		   => __( 'Edit Partner', 'stop_ivory' ),
		'update_item'		 => __( 'Update Partner', 'stop_ivory' ),
		'search_items'		=> __( 'Search Partner', 'stop_ivory' ),
		'not_found'		   => __( 'Not found', 'stop_ivory' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'stop_ivory' ),
	);
	$args = array(
		'label'			   => __( 'Partner', 'stop_ivory' ),
		'description'		 => __( 'Governments, IGOs, NGOs, Private Sector', 'stop_ivory' ),
		'labels'			  => $labels,
		'supports'			=> array( 'title', 'editor', 'thumbnail', ),
		'taxonomies'		  => array( 'partner_tx' ),
		'hierarchical'		=> false,
		'public'			  => true,
		'show_ui'			 => true,
		'show_in_menu'		=> true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'	   => 5,
		'menu_icon'		   => '',
		'can_export'		  => true,
		'has_archive'		 => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'	 => 'page',
	);
	register_post_type( 'partner', $args );
}
add_action( 'init', 'partner', 0 );

function partner_tx() {
	$labels = array(
		'name'					   => _x( 'Partner categories', 'Taxonomy General Name', 'stop_ivory' ),
		'singular_name'			  => _x( 'Partner category', 'Taxonomy Singular Name', 'stop_ivory' ),
		'menu_name'				  => __( 'Partner category', 'stop_ivory' ),
		'all_items'				  => __( 'All Partner categories', 'stop_ivory' ),
		'parent_item'				=> __( 'Parent Partner category', 'stop_ivory' ),
		'parent_item_colon'		  => __( 'Parent Partner category:', 'stop_ivory' ),
		'new_item_name'			  => __( 'New Partner category', 'stop_ivory' ),
		'add_new_item'			   => __( 'Add New Partner category', 'stop_ivory' ),
		'edit_item'				  => __( 'Edit Partner category', 'stop_ivory' ),
		'update_item'				=> __( 'Update Partner category', 'stop_ivory' ),
		'separate_items_with_commas' => __( 'Separate Partner categories with commas', 'stop_ivory' ),
		'search_items'			   => __( 'Search Partner categories', 'stop_ivory' ),
		'add_or_remove_items'		=> __( 'Add or remove Partner categories', 'stop_ivory' ),
		'choose_from_most_used'	  => __( 'Choose from the most used Partner categories', 'stop_ivory' ),
		'not_found'				  => __( 'Not Found', 'stop_ivory' ),
	);
	$args = array(
		'labels'					 => $labels,
		'hierarchical'			   => true,
		'public'					 => true,
		'show_ui'					=> true,
		'show_admin_column'		  => true,
		'show_in_nav_menus'		  => true,
		'show_tagcloud'			  => true,
	);
	register_taxonomy( 'partner_tx', array( 'partner' ), $args );
}
add_action( 'init', 'partner_tx', 0 );

function whosinvolved() {
	$labels = array(
		'name'				=> _x( 'Who\'s Involved', 'Post Type General Name', 'stop_ivory' ),
		'singular_name'	   => _x( 'Who\'s Involved', 'Post Type Singular Name', 'stop_ivory' ),
		'menu_name'		   => __( 'Who\'s Involved', 'stop_ivory' ),
		'parent_item_colon'   => __( 'Parent Partner:', 'stop_ivory' ),
		'all_items'		   => __( 'All Who\'s Involved', 'stop_ivory' ),
		'view_item'		   => __( 'View Who\'s Involved', 'stop_ivory' ),
		'add_new_item'		=> __( 'Add New Who\'s Involved', 'stop_ivory' ),
		'add_new'			 => __( 'Add New', 'stop_ivory' ),
		'edit_item'		   => __( 'Edit Who\'s Involved', 'stop_ivory' ),
		'update_item'		 => __( 'Update Who\'s Involved', 'stop_ivory' ),
		'search_items'		=> __( 'Search Who\'s Involved', 'stop_ivory' ),
		'not_found'		   => __( 'Not found', 'stop_ivory' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'stop_ivory' ),
	);
	$args = array(
		'label'			   => __( 'whos_involved', 'stop_ivory' ),
		'description'		 => __( 'Governments, IGOs, NGOs, Private Sector', 'stop_ivory' ),
		'labels'			  => $labels,
		'supports'			=> array( 'title', 'editor', 'thumbnail' ),
		'taxonomies'		  => array( 'whos_involved_tx' ),
		'hierarchical'		=> false,
		'public'			  => true,
		'show_ui'			 => true,
		'show_in_menu'		=> true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'	   => 5,
		'menu_icon'		   => '',
		'can_export'		  => true,
		'has_archive'		 => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'	 => 'page',
	);
	register_post_type( 'whos_involved', $args );
}
add_action( 'init', 'whosinvolved', 0 );

function whos_involved_tx() {
	$labels = array(
		'name'					   => _x( 'Who\'s Involved categories', 'Taxonomy General Name', 'stop_ivory' ),
		'singular_name'			  => _x( 'Who\'s Involved category', 'Taxonomy Singular Name', 'stop_ivory' ),
		'menu_name'				  => __( 'Who\'s Involved category', 'stop_ivory' ),
		'all_items'				  => __( 'All Who\'s Involved categories', 'stop_ivory' ),
		'parent_item'				=> __( 'Parent Who\'s Involved category', 'stop_ivory' ),
		'parent_item_colon'		  => __( 'Parent Who\'s Involved category:', 'stop_ivory' ),
		'new_item_name'			  => __( 'New Who\'s Involved category', 'stop_ivory' ),
		'add_new_item'			   => __( 'Add New Who\'s Involved category', 'stop_ivory' ),
		'edit_item'				  => __( 'Edit Who\'s Involved category', 'stop_ivory' ),
		'update_item'				=> __( 'Update Who\'s Involved category', 'stop_ivory' ),
		'separate_items_with_commas' => __( 'Separate Who\'s Involved categories with commas', 'stop_ivory' ),
		'search_items'			   => __( 'Search Who\'s Involved categories', 'stop_ivory' ),
		'add_or_remove_items'		=> __( 'Add or remove Who\'s Involved categories', 'stop_ivory' ),
		'choose_from_most_used'	  => __( 'Choose from the most used Who\'s Involved categories', 'stop_ivory' ),
		'not_found'				  => __( 'Not Found', 'stop_ivory' ),
	);
	$args = array(
		'labels'					 => $labels,
		'hierarchical'			   => true,
		'public'					 => true,
		'show_ui'					=> true,
		'show_admin_column'		  => true,
		'show_in_nav_menus'		  => true,
		'show_tagcloud'			  => true,
	);
	register_taxonomy( 'whos_involved_tx', array( 'whos_involved' ), $args );
}
add_action( 'init', 'whos_involved_tx', 0 );

function epi_in_action() {
	$labels = array(
		'name'				=> _x( 'EPI In Action', 'Post Type General Name', 'stop_ivory' ),
		'singular_name'	   => _x( 'EPI In Action', 'Post Type Singular Name', 'stop_ivory' ),
		'menu_name'		   => __( 'EPI In Action', 'stop_ivory' ),
		'parent_item_colon'   => __( 'Parent EPI In Action:', 'stop_ivory' ),
		'all_items'		   => __( 'All EPI In Action', 'stop_ivory' ),
		'view_item'		   => __( 'View EPI In Action', 'stop_ivory' ),
		'add_new_item'		=> __( 'Add New EPI In Action', 'stop_ivory' ),
		'add_new'			 => __( 'Add New', 'stop_ivory' ),
		'edit_item'		   => __( 'Edit EPI In Action', 'stop_ivory' ),
		'update_item'		 => __( 'Update EPI In Action', 'stop_ivory' ),
		'search_items'		=> __( 'Search EPI In Action', 'stop_ivory' ),
		'not_found'		   => __( 'Not found', 'stop_ivory' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'stop_ivory' ),
	);
	$args = array(
		'label'			   => __( 'EPI In Action', 'stop_ivory' ),
		'description'		 => __( '', 'stop_ivory' ),
		'labels'			  => $labels,
		'supports'			=> array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'taxonomies'		  => array( 'epi_in_action_tx' ),
		'hierarchical'		=> false,
		'public'			  => true,
		'show_ui'			 => true,
		'show_in_menu'		=> true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'	   => 5,
		'menu_icon'		   => '',
		'can_export'		  => true,
		'has_archive'		 => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'	 => 'page',
	);
	register_post_type( 'epi_in_action', $args );
}
add_action( 'init', 'epi_in_action', 0 );

function epi_in_action_type() {
	$labels = array(
		'name'					   => _x( 'EPI In Action types', 'Taxonomy General Name', 'stop_ivory' ),
		'singular_name'			  => _x( 'EPI In Action type', 'Taxonomy Singular Name', 'stop_ivory' ),
		'menu_name'				  => __( 'EPI In Action type', 'stop_ivory' ),
		'all_items'				  => __( 'All EPI In Action types', 'stop_ivory' ),
		'parent_item'				=> __( 'Parent EPI In Action type', 'stop_ivory' ),
		'parent_item_colon'		  => __( 'Parent EPI In Action type:', 'stop_ivory' ),
		'new_item_name'			  => __( 'New EPI In Action type', 'stop_ivory' ),
		'add_new_item'			   => __( 'Add New EPI In Action typey', 'stop_ivory' ),
		'edit_item'				  => __( 'Edit EPI In Action type', 'stop_ivory' ),
		'update_item'				=> __( 'Update EPI In Action type', 'stop_ivory' ),
		'separate_items_with_commas' => __( 'Separate EPI In Action types with commas', 'stop_ivory' ),
		'search_items'			   => __( 'Search EPI In Action types', 'stop_ivory' ),
		'add_or_remove_items'		=> __( 'Add or remove EPI In Action types', 'stop_ivory' ),
		'choose_from_most_used'	  => __( 'Choose from the most used EPI In Action types', 'stop_ivory' ),
		'not_found'				  => __( 'Not Found', 'stop_ivory' ),
	);
	$args = array(
		'labels'					 => $labels,
		'hierarchical'			   => true,
		'public'					 => true,
		'show_ui'					=> true,
		'show_admin_column'		  => true,
		'show_in_nav_menus'		  => true,
		'show_tagcloud'			  => true,
	);
	register_taxonomy( 'epi_in_action_type', array( 'epi_in_action' ), $args );
}
add_action( 'init', 'epi_in_action_type', 0 );

function epi_in_action_tx() {
	$labels = array(
		'name'					   => _x( 'EPI In Action categories', 'Taxonomy General Name', 'stop_ivory' ),
		'singular_name'			  => _x( 'EPI In Action category', 'Taxonomy Singular Name', 'stop_ivory' ),
		'menu_name'				  => __( 'EPI In Action category', 'stop_ivory' ),
		'all_items'				  => __( 'All EPI In Action categories', 'stop_ivory' ),
		'parent_item'				=> __( 'Parent EPI In Action category', 'stop_ivory' ),
		'parent_item_colon'		  => __( 'Parent EPI In Action category:', 'stop_ivory' ),
		'new_item_name'			  => __( 'New EPI In Action category', 'stop_ivory' ),
		'add_new_item'			   => __( 'Add New EPI In Action category', 'stop_ivory' ),
		'edit_item'				  => __( 'Edit EPI In Action category', 'stop_ivory' ),
		'update_item'				=> __( 'Update EPI In Action category', 'stop_ivory' ),
		'separate_items_with_commas' => __( 'Separate EPI In Action categories with commas', 'stop_ivory' ),
		'search_items'			   => __( 'Search EPI In Action categories', 'stop_ivory' ),
		'add_or_remove_items'		=> __( 'Add or remove EPI In Action categories', 'stop_ivory' ),
		'choose_from_most_used'	  => __( 'Choose from the most used EPI In Action categories', 'stop_ivory' ),
		'not_found'				  => __( 'Not Found', 'stop_ivory' ),
	);
	$args = array(
		'labels'					 => $labels,
		'hierarchical'			   => true,
		'public'					 => true,
		'show_ui'					=> true,
		'show_admin_column'		  => true,
		'show_in_nav_menus'		  => true,
		'show_tagcloud'			  => true,
	);
	register_taxonomy( 'epi_in_action_tx', array( 'epi_in_action' ), $args );
}
add_action( 'init', 'epi_in_action_tx', 0 );

//function contacts() {
//	$labels = array(
//		'name'				=> _x( 'Contacts', 'Post Type General Name', 'stop_ivory' ),
//		'singular_name'	   => _x( 'Contact', 'Post Type Singular Name', 'stop_ivory' ),
//		'menu_name'		   => __( 'Contacts', 'stop_ivory' ),
//		'parent_item_colon'   => __( 'Parent Contact:', 'stop_ivory' ),
//		'all_items'		   => __( 'All Contacts', 'stop_ivory' ),
//		'view_item'		   => __( 'View Contact', 'stop_ivory' ),
//		'add_new_item'		=> __( 'Add New Contact', 'stop_ivory' ),
//		'add_new'			 => __( 'Add Contact', 'stop_ivory' ),
//		'edit_item'		   => __( 'Edit Contact', 'stop_ivory' ),
//		'update_item'		 => __( 'Update Contact', 'stop_ivory' ),
//		'search_items'		=> __( 'Search Contacts', 'stop_ivory' ),
//		'not_found'		   => __( 'Not found', 'stop_ivory' ),
//		'not_found_in_trash'  => __( 'Not found in Trash', 'stop_ivory' ),
//	);
//	$args = array(
//		'labels'			  => $labels,
//		'supports'			=> array( 'title', 'editor', 'thumbnail', 'post-formats', 'page-attributes' ),
//		'taxonomies'		  => array( 'post_tag' ),
//		'hierarchical'		=> false,
//		'public'			  => true,
//		'show_ui'			 => true,
//		'show_in_menu'		=> true,
//		'show_in_nav_menus'   => true,
//		'show_in_admin_bar'   => true,
//		'menu_position'	   => 5,
//		'menu_icon'		   => '',
//		'can_export'		  => true,
//		'has_archive'		 => true,
//		'exclude_from_search' => false,
//		'publicly_queryable'  => true,
//		'capability_type'	 => 'page',
//	);
//	register_post_type( 'contacts', $args );
//}
//add_action( 'init', 'contacts', 0 );

function lectureSpeaker() {
	p2p_register_connection_type( array(
		'name' => 'orgs2news',
		'from' => 'partner',
		'to' => 'epi_in_action'
	) );
}
add_action( 'p2p_init', 'lectureSpeaker' );

// extra meta boxes
function page_image( $meta_boxes ) {
	$prefix = '_cmb_';
	$meta_boxes[] = array(
		'id' => 'meta',
		'title' => 'Extra page/post information',
		'pages' => array('page', 'post', 'partner', 'news'),
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true,
		'fields' => array(
			array(
				'name' => 'Instructions',
				'desc' => 'Copying and pasting from Word adds double paragraph breaks - remember to delete them or the text will be harder to read on the site.<br />"PDF Download" files appear at the bottom of the post with a large arrow.<br />"Related Information" appears at the side of the page.<br />Images uploaded should ideally be a minimum size of 2050x1350 pixels in dimensions.<br />Partner images should be exactly 297x174 pixels in dimension and "desaturated" so that they appear in greyscale.',
				'type' => 'title',
				'id' => $prefix . 'test_title'
			),
//			array(
//				'name' => 'Landscape Background Image',
//				'desc' => 'Add desktop/tablet/mobile image (2560 x 1440)',
//				'type' => 'file',
//				'id' => $prefix . 'bg'
//			),
//			array(
//				'name' => 'Portrait Background Image',
//				'desc' => 'Add tablet/mobile portrait image (800 × 1024)',
//				'type' => 'file',
//				'id' => $prefix . 'bg_p'
//			),
			array(
				'name' => 'PDF Download',
				'desc' => 'Adds the large PDF Download link at the bottom of the page',
				'type' => 'file',
				'id' => $prefix . 'download'
			),
			array(
				'name' => 'Related Information',
				'desc' => 'Space for any PDfs, or supporting information',
				'type' => 'wysiwyg',
				'id' => $prefix . 'pdf'
			),
		),
	);
	return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'page_image' );

add_action( 'init', 'be_initialize_cmb_meta_boxes', 9999 );
function be_initialize_cmb_meta_boxes() {
	if ( !class_exists( 'cmb_Meta_Box' ) ) {
		require_once( 'metabox/init.php' );
	}
}

// get the slug
function the_slug($echo=true){
	$slug = basename(get_permalink());
	do_action('before_slug', $slug);
	$slug = apply_filters('slug_filter', $slug);
	if( $echo ) echo $slug;
	do_action('after_slug', $slug);
	return $slug;
}

// mobile/tablet detection
function mobile_detected($agents) {
	$userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
	foreach($agents as $agent) {
		if(strpos($userAgent,strtolower($agent)) !== false)
		return true;
	}
	return false;
}

// SEO
function basic_wp_seo() {
	global $page, $paged, $post;
	$default_keywords = 'Poaching, Ivory, Elephant, Crisis, Range States, African Elephant Action Plan, Inventory, CITES';
	$output = '';
	$seo_desc = get_post_meta($post->ID, 'mm_seo_desc', true);
	$description = get_bloginfo('description', 'display');
	$pagedata = get_post($post->ID);
	if (is_singular()) {
		if (!empty($seo_desc)) {
			$content = $seo_desc;
		} else if (!empty($pagedata)) {
			$content = apply_filters('the_excerpt_rss', $pagedata->post_content);
			$content = substr(trim(strip_tags($content)), 0, 155);
			$content = preg_replace('#\n#', ' ', $content);
			$content = preg_replace('#\s{2,}#', ' ', $content);
			$content = trim($content);
		} 
	} else {
		$content = $description;	
	}
	$output .= '<meta name="description" content="' . esc_attr($content) . '">' . "\n";

	$keys = get_post_meta($post->ID, 'mm_seo_keywords', true);
	$cats = get_the_category();
	$tags = get_the_tags();
	if (empty($keys)) {
		if (!empty($cats)) foreach($cats as $cat) $keys .= $cat->name . ', ';
		if (!empty($tags)) foreach($tags as $tag) $keys .= $tag->name . ', ';
		$keys .= $default_keywords;
	}
	$output .= "" . '<meta name="keywords" content="' . esc_attr($keys) . '">' . "\n";
	$output .= "" . '<meta name="copyright" content="© Stop Ivory, ' . date('Y') . '">' . "\n";

	if (is_category() || is_tag()) {
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		if ($paged > 1) {
			$output .=  "" . '<meta name="robots" content="noindex,follow">' . "\n";
		} else {
			$output .=  "" . '<meta name="robots" content="index,follow">' . "\n";
		}
	} else if (is_home() || is_singular()) {
		$output .=  "" . '<meta name="robots" content="index,follow">' . "\n";
	} else {
		$output .= "" . '<meta name="robots" content="noindex,follow">' . "\n";
	}

	$title_custom = get_post_meta($post->ID, 'mm_seo_title', true);
	$url = ltrim(esc_url($_SERVER['REQUEST_URI']), '/');
	$name = get_bloginfo('name', 'display');
	$title = trim(wp_title('', false));
	$cat = single_cat_title('', false);
	$tag = single_tag_title('', false);
	$search = get_search_query();

	if (!empty($title_custom)) $title = $title_custom;
	if ($paged >= 2 || $page >= 2) $page_number = ' | ' . sprintf('Page %s', max($paged, $page));
	else $page_number = '';

	if (is_home() || is_front_page()) $seo_title = $name . ' | ' . $description;
	elseif (is_singular())			$seo_title = $title . ' | ' . $name;
	elseif (is_tag())				 $seo_title = 'Tag Archive: ' . $tag . ' | ' . $name;
	elseif (is_category())			$seo_title = 'Category Archive: ' . $cat . ' | ' . $name;
	elseif (is_archive())			 $seo_title = 'Archive: ' . $title . ' | ' . $name;
	elseif (is_search())			  $seo_title = 'Search: ' . $search . ' | ' . $name;
	elseif (is_404())				 $seo_title = '404 - Not Found: ' . $url . ' | ' . $name;
	else							  $seo_title = $name . ' | ' . $description;

	return $output;
}

function remove_footer_admin () {
	echo '&copy; '. date('Y') . ' Stop Ivory. Site built by <a href="http://mccannlondon.co.uk">McCann London</a>.';
	echo '<style>#wp-admin-bar-updates,.update-plugins{display:none !important;}.category-adder {display: none !important;}</style>';
}
add_filter('admin_footer_text', 'remove_footer_admin');

function hide_wp_update_nag() {
	remove_action( 'admin_notices', 'update_nag', 3 ); //update notice at the top of the screen
	remove_filter( 'update_footer', 'core_update_footer' ); //update notice in the footer
}
add_action('admin_menu','hide_wp_update_nag');

add_filter( 'post_class', 'tax_post_class', 10, 3 );

if ( ! function_exists('tax_post_class') ) {
	function tax_post_class($classes, $class, $ID) {

		$taxonomies_args = array(
			'public' => true,
			'_builtin' => false,
		);

		$taxonomies = get_taxonomies( $taxonomies_args, 'names', 'and' );

		$terms = get_the_terms( (int) $ID, (array) $taxonomies );

		if ( ! empty( $terms ) ) {
			foreach ( (array) $terms as $order => $term ) {
				if ( ! in_array( $term->slug, $classes ) ) {
					$classes[] = $term->slug;
				}
			}
		}

		$classes[] = 'clearfix';

		return $classes;
	}
}
add_action( 'dashboard_glance_items', 'my_add_cpt_to_dashboard' );

function my_add_cpt_to_dashboard() {
	$showTaxonomies = 1;
	if ($showTaxonomies) {
		$taxonomies = get_taxonomies( array( '_builtin' => false ), 'objects' );
		foreach ( $taxonomies as $taxonomy ) {
			$num_terms  = wp_count_terms( $taxonomy->name );
			$num = number_format_i18n( $num_terms );
			$text = _n( $taxonomy->labels->singular_name, $taxonomy->labels->name, $num_terms );
			$associated_post_type = $taxonomy->object_type;
			if ( current_user_can( 'manage_categories' ) ) {
			  $output = '<a href="edit-tags.php?taxonomy=' . $taxonomy->name . '&post_type=' . $associated_post_type[0] . '">' . $num . ' ' . $text .'</a>';
			}
			echo '<li class="taxonomy-count">' . $output . ' </li>';
		}
	}
	// Custom post types counts
	$post_types = get_post_types( array( '_builtin' => false ), 'objects' );
	foreach ( $post_types as $post_type ) {
		if($post_type->show_in_menu==false) {
			continue;
		}
		$num_posts = wp_count_posts( $post_type->name );
		$num = number_format_i18n( $num_posts->publish );
		$text = _n( $post_type->labels->singular_name, $post_type->labels->name, $num_posts->publish );
		if ( current_user_can( 'edit_posts' ) ) {
			$output = '<a href="edit.php?post_type=' . $post_type->name . '">' . $num . ' ' . $text . '</a>';
		}
		echo '<li class="page-count ' . $post_type->name . '-count">' . $output . '</td>';
	}
}

add_action( 'admin_init', 'super_sticky_add_meta_box' );
add_action( 'admin_init', 'super_sticky_admin_init', 20 );
add_action( 'pre_get_posts', 'super_sticky_posts_filter' );

function super_sticky_description() {
	echo '<p>' . __( 'Enable support for sticky custom post types.' ) . '</p>';
}

function super_sticky_set_post_types() {
	$post_types = get_post_types( array( '_builtin' => false, 'public' => true ), 'names' );
	if ( ! empty( $post_types ) ) {
		$checked_post_types = super_sticky_post_types();
		foreach ( $post_types as $post_type ) { ?>
			<div><input type="checkbox" id="<?php echo esc_attr( 'post_type_' . $post_type ); ?>" name="sticky_custom_post_types[]" value="<?php echo esc_attr( $post_type ); ?>" <?php checked( in_array( $post_type, $checked_post_types ) ); ?> /> <label for="<?php echo esc_attr( 'post_type_' . $post_type ); ?>"><?php echo esc_html( $post_type ); ?></label></div><?php
		}
	} else {
		echo '<p>' . __( 'No public custom post types found.' ) . '</p>';
	}
}

function super_sticky_filter( $query_type ) {
	$filters = (array) get_option( 'sticky_custom_post_types_filters', array() );

	return in_array( $query_type, $filters );
}

function super_sticky_set_filters() { ?>
	<span><input type="checkbox" id="sticky_custom_post_types_filters_home" name="sticky_custom_post_types_filters[]" value="home" <?php checked( super_sticky_filter( 'home' ) ); ?> /> <label for="sticky_custom_post_types_filters_home">home</label></span><?php
}

function super_sticky_admin_init() {
	register_setting( 'reading', 'sticky_custom_post_types' );
	register_setting( 'reading', 'sticky_custom_post_types_filters' );
	add_settings_section( 'super_sticky_options', __( 'Sticky Custom Post Types' ), 'super_sticky_description', 'reading' );
	add_settings_field( 'sticky_custom_post_types', __( 'Show "Stick this..." checkbox on' ), 'super_sticky_set_post_types', 'reading', 'super_sticky_options' );
	add_settings_field( 'sticky_custom_post_types_filters', __( 'Display selected post type(s) on' ), 'super_sticky_set_filters', 'reading', 'super_sticky_options' );
}

function super_sticky_post_types() {
	return (array) get_option( 'sticky_custom_post_types', array() );
}

function super_sticky_meta() { ?>
	<input id="super-sticky" name="sticky" type="checkbox" value="sticky" <?php checked( is_sticky() ); ?> /> <label for="super-sticky" class="selectit"><?php _e( 'Add this to the home page carousel' ) ?></label><?php
}

function super_sticky_add_meta_box() {
	if( ! current_user_can( 'edit_others_posts' ) )
		return;

	foreach( super_sticky_post_types() as $post_type )
		add_meta_box( 'super_sticky_meta', __( 'Carousel' ), 'super_sticky_meta', $post_type, 'side', 'high' );
}

function super_sticky_posts_filter( $query ) {
	if ( $query->is_main_query() && $query->is_home() && ! $query->get( 'suppress_filters' ) && super_sticky_filter( 'home' ) ) {

		$super_sticky_post_types = super_sticky_post_types();

		if ( ! empty( $super_sticky_post_types ) ) {
			$post_types = array();

			$query_post_type = $query->get( 'post_type' );

			if ( empty( $query_post_type ) ) {
				$post_types[] = 'post';
			} elseif ( is_string( $query_post_type ) ) {
				$post_types[] = $query_post_type;
			} elseif ( is_array( $query_post_type ) ) {
				$post_types = $query_post_type;
			} else {
				return; // Unexpected value
			}

			$post_types = array_merge( $post_types, $super_sticky_post_types );

			$query->set( 'post_type', $post_types );
		}
	}
}

function my_custom_login_logo() {
	echo '<style  type="text/css"> body.login { background: #e5e5e5 url(' . get_bloginfo('template_directory') . '/img/bg.png) center center; } .login h1 {background: rgba(0,0,0,0.7); padding: 25px 0 0 0;} .login h1 a {  background-image:url(' . get_bloginfo('template_directory') . '/img/admin-logo.png)  !important; background-size: 110px 50px !important; width: 110px !important; margin: 0 auto;} .login #nav a , .login #backtoblog a { color: #111; text-decoration: none; } .login #nav a:hover, .login #backtoblog a:hover { color: #83263D; text-decoration: none; } #login_error { display: none; } .login form { margin-top: 0; background: rgba(0,0,0,0.7) } .login label { color: #efefef; } .wp-core-ui .button-primary { background: #83263D; border-color: #5F1C2C; box-shadow: 0 1px 0 rgba(174,50,81, 0.5) inset, 0 1px 0 rgba(0, 0, 0, 0.15); color: #fff; text-decoration: none; } .wp-core-ui .button-primary:hover { background: #6F2034; border-color: #4F1725; box-shadow: 0 1px 0 rgba(174,50,81, 0.5) inset, 0 1px 0 rgba(0, 0, 0, 0.15); color: #fff; text-decoration: none; }</style>';
}
add_action('login_head',  'my_custom_login_logo');

function additional_admin_color_schemes() {  
	$theme_dir = get_template_directory_uri();  
	wp_admin_css_color( 'stopivory', __( 'Stop Ivory' ),  
		$theme_dir . '/css/si_admin.css',  
		array( '#222222', '#000000', '#d81420', '#efefef' )  
	);  
}  
add_action('admin_init', 'additional_admin_color_schemes');

class epi_tax_walker extends Walker_Category {
	function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
		extract($args);
		$cat_name = esc_attr( $category->name );
		$cat_name = apply_filters( 'list_cats', $cat_name, $category );
		$my_blog_link = site_url('/');

		$link = '<button class="filterer" data-desc="'.$category->description.'" data-filter=".'.$category->slug.'" href="#'.$category->slug.'" ';
		if ( $use_desc_for_title == 0 || empty($category->description) )
			$link .= 'title="' . esc_attr( sprintf(__( 'Show only %s' ), $cat_name) ) . '"';
		else
			$link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';
		$link .= '>';
		$link .= $cat_name . '</button>';
		if ( !empty($feed_image) || !empty($feed) ) {
			$link .= ' ';
			if ( empty($feed_image) )
				$link .= '(';
			$link .= '<a href="' . esc_url( get_term_feed_link( $category->term_id, $category->taxonomy, $feed_type ) ) . '"';
			if ( empty($feed) ) {
				$alt = ' alt="' . sprintf(__( 'Feed for all posts filed under %s' ), $cat_name ) . '"';
			} else {
				$title = ' title="' . $feed . '"';
				$alt = ' alt="' . $feed . '"';
				$name = $feed;
				$link .= $title;
			}
			$link .= '>';
			if ( empty($feed_image) )
				$link .= $name;
			else
				$link .= "<img src='$feed_image'$alt$title" . ' />';
			$link .= '</button>';
			if ( empty($feed_image) )
				$link .= ')';
		}
		if ( !empty($show_count) )
			$link .= ' (' . intval($category->count) . ')';
		if ( 'list' == $args['style'] ) {
			$output .= "\t<li";
			$class = 'cat-item cat-item-' . $category->term_id;
			if ( !empty($current_category) ) {
				$_current_category = get_term( $current_category, $category->taxonomy );
				if ( $category->term_id == $current_category )
					$class .=  ' current-cat';
				elseif ( $category->term_id == $_current_category->parent )
					$class .=  ' current-cat-parent';
			}
			$output .=  ' class="' . $class . '"';
			$output .= ">$link\n";
		} else {
			$output .= "\t$link<br />\n";
		}
	}
}

add_filter('nav_menu_css_class', 'current_type_nav_class', 10, 2);
function current_type_nav_class($classes, $item) {
	// Get post_type for this post
	$post_type = get_query_var('post_type');
	// Go to Menus and add a menu class named: {custom-post-type}-menu-item
	// This adds a 'current_page_parent' class to the parent menu item
	if( in_array( $post_type.'-menu-item', $classes ) )
		array_push($classes, 'current_page_parent');
	return $classes;
}

add_action('admin_head-nav-menus.php', 'wpclean_add_metabox_menu_posttype_archive');
 
function wpclean_add_metabox_menu_posttype_archive() {
	add_meta_box('wpclean-metabox-nav-menu-posttype', 'Custom Post Type Archives', 'wpclean_metabox_menu_posttype_archive', 'nav-menus', 'side', 'default');
}
 
function wpclean_metabox_menu_posttype_archive() {
	$post_types = get_post_types(array('show_in_nav_menus' => true, 'has_archive' => true), 'object');
	if ($post_types) :
		$items = array();
		$loop_index = 999999;
		foreach ($post_types as $post_type) {
			$item = new stdClass();
			$loop_index++;
			$item->object_id = $loop_index;
			$item->db_id = 0;
			$item->object = 'post_type_' . $post_type->query_var;
			$item->menu_item_parent = 0;
			$item->type = 'custom';
			$item->title = $post_type->labels->name;
			$item->url = get_post_type_archive_link($post_type->query_var);
			$item->target = '';
			$item->attr_title = '';
			$item->classes = array();
			$item->xfn = '';
			$items[] = $item;
		}
		$walker = new Walker_Nav_Menu_Checklist(array());
		echo '<div id="posttype-archive" class="posttypediv">';
		echo '<div id="tabs-panel-posttype-archive" class="tabs-panel tabs-panel-active">';
		echo '<ul id="posttype-archive-checklist" class="categorychecklist form-no-clear">';
		echo walk_nav_menu_tree(array_map('wp_setup_nav_menu_item', $items), 0, (object) array('walker' => $walker));
		echo '</ul>';
		echo '</div>';
		echo '</div>';
		echo '<p class="button-controls">';
		echo '<span class="add-to-menu">';
		echo '<input type="submit"' . disabled(1, 0) . ' class="button-secondary submit-add-to-menu right" value="' . __('Add to Menu', 'stop_ivory') . '" name="add-posttype-archive-menu-item" id="submit-posttype-archive" />';
		echo '<span class="spinner"></span>';
		echo '</span>';
		echo '</p>';
	endif;
}

function revcon_change_post_label() {
    global $menu;
    global $submenu;
    $menu[10][0] = 'Uploads';
    echo '';
}
function revcon_change_post_object() {
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'News';
    $labels->singular_name = 'News';
    $labels->add_new = 'Add News';
    $labels->add_new_item = 'Add News';
    $labels->edit_item = 'Edit News';
    $labels->new_item = 'News';
    $labels->view_item = 'View News';
    $labels->search_items = 'Search News';
    $labels->not_found = 'No News found';
    $labels->not_found_in_trash = 'No News found in Trash';
    $labels->all_items = 'All News';
    $labels->menu_name = 'News';
    $labels->name_admin_bar = 'News';
}
 
add_action( 'admin_menu', 'revcon_change_post_label' );
add_action( 'init', 'revcon_change_post_object' );

function add_menu_icons_styles(){
 
echo '<style>
#adminmenu .menu-icon-partner div.wp-menu-image:before {
	content: "\f307";
}
#adminmenu .menu-icon-whos_involved div.wp-menu-image:before {
	content: "\f307";
}
#adminmenu .menu-icon-epi_in_action div.wp-menu-image:before {
	content: "\f325";
}
#adminmenu .menu-icon-contacts div.wp-menu-image:before {
	content: "\f336";
}
#dashboard_right_now .partner-count a:before {
    content: "\f307";
}
#dashboard_right_now .whos_involved-count a:before {
    content: "\f307";
}
#dashboard_right_now .epi_in_action-count a:before {
    content: "\f325";
}
#dashboard_right_now .taxonomy-count a:before {
    content: "\f323";
}
#wp-admin-bar-comments {
	display: none;
}
</style>';

}
add_action( 'admin_head', 'add_menu_icons_styles' );

add_action( 'admin_menu', 'catMCE_menu' ); function CatMCE_menu() { add_options_page( 'CatMCE settings', 'CategoryTinyMCE', 'manage_options', 'catMCE', 'catMCE_options' ); } add_action ('admin_init', 'catMCE_register'); function catMCE_register(){ register_setting('catMCE_options', 'catMCE_seo'); } function catMCE_options() { if ( !current_user_can( 'manage_options' ) ) { wp_die( __( 'You do not have sufficient permissions to access this page.' ) ); } ?>
	<div class="wrap">
	<h2>CategoryTinyMCE SEO Settings</h2>
	<div id="donate_container">
     The latest fully maintained version compatible with WP3.9 is available from http://wp.ypraise.com/
    </div>

	<p><form method="post" action="options.php">	</p>
	<p>SEO Settings for CategoryTinyMCE:</p>

	<?php
 settings_fields( 'catMCE_options' ); ?>
<p>Choose SEO:

<input type="checkbox" name="catMCE_seo" value="1" <?php checked( '1', get_option( 'catMCE_seo' ) ); ?> />
							</p>

 <?php
 submit_button(); echo '</form>'; echo '</div>'; } remove_filter( 'pre_term_description', 'wp_filter_kses' ); remove_filter( 'term_description', 'wp_kses_data' ); add_action( 'admin_print_styles', 'categorytinymce_admin_head' ); function categorytinymce_admin_head() { ?>
<style type="text/css">
  .quicktags-toolbar input{float:left !important; width:auto !important;}
  </style>
<?php } define('description1', 'Category_Description_option'); add_filter('edit_category_form_fields', 'description1'); function description1($tag) { $tag_extra_fields = get_option(description1); ?>

<table class="form-table">
        <tr class="form-field">
            <th scope="row" valign="top"><label for="description"><?php _ex('Description', 'Taxonomy Description'); ?></label></th>
			<td>
	<?php
 $settings = array('wpautop' => true, 'media_buttons' => true, 'quicktags' => true, 'textarea_rows' => '15', 'textarea_name' => 'description' ); wp_editor(html_entity_decode($tag->description , ENT_QUOTES, 'UTF-8'), 'description1', $settings); ?>
	<br />
	<span class="description"><?php _e('The description is not prominent by default, however some themes may show it.'); ?></span>
	</td>
        </tr>

</table>
    <?php
 } add_action ( 'edit_category_form_fields', 'extra_category_fields'); function extra_category_fields( $tag ) { $t_id = $tag->term_id; $cat_meta = get_option( "category_$t_id"); ?>
<?php
} add_action ( 'edited_category', 'save_extra_category_fileds'); function save_extra_category_fileds( $term_id ) { if ( isset( $_POST['Cat_meta'] ) ) { $t_id = $term_id; $cat_meta = get_option( "category_$t_id"); $cat_keys = array_keys($_POST['Cat_meta']); foreach ($cat_keys as $key){ if (isset($_POST['Cat_meta'][$key])){ $cat_meta[$key] =stripslashes_deep($_POST['Cat_meta'][$key]); } } update_option( "category_$t_id", $cat_meta ); } } define('description2', 'Tag_Description_option'); add_filter('edit_tag_form_fields', 'description2'); function description2($tag) { $tag_extra_fields = get_option(description1); ?>

<table class="form-table">
        <tr class="form-field">
            <th scope="row" valign="top"><label for="description"><?php _ex('Description', 'Taxonomy Description'); ?></label></th>
			<td>
	<?php
 $settings = array('wpautop' => true, 'media_buttons' => true, 'quicktags' => true, 'textarea_rows' => '15', 'textarea_name' => 'description' ); wp_editor(html_entity_decode($tag->description , ENT_QUOTES, 'UTF-8'), 'description2', $settings ); ?>
	<br />
	<span class="description"><?php _e('The description is not prominent by default, however some themes may show it.'); ?></span>
	</td>
        </tr>

</table>


   <?php
 } add_action ( 'edit_tag_form_fields', 'extra_tag_fields'); function extra_tag_fields( $tag ) { $t_id = $tag->term_id; $tag_meta = get_option( "tag_$t_id"); ?>
<?php
} add_action ( 'edited_terms', 'save_extra_tag_fileds'); function save_extra_tag_fileds( $term_id ) { if ( isset( $_POST['tag_meta'] ) ) { $t_id = $term_id; $tag_meta = get_option( "tag_$t_id"); $tag_keys = array_keys($_POST['tag_meta']); foreach ($tag_keys as $key){ if (isset($_POST['tag_meta'][$key])){ $tag_meta[$key] =stripslashes_deep($_POST['tag_meta'][$key]); } } update_option( "tag_$t_id", $tag_meta ); } } $catseo = get_option('catMCE_seo'); if ($catseo == "1") { function add_tagseo_meta() { if ( is_category() ) { $cat_id = get_query_var('cat'); $queried_object = get_queried_object(); $term_id = $queried_object->term_id; $cat_data = get_option("category_$term_id"); if (isset($cat_data['seo_met_description'])){ ?>
          <meta name="description" content="<?php echo $cat_data['seo_met_description']; ?>">

<?php
 } if (isset($cat_data['seo_met_keywords'])){ ?>
          <meta name="keywords" content="<?php echo $cat_data['seo_met_keywords']; ?>">

<?php
 } } elseif ( is_tag() ) { $tag_id = get_query_var('tag'); $queried_object = get_queried_object(); $term_id = $queried_object->term_id; $tag_data = get_option("tag_$term_id"); if (isset($tag_data['seo_met_description'])){ ?>
          <meta name="description" content="<?php echo $tag_data['seo_met_description'] ?>">

<?php
 } if (isset($tag_data['seo_met_keywords'])){ ?>
          <meta name="keywords" content="<?php echo $tag_data['seo_met_keywords']; ?>">

<?php
 } } } add_action('wp_head', 'add_tagseo_meta'); function add_tag_title() { if (is_category()){ $cat_id = get_query_var('cat'); $cat_data = get_option("category_$cat_id"); if (isset($cat_data['seo_met_title'])){ $title = $cat_data['seo_met_title']; return $title; } else{ $current_category = single_cat_title("", false); $title = $current_category .' | ' . get_bloginfo( "name", "display" ); return $title; } } elseif (is_tag()){ $tag_id = get_query_var('tag'); $queried_object = get_queried_object(); $term_id = $queried_object->term_id; $tag_data = get_option("tag_$term_id"); if (isset($tag_data['seo_met_title'])){ $title = $tag_data['seo_met_title']; return $title; } else{ $current_tag = single_tag_title("", false); $title = $current_tag .' | ' . get_bloginfo( "name", "display" ); return $title; } } elseif (is_home() || is_front_page() ) { $title = get_bloginfo( "name", "display" ) .' | ' . get_bloginfo( "description", "display" ); return $title; } else { $title = get_the_title() . ' | ' . get_bloginfo( "name", "display" ); return $title; } } add_filter( 'wp_title', 'add_tag_title', 1000 ); } function hide_category_description() { global $current_screen; if ( $current_screen->id == 'edit-category' ) { ?>
<script type="text/javascript">
jQuery(function($) {
 $('select#description').closest('tr.form-field').hide(); $('textarea#description, textarea#tag-description').closest('tr.form-field').hide();
 });
 </script> <?php
 } } function hide_tag_description() { global $current_screen; if ( $current_screen->id == 'edit-'.$current_screen->taxonomy ) { ?>
<script type="text/javascript">
jQuery(function($) {
 $('select#description').closest('tr.form-field').hide(); $('textarea#description, textarea#tag-description').closest('tr.form-field').hide();
 });
 </script> <?php
 } } add_action('admin_head', 'hide_category_description'); add_action('admin_head', 'hide_tag_description'); function manage_my_category_columns($columns) { if ( !isset($_GET['taxonomy']) || $_GET['taxonomy'] != 'category' ) return $columns; if ( $posts = $columns['description'] ){ unset($columns['description']); } return $columns; } add_filter('manage_edit-category_columns','manage_my_category_columns'); function manage_my_tag_columns($columns) { if ( !isset($_GET['taxonomy']) || $_GET['taxonomy'] != 'post_tag' ) return $columns; if ( $posts = $columns['description'] ){ unset($columns['description']); } return $columns; } add_filter('manage_edit-post_tag_columns','manage_my_tag_columns'); add_filter('term_description', 'do_shortcode'); add_filter('deleted_term_taxonomy', 'remove_Category_Extras'); function remove_Category_Extras($term_id) { if($_POST['taxonomy'] == 'category'): $tag_extra_fields = get_option(Category_Extras); unset($tag_extra_fields[$term_id]); update_option(Category_Extras, $tag_extra_fields); endif; }