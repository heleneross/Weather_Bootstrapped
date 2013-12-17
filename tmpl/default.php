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

// edit css for custom display
$document = JFactory::getDocument();
$document->addStyleSheet (JURI::Root() ."modules/mod_weather_b/resources/weather.css");


if(count($w)==1)
//single woeid with or without 5day forecast
{
?>
<div id="<?php echo $unique_id;?>single" class="weather-s">
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
      if($boot_collapse) {
        echo '<div id="'.$unique_id.'btn" class="days collapse'.(($start_collapsed)?'':' in').'" />';
      }
      else {
        echo '<div class="days '.$unique_id.'collapse" />';
        if($start_collapsed) {
          echo '<script type="text/javascript">jQuery(document).ready(function() {jQuery( ".'.$unique_id.'collapse" ).css( "display","none" );});</script>';
        }
      }
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
<?php if($forecast5) { 
  if($boot_collapse){
     echo '<button type="button" class="btn btn-small btn-weather" data-toggle="collapse" data-target="#'.$unique_id.'btn">...</button>';
  }
  else { ?>
     <button type="button" onfocus="this.blur()" class="btn-weather <?php echo $unique_id;?>btn"><?php echo ($start_collapsed) ? '+' : '-'; ?></button>
     <script type="text/javascript">
     jQuery(".<?php echo $unique_id;?>btn").click(function() {
     var txt = jQuery(".<?php echo $unique_id;?>collapse").is(':visible') ? '+' : '-';
     jQuery(".<?php echo $unique_id;?>btn").text(txt);
     jQuery(".<?php echo $unique_id;?>collapse").slideToggle("slow");
});
</script>
<?php
  }
}
?>
<a class="yahoolink" href="<?php echo $w[0]->link(); ?>" title="<?php echo $linktitle; ?>" target="_blank"><?php echo $linktext; ?></a>
<?php
echo '</div>'; 
} ?>

<?php
//carousel - can't have a 5day forecast with this
if (count($w) > 1) {
  echo '<div class="weather-c">';
  echo '<div id="'.$unique_id.'carousel" class="carousel slide weather2" data-ride="carousel" data-interval="'.$speed.'">';
  $first = true;
    foreach ($w as $loc){
    if ($first) {
        echo '<div class="carousel-inner">';
        echo '<div class="item  active" style="background-image:url('.$imgpath_big.$loc->condition('code').$img_big_ext.')">';
        $first = false;
    }
    else
    {
        echo '<div class="item" style="background-image:url('.$imgpath_big.$loc->condition('code').$img_big_ext.')">';  
    }
    echo '<div class="weathertext">';
    //add more weather information to this div
    echo '<p class="location">'.modweather_bHelper::german_city($loc->location('city')).'</p>';
    echo '<p class="temperature">'.$loc->condition('temp').'<span class="units">&deg;'.$loc->unit('temperature').'</span></p>';
    echo '<p class="text">'.$loc->condition('text').'</p>';
    echo '<p class="date">'.$loc->shortdate().'</p>';
    //end of information div
    echo '</div>';
    echo '<a class="yahoolink" href="'.$loc->link().'" title="'.$linktitle.'" target="_blank">'.$linktext.'</a></div>';
    }
    echo '</div></div></div>';
}
?>


