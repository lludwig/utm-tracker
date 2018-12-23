<?php 
/**
 * Plugin Name: UTM Tracker
 * Description: Tracks UTM codes
 * Version:     1.0.2
 * Author:      Ludwig Media
 * Author URI:  https://larryludwig.com/
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

if (!defined('UTM_TRACKER_VERSION_NUM'))
	define('UTM_TRACKER_VERSION_NUM', '1.0.2');

if ( ! defined( 'UTM_TRACKER_PATH' ) ) {
        define( 'UTM_TRACKER_PATH', plugin_dir_path( __FILE__ ) );
} 

require_once( UTM_TRACKER_PATH . 'admin/class-utm-tracker-admin.php' );

// Add the ability to WP to create async loading scripts
function utm_add_async_forscript($url)
{
    if (strpos($url, '#asyncload')===false)
        return $url;
    else if (is_admin())
        return str_replace('#asyncload', '', $url);
    else
        return str_replace('#asyncload', '', $url)."' async='async"; 
}
add_filter('clean_url', 'utm_add_async_forscript', 11, 1);

function add_action_links( $actions, $plugin_file ) {
	static $plugin;

       	if (!isset($plugin))
		$plugin = plugin_basename(__FILE__);
	if ($plugin == $plugin_file) {
		$settings = array('settings' => '<a href="options-general.php?page=utm-tracker">' . __('Settings', 'General') . '</a>');
		$site_link = array('docs' => '<a href="https://larryludwig.com/plugins/utm-tracker/?utm_source=wpplugin&utm_medium=link&utm_campaign=pluginpage" target="_blank">Docs</a>');
		$actions = array_merge($site_link, $actions);
		$actions = array_merge($settings, $actions);
	}
	return $actions;
}
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'add_action_links', 10, 5);

function utm_tracker() {
?>
<script type="text/javascript" charset="utf-8">
var _uf = _uf || {};
_uf.domain = "<?php echo get_option('utm-tracker-domain-name'); ?>";
_uf.cookieExpiryDays = <?php echo get_option('utm-tracker-ttl'); ?>;
_uf.additional_params_map = {
	gclid: "IJGCLID",
	adpos: "IJADPOS",
	place: "IJPLACE",
	net: "IJNET",
	match: "IJMATCH"
};
</script>
<?php
}
add_action('wp_footer', 'utm_tracker', 1);

function utm_tracker_script() {
	wp_enqueue_script( 'utm-tracker-js', plugins_url( '/js/utmtracker.min.js#asyncload', __FILE__ ), null, UTM_TRACKER_VERSION_NUM, true);
}
add_action('wp_enqueue_scripts','utm_tracker_script');
