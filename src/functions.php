<?php
/*======================================
  Includes
======================================*/
require_once('inc/config.php');
require_once('inc/define.php');
require_once('inc/enqueue-scipts.php');
require_once('inc/utility.php');


/*======================================
  初期設定
======================================*/
function theme_setup()
{

  /*
    Titleタグ
  ----------------------------------- */
  add_theme_support('title-tag');

  /*
    HTML5をサポート
  ----------------------------------- */
  $args = [
    'search-form',
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
    'style',
    'script'
  ];
  add_theme_support('html5', $args);




  /*
    アイキャッチ画像
  ----------------------------------- */
  add_theme_support('post-thumbnails');


  /*
    カスタムメニュー
  ----------------------------------- */
  $locations = [
    'global' => 'Global Navigation'
  ];
  register_nav_menus($locations);
}
add_action('after_setup_theme', 'theme_setup');


/*======================================
  Originの設定
======================================*/
function cors_http_header()
{
  header("Access-Control-Allow-Origin: *");
}
add_action('send_headers', 'cors_http_header');


/*======================================
  画質の劣化の無効化
======================================*/
add_filter('jpeg_quality', function ($arg) {
  return 100;
});
add_filter('big_image_size_threshold', '__return_false');


/*======================================
  不要な head内の要素削除
======================================*/
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
