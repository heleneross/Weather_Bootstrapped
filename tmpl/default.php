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

// Edit css for custom display
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::Root() . "modules/mod_weather_b/resources/".$params->def('wcss','weather.css'));

// Single woeid
if (count($w) == 1)
{
	// Basic forecast - city, temperature, conditions, date, loads _basic template
	echo '<div id="' . $unique_id . 'single" class="weather-s">';
	if ($params->def('singletype', 'basic') == 'basic')
	{
		require JModuleHelper::getLayoutPath('mod_weather_b', '_basic');
	}
	else
	{
		require JModuleHelper::getLayoutPath('mod_weather_b', '_all');
	}

	if ($forecast5)
	{
		// 5 day forecast - shows basic conditions, loads _5day template
		require JModuleHelper::getLayoutPath('mod_weather_b', '_5day');
    echo '<a class="yahoolink" href="' . $w[0]->link() . '" title="' . $linktitle . '" target="_blank">' . $linktext . '</a>';
	}
  else
  {
      	echo '<div class="linkouter"><a class="yahoolink" href="' . $w[0]->link() . '" title="' . $linktitle . '" target="_blank">' . $linktext . '</a></div>';
  }

	echo '</div>';
}

// Carousel using multiple WOEIDs
if (count($w) > 1)
{
	require JModuleHelper::getLayoutPath('mod_weather_b', '_carousel');
}

