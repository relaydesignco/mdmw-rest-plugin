<?php
/*
Plugin Name: Midwest Design Week Rest
Description: Setup for Midwest Design Week Rest API
Author: David Soards
Version: 0.1.0
Text Domain: 	mwdw-rest
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
GitHub Plugin URI: relaydesignco/mdmw-rest-plugin
*/

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly


// create events post type
add_action('init', 'create_post_type_events');
function create_post_type_events()
{
    $labels = array(
    'name'               => _x('Events', 'post type general name', 'mwdw-rest'),
    'singular_name'      => _x('Event', 'post type singular name', 'mwdw-rest'),
    'menu_name'          => _x('Events', 'admin menu', 'mwdw-rest'),
    'name_admin_bar'     => _x('Event', 'add new on admin bar', 'mwdw-rest'),
    'add_new'            => _x('Add New', 'Event', 'mwdw-rest'),
    'add_new_item'       => __('Add New Event', 'mwdw-rest'),
    'new_item'           => __('New Event', 'mwdw-rest'),
    'edit_item'          => __('Edit Event', 'mwdw-rest'),
    'view_item'          => __('View Event', 'mwdw-rest'),
    'all_items'          => __('All Events', 'mwdw-rest'),
    'search_items'       => __('Search Events', 'mwdw-rest'),
    'parent_item_colon'  => __('Parent Events:', 'mwdw-rest'),
    'not_found'          => __('No Events found.', 'mwdw-rest'),
    'not_found_in_trash' => __('No Events found in Trash.', 'mwdw-rest')
  );

    $args = array(
    'labels'             => $labels,
    'description'        => __('Description.', 'mwdw-rest'),
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'rewrite'            => array('slug' => 'event'),
    'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => 5,
    'show_in_rest'       => true,
    'rest_base'          => 'events',
    'rest_controller_class' => 'WP_REST_Posts_Controller',
    'supports'           => array('title', 'editor', 'custom-fields'),
  );

    register_post_type('events', $args);
}


// create sponsors post type
add_action('init', 'create_post_type_sponsors');
function create_post_type_sponsors()
{
    $labels = array(
    'name'               => _x('Sponsors', 'post type general name', 'mwdw-rest'),
    'singular_name'      => _x('Sponsor', 'post type singular name', 'mwdw-rest'),
    'menu_name'          => _x('Sponsors', 'admin menu', 'mwdw-rest'),
    'name_admin_bar'     => _x('Sponsor', 'add new on admin bar', 'mwdw-rest'),
    'add_new'            => _x('Add New', 'Sponsor', 'mwdw-rest'),
    'add_new_item'       => __('Add New Sponsor', 'mwdw-rest'),
    'new_item'           => __('New Sponsor', 'mwdw-rest'),
    'edit_item'          => __('Edit Sponsor', 'mwdw-rest'),
    'view_item'          => __('View Sponsor', 'mwdw-rest'),
    'all_items'          => __('All Sponsors', 'mwdw-rest'),
    'search_items'       => __('Search Sponsors', 'mwdw-rest'),
    'parent_item_colon'  => __('Parent Sponsors:', 'mwdw-rest'),
    'not_found'          => __('No Sponsors found.', 'mwdw-rest'),
    'not_found_in_trash' => __('No Sponsors found in Trash.', 'mwdw-rest')
  );

    $args = array(
    'labels'             => $labels,
    'description'        => __('Description.', 'mwdw-rest'),
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'rewrite'            => array('slug' => 'sponsor'),
    'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => 5,
    'show_in_rest'       => true,
    'rest_base'          => 'sponsors',
    'rest_controller_class' => 'WP_REST_Posts_Controller',
    'supports'           => array('title', 'custom-fields'),
    // 'taxonomies' => array('category') // for default categories
  );

    register_post_type('sponsors', $args);
}


// Register custom taxonomy for Sponsors post type
add_action('init', 'create_sponsors_taxonomy', 30);
function create_sponsors_taxonomy()
{
    $labels = array(
    'name'              => _x('Levels', 'taxonomy general name'),
    'singular_name'     => _x('Level', 'taxonomy singular name'),
    'search_items'      => __('Search Levels'),
    'all_items'         => __('All Levels'),
    'parent_item'       => __('Parent Level'),
    'parent_item_colon' => __('Parent Level:'),
    'edit_item'         => __('Edit Level'),
    'update_item'       => __('Update Level'),
    'add_new_item'      => __('Add New Level'),
    'new_item_name'     => __('New Level Name'),
    'menu_name'         => __('Level'),
  );

    $args = array(
    'hierarchical'          => true,
    'labels'                => $labels,
    'show_ui'               => true,
    'show_admin_column'     => true,
    'query_var'             => true,
    'rewrite'               => array('slug' => 'level'),
    'show_in_rest'          => true,
    'rest_base'             => 'levels',
    'rest_controller_class' => 'WP_REST_Terms_Controller',
  );

    register_taxonomy('levels', array('sponsors'), $args);
}


// create speakers post type
add_action('init', 'create_post_type_speakers');
function create_post_type_speakers()
{
    $labels = array(
    'name'               => _x('Speakers', 'post type general name', 'mwdw-rest'),
    'singular_name'      => _x('Speaker', 'post type singular name', 'mwdw-rest'),
    'menu_name'          => _x('Speakers', 'admin menu', 'mwdw-rest'),
    'name_admin_bar'     => _x('Speaker', 'add new on admin bar', 'mwdw-rest'),
    'add_new'            => _x('Add New', 'Speaker', 'mwdw-rest'),
    'add_new_item'       => __('Add New Speaker', 'mwdw-rest'),
    'new_item'           => __('New Speaker', 'mwdw-rest'),
    'edit_item'          => __('Edit Speaker', 'mwdw-rest'),
    'view_item'          => __('View Speaker', 'mwdw-rest'),
    'all_items'          => __('All Speakers', 'mwdw-rest'),
    'search_items'       => __('Search Speakers', 'mwdw-rest'),
    'parent_item_colon'  => __('Parent Speakers:', 'mwdw-rest'),
    'not_found'          => __('No Speakers found.', 'mwdw-rest'),
    'not_found_in_trash' => __('No Speakers found in Trash.', 'mwdw-rest')
  );

    $args = array(
    'labels'             => $labels,
    'description'        => __('Description.', 'mwdw-rest'),
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'rewrite'            => array('slug' => 'speaker'),
    'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => 5,
    'show_in_rest'       => true,
    'rest_base'          => 'speakers',
    'rest_controller_class' => 'WP_REST_Posts_Controller',
    'supports'           => array('title', 'editor', 'custom-fields'),
  );

    register_post_type('speaker', $args);
}


// add ACF fields to post types default and custom endpoints
// http://midwestdesignweekapi.local/wp-json/wp/v2/posts?page=1&per_page=100&_embed=1
add_filter('rest_prepare_post', 'acf_to_rest_api', 10, 3);
add_filter('rest_prepare_events', 'acf_to_rest_api', 10, 3);
add_filter('rest_prepare_sponsors', 'acf_to_rest_api', 10, 3);
add_filter('rest_prepare_speaker', 'acf_to_rest_api', 10, 3);
function acf_to_rest_api($response, $post, $request)
{
    if (!function_exists('get_fields')) {
        return $response;
    }

    if (isset($post)) {
        $acf = get_fields($post->id);
        $response->data['acf'] = $acf;
    }
    return $response;
}


// create custom events endpoint
// http://midwestdesignweekapi.local/wp-json/mwdw/v1/sponsors
function events_endpoint($request_data)
{
    $args = array(
    'post_type' => 'events',
    'posts_per_page' => -1,
    'numberposts' => -1,
    'post_status' => 'publish',
  );
    $posts = get_posts($args);
    foreach ($posts as $key => $post) {
        $posts[$key]->acf = get_fields($post->ID);
    }
    return  $posts;
}
add_action('rest_api_init', function () {
    register_rest_route('mwdw/v1', '/events/', array(
    'methods' => 'GET',
    'callback' => 'events_endpoint'
  ));
});


// create custom sponsors endpoint
// http://midwestdesignweekapi.local/wp-json/mwdw/v1/events
function sponsors_endpoint($request_data)
{
    $args = array(
    'post_type' => 'sponsors',
    'posts_per_page' => -1,
    'numberposts' => -1,
    'post_status' => 'publish',
  );
    $posts = get_posts($args);
    foreach ($posts as $key => $post) {
        $posts[$key]->acf = get_fields($post->ID);
    }
    return  $posts;
}
add_action('rest_api_init', function () {
    register_rest_route('mwdw/v1', '/sponsors/', array(
    'methods' => 'GET',
    'callback' => 'sponsors_endpoint'
  ));
});
