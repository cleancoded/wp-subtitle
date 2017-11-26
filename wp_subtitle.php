<?php
/**
Plugin Name: WP Subtitle
Version: 1.0
Plugin Description: Custom sub title feature, add sub title to your post, page and other custom post type pages.
Author: James
Author URI: http://www.cleancoded.com
License: GPL v3
Text Domain: wp_subtitle
*/

defined('ABSPATH') or die('Are you sure you want to do this?');

if (!function_exists('wp_subtitle')) {
    function wp_subtitle()
    {
    	//define post types where the meta box will be displaye

    	$post_types = array('post', 'page');
        foreach ($post_types as $post_type) {
            add_meta_box("wp_subtitle_meta_box", __('Theme Options', 'wp_subtitle'), 'wp_subtitle_html', $post_type, 'normal', 'default');
        }
    }
}
add_action('add_meta_boxes', 'wp_subtitle');
function wp_subtitle_html($post)
{
    echo '<label></label>';
    printf(__('<input type="text" value="%s" name="wp_subtitle" />'), get_post_meta($post->ID, '_wp_subtitle', true));
}

function wp_subtitle_save($post_id)
{
    if (isset($_POST['wp_subtitle'])):
        update_post_meta($post_id, '_wp_subtitle', $_POST['wp_subtitle']);
    endif;
}
add_action('save_post', 'wp_subtitle_save');

//frontend handling

//display the sub title just below the title

function custom_subtitle_handling($title_subtitle){
	add_action('the_title', $title_subtitle);
}

add_filter('custom_subtitle', 'custom_subtitle_handling', 10, 1);


function get_subtitle(){
	global $post;
	// print_r($post);
		return '<span class="title">'.$post->post_title.'</span><br/><span>'.get_post_meta($post->ID, '_wp_subtitle', true).'</span>';
}
function check_for_subtitle(){
	if(is_singular() && in_the_loop()):
		apply_filters('custom_subtitle', 'get_subtitle');
	endif;
}
add_action('the_post', 'check_for_subtitle');