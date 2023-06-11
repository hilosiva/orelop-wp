<?php
/*======================================
  スタイル・スクリプトの追加
======================================*/

if ( defined( 'IS_VITE_DEVELOPMENT') && IS_VITE_DEVELOPMENT  ) {

  function vite_development_scripts() {
    echo '<script type="module" crossorigin src="' . VITE_SERVER . '/' . VITE_ENTRY_POINT . '"></script>';
    echo '<script type="module" crossorigin src="' . VITE_SERVER . '/@vite/client' . '"></script>';
  }
  add_action( 'wp_head', 'vite_development_scripts' );
}


function theme_scripts() {

  if ( !defined( 'IS_VITE_DEVELOPMENT') || !IS_VITE_DEVELOPMENT ) {

    if ( is_array( MANIFEST ) && isset(MANIFEST[VITE_ENTRY_POINT]) ) {

      $enqueues = MANIFEST[VITE_ENTRY_POINT];

      if ( isset($enqueues['css']) ) {
        foreach($enqueues['css'] as $key => $css_file) {
           wp_enqueue_style( 'main-' . $key , DIST_URL . '/' . $css_file );
        }
      }


      $js_file = $enqueues['file'];
       if ( !empty( $js_file ) ) {
          wp_enqueue_script( 'main', DIST_URL . '/' . $js_file, JS_DEPENDENCY, '', JS_LOAD_IN_FOOTER );
        }

    }
  }



}
add_action( 'wp_enqueue_scripts', 'theme_scripts' );

/*======================================
  defer 属性の付加
======================================*/
function add_defer($tag, $handle) {

  if($handle === 'main' && !JS_LOAD_IN_FOOTER) {
    return str_replace(' src=', ' defer src=', $tag);
  }


  return $tag;

}
add_filter('script_loader_tag', 'add_defer', 10, 2);
