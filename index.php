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

add_action('wp_footer', 'ij_utm_tracker', 99);
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
<script type="text/javascript" async src="<?php echo plugins_url( 'js/utm-tracker-'.IJ_UTM_TRACKER_VERSION_NUM.'.min.js', __FILE__ ); ?>"></script>
<?php
}
