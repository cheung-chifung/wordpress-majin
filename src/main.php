<?php
/*
Plugin Name: Majin for Wordpress
Plugin URI: http://wordpress.org/plugins/wordpress-majin/
Description: A wordpress plugin for Majin users
Author: Chifung Cheung
Version: 1.0
Author URI: https://github.com/keekun/wordpress-majin
*/

class WordpressMajin {
	private $options;

	public function __construct() {
		$this->plugin = new stdClass;
		$this->plugin->name = 'wordpress-majin';
		$this->plugin->displayName = 'Majin for Wordpress';
		$this->plugin->version = '1.0';
		$this->plugin->folder       = plugin_dir_path( __FILE__ );
		$this->plugin->url          = plugin_dir_url( __FILE__ );
		
		add_action('admin_init', array(&$this, 'registerSettings'));
		add_action('admin_menu', array(&$this, 'adminPanelsAndMetaBoxes'));

		add_action('wp_footer', array(&$this, 'frontendFooter'));
	}

	function registerSettings() {
		register_setting(
			$this->plugin->name, // Setting group
			'majin_options', // Setting name
			array(&$this, 'sanitize') // Callback
		);
		add_settings_section(
		  'majin_settings_section', // Section ID
		  'Majin設定', // Title
		  array(&$this, 'print_section_info'), // Callback
		  'majin-settings' // Page
		);
		add_settings_field(
			'majin_tag', // Field ID
			'Majinタグ', // Title
		    array(&$this, 'majin_tag_field'), // Callback
			'majin-settings', // Page
			'majin_settings_section' // Section ID
		);
	}

	function adminPanelsAndMetaBoxes() {
		add_options_page(
			'Majinタグ',
			'Majin',
			'manage_options',
			'majin-settings', // Page
			array(&$this, 'majin_settings_page')
		);
	}

	function print_section_info() {
		print('下記の「Majinタグ」項目にMajinのタグを入力してください。');
	}

	function majin_settings_page() {
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		$this->options = get_option('majin_options');
		include_once(WP_PLUGIN_DIR . '/' . $this->plugin->name . '/form.php' );
	}

	public function sanitize($input) {
        $new_input = array();
        if (isset( $input['majin_tag'])) {
            $new_input['majin_tag'] = $input['majin_tag'];
		}
        return $new_input;
	}
	
	public function majin_tag_field() {
        printf(
            '<textarea type="text" style="width: 100%%; height: 100px;" name="majin_options[majin_tag]">%s</textarea>',
            isset( $this->options['majin_tag'] ) ? esc_attr( $this->options['majin_tag']) : ''
        );
    }

	function frontendFooter() {
		$opts = get_option('majin_options');
		printf($opts['majin_tag']);
	}
}

$wfMajin = new WordpressMajin();
?>