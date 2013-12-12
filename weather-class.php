<?php
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
      return $this->weather->channel->xpath('yweather:location/@'.$loc)[0];
    }
 
    public function wind ($wind) {
      //chill, direction, speed
      return $this->weather->channel->xpath('yweather:wind/@'.$wind)[0];
    }
    
    public function unit ($unit) {
      //temperature, distance, pressure, speed
      return $this->weather->channel->xpath('yweather:units/@'.$unit)[0];
    }
       
    public function atmosphere($atmos) {
      //humidity, visibility, pressure, rising
      return $this->weather->channel->xpath('yweather:atmosphere/@'.$atmos)[0];
    }
    
    public function astronomy ($ast) {
      //sunrise, sunset
      return $this->weather->channel->xpath('yweather:astronomy/@'.$ast)[0];
    }
    
    public function condition ($cond) {
      //temp, code, text, date - the basic weather data
      return $this->weather->channel->item->xpath('yweather:condition/@'.$cond)[0];
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