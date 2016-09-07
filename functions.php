<?php
//* Code goes here
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );

function enqueue_parent_styles() {
   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}

function custom_post_type_personal() {

// Set UI labels for Custom Post Type
	$labels = array(
		'name'                => _x( 'Your Portfolio', 'Post Type General Name', 'anth' ),
		'singular_name'       => _x( 'Your Portfolio', 'Post Type Singular Name', 'anth' ),
		'menu_name'           => __( 'Your Portfolio', 'anth' ),
		'all_items'           => __( 'All Portfolios', 'blackout' ),
		'view_item'           => __( 'View Portfolio', 'blackout' ),
		'add_new_item'        => __( 'Add New Portfolio', 'blackout' ),
		'add_new'             => __( 'Add New', 'blackout' ),
		'edit_item'           => __( 'Edit Portfolio', 'blackout' ),
		'update_item'         => __( 'Update Portfolio', 'blackout' ),
		'search_items'        => __( 'Search Portfolio', 'blackout' ),
		'not_found'           => __( 'Portfolio Not Found', 'blackout' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'blackout' ),
	);
	
// Set other options for Custom Post Type
	
	$args = array(
		'label'               => __( 'Portfolio', 'blackout' ),
		'description'         => __( 'Portfolio info', 'blackout' ),
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
		'capability_type'     => 'post',
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

/**  set custom field stu_id if empty **/

function setField(){

}


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

//EXCERPT STUFF

function team_excerpt_length( $length ) {
    return 150;
}
add_filter( 'excerpt_length', 'team_excerpt_length', 999 );

function wpdocs_excerpt_more( $more ) {
    return ' . . .<br> <a class="button" href="'.get_the_permalink().'" rel="nofollow">Read More</a>';
}
add_filter( 'excerpt_more', 'wpdocs_excerpt_more' );

/**

HIDE Posts from ppl who aren't the author or greater
**/

function posts_for_current_author($query) {
	global $pagenow;

	if( 'edit.php' != $pagenow || !$query->is_admin )
	    return $query;

	if( !current_user_can( 'manage_options' ) ) {
		global $user_ID;
		$query->set('author', $user_ID );
	}
	return $query;
}
add_filter('pre_get_posts', 'posts_for_current_author');

/** HIDE MORE ADMIN STUFF from AUTHORS **/

/* Clean up the admin sidebar navigation *************************************************/
function remove_admin_menu_items() {
if( current_user_can( 'manage_options' ) ) { }
	else {	
  $remove_menu_items = array(__('Media'),__('Tools'),__('Episodes'),__('Contact'), __('Comments'));
  global $menu;
  end ($menu);
  while (prev($menu)){
    $item = explode(' ',$menu[key($menu)][0]);
    if(in_array($item[0] != NULL?$item[0]:"" , $remove_menu_items)){
      unset($menu[key($menu)]);
    }
  }
}
}
add_action('admin_menu', 'remove_admin_menu_items');

function remove_menus(){
if( current_user_can( 'manage_options' ) ) { }
	else {		
  
  remove_menu_page( 'index.php' );                  //Dashboard
  remove_menu_page( 'jetpack' );                    //Jetpack* 
  remove_menu_page( 'options-general.php' );        //Settings
  remove_menu_page( 'vc-welcome' );        //Settings
  remove_menu_page( 'profile' );        //profile
  //remove_menu_page('profile.php');

}
}
add_action( 'admin_menu', 'remove_menus', 999 );


//redirects from dashboard to edit post list 
function remove_the_dashboard () {
if (current_user_can('level_10')) {
	return;
	}else {
	global $menu, $submenu, $user_ID;
	$the_user = new WP_User($user_ID);
	reset($menu); $page = key($menu);
	while ((__('Dashboard') != $menu[$page][0]) && next($menu))
	$page = key($menu);
	if (__('Dashboard') == $menu[$page][0]) unset($menu[$page]);
	reset($menu); $page = key($menu);
	while (!$the_user->has_cap($menu[$page][1]) && next($menu))
	$page = key($menu);
	if (preg_match('#wp-admin/?(index.php)?$#',$_SERVER['REQUEST_URI']) && ('index.php' != $menu[$page][2]))
	wp_redirect(get_option('siteurl') . '/wp-admin/edit.php');}
}
add_action('admin_menu', 'remove_the_dashboard');

//adds author email to user_id meta field on save

function add_user_id_metafield( $post_id ) {
        $metaEmail = get_post_meta( get_the_ID(), 'stu_id', true );
        // Check if the custom field has a value.
        if (isset($post->post_status) && 'auto-draft' == $post->post_status) {
    return;
  }
        if ( ! empty( $metaEmail) ) {
        } else {
        	global $current_user;
			wp_get_current_user(); 
            $user_email = $current_user->user_email;           
            update_post_meta(get_the_ID($post_id),'stu_id', $user_email);
    
         }
}
add_action( 'save_post', 'add_user_id_metafield' );