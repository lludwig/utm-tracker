<?php 
/**
 * Plugin Name: IJ UTM Tracker
 * Description: Tracks UTM codes
 * Version:     1.0.0
 * Author:      Larry Ludwig (lludwig@investorjunkie.com)
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

if (!defined('IJ_UTM_TRACKER_VERSION_NUM'))
	define('IJ_UTM_TRACKER_VERSION_NUM', '1.0.0');

function add_async_forscript($url)
{
    if (strpos($url, '#asyncload')===false)
        return $url;
    else if (is_admin())
        return str_replace('#asyncload', '', $url);
    else
        return str_replace('#asyncload', '', $url)."' async='async"; 
}
add_filter('clean_url', 'add_async_forscript', 11, 1);


add_action('wp_footer', 'ij_utm_tracker', 1);
function ij_utm_tracker() {
?>
<script type="text/javascript" charset="utf-8">
var _uf = _uf || {};
_uf.domain = ".investorjunkie.com";
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
add_action('wp_enqueue_scripts','ij_utm_tracker_script');
function ij_utm_tracker_script() {
	wp_enqueue_script( 'ij-utm-tracker-js', plugins_url( '/js/utmtracker.min.js', __FILE__ ), null, IJ_UTM_TRACKER_VERSION_NUM, true);
}
