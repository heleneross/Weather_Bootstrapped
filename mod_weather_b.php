<?php
/**
* @package weather-bootstrapped
* @author Helen
* @website bfgnet.de
* @email heleneross@gmail.com
* @copyright Copyright © 2013 Helen Ross - All Rights Reserved 
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
**/

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once(dirname(__FILE__).'/helper.php');
require_once(dirname(__FILE__).'/weather-class.php');

$key = $params->get('woeid','44418');
$units = $params->get('units','c');
$cache = JFactory::getCache('mod_weather_b', '');
if($params->get('owncache','1')){$cache->setCaching(1);}
//setLifeTime works in minutes!
$cache->setLifeTime ($params->get('cache_time',60));
$w = modweather_bHelper::getFeeds($key,$units,$cache);

//check we have returned feed data if not bail out
if(count($w)<1)
{
  echo '<div id="weather-error" style="padding:5px">Sorry weather data is not available</div>';
  return;
}

$forecast5 = $params->get('forecast',0);
$linktext = $params->get('linktext','Full Forecast');
$linktitle = $params->get('linktitle','Full Yahoo weather forecast');
$imgpath_big = $params->get('imgpath_big','http://l.yimg.com/a/i/us/nws/weather/gr/');
$imgpath_small = $params->get('imgpath_small','http://l.yimg.com/a/i/us/we/52/');
$img_big_ext = $params->get('img_big_ext','d.png');
$img_small_ext = $params->get('img_small_ext','.gif');
$speed = $params->get('speed',5000);
$unique_id = $params->get('unique_id','w-');
$start_collapsed = $params->get('start_collapsed',1);
$boot_collapse = $params->get('boot_collapse',0);
//path setup
//uncomment lines below for testing or hardcoding paths
//$feedpath = 'http://bfgnet.local/feed-data/error.xml';
//$imgpath_big = JURI::Root() ."modules/mod_weather_b/weather-images/big/"; 
//$imgpath_small = 'http://bfgnet.local/weather-images/small/';
//$imgpath_big = "http://localhost/weather/weather-images/other/";
//$img_big_ext = ".png";

// these graphics are about half the size of the ones above
//$imgpath_small = 'http://l.yimg.com/a/i/us/nws/weather/gr/';
//$img_small_ext = 's.gif';

require(JModuleHelper::getLayoutPath('mod_weather_b',$params->get('modstyle','default')));
  
?>