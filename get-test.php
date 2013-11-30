<?php
/*
Plugin Name: Get Twitter
Plugin URI: http://jaxx2104.info
Description: Twitterを表示するプラグイン
Author: jaxx2104
Version: 0.1
Author URI: http://www.jaxx2104.info
 */

class GetTwitter_Widget extends WP_Widget {
  public function __construct() {
    parent::__construct(
      'getTwitter_widget', // Base ID
      'Get Twitter', // Name
      array( 'description' => __('TwitterAPIを使って、つぶやきを表示するプラグイン', 'text_domain'), )
    );
  }

  public function widget($args, $instance) {
    require_once('get_twitter.php');
    $gettwitter = new getTest;
    list($title,$data) = $gettwitter->get_twitter();
    extract($args);
    echo $before_widget;
    if (!empty($title))
    echo $before_title . $title . $after_title;
    echo $data;
    echo $after_widget;
  }

  public function update($new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    return $instance;
  }

  public function form( $instance ) {
    if ( $instance ) {
      $title = esc_attr($instance['title']);
    }
    else {
      $title = __('New title', 'text_domain');
    }
    echo sprintf('<p><label for="%s">%s</label><input class="widefat" id="%s" name="%s" type="text" value="%s" /></p>',$this->get_field_id('title'),_e('Title:'),$this->get_field_id('title'),$this->get_field_name('title'),$title);
  }



}

add_action('widgets_init',
           create_function('', 'register_widget("GetTwitter_widget");')
           );

?>