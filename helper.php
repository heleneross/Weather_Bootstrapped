<?php
/**
* @package weather-bootstrapped
* @author Helen
* @website bfgnet.de
* @email heleneross@gmail.com
* @copyright Copyright � 2013 Helen Ross - All Rights Reserved 
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
**/

// no direct access
defined('_JEXEC') or die('Restricted access');

class modweather_bHelper
{
    public static function getFeeds($key,$units,$cache){
      $feedarray = array();
      $location = explode(',',$key);
      $feedpath = 'http://weather.yahooapis.com/forecastrss?w=';
      //testing
      //$feedpath = 'http://localhost/weather/feed-data/';
      //get the feeds with curl
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      foreach($location as $woeid){
              $url = $feedpath.$woeid.'&u='.$units;
              //testing
              //$url = $feedpath.$woeid.'.xml';
              curl_setopt($ch, CURLOPT_URL, $url );
              // $weather_rss read/write to cache
              if (!($weather_rss = $cache->get($woeid))) {
                  $weather_rss = curl_exec($ch);
                  $cache->store($weather_rss, $woeid);
              }
              if($weather_rss && stripos($weather_rss,'error')===false){
                    $feedarray[] = new weather($weather_rss);
              }
      }
      curl_close($ch);
      return $feedarray;
    }
    
  
    public static function cardinalize($degree) {
      $direction = '';
      if($degree == 0) $direction = '';
      if($degree >= 348.75 && $degree <= 11.25) $direction = 'N';
      if($degree > 11.25 && $degree <= 33.75) $direction = 'NNE';
      if($degree > 33.75 && $degree <= 56.25) $direction = 'NE';
      if($degree > 56.25 && $degree <= 78.75) $direction = 'ENE';
      if($degree > 78.75 && $degree <= 101.25) $direction = 'E';
      if($degree > 101.25 && $degree <= 123.75) $direction = 'ESE';
      if($degree > 123.75 && $degree <= 146.25) $direction = 'SE';
      if($degree > 146.25 && $degree <= 168.75) $direction = 'SSE';
      if($degree > 168.75 && $degree <= 191.25) $direction = 'S';
      if($degree > 191.25 && $degree <= 213.75) $direction = 'SSW';
      if($degree > 213.75 && $degree <= 236.25) $direction = 'SW';
      if($degree > 236.25 && $degree <= 258.75) $direction = 'WSW';
      if($degree > 258.75 && $degree <= 281.25) $direction = 'W';
      if($degree > 281.25 && $degree <= 303.75) $direction = 'WNW';
      if($degree > 303.75 && $degree <= 326.25) $direction = 'NW';
      if($degree > 326.25 && $degree < 348.75) $direction = 'NNW';
    return $direction;
    }

    public static function german_city ($city) {
      //put the umlauts back in some german cities
        switch (strtoupper($city)) {
        case "MUNCHENGLADBACH":
                $city = "M&ouml;nchengladbach";
                break;
        case "GUTERSLOH":
                $city = 'G&uuml;tersloh';
                break;
        case "DULMEN":
                $city = "D&uuml;lmen";
                break;
        case "DUSSELDORF":
                $city = "D&uuml;sseldorf";
                break;
        case "MUNSTER":
                $city = "M&uumlnster";
                break;                     
          }
          return $city;
      }
}
?>