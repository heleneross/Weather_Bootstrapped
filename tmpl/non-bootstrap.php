<?php
/**
* @package weather_b
* @author Helen
* @website bfgnet.de
* @email heleneross@gmail.com
* @copyright 
* @license 
**/



// no direct access
defined('_JEXEC') or die('Restricted access');

// edit css for custom display
$document = JFactory::getDocument();
$document->addStyleSheet (JURI::Root() ."modules/mod_weather_b/resources/weather.css");


if(count($w)==1)
//single woeid with or without 5day forecast
{
?>
<div id="<?php echo $unique_id;?>single" class="weather2">
<div class="weatherpic">
<img src="<?php echo $imgpath_big.$w[0]->condition('code').$img_big_ext; ?>" class="img-responsive" /> 
</div>
<div class="weathertext">
<p class="location"><?php echo modweather_bHelper::german_city($w[0]->location('city')); ?></p>
<p class="temperature"><?php echo $w[0]->condition('temp').'<span class="units">&deg;'.$w[0]->unit('temperature'); ?></span></p>
<p class="text"><?php echo $w[0]->condition('text'); ?></p>
<p class="date"><?php echo $w[0]->shortdate(); ?></p>
</div>
<?php

if($forecast5)
  {
      echo '<div id="days" class="collapse in">';
      foreach ($w[0]->forecast() as $day)
        {
          echo '<div class="day">';
          echo '<img src="'.$imgpath_small.$day['code'].$img_small_ext.'" />';
          echo '<div class="daytext">';
          echo '<p class="day-date">'.$day['day'].' '.substr($day['date'],0,-5).'</p>';
          echo '<p class="day-temp">Low: '.$day['low'].' High: '.$day['high'].'</p>';
          echo '<p class="day-text">'.$day['text'].'</p>';
          echo '</div></div>';
        }
      echo '</div>';
  }
?>
<a class="yahoolink" href="<?php echo $w[0]->link(); ?>" title="<?php echo $linktitle; ?>" target="_blank"><?php echo $linktext; ?></a>
</div>

<?php
}
//carousel - can't have a 5day forecast with this
if (count($w) > 1) {
    //add bootstrap js and css for carousel here
    $document->addScript(JURI::Root() . "modules/mod_weather_b/resources/bootstrap.min.js");
    $document->addStyleSheet (JURI::Root() ."modules/mod_weather_b/resources/carousel.css");
    //if you have a mootools conflict enable the next line
    $document->addScript(JURI::Root() . "modules/mod_weather_b/resources/conflict.js");
  echo '<div id="'.$unique_id.'carousel" class="carousel slide" data-ride="carousel" data-interval="'.$speed.'">';
  echo '<div class="carousel-inner">';
  $first = true;
    foreach ($w as $loc){
    if ($first) {
        echo '<div class="item  active" style="background-image:url('.$imgpath_big.$loc->condition('code').$img_big_ext.')">';
        $first = false;
    }
    else
    {
        echo '<div class="item" style="background-image:url('.$imgpath_big.$loc->condition('code').$img_big_ext.')">';  
    }
    echo '<div class="weathertext">';
    echo '<p class="location">'.modweather_bHelper::german_city($loc->location('city')).'</p>';
    echo '<p class="temperature">'.$loc->condition('temp').'<span class="units">&deg;'.$loc->unit('temperature').'</span></p>';
    echo '<p class="text">'.$loc->condition('text').'</p>';
    echo '<p class="date">'.$loc->shortdate().'</p>';
    echo '</div>';
    echo '<a class="yahoolink" href="'.$loc->link().'" title="'.$linktitle.'" target="_blank">'.$linktext.'</a></div>';
    }
    echo '</div></div>';
}
?>


