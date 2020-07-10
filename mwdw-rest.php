<?php
/*
Plugin Name: Midwest Design Week Rest
Description: Setup for Midwest Design Week Rest API
Author: David Soards
Version: 0.1.0
GitHub Plugin URI: relaydesignco/mdmw-rest-plugin
*/

if (!defined('ABSPATH')) exit; // Exit if accessed directly


// create custom events endpoint
// http://midwestdesignweekapi.local/wp-json/events/v2/posts
function  events_endpoint($request_data)
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
  register_rest_route('events/v2', '/posts/', array(
    'methods' => 'GET',
    'callback' => 'events_endpoint'
  ));
});


// specify whether I’m using a local Advanced Custom Fields configuration (development) or my PHP export (staging/production)
// must also add the following to wp-config.php in your dev environment ONLY: define('USE_LOCAL_ACF_CONFIGURATION', true);
if (!defined('USE_LOCAL_ACF_CONFIGURATION') || !USE_LOCAL_ACF_CONFIGURATION) {
  require_once dirname(__FILE__) . '/advanced-custom-fields.php';
}


// create custom sponsors endpoint
// http://midwestdesignweekapi.local/wp-json/events/v2/posts
function  sponsors_endpoint($request_data)
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
function dt_get_all_post_ids()
{
  if (false === ($all_post_ids = get_transient('dt_all_post_ids'))) {
    $all_post_ids = get_posts(array(
      'numberposts' => -1,
      'post_type'   => 'sponsors',
      'fields'      => 'ids',
    ));
  }

  return $all_post_ids;
}
add_action('rest_api_init', function () {
  register_rest_route('sponsors/v2', '/posts/', array(
    'methods' => 'GET',
    'callback' => 'sponsors_endpoint'
  ));
});


// specify whether I’m using a local Advanced Custom Fields configuration (development) or my PHP export (staging/production)
// must also add the following to wp-config.php in your dev environment ONLY: define('USE_LOCAL_ACF_CONFIGURATION', true);
if (!defined('USE_LOCAL_ACF_CONFIGURATION') || !USE_LOCAL_ACF_CONFIGURATION) {
  require_once dirname(__FILE__) . '/advanced-custom-fields.php';
}


// create events post type
function create_post_type_events()
{
  register_post_type(
    'events',
    array(
      'labels' => array(
        'name' => __('Events'),
        'singular_name' => __('Event')
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'events'),
      'show_in_rest' => true,
      'supports'            => array('title', 'editor', 'custom-fields'),
      'menu_position'       => 6,

    )
  );
}
add_action('init', 'create_post_type_events', 0);


// create sponsors post type
function create_post_type_sponsors()
{
  register_post_type(
    'sponsors',
    array(
      'labels' => array(
        'name' => __('Sponsors'),
        'singular_name' => __('Sponsor')
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'sponsors'),
      'show_in_rest' => true,
      'supports'            => array('title', 'custom-fields'),
      'menu_position'       => 6,

    )
  );
}
add_action('init', 'create_post_type_sponsors', 0);

// add ACF fields to post types default endpoints
// http://midwestdesignweekapi.local/wp-json/wp/v2/posts
function acf_to_rest_api($response, $post, $request)
{
  if (!function_exists('get_fields')) return $response;

  if (isset($post)) {
    $acf = get_fields($post->id);
    $response->data['acf'] = $acf;
  }
  return $response;
}
add_filter('rest_prepare_post', 'acf_to_rest_api', 10, 3);
add_filter('rest_prepare_events', 'acf_to_rest_api', 10, 3);
add_filter('rest_prepare_sponsors', 'acf_to_rest_api', 10, 3);