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

$date = $params->get('shortdate', 0) ? $w[0]->shortdate() : ($params->get('longdate', 0) ? $w[0]->condition('date') : false);

// If you want these output in a different order then reorder the array as you wish
// The key is used both as the class of the element and also the text displayed
// If you edit the key name you may need to change the css
$view = array(
	'city' => $params->get('city', 0) ? Modweather_BHelper::german_city($w[0]->location('city')) : false,
	'region' => $params->get('region', 0) ? $w[0]->location('region') : false,
	'country' => $params->get('country', 0) ? $w[0]->location('country') : false,
	'chill' => $params->get('chill', 0) ? $w[0]->wind('chill') . '&deg;' . $w[0]->unit('temperature') : false,
	'direction' => $params->get('direction', 0) ? Modweather_BHelper::cardinalize($w[0]->wind('direction')) : false,
	'speed' => $params->get('speed', 0) ? $w[0]->wind('speed') . ' ' . $w[0]->unit('speed') : false,
	'humidity' => $params->get('humidity', 0) ? $w[0]->atmosphere('humidity') : false,
	'visibility' => $params->get('visibility', 0) ? $w[0]->atmosphere('visibility') . ' ' . $w[0]->unit('distance') : false,
	'pressure' => $params->get('pressure', 0) ? $w[0]->atmosphere('pressure') . ' ' . $w[0]->unit('pressure') : false,
	'rising' => $params->get('rising', 0) ? $w[0]->atmosphere('rising') : false,
	'sunrise' => $params->get('sunrise', 0) ? $w[0]->astronomy('sunrise') : false,
	'sunset' => $params->get('sunset', 0) ? $w[0]->astronomy('sunset') : false,
	'temp' => $params->get('temp', 0) ? $w[0]->condition('temp') . '&deg;' . $w[0]->unit('temperature') : false,
	'low' => $params->get('low', 0) ? $w[0]->today_minmax('low') : false,
	'high' => $params->get('high', 0) ? $w[0]->today_minmax('high') : false,
	'condition' => $params->get('text', 0) ? htmlspecialchars($w[0]->condition('text')) : false,
	'date' => $date
);
$view = array_filter($view,'strlen');
?>

<div class="weatherpic-all"
     style="background-image:url(<?php echo Modweather_BHelper::imgcache($imgpath_big . $w[0]->condition('code') . $img_big_ext, $cacheimg); ?>)">


	<?php

	if ($params->get('singletype') == 'all')
	{
		// p type output
		echo '<div class="weathertext-all">';
		foreach ($view as $key => $value)
		{
			echo '<p class="' . $key . '"><span class="title">' . ucfirst($key) . ':</span>' . $value . '</p>';
		}
		echo '</div>';
	}
	else
	{
		// dl type output
		echo '<dl class="weathertext-dl">';
		foreach ($view as $key => $value)
		{
			echo '<dt class="' . $key . '">' . ucfirst($key) . ':</dt><dd class="' . $key . '">' . $value . '</dd>';
		}
		echo '</dl>';
	}
	echo '</div>';
	?>

