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

			<dd class="category-name">
				<?php $title = $this->escape($displayData['item']->category_title); ?>
				<?php if ($displayData['params']->get('link_category') && $displayData['item']->catslug) : ?>
					<?php $url = '<a href="' . JRoute::_(ContentHelperRoute::getCategoryRoute($displayData['item']->catslug)) . '" itemprop="genre">' . $title . '</a>'; ?>
					<span class="glyphicon glyphicon-folder-open"></span><?php echo $url;?> 
					
					<?php //echo JText::sprintf('COM_CONTENT_CATEGORY', $url); ?>
				<?php else : ?>
					<span class="glyphicon glyphicon-folder-open"></span><?php echo '<span itemprop="genre">' . $title . '</span>';?>
					<?php // echo JText::sprintf('COM_CONTENT_CATEGORY', '<span itemprop="genre">' . $title . '</span>'); ?>
				<?php endif; ?>
			</dd>
<?php
}  else {
	// Pasamos parametro Si , entonce solo mostramos icono.
?>

			<dd class="category-name">
				<?php $title = $this->escape($displayData['item']->category_title); ?>
				<?php $url = '<a href="' . JRoute::_(ContentHelperRoute::getCategoryRoute($displayData['item']->catslug)) . '" itemprop="genre">' . $title . '</a>'; ?>	
				<a class="icon" title="<?php echo $title;?>" href="<?php  JRoute::_(ContentHelperRoute::getCategoryRoute($displayData['item']->catslug)) ;?>"><span class="glyphicon glyphicon-folder-open"></span></a>
			</dd>
<?php 
}
?>
