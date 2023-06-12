<?php
/*======================================
  ユーティリティ
======================================*/

/**
* 画像表示用関数
*
* @param strng $path    表示する画像の相対パス
* @param strng $alt alt属性に指定する代替えテキスト
* @param int $width 画像の幅
* @param int $height 画像の高さ
* @param bool $decoding decoding属性の値を「async」にする
* @param bool $loading loading属性の値を「lazy」にする
*/
function the_assets_image($path, $alt = "" , $width = false, $height = false, $decoding = true, $loading = true) {


  if(substr($path, 0, 4) === "http"){
    echo 'src="' . esc_url($path) . '" width="' . esc_attr($width) . '" height="' . esc_attr($height) . '" alt="' . esc_attr($alt) . '" decoding="' . esc_attr( $decoding ? 'async' : 'auto') . '" loading="' . esc_attr($loading ? 'lazy' : 'eager') . '"';
    return false;
  }

  if ( defined( 'IS_VITE_DEVELOPMENT') && IS_VITE_DEVELOPMENT ) {
    $image_url = DIST_URL . '/' . $path;
    $image_root_path = __DIR__ . '/../' . $path;

  } else {
    if ( is_array( MANIFEST ) && isset(MANIFEST[$path])) {
      $image_url= DIST_URL . '/' . MANIFEST[$path]['file'];
      $image_root_path = __DIR__ . '/../' . MANIFEST[$path]['file'];
    }
  }

  if (!isset($image_url) || !isset($image_root_path)) {
    return false;
  }

  $imageSize = getimagesize( $image_root_path );
  $imageInfo =[
    'url' => $image_url,
    'alt' => $alt,
    'width' =>  $imageSize[0],
    'height' =>  $imageSize[1],
    'decoding' => $decoding ? 'async' : 'auto',
    'loading' => $loading ? 'lazy' : 'eager',
  ];

  echo '<img src="' . esc_url($imageInfo['url']) . '" alt="' . esc_attr($imageInfo['alt']) . '" width="' . esc_attr($imageInfo['width']) . '" height="' . esc_attr($imageInfo['height']) . '" decoding="' . esc_attr($imageInfo['decoding']) . '" loading="' . esc_attr($imageInfo['loading']) . '">';

}
