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


/**
 * Class Weather
 */
class Weather
{
	/**
	 * @var SimpleXMLElement
	 */
	private $_weather;

	/**
	 * @var bool
	 */
	public $error = false;

	/**
	 * Constructor for a weather object given an xml feed
	 *
	 * @param string $rss_feed an xml string either from the rss feed or the cache
	 */
	public function __construct($rss_feed)
	{
		$this->_weather = new SimpleXMLElement($rss_feed);

		if (stripos($this->_weather->channel->title, "error"))
		{
			$this->error = true;
		}
	}

	/**
	 * Whether the xpath function returns false or empty array for non-existent path
	 * seems to depend on the libxml version
	 * Using empty() to check for either an empty array or false value
	 * return '' if empty and the requested string if not
	 */

	/**
	 * Returns requested location data from the xml
	 *
	 * @param string $loc values should be city, region or country
	 *
	 * @return string
	 */
	public function location($loc)
	{
		$l = $this->_weather->channel->xpath('yweather:location/@' . $loc);

		return (empty($l) ? '' : (string) $l[0]);
	}

	/**
	 * Returns requested wind data from the xml
	 *
	 * @param string $wind values should be chill, direction or speed
	 *
	 * @return string
	 */
	public function wind($wind)
	{
		$w = $this->_weather->channel->xpath('yweather:wind/@' . $wind);

		return (empty($w) ? '' : (string) $w[0]);
	}

	/**
	 * Returns requested units for data type
	 *
	 * @param string $unit values should be temperature, distance, pressure or speed
	 *
	 * @return string
	 */
	public function unit($unit)
	{
		$u = $this->_weather->channel->xpath('yweather:units/@' . $unit);

		return (empty($u) ? '' : (string) $u[0]);
	}

	/**
	 * Returns requested atmospheric conditions
	 *
	 * @param string $atmos values should be humidity, visibility, pressure or rising
	 *
	 * @return string
	 */
	public function atmosphere($atmos)
	{
		$a = $this->_weather->channel->xpath('yweather:atmosphere/@' . $atmos);

		return (empty($a) ? '' : (string) $a[0]);
	}

	/**
	 * Returns sunrise or sunset time
	 *
	 * @param string $ast values should be sunrise or sunset
	 *
	 * @return string
	 */
	public function astronomy($ast)
	{
		$a = $this->_weather->channel->xpath('yweather:astronomy/@' . $ast);

		return (empty($a) ? '' : (string) $a[0]);
	}

	/**
	 * The basic weather data
	 *
	 * @param string $cond values should be temp, code, text or date
	 *
	 * @return  string
	 */
	public function condition($cond)
	{
		$c = $this->_weather->channel->item->xpath('yweather:condition/@' . $cond);

		return (empty($c) ? '' : (string) $c[0]);
	}

	/**
	 * Returns raw url to full forecast at Yahoo
	 *
	 * @return string   url to full forecast
	 */
	public function link()
	{
		$link = explode('*', $this->_weather->channel->link);

		return array_pop($link);
	}

	/**
	 * Returns forecast SimpleXMLElement which can be iterated over
	 *
	 * @return  SimpleXMLElement
	 */
	public function forecast()
	{
		return $this->_weather->channel->item->xpath('yweather:forecast');
	}

	public function today_minmax($mm)
	{
		$temp = self::forecast();
		return (string)$temp[0]->attributes()->$mm;
	}

	/**
	 * Returns a l d M Y formatted date eg. Thursday 05 Dec 2013
	 * rather than Thu, 05 Dec 2013 10:00 am CET
	 *
	 * @return string
	 */
	public function shortdate()
	{
		$myDateTime = DateTime::createFromFormat('D, d M Y h:i a e', $this->condition('date'));

		return $myDateTime->format('l d M Y');
	}
}
