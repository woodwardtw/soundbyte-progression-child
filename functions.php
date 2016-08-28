<?php
//* Code goes here
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );

function enqueue_parent_styles() {
   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}

function custom_post_type_personal() {

// Set UI labels for Custom Post Type
	$labels = array(
		'name'                => _x( 'Personal', 'Post Type General Name', 'anth' ),
		'singular_name'       => _x( 'Personal', 'Post Type Singular Name', 'anth' ),
		'menu_name'           => __( 'Personals', 'anth' ),
		'all_items'           => __( 'All Personals', 'blackout' ),
		'view_item'           => __( 'View Personal', 'blackout' ),
		'add_new_item'        => __( 'Add New Personal', 'blackout' ),
		'add_new'             => __( 'Add New', 'blackout' ),
		'edit_item'           => __( 'Edit Personal', 'blackout' ),
		'update_item'         => __( 'Update Personal', 'blackout' ),
		'search_items'        => __( 'Search Personal', 'blackout' ),
		'not_found'           => __( 'Personal Not Found', 'blackout' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'blackout' ),
	);
	
// Set other options for Custom Post Type
	
	$args = array(
		'label'               => __( 'Personals', 'blackout' ),
		'description'         => __( 'Personal info', 'blackout' ),
		'labels'              => $labels,
		// Features this CPT supports in Post Editor
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes', ),
		// You can associate this CPT with a taxonomy or custom taxonomy. 
		'taxonomies'          => array( 'scene' ),
		/* A hierarchical CPT is like Pages and can have
		* Parent and child items. A non-hierarchical CPT
		* is like Posts.
		*/	
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
		'show_in_rest'       => true,
  		'rest_base'          => 'personal-api',
  		'rest_controller_class' => 'WP_REST_Posts_Controller',
	);
// Registering your Custom Post Type
	register_post_type( 'Personals', $args );

}	
add_action( 'init', 'custom_post_type_personal', 0 );

function custom_post_type_team() {

// Set UI labels for Custom Post Type
	$labels = array(
		'name'                => _x( 'Team', 'Post Type General Name', 'anth' ),
		'singular_name'       => _x( 'Team', 'Post Type Singular Name', 'anth' ),
		'menu_name'           => __( 'Teams', 'anth' ),
		'all_items'           => __( 'All Teams', 'blackout' ),
		'view_item'           => __( 'View Team', 'blackout' ),
		'add_new_item'        => __( 'Add New Team', 'blackout' ),
		'add_new'             => __( 'Add New', 'blackout' ),
		'edit_item'           => __( 'Edit Team', 'blackout' ),
		'update_item'         => __( 'Update Team', 'blackout' ),
		'search_items'        => __( 'Search Team', 'blackout' ),
		'not_found'           => __( 'Team Not Found', 'blackout' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'blackout' ),
	);
	
// Set other options for Custom Post Type
	
	$args = array(
		'label'               => __( 'Teams', 'blackout' ),
		'description'         => __( 'Team info', 'blackout' ),
		'labels'              => $labels,
		// Features this CPT supports in Post Editor
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes', ),
		// You can associate this CPT with a taxonomy or custom taxonomy. 
		'taxonomies'          => array( 'scene' ),
		/* A hierarchical CPT is like Pages and can have
		* Parent and child items. A non-hierarchical CPT
		* is like Posts.
		*/	
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
		'show_in_rest'       => true,
  		'rest_base'          => 'personal-api',
  		'rest_controller_class' => 'WP_REST_Posts_Controller',
	);
// Registering your Custom Post Type
	register_post_type( 'Teams', $args );

}	
add_action( 'init', 'custom_post_type_team', 0 );

/**
 * Extend WordPress search to include custom fields
 *
 * http://adambalee.com
 */

/**
 * Join posts and postmeta tables
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_join
 */
function cf_search_join( $join ) {
    global $wpdb;

    if ( is_search() ) {    
        $join .=' LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
    }
    
    return $join;
}
add_filter('posts_join', 'cf_search_join' );

/**
 * Modify the search query with posts_where
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_where
 */
function cf_search_where( $where ) {
    global $pagenow, $wpdb;
   
    if ( is_search() ) {
        $where = preg_replace(
            "/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
            "(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1)", $where );
    }

    return $where;
}
add_filter( 'posts_where', 'cf_search_where' );

/**
 * Prevent duplicates
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_distinct
 */
function cf_search_distinct( $where ) {
    global $wpdb;

    if ( is_search() ) {
        return "DISTINCT";
    }

    return $where;
}
add_filter( 'posts_distinct', 'cf_search_distinct' );

function team_excerpt_length( $length ) {
    return 150;
}
add_filter( 'excerpt_length', 'team_excerpt_length', 999 );