<?php
/* ==============================================
  定数
============================================== */
define('ENTRY_POINT',  'assets/js/main.js');
define('DIST_URL',  get_template_directory_uri());
define('PUBLIC_URL', IS_DEVELOPMENT ? '' : get_template_directory_uri());
define('JS_DEPENDENCY', []);
define('JS_LOAD_IN_FOOTER', false);
