<?php
/*
Plugin Name: Gravity Forms Repeater Add-On
Plugin URI: https://wordpress.org/plugins/repeater-add-on-for-gravity-forms/
Description: A Gravity Forms add-on that allows specified groups of fields to be repeated by the user.
Version: 1.0.1
Author: Kodie Grantham
Author URI: http://kodieg.com
*/

add_filter('plugin_row_meta', 'gfrepeater_row_meta', 10, 2);
function gfrepeater_row_meta($links, $file) {
	if (strpos($file, basename(__FILE__)) !== false) {
		$new_links = array('<a href="https://github.com/kodie/gravityforms-repeater" target="_blank">GitHub</a>');
		$links = array_merge($links, $new_links);
	}
	return $links;
}

if (class_exists("GFForms")) {
    GFForms::include_addon_framework();

	class GFRepeater extends GFAddOn {
		protected $_version = "1.0.1";
		protected $_min_gravityforms_version = "1.0.0";
		protected $_slug = "repeateraddon";
		protected $_path = "gravityforms-repeater/repeater.php";
		protected $_full_path = __FILE__;
		protected $_title = "Gravity Forms Repeater Add-On";
		protected $_short_title = "Repeater Add-On";

		public function scripts() {
			$scripts = array(
				array(
					"handle"	=> "gf_repeater_js_admin",
					"src"		=> $this->get_base_url() . "/js/gf-repeater-admin.min.js",
					"version"	=> $this->_version,
					"deps"		=> array('jquery'),
					"in_footer"	=> false,
					"callback"	=> array($this, 'localize_scripts'),
					"strings"	=> array('page' => rgget('page')),
					"enqueue"	=> array(
						array(
							"admin_page" => array('form_editor', 'entry_view', 'entry_detail')
						)
					)
				)
			);
			return array_merge(parent::scripts(), $scripts);
		}
    }
    new GFRepeater();

    add_action('init',  array('GF_Field_Repeater', 'init'), 20);

    require_once('class-gf-field-repeater.php');
    require_once('class-gf-field-repeater-end.php');
}