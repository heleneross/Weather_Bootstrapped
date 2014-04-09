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
?>

<div class="weatherpic"
     style="background-image:url(<?php echo Modweather_BHelper::imgcache($imgpath_big . $w[0]->condition('code') . $img_big_ext, $cacheimg); ?>)">
	<div class="weathertext">
		<p class="location"><?php echo Modweather_BHelper::german_city($w[0]->location('city')); ?></p>

		<p class="temperature"><?php echo $w[0]->condition('temp') . '<span class="units">&deg;<span class="forc">' . $w[0]->unit('temperature'); ?></span></span></p>

		<p class="text"><?php echo htmlspecialchars($w[0]->condition('text')); ?></p>

		<p class="smalltext">High: <?php echo $w[0]->today_minmax('high'); ?>
			&nbsp;&nbsp;Low: <?php echo $w[0]->today_minmax('low'); ?></p>

		<p class="smalltext">Wind: <?php echo Modweather_BHelper::cardinalize($w[0]->wind('direction')); ?>
			&nbsp;&nbsp;<?php echo $w[0]->wind('speed') . ' ' . $w[0]->unit('speed'); ?></p>
	</div>
</div>
