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

require_once dirname(__FILE__) . '/helper.php'; 
require_once dirname(__FILE__) . '/weather-class.php';
require_once dirname(__FILE__) . '/cond_codes.php';

$key = $params->get('woeid', '44418');

$units = $params->get('units', 'c');
$cache = JFactory::getCache('mod_weather_b', '');

if ($params->get('owncache', '1')) {
    $cache->setCaching(1);
} 
// Cache setLifeTime works in minutes!
$cache->setLifeTime($params->get('cache_time', 60));

/** @var $w \Weather[] */
$w = Modweather_BHelper::getFeeds($key, $units, $cache);

// Check we have returned feed data if not bail out
if (count($w) < 1) {
    echo '<div id="weather-error" style="padding:5px">
    Sorry weather data is not available
    </div>';
    return;
}

// Explicitly map the parameters to variables

/** @var $forecast5 bool     true=5 day forcast, false=today only */
$forecast5 = $params->get('forecast', 0);

/** @var $linktext string    the text to use for the link */
$linktext = $params->get('linktext', 'Full Forecast');

/** @var $linktitle string the text which is typically shown when you hover over the link */
$linktitle = $params->get('linktitle', 'Full Yahoo weather forecast');

/** @var $imgpath_big string   path to large size images - excluding image name */
$imgpath_big = $params->get('imgpath_big', 'http://l.yimg.com/a/i/us/nws/weather/gr/');

/** @var $imgpath_small string    path to small images for 5 day forecast - excluding image name */
$imgpath_small = $params->get('imgpath_small', 'http://l.yimg.com/a/i/us/we/52/');

/** @var $img_big_ext string    image extension - d=day, n=night if using default large image path */
$img_big_ext = $params->get('img_big_ext', 'd.png');

/** @var $img_small_ext string    image extension for small 5 day forecast images */
$img_small_ext = $params->get('img_small_ext', '.gif');

/** @var $cacheimg bool  if true images should be cached to cache/weather */
$cacheimg = $params->get('cacheimg',1);

/** @var $tspeed integer    carousel speed*/
$tspeed = $params->get('tspeed', 5000);

/** @var $unique_id string    a unique id to assign to the module to avoid conflicts if you have several modules on a page */
$unique_id = $params->get('unique_id', 'w-');

/** @var $start_collapsed bool    should the 5 day forecast be hidden on page load */
$start_collapsed = $params->get('start_collapsed', 1);

/** @var $boot_collapse bool    false=use jQuery collapse, true=use the bootstrap collapse script */
$boot_collapse = $params->get('boot_collapse', 0);

/** @var  $weather_icons bool    true=use weather icons for 5 day forecast overriding small images */
$weather_icons = $params->get('weather_icons', 0);

/** @var  $add_bootstrap bool    true=add bootstrap js and css */
$add_bootstrap = $params->get('add_bootstrap', 0);

/** @var  $mootools_conflict bool   true=load conflict.js */
$mootools_conflict = $params->get('mootools_conflict', 0);

/** @var  $indicators bool   add carousel indicators to the carousel */
$indicators = $params->get('indicators', 0);

// Some feed data was returned so now display it
require JModuleHelper::getLayoutPath('mod_weather_b','default');

//http://localhost/weather-images/big/
//http://localhost/weather-images/small/