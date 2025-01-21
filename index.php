<?php

/*
  Plugin Name: KW Custom Link
  Description: Custom block type to include title, url, and description
  Version: 1.2
  Author: Karl Witek
  Author URI: https://karlwitek.com
*/

if (!defined('ABSPATH')) exit;

class KWCustomLink {
  function __construct() {
    add_action('init', array($this, 'loadAdmin'));
    add_action('wp_enqueue_scripts', array($this, 'loadCssJavascript'));

  }

  function loadAdmin() {

    wp_register_style('kwcustomlinkstylesheet', plugin_dir_url(__FILE__) . 'css/block.css', array(), '1.0', 'all');
    wp_register_script('kwcustomlinkblocktype', plugin_dir_url(__FILE__) . '/javascript/admin.js', array('wp-blocks', 'wp-element', 'jquery'));
    register_block_type('kwplugin/linkblock', array(
      'editor_script' => 'kwcustomlinkblocktype',
      'render_callback' => array($this, 'pageHTML'),
      'editor_style' => 'kwcustomlinkstylesheet',
    ));

  }

  function loadCss() {
    wp_enqueue_style('linkstyle',
      plugin_dir_url(__FILE__) . 'css/custom-link.css',
      array(),
      'all');
  }

  function loadJavascript() {
    wp_enqueue_script('linkjs',
    plugin_dir_url(__FILE__) . 'javascript/custom-link.js',
    array('jquery'),
    '1.0',
    true
    );
  }

  function loadCssJavascript() {
    if (is_singular()) {
      $pageId = get_the_ID();
      $navContentId = get_page_by_path('nav-content');

      if (has_block('kwplugin/linkblock', $pageId) || has_block('kwplugin/linkblock', $navContentId)) {
        $this->loadCss();
        $this->loadJavascript();
      }
    }
  }

  function createHref($attributes) {
    $inputStr = $attributes['urlOrSlug'];
    $pattern = "/^https:\/\//";
    if (preg_match($pattern, $inputStr)) {
      return $attributes['urlOrSlug'];
    }
    if ($attributes['pageAnchor']) {
      return get_permalink(get_page_by_path($attributes['urlOrSlug'])) . '#' . $attributes['pageAnchor'];
    }
    return get_permalink(get_page_by_path($attributes['urlOrSlug']));
  }

  function getTargetAttrValue($attributes) {
    $inputStr = $attributes['urlOrSlug'];
    $pattern = "/^https:\/\//";
    if (preg_match($pattern, $inputStr)) {
      return "_blank";
    }
    return "_self";
  }

  function pageHTML($attributes) {
    
    ob_start(); ?>
      <a href=<?php echo $this->createHref($attributes); ?> target=<?php echo $this->getTargetAttrValue($attributes); ?> class="kwcl-anchor-link">
        <div class="kwcl-link-div">
          <h2 class="kwcl-title"><?php echo esc_html($attributes['title']) ?></h2>
          <div class="kwcl-textarea-div">
            <p class="kwcl-textarea"><?php echo esc_html($attributes['description']) ?></p>
          </div>
        </div>
      </a>
    <?php
    return ob_get_clean();
  }

}

$kwCustomLink = new KWCustomLink();