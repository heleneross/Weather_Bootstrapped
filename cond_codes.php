<?php
/**
 * @package    Weather-bootstrapped
 * @author     Helen <heleneross@gmail.com>
 * @website    https://github.com/heleneross/Weather_Bootstrapped
 * @copyright  Copyright (C) 2013 Helen Ross - All Rights Reserved
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 * @info       weather-icons Erik Flowers https://github.com/erikflowers/weather-icons
 **/

// No direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Class Condition_Code
 *
 * @since  v1.2
 */
class Condition_Code
{
	/**
	 * @var array   maps yahoo weather codes to weather text
	 */
	public static $yahoo_code = array(
		"0" => "tornado",
		"1" => "tropical storm",
		"2" => "hurricane",
		"3" => "severe thunderstorms",
		"4" => "thunderstorms",
		"5" => "mixed rain and snow",
		"6" => "mixed rain and sleet",
		"7" => "mixed snow and sleet",
		"8" => "freezing drizzle",
		"9" => "drizzle",
		"10" => "freezing rain",
		"11" => "showers",
		"12" => "showers",
		"13" => "snow flurries",
		"14" => "light snow showers",
		"15" => "blowing snow",
		"16" => "snow",
		"17" => "hail",
		"18" => "sleet",
		"19" => "dust",
		"20" => "foggy",
		"21" => "haze",
		"22" => "smoky",
		"23" => "blustery",
		"24" => "windy",
		"25" => "cold",
		"26" => "cloudy",
		"27" => "mostly cloudy (night)",
		"28" => "mostly cloudy (day)",
		"29" => "partly cloudy (night)",
		"30" => "partly cloudy (day)",
		"31" => "clear (night)",
		"32" => "sunny",
		"33" => "fair (night)",
		"34" => "fair (day)",
		"35" => "mixed rain and hail",
		"36" => "hot",
		"37" => "isolated thunderstorms",
		"38" => "scattered thunderstorms",
		"39" => "scattered thunderstorms",
		"40" => "scattered showers",
		"41" => "heavy snow",
		"42" => "scattered snow showers",
		"43" => "heavy snow",
		"44" => "partly cloudy",
		"45" => "thundershowers",
		"46" => "snow showers",
		"47" => "isolated thundershowers",
		"3200" => "not available");

	/**
	 * @var array   maps yahoo weather codes to icons in the weather-icon font
	 */
	public static $weather_icons = array(
		"0" => "wi-tornado",
		"1" => "wi-tornado",
		"2" => "wi-tornado",
		"3" => "wi-thunderstorm",
		"4" => "wi-thunderstorm",
		"5" => "wi-rain-mix",
		"6" => "wi-day-rain-mix",
		"7" => "wi-day-rain-mix",
		"8" => "wi-hail",
		"9" => "wi-day-showers",
		"10" => "wi-hail",
		"11" => "wi-showers",
		"12" => "wi-showers",
		"13" => "wi-snow",
		"14" => "wi-snow",
		"15" => "wi-snow",
		"16" => "wi-snow",
		"17" => "wi-hail",
		"18" => "wi-rain-mix",
		"19" => "wi-day-fog",
		"20" => "wi-fog",
		"21" => "wi-day-fog",
		"22" => "wi-day-fog",
		"23" => "wi-cloudy-gusts",
		"24" => "wi-cloudy-gusts",
		"25" => "wi-thermometer",
		"26" => "wi-cloudy",
		"27" => "wi-night-cloudy",
		"28" => "wi-day-cloudy",
		"29" => "wi-cloudy",
		"30" => "wi-day-sunny-overcast",
		"31" => "wi-night-clear",
		"32" => "wi-day-sunny",
		"33" => "wi-night-clear",
		"34" => "wi-day-sunny",
		"35" => "wi-rain-mix",
		"36" => "wi-thermometer",
		"37" => "wi-day-lightning",
		"38" => "wi-day-lightning",
		"39" => "wi-day-lightning",
		"40" => "wi-day-showers",
		"41" => "wi-snow",
		"42" => "wi-day-snow",
		"43" => "wi-snow",
		"44" => "wi-day-cloudy",
		"45" => "wi-day-storm-showers",
		"46" => "wi-day-snow",
		"47" => "wi-day-storm-showers",
		"3200" => "wi-refresh");

	/**
	 * @var array   maps wind direction to icons in the weather-icon font, not very accurate
	 */
	public static $wind_icon = array(
		"N" => "wi-wind-north",
		"NNE" => "wi-wind-north-east",
		"NE" => "wi-wind-north-east",
		"ENE" => "wi-wind-north-east",
		"E" => "wi-wind-east",
		"ESE" => "wi-wind-south-east",
		"SE" => "wi-wind-south-east",
		"SSE" => "wi-wind-south-east",
		"S" => "wi-wind-south",
		"SSW" => "wi-wind-south-west",
		"SW" => "wi-wind-south-west",
		"WSW" => "wi-wind-south-west",
		"W" => "wi-wind-west",
		"WNW" => "wi-wind-north-west",
		"NW" => "wi-wind-north-west",
		"NNW" => "wi-wind-north-west");

	/**
	 * Given a code returns weather text eg. 'isolated thundershowers'
	 *
	 * @param   string  $akey  yahoo weather code
	 *
	 * @return  string
	 */
	public static function getYahoo($akey)
	{
		// Use "$akey" to ensure it is evaluated as a string
		if (isset(self::$yahoo_code["$akey"]))
		{
			return (string) self::$yahoo_code["$akey"];
		}
		else
		{
			return 'not available';
		}
	}

	/**
	 * given a code returns weather icon eg. 'wi-cloudy-windy'
	 *
	 * @param   string  $akey  yahoo weather code
	 *
	 * @return  string
	 */
	public static function getIcon($akey)
	{
		if (isset(self::$weather_icons["$akey"]))
		{
			return (string) self::$weather_icons["$akey"];
		}
		else
		{
			return 'wi-refresh';
		}
	}

	/**
	 * Returns html i tag with weather-icon eg. <i class="wi-refresh"></i>
	 *
	 * @param   string  $akey  yahoo weather code
	 *
	 * @return  string
	 */
	public static function getIconFull($akey)
	{
		if (isset(self::$weather_icons["$akey"]))
		{
			$text = (string) self::$weather_icons["$akey"];

			return '<i class="' . $text . '"></i>';
		}
		else
		{
			return '<i class="wi-refresh"></i>';
		}
	}

// TODO ? move cardinalize function to cond_codes and allow passing in raw numeric bearing to getWindIcon
	/**
	 * Use the cardinalize function then use this function to get the icon
	 *
	 * @param   string  $akey  weather direction eg. NNE
	 *
	 * @return  string  returns weather icon associated with the wind direction
	 */
	public static function getWindIcon($akey)
	{
		$akey = strtoupper("$akey");

		if (isset(self::$wind_icon[$akey]))
		{
			return (string) self::$wind_icon[$akey];
		}
		else
		{
			return 'wi-strong-wind';
		}
	}
}
