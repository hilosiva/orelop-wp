<?php
/* ==============================================
  定数
============================================== */
define('VITE_ENTRY_POINT',  'assets/js/main.js');

define('DIST_URL',  get_template_directory_uri());
define('PUBLIC_URL', IS_VITE_DEVELOPMENT ? '' : get_template_directory_uri());

define('JS_DEPENDENCY', array()); // array( 'jquery' ) as example
define('JS_LOAD_IN_FOOTER', false); // load scripts in footer?
