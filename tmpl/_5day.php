<?php
/**
 * @package    Weather-bootstrapped
 * @author     Helen <heleneross@gmail.com>
 * @website    https://github.com/heleneross/Weather_Bootstrapped
 * @copyright  Copyright (C) 2013 Helen Ross - All Rights Reserved
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 **/

// No direct access
defined('_JEXEC') or die('Restricted access');

// Use weather-icons?
if ($weather_icons)
{
	$document->addStyleSheet(JURI::Root() . "modules/mod_weather_b/resources/weather-icons.min.css");
}

// Type of collapse - bootstrap or JQuery (JQuery gives better results)
if ($boot_collapse)
{
	echo '<div id="' . $unique_id . 'btn" class="days collapse' . (($start_collapsed) ? '' : ' in') . '" >';
}
else
{
	echo '<div class="days ' . $unique_id . 'collapse" >';

	if ($start_collapsed)
	{
		// Collapse with JQuery rather than hiding with css for accessibility
		echo '<script type="text/javascript">';
		echo 'jQuery(document).ready(function() {jQuery( ".' . $unique_id . 'collapse" ).css( "display","none" );});';
		echo '</script>';
	}
}

// Output forecast for days
foreach ($w[0]->forecast() as $day)
{
	// Images or weather-icons
	if ($weather_icons)
	{
		echo '<div class="day">' . Condition_Code::getIconFull($day['code']);
	}
	else
	{
		echo '<div class="day" style="background-image:url(' . Modweather_BHelper::imgcache($imgpath_small . $day['code'] . $img_small_ext, $cacheimg) . ')">';
	}


	echo '<div class="daytext">';
	echo '<p class="day-date">' . $day['day'] . ' ' . substr($day['date'], 0, -5) . '</p>';
	echo '<p class="day-temp">Low: ' . $day['low'] . ' High: ' . $day['high'] . '</p>';
	echo '<p class="day-text">' . $day['text'] . '</p>';
	echo '</div></div>';
}
echo '</div>';

if ($boot_collapse)
{
	echo '<button type="button" class="btn btn-small btn-weather" data-toggle="collapse" data-target="#' . $unique_id . 'btn">...</button>';
}
else
{
	?>
	<button type="button" title="expand/collapse forecast" onfocus="this.blur()"
	        class="btn-weather <?php echo $unique_id; ?>btn"><?php echo ($start_collapsed) ? '+' : '-'; ?></button>
	<script type="text/javascript">
		jQuery(".<?php echo $unique_id;?>btn").click(function () {
			var txt = jQuery(".<?php echo $unique_id;?>collapse").is(':visible') ? '+' : '-';
			jQuery(".<?php echo $unique_id;?>btn").text(txt);
			jQuery(".<?php echo $unique_id;?>collapse").slideToggle("slow");
		});
	</script>
<?php
}
