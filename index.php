<?php 
/**
 * Plugin Name: UTM Tracker
 * Description: Tracks UTM codes
 * Version:     1.0.1
 * Author:      Ludwig Media
 * Author URI:  https://larryludwig.com/
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

if (!defined('UTM_TRACKER_VERSION_NUM'))
	define('UTM_TRACKER_VERSION_NUM', '1.0.1');

// Strip out just the domain name
function utm_urlToDomain($url) {
   return implode(array_slice(explode('/', preg_replace('/https?:\/\/(www\.)?/', '', $url)), 0, 1));
}

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

function utm_tracker() {
?>
<script type="text/javascript" charset="utf-8">
var _uf = _uf || {};
_uf.domain = ".<?php echo utm_urlToDomain(get_site_url()); ?>";
</script>
<?php
}
add_action('wp_footer', 'utm_tracker', 1);

function utm_tracker_script() {
	wp_enqueue_script( 'utm-tracker-js', plugins_url( '/js/utmtracker.min.js#asyncload', __FILE__ ), null, UTM_TRACKER_VERSION_NUM, true);
}
add_action('wp_enqueue_scripts','utm_tracker_script');
