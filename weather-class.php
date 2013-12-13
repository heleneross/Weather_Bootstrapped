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

class weather {
    private $weather;
    public $error;
    public function __construct($rss_feed) {
      $this->weather = new SimpleXMLElement($rss_feed);
      if (stripos($this->weather->channel->title,"error"))
        {
          $this->error = true;
        }
    }
    
    public function location ($loc) {
      //city, region, country
      $l = $this->weather->channel->xpath('yweather:location/@'.$loc);
      return (string)$l[0];
    }
 
    public function wind ($wind) {
      //chill, direction, speed
      $w = $this->weather->channel->xpath('yweather:wind/@'.$wind);
      return (string)$w[0];
    }
    
    public function unit ($unit) {
      //temperature, distance, pressure, speed
      $u = $this->weather->channel->xpath('yweather:units/@'.$unit);
      return (string)$u[0];
    }
       
    public function atmosphere($atmos) {
      //humidity, visibility, pressure, rising
      $a = $this->weather->channel->xpath('yweather:atmosphere/@'.$atmos);
      return (string)$a[0];
    }
    
    public function astronomy ($ast) {
      //sunrise, sunset
      $a = $this->weather->channel->xpath('yweather:astronomy/@'.$ast);
      return (string)$a[0];
    }
    
    public function condition ($cond) {
      //temp, code, text, date - the basic weather data
      $c = $this->weather->channel->item->xpath('yweather:condition/@'.$cond);
      return (string)$c[0];
    }
    
    public function link () {
      //url to full forecast - raw url
      return array_pop(explode('*',$this->weather->channel->link));
    }
    
    public function forecast () {
      //returns SimpleXMLObject which you can iterate over
      return $this->weather->channel->item->xpath('yweather:forecast');
    }
    
    public function shortdate () {
      //returns main forecast date as eg. Thursday 05 Dec 2013 rather than Thu, 05 Dec 2013 10:00 am CET
      $myDateTime = DateTime::createFromFormat('D, d M Y h:i a e', $this->condition('date'));
      return $myDateTime->format('l d M Y');
    }
}
?>