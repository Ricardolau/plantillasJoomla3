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
<dd class="createdby" itemprop="author" itemscope itemtype="https://schema.org/Person">
	<?php $author = ($displayData['item']->created_by_alias ? $displayData['item']->created_by_alias : $displayData['item']->author); ?>
	<?php $author = '<span itemprop="name">' . $author . '</span>'; ?>
	<?php if (!empty($displayData['item']->contact_link ) && $displayData['params']->get('link_author') == true) : ?>
		<span class="glyphicon glyphicon-user"></span><?php echo $author;?>
		<?php //echo JText::sprintf('COM_CONTENT_WRITTEN_BY', JHtml::_('link', $displayData['item']->contact_link, $author, array('itemprop' => 'url'))); ?>
	<?php else :?>
		<span class="glyphicon glyphicon-user"></span>
		<?php echo $author;?>

		<?php //echo JText::sprintf('COM_CONTENT_WRITTEN_BY', $author); ?>
	<?php endif; ?>
</dd>
<?php
}  else {
	// Pasamos parametro Si , entonce solo mostramos icono.
?>

<dd class="createdby" itemprop="author" itemscope itemtype="https://schema.org/Person">
	<?php $nombreauthor = ($displayData['item']->created_by_alias ? $displayData['item']->created_by_alias : $displayData['item']->author); ?>
	<?php $author = '<span itemprop="name">' . $nombreauthor . '</span>'; ?>
		<a class="icon" title="<?php echo $nombreauthor;?>"><span class="glyphicon glyphicon-user"></span></a>
</dd>
<?php 
}
?>
