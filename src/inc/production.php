<?php
/* ==============================================
  本番環境設定
============================================== */
define("IS_VITE_DEVELOPMENT", false);
define('MANIFEST', json_decode(file_get_contents(__DIR__ . '/../manifest.json'), true));
