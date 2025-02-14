<?php
define('DIST_THEME_URL', get_template_directory_uri());


class ViteHelper

{
  const IS_DEVELOPMENT = true;
  const VITE_SERVER = 'http://192.168.1.5:4173';
  const ENTRY_POINT = 'assets/scripts/main.js';
  const DIST_URL = DIST_THEME_URL;
  const PUBLIC_URL = self::IS_DEVELOPMENT ? self::VITE_SERVER : DIST_THEME_URL;


  private $js_dependencies;
  private $js_load_in_footer;
  private $manifest;
  private $root;

  function __construct($js_dependencies = [], $js_load_in_footer = false)
  {
    $this->root = __DIR__ . '/../';
    $this->manifest = [];

    $this->js_dependencies = $js_dependencies;
    $this->js_load_in_footer = $js_load_in_footer;


    $this->init();
    $this->setManifest();
    $this->setAction();
    $this->setFilter();
  }

  private function init()
  {
    if (self::IS_DEVELOPMENT) {
      ini_set('display_errors', "On");
    }
  }

  private function setManifest()
  {
    if (!self::IS_DEVELOPMENT) {
      $this->manifest = json_decode(file_get_contents($this->root . '.vite/manifest.json'), true);
    }
  }

  public function setAction()
  {
    if (self::IS_DEVELOPMENT) {
      add_action('send_headers', array($this, 'corsHttpHeader'));
    }

    add_action('wp_enqueue_scripts', array($this, 'themeScripts'));
  }

  public function setFilter()
  {
    add_filter('script_loader_tag', array($this, 'addScriptAttibute'), 10, 2);

    if (self::IS_DEVELOPMENT) {
      add_filter('template_directory_uri', array($this, 'overrideThemeUrl'));
      add_filter('stylesheet_directory_uri', array($this, 'overrideThemeUrl'));
    }
  }


  public function corsHttpHeader()
  {
    header("Access-Control-Allow-Origin: *");
  }


  public function overrideThemeUrl($url)
  {
    if (self::IS_DEVELOPMENT) {
      $theme_name = get_template();
      return self::VITE_SERVER;
    }
    return $url;
  }


  public function themeScripts()
  {
    if (self::IS_DEVELOPMENT) {

      wp_enqueue_script('vite-main', self::VITE_SERVER . '/' . self::ENTRY_POINT, $this->js_dependencies, '', false);
      wp_enqueue_script('vite-client', self::VITE_SERVER . '/@vite/client', false, false);
    } else {

      if (isset($this->manifest[self::ENTRY_POINT])) {
        $enqueues = $this->manifest[self::ENTRY_POINT];

        if (isset($enqueues['css'])) {
          foreach ($enqueues['css'] as $key => $css_file) {
            wp_enqueue_style('main-' . $key, self::DIST_URL . '/' . $css_file);
          }
        }

        $js_file = $enqueues['file'];
        if (!empty($js_file)) {
          wp_enqueue_script('main', self::DIST_URL . '/' . $js_file, $this->js_dependencies, '', $this->js_load_in_footer);
        }
      }
    }
  }

  public function addScriptAttibute($tag, $handle)
  {
    if (self::IS_DEVELOPMENT && ($handle === 'vite-main' || $handle === 'vite-client')) {
      return str_replace(' src=', ' type="module" crossorigin src=', $tag);
    }

    if (!self::IS_DEVELOPMENT && $handle === 'main' && !$this->js_load_in_footer) {
      return str_replace(' src=', ' defer src=', $tag);
    }
    return $tag;
  }
}

$ViteHelper = new ViteHelper();

define('THEME_URL', get_template_directory_uri());
