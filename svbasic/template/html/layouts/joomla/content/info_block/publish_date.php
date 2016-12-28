<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

if ($displayData['columna'] == 'no' or !isset($displayData['columna'])) {;
// Quiere decir que le pasamos este parametro y es un articulo en toda la pantalla.

?>
			<dd class="published">
				<span class="glyphicon glyphicon-calendar"></span>
				<time datetime="<?php echo JHtml::_('date', $displayData['item']->publish_up, 'c'); ?>" itemprop="datePublished">
					<?php echo JHtml::_('date', $displayData['item']->publish_up, JText::_('DATE_FORMAT_LC3')); ?>
				</time>
			</dd>
<?php
}  else {
	// Pasamos parametro Si , entonce solo mostramos icono.
?>

			<dd class="published">
					<a class="icon" title="<?php echo  $displayData['item']->publish_up;?>"><span class="glyphicon glyphicon-calendar"></span></a>
			</dd>
<?php 
}
?>
