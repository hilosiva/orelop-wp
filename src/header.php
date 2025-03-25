<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width">
  <meta name="format-detection" content="telephone=no" />
  <link rel="shortcut icon" type="image/svg+xml" href="<?php echo esc_url(ViteHelper::PUBLIC_URL); ?>/favicon.svg">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
