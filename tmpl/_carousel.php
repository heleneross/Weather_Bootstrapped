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


// Add bootstrap js and css for carousel here
if ($add_bootstrap)
{
	$document->addScript(JURI::Root() . "modules/mod_weather_b/resources/bootstrap.min.js");
	$document->addStyleSheet(JURI::Root() . "modules/mod_weather_b/resources/carousel.css");
}

// If you have a mootools conflict then the carousel won't work properly - need to disable mootools slides
if ($mootools_conflict)
{
	$document->addScript(JURI::Root() . "modules/mod_weather_b/resources/conflict.js");
}

// Carousel setup
echo '<div class="weather-c">';
echo '<div id="' . $unique_id . 'carousel" class="carousel slide" data-ride="carousel" data-interval="' . $tspeed . '">';


// Carousel items
$first = true;

foreach ($w as $loc)
{
	if ($first)
	{
		echo '<div class="carousel-inner">';
		//echo '<div class="item  active">';
		//echo '<img alt="" src="' . Modweather_BHelper::imgcache($imgpath_big . $loc->condition('code') . $img_big_ext,$cacheimg) . '" />';
		echo '<div class="item active" style="background-image:url(' . Modweather_BHelper::imgcache($imgpath_big . $loc->condition('code') . $img_big_ext, $cacheimg) . ')">';
		$first = false;
	}
	else
	{
		//echo '<div class="item">';
		//echo '<img alt="" src="' . Modweather_BHelper::imgcache($imgpath_big . $loc->condition('code') . $img_big_ext,$cacheimg) . '" />';
		echo '<div class="item" style="background-image:url(' . Modweather_BHelper::imgcache($imgpath_big . $loc->condition('code') . $img_big_ext, $cacheimg) . ')">';
	}

	echo '<div class="xcarousel-caption">';

	// Start information div. You can add more weather information to this div
	echo '<p class="location">' . Modweather_BHelper::german_city($loc->location('city')) . '</p>';
	echo '<p class="temperature">' . $loc->condition('temp') . '<span class="units">&deg;<span class="forc">' . $loc->unit('temperature') . '</span></span></p>';
	echo '<p class="condition">' . htmlspecialchars($loc->condition('text')) . '</p>';
	//echo '<span class="date">' . $loc->shortdate() . '</span>';
	echo '<p class="range">High: ' . $loc->today_minmax('high') . '&nbsp;Low: ' . $loc->today_minmax('low') . '</p>';
	echo '<p class="wind">Wind: ' . $loc->wind('speed') . ' ' . $loc->unit('speed') . '</p>';
	echo '<a class="yahoolink" href="' . $loc->link() . '" title="' . $linktitle . '" target="_blank">' . $linktext . '</a></div></div>';
}

echo '</div>';
// Carousel indicators
if ($indicators)
{
	echo '<ol class="carousel-indicators">';
	echo '<li data-target="#' . $unique_id . 'carousel" data-slide-to="0" class="active"></li>';

	for ($i = 1; $i < count($w); $i++)
	{
		echo '<li data-target="#' . $unique_id . 'carousel" data-slide-to="' . $i . '"></li>';
	}

	echo '</ol>';
}

echo '</div></div>';