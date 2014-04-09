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
 * Class Modweather_BHelper
 **/
class Modweather_BHelper
{
	/**
	 * this function retrieves the feeds using the WOEIDs
	 * and stores the weather objects in feedarray
	 *
	 * @param string $key   comma separated list of WOEIDs
	 * @param string $units c or f expected
	 * @param object $cache a JCacheController object
	 *
	 * @return  \Weather[]
	 */

	public static function getFeeds($key, $units, $cache)
	{
		$feedarray = array();
		$location = explode(',', $key);

		// Get rid of any whitespace in the array
		$location = array_map('trim', $location);
		$feedpath = 'http://weather.yahooapis.com/forecastrss?w=';
		//$feedpath = 'http://bfgnet.dev/feed-data/';

		// Get the feeds with curl
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		foreach ($location as $woeid)
		{
			$url = $feedpath . $woeid . '&u=' . $units;
			//$url = $feedpath . $woeid . '.xml';
			curl_setopt($ch, CURLOPT_URL, $url);

			// $weather_rss read/write to cache
			if (!($weather_rss = $cache->get($woeid)))
			{
				$weather_rss = curl_exec($ch);

				// 200 = success
				if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == 200)
				{
					$cache->store($weather_rss, $woeid);
				}
				else
				{
					$weather_rss = 'error';
				}
			}

			// If we have a feed returned then create a new weather object, add it to the feedarray
			if ($weather_rss && stripos($weather_rss, 'error') === false)
			{
				$feedarray[] = new Weather($weather_rss);
			}
		}

		curl_close($ch);

		return $feedarray;
	}

	/**
	 * Returns a compass direction given degrees
	 *
	 * @param int $degree compass bearing
	 *
	 * @return  string
	 */
	public static function cardinalize($degree)
	{
		$direction = '-';

		switch ($degree)
		{
			case ($degree <= 11.25):
			case ($degree >= 348.75):
				$direction = 'N';
				break;
			case ($degree <= 33.75):
				$direction = 'NNE';
				break;
			case ($degree <= 56.25):
				$direction = 'NE';
				break;
			case ($degree <= 78.75):
				$direction = 'ENE';
				break;
			case ($degree <= 101.25):
				$direction = 'E';
				break;
			case ($degree <= 123.75):
				$direction = 'ESE';
				break;
			case ($degree <= 146.25):
				$direction = 'SE';
				break;
			case ($degree <= 168.75):
				$direction = 'SSE';
				break;
			case ($degree <= 191.25):
				$direction = 'S';
				break;
			case ($degree <= 213.75):
				$direction = 'SSW';
				break;
			case ($degree <= 236.25):
				$direction = 'SW';
				break;
			case ($degree <= 258.75):
				$direction = 'WSW';
				break;
			case ($degree <= 281.25):
				$direction = 'W';
				break;
			case ($degree <= 303.75):
				$direction = 'WNW';
				break;
			case ($degree <= 326.25):
				$direction = 'NW';
				break;
			case ($degree < 348.75):
				$direction = 'NNW';
				break;
			default:
				$direction = '-';
		}

		return $direction;
	}

	/**
	 * The yahoo weather service often mangles the name of cities with umlauts, here are some fixed, add more if required
	 *
	 * @param   string $city name as returned by yahoo weather
	 *
	 * @return  string modified city name
	 */
	public static function german_city($city)
	{
		switch (strtoupper($city))
		{
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
				$city = "M&uuml;nster";
				break;
		}

		return $city;
	}

	/**
	 * Function to cache images if required
	 *
	 * @param string $image_url the actual url of the image
	 * @param bool   $cache     whether the images should be cached
	 *
	 * @return string          returns either the original url or url to cache item
	 */
	public static function imgcache($image_url, $cache = false)
	{
		$cached_image = '';
		if (!$cache)
		{
			return $image_url;
		}
		$image_path = JPATH_CACHE . '/weather-images/';

		if (!file_exists($image_path))
		{
			mkdir($image_path, 0755, true);
			file_put_contents($image_path . 'index.html', '<!DOCTYPE html><title></title>');
		}
		if (!empty($image_url))
		{
			// So we don't overwrite images in cache
			$hash = md5($image_url);
			// Get file name - possibly clean this up
			$exploded_image_url = explode("/", $image_url);
			$image_filename = end($exploded_image_url);
			$exploded_image_filename = explode(".", $image_filename);
			$extension = end($exploded_image_filename);

			// Image validation
			if (strtolower($extension) == "gif" || strtolower($extension) == "jpg" || strtolower($extension) == "png")
			{
				$cached_image = $image_path . $hash . '.' . $extension;
				// Check if image exists
				if (file_exists($cached_image))
				{
					return JURI::base() . 'cache/weather-images/' . $hash . '.' . $extension;
				}
				else
				{

					// Get remote image
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $image_url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$image_to_fetch = curl_exec($ch);
					$curlinfo = curl_getinfo($ch, CURLINFO_HTTP_CODE);
					curl_close($ch);
					// 200 = success
					if ($curlinfo == 200)
					{
						// Save image
						$local_image_file = fopen($cached_image, 'w+');
						if (!$local_image_file)
						{
							// Probably a problem with file permissions
							return $image_url;
						}
						chmod($cached_image, 0755);
						fwrite($local_image_file, $image_to_fetch);
						fclose($local_image_file);
						// paranoia  - is it really an image, 1=>'GIF',	2=>'JPEG', 3=>'PNG'
						$info = getimagesize($cached_image);
						if ($info[2] == 1 || $info[2] == 2 || $info[2] == 3)
						{
							return JURI::base() . 'cache/weather-images/' . $hash . '.' . $extension;
						}
						else
						{
							// delete bad file
							unlink($cached_image);
							return $image_url;
						}
					}
					else
					{
						return $image_url;
					}

				}
			}
		}
	}
}
