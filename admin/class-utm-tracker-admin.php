<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    utm-tracker
 * @subpackage utm-tracker/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    utm-tracker
 * @subpackage utm-tracker/admin
 * @author     Ludwig Media <plugin@larryludwig.com>
 */
class UTM_Tracker_Admin {

	public $settings_slug = 'utm-tracker';

	public function __construct() {
		$this->init();
	}

	public function init() {
		register_setting( 'utm-tracker', 'utm-tracker-domain-name', array ('type' => 'string', 'description' => 'If different than the default domain name used in confirmation. Useful when hosting a subdomain.', 'default' => 
				$this->urlToDomain(get_site_url())));
		register_setting( 'utm-tracker', 'utm-tracker-ttl', array ('type' => 'number', 'description' => 'How long should the cookie be active in days.', 'default' => 30 ) );

		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_init', array( $this, 'settings' ) );
	}
	
	public function admin_menu() {
		add_options_page(
			__('UTM Tracker Settings', 'utm-tracker'),
                        __('UTM Tracker', 'utm-tracker'),
                        'manage_options',
                        'utm-tracker',
                        array($this, 'settings_page')
                );
	}

        public function settings() {
                add_settings_section( 'utm-tracker-section', null, array ($this, 'settings_section_description'), 'utm-tracker' );
                add_settings_field( 'utm-tracker-domain-name', 'Domain Name Cookie', array ($this, 'domain_name_field'), 'utm-tracker', 'utm-tracker-section' );
                add_settings_field( 'utm-tracker-ttl', 'Cookie Age', array ($this, 'ttl_field'), 'utm-tracker', 'utm-tracker-section' );
        }

	public function settings_section_description(){
		echo wpautop( "For more documentation on using this plugin please visit our <a href=\"https://larryludwig.com/plugins/utm-tracker/?utm_source=wpplugin&utm_medium=link&utm_campaign=settings\" target=\"_blank\">online manual</a>." );
	}

	public function settings_page() {
?>
<div class="wrap">
	<h1>UTM Tracker Settings</h1>
	<form method="post" action="options.php">
<?php
            settings_fields( 'utm-tracker' );
            do_settings_sections( 'utm-tracker' );
            submit_button();
?>
	</form>
</div>
<?php
	}

	public function domain_name_field() {
		$output  = '<input id="utm-tracker-domain-name" type="text" name="utm-tracker-domain-name" value="'. get_option('utm-tracker-domain-name') .'" size="40">';
		$output .= ' <small>start the domain with a period to allow subdomains.</small>';
		echo $output;
	}

	public function ttl_field() {
		$output  = 'Domain Name: <input id="utm-tracker-ttl" type="text" name="utm-tracker-ttl" value="'. get_option('utm-tracker-ttl') .'" size="3">';
		$output .= ' <small>Time for the cooke to live (in days).</small>';
		echo $output;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/plugin-name-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/plugin-name-admin.js', array( 'jquery' ), $this->version, false );

	}

	// Strip out just the domain name
	private function urlToDomain($url) {
		return implode(array_slice(explode('/', preg_replace('/https?:\/\/(www\.)?/', '', $url)), 0, 1));
	}

}

if( is_admin() )
	$utm_tracker_admin = new UTM_Tracker_Admin();
